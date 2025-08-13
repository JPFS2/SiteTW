<?php 

namespace App\Controller\Admin;
use App\Controller\Admin\Page;
use App\Model\Entity\Pedido as M_Pedido;
use App\Model\Entity\PedidoItens as M_PedidoItens;
use App\Model\Entity\PedidoPagamento as M_PedidoPagamento;
use App\Model\Entity\PedidoExcluido as M_PedidoEX;
use App\Model\Entity\Credito as M_Credito;
use App\Model\Entity\Empresa as M_Empresa;
use App\Model\Entity\Produto as M_Produto;
use App\Utils\View;

class ControlePedido extends Page {

    /*
    * Metodo Responsavel por retornar a view da dela de relaçao de pedidos
    *  @retunr string 
    */
    public static function getPedidos(){
        $tr = '';
        // Otimizando a consulta com LIMIT e ORDER BY
        $pedidos = M_Pedido::buscar(null,'pedido.numped desc',50,'pedido.numped, pedido.codmesa, pedido.dtpedido, pedido.vltotal, pedido.cxencerrado, cadcliente.cliente');

        while($pedido = $pedidos->fetchObject()){
            $status = isset($pedido->cxencerrado)
                ? '<span class="badge bg-success">Faturado</span>'
                : '<span class="badge bg-warning">Faturamento Pendente</span>';

            $date = date_create($pedido->dtpedido);

            $tr .= View::render('admin/controlepedido/pedidos', [
                'numped' => $pedido->numped,
                'mesa' => $pedido->codmesa,
                'cliente' => $pedido->cliente,
                'dtpedido' => date_format($date,'d/m/Y - H:i'),
                'vltotal' => number_format($pedido->vltotal, 2, ',', '.'),
                'status' => $status
            ]);
        }

        $userType = $_SESSION['admin']['usuario']['tipo_usuario'] ?? 'user';
        $content = View::render('admin/controlepedidos', [
            'tr' => $tr,
            'usuario' => $_SESSION['admin']['usuario']['nome'],
            'menu' => \App\Utils\MenuPermissions::renderMenu($userType, '/admin')
        ]);

        return parent::getPageLogin('Controle',$content);
    }


    public static function getPedidoItens($id){
        $tr = '';
        // Otimizando a consulta selecionando apenas os campos necessários
        $itens = M_Pedido::buscarItens('numped = '.$id,null,null,'pedidoitens.codprod, pedidoitens.qt, pedidoitens.punit, pedidoitens.vlliq, cadprod.descricao');

        while ($item = $itens->fetchObject()){
            $tr .= View::render('admin/controlepedido/produtos', [
                'codprod' => $item->codprod,
                'descricao' => $item->descricao,
                'qt' => $item->qt,
                'punit' => number_format($item->punit, 2, ',', '.'),
                'vlliq' => number_format($item->vlliq, 2, ',', '.')
            ]);
        }
        return $tr;
    }

    public static function getPedidoPag($id){
        $tr = '';
        // Otimizando a consulta selecionando apenas os campos necessários
        $itens = M_PedidoPagamento::buscarItens('numped = '.$id,null,null,'moeda, valor');

        while ($item = $itens->fetchObject()){
            $tr .= View::render('admin/controlepedido/moedas', [
                'vltotal' => number_format($item->valor, 2, ',', '.'),
                'moeda' => $item->moeda
            ]);
        }
        return $tr;
    }

    public static function getPedidoTroca($id){

        $tr = '';
        $itens = M_Credito::buscarJoin('numpedBaixa = '.$id,null,null,'*');

        while ($item = $itens->fetchObject()){

            $tr .= View::render('admin/controlepedido/troca', [
                'vltotal' => $item->vlcredito,
            ]);
        }
        return $tr;

    }

    public static function getProdutoTroca($id){

        $tr = '';
        $itens = M_Credito::buscarJoin('numpedBaixa = '.$id,null,null,'*');

        while ($item = $itens->fetchObject()){

            $tr .= View::render('admin/controlepedido/produtosTroca', [
                'produto' => $item->descricao,
                'numeroSerie' => $item->peso,
                'capacidade' => $item->ean13,
                'cor' => $item->und,
                'valor' => $item->vlcredito,
            ]);
        }
        return $tr;

    }
    /**
     * Metodo (POST) responsavel por Deletar o pedido
     */
    public static function desistePedido($request){

        $postVars = $request->getPostVars();


        $id =  $postVars['id'];

        $itens = M_PedidoItens::busca("numped = ".$id);
        $credito = M_Credito::buscar("numpedBaixa = ".$id,null,null,"*")->fetchObject(M_Credito::class);
        $pagamentos = M_PedidoPagamento::buscar("numped = ".$id,null,null,"*");


        if (isset($credito->codcred)){
            M_Credito::deletar($credito->codcred);
            M_Produto::deletar($credito->codprod);
        }

        while ($item = $itens->fetchObject(M_PedidoItens::class)){
            M_Produto::retornaEstoque($item->codprod,$item->qt);
            $item->cadastrarExclusao();
        }

        while ($pag = $pagamentos->fetchObject(M_PedidoPagamento::class)){
            $pag->cadastrarExclusao();
        }

        $pedidoS = M_Pedido::buscarQt('numped = '.$id)->fetchObject();


        $pedidoEx = new M_PedidoEX();
        $pedidoEx->numped = $pedidoS->numped;
        $pedidoEx->codcli = $pedidoS->codcli;
        $pedidoEx->vlpedido = $pedidoS->vltotal;
        $pedidoEx->vldesconto = $pedidoS->vldesconto;
        $pedidoEx->acrescimo = $pedidoS->acrescimo;
        $pedidoEx->dtpedido = $pedidoS->dtpedido;
        $pedidoEx->observacao = $postVars['observacao'];
        $pedidoEx->cadastrar();

        M_Pedido::deletar($id);
        M_PedidoItens::deletar($id);
        M_PedidoPagamento::deletar($id);

        header("Location: http://localhost/controle/admin/pedidos");
        die();

    }

    /**
     * Metodo Responsavel por Extornar (Reabrir) o pedido
     */
    public static function extornaPedido($request){

        $postVars = $request->getPostVars();

        $id = $postVars['id'];    

        $itens = M_PedidoItens::busca("numped = ".$id);
        $credito = M_Credito::buscar("numpedBaixa = ".$id,null,null,"*")->fetchObject(M_Credito::class);

        if (isset($credito->codcred)){
            M_Credito::deletar($credito->codcred);
            M_Produto::deletar($credito->codprod);
        }

        while ($item = $itens->fetchObject()){
            M_Produto::retornaEstoque($item->codprod,$item->qt);
        }

        // M_Produto::retornaEstoque($obCarrinho->codprod);

        M_Pedido::deletar($id);
        M_PedidoItens::deletar($id);
        M_PedidoPagamento::deletar($id);

        header("Location: https://juninhodoiphone.com/controle/admin/pedidos");
        die();

    }

    public static function  getPedido($id){

        $empresa = M_Empresa::buscar()->fetchObject();

        $pedido = M_Pedido::buscar('numped = '.$id,null,null,'pedido.* ,
         cadcliente.cliente, cadcliente.telefone, cadcliente.email, cadcliente.endereco, cadcliente.numero,
         cadcliente.bairro, cadcliente.cidade, cadcliente.uf')->fetchObject();
        $date = date_create($pedido->dtpedido);

        $content = View::render('admin/controlepedido', [
            'empresa' => $empresa->razaosocial,
            'fantasia' => $empresa->fantasia,
            'empendereco' => $empresa->endereco,
            'empnumero' => $empresa->numero,
            'empbairro' => $empresa->bairro,
            'empcidade' => $empresa->cidade,
            'empuf' => $empresa->uf,
            'emptelefone' => $empresa->telefone,
            'empemail' => $empresa->email,

            'numped' => $id,
            'data' => date_format($date,'d/m/Y'),
            'vldesconto' => $pedido->vldesconto,
            'vltotal' => $pedido->vltotal,
            'vlfrete' => isset($pedido->vlfrete) ? $pedido->vlfrete : '0.00',

            'tr' => self::getPedidoItens($id),
            'moedas' => self::getPedidoPag($id),
            'troca' => self::getPedidoTroca($id),
            'produtoTroca' => self::getProdutoTroca($id),

            'Cliente' => $pedido->cliente,
            'endereco' => $pedido->endereco,
            'numero' => $pedido->numero,
            'bairro' => $pedido->bairro,
            'cidade' => $pedido->cidade,
            'uf' => $pedido->uf,
            'telefone' => $pedido->telefone,
            'email' => $pedido->email
        ]);

        return parent::getPageLogin('Controle',$content);
    }

    }

