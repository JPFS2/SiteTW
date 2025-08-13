<?php 

namespace App\Controller\Admin;
use App\Controller\Admin\Page;
use App\Model\Entity\Pedido as M_Pedido;
use App\Model\Entity\Recebimentos as M_Recebimentos;
use App\Model\Entity\PedidoPagamento as M_PedidoPag;
use App\Model\Entity\Empresa as M_Empresa;
use App\Model\Entity\Cliente as M_Cliente;
use App\Utils\View;

class Promissorias extends Page {

    /*
    * Metodo resposave por retornar o conteudo da view do home
    *  @retunr string 
    */
    public static function getDevedores(){

        $tr = '';
        $tr2 = '';


        $pedidos = M_Pedido::buscarAbertos('pedidopagamentos.moeda = "Promissoria" and pedidopagamentos.acertado = "N" order by dtpedido',null,null,'*');

        while($pedido = $pedidos->fetchObject()){

            $cliente = M_Cliente::buscar('codcli = '.$pedido->codcli)->fetchObject();


            $date = date_create($pedido->dtpedido);
            $dateV = date_create($pedido->vencimento);

            $tr .= View::render('admin/promissorias/pedidos', [
                'numped' => $pedido->numped,
                'cliente' =>  $cliente->cliente,
                'moeda' =>  $pedido->moeda,
                'dtpedido' => date_format($date,'d/m/Y'),
                'vlliq' => $pedido->valor,
                'dtvenc' => date_format($dateV,'d/m/Y')

            ]);

        }

        $recebimentos = M_Recebimentos::buscar('cxencerrado is null');

        while($pedido =  $recebimentos->fetchObject()){

            $date = date_create($pedido->data);
         
            $tr2 .= View::render('admin/promissorias/recebidos', [
                'numped' => $pedido->numped,
                'cliente' =>  $pedido->id,
                'moeda' =>  'Dinheiro',
                'dtpedido' => date_format($date,'d/m/Y'),
                'vlliq' => $pedido->valor,
                'dtvenc' => ''

            ]);

        }

        $content = View::render('admin/promissorias', [
            'tr' => $tr,
            'tr2' => $tr2
        ]);

        return parent::getPageLogin('Controle',$content);
    }

    public static function getPedidoItens($id){

        $tr = '';
        $itens = M_Pedido::buscarItens('numped = '.$id,null,null,'pedidoitens.*, cadprod.descricao');

        while ($item = $itens->fetchObject()){

            $tr .= View::render('admin/controlepedido/produtos', [
                'codprod' => $item->codprod,
                'descricao' =>  $item->descricao,
                'qt' => $item->qt,
                'punit' => $item->punit,
                'vlliq' => $item->vlliq
            ]);
        }
        return $tr;

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

    public static function extornarecebimento($request){
        $postVars = $request->getPostVars();
     
        $rec = M_Recebimentos::buscar('id = '.  $postVars['numerorecebimento'])->fetchObject();
        
        $numped = $rec->numped;
        $valorRec = $rec->valor;

        $pedidoPag = M_PedidoPag::buscar('numped = '. $numped)->fetchObject();


        if(!isset($pedidoPag->valorpago)){
            M_PedidoPag::ExtornaBaixaTotal($numped);
            M_Recebimentos::excluir($postVars['numerorecebimento']);
        }else{
            M_PedidoPag::ExtornaBaixaParcial($numped,$pedidoPag->valor,$valorRec);
            M_Recebimentos::excluir($postVars['numerorecebimento']);
        }

        header("Location: http://localhost/controle/admin/promissorias");
        die();

    }

    }

