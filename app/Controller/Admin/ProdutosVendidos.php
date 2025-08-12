<?php 

namespace App\Controller\Admin;
use App\Controller\Admin\Page;
use App\Model\Entity\Pedido as M_Pedido;
use App\Model\Entity\PedidoItens as M_PedidoItens;
use App\Model\Entity\PedidoPagamento as M_PedidoPagamento;
use App\Model\Entity\Credito as M_Credito;
use App\Model\Entity\Empresa as M_Empresa;
use App\Model\Entity\Produto as M_Produto;
use App\Utils\View;

class ProdutosVendidos extends Page {

    /*
    * Metodo resposave por retornar o conteudo da view do home
    *  @retunr string 
    */
    public static function getPedidos(){

        $tr = '';
        /** @var
         * $pedidos = M_PedidoItens::buscarItens(null,null,null,'*');
         * */
        $pedidos = M_Pedido::buscarItensProdutos(null,null,null,'*');

       

        while($pedido = $pedidos->fetchObject()){

            $tpPedido = isset($tipo->numpedBaixa) ? '<span class="badge bg-warning">Troca</span>' : '<span class="badge bg-success">Venda</span>';

            $date = date("Y/m/d", strtotime($pedido->dtpedido));

            $tr .= View::render('admin/vendaproduto/pedidos', [
                'numped' => $pedido->numped,
                'codprod' => $pedido->codprod,
                'descricao' =>  $pedido->descricao,
                'data' =>  $date,
                'capacidade' => $pedido->ean13,
                'cor' => $pedido->und,
                'imei' => $pedido->peso,
                'qt' => $pedido->qt,
                'valor' => $pedido->vlliq,
          ]);

        }

        $content = View::render('admin/vendaproduto', [
            'tr' => $tr
        ]);

        return parent::getPageLogin('Controle',$content);
    }

    public static function getPedidoItens($id){

        $tr = '';
        $itens = M_Pedido::buscarItens('numped = '.$id,null,null,'pedidoitens.*, cadprod.descricao, cadprod.peso');

        while ($item = $itens->fetchObject()){

            $tr .= View::render('admin/controlepedido/produtos', [
                'codprod' => $item->codprod,
                'descricao' =>  $item->descricao,
                'qt' => $item->qt,
                'punit' => $item->punit,
                'imei' => $item->peso,
                'vlliq' => $item->vlliq
            ]);
        }
        return $tr;

    }

    public static function getPedidoPag($id){

        $tr = '';
        $itens = M_PedidoPagamento::buscarItens('numped = '.$id,null,null,'*');

        while ($item = $itens->fetchObject()){

            $tr .= View::render('admin/controlepedido/moedas', [
                'vltotal' => $item->valor,
                'moeda' =>  $item->moeda,
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


    public static function extornaPedido($id){

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

