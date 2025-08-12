<?php 

namespace App\Controller\Admin;
use App\Controller\Admin\Page;
use App\Model\Entity\Produto as M_Produto;
use App\Model\Entity\Pedido as M_Pedido;
use App\Model\Entity\Abastecimento as M_Abastecimento;
use App\Model\Entity\Sangria as M_Sangria;
use App\Model\Entity\Empresa as M_Empresa;
use App\Model\Entity\Cliente as M_Cliente;
use App\Model\Entity\Recebimentos as M_Recebido;
use App\Model\Entity\Manutencao as M_Manutencao;
use App\Model\Entity\ManutencaoPagamentos as M_ManutencaoPag;

use App\Utils\View;

class RelacaoManutencoes extends Page {

    /*
    * Metodo resposave por retornar o conteudo da view do home
    *  @retunr string 
    */
    public static function getManutencoes(){

        $tr = '';

        $manutencoes = M_Manutencao::buscarJoinPag(null,null,null,'manutencao.*');

        foreach ($manutencoes as $manutencao){

            $dtman = $manutencao['dtmanutencao'];
            $produto = M_Produto::buscar('codprod = '.$manutencao['entrada'])->fetchObject();
            $produtoR = M_Produto::buscar('codprod = '.$manutencao['saida'])->fetchObject();

            $cliente = M_Cliente::buscar('codcli ='.$manutencao['codcliente'],null,null,'cliente')->fetchObject()->cliente;


            $tr .= View::render('admin/relacaomanutencoes/produtos', [
                'cliente' => $cliente,
                'codigo' => $manutencao['codmanutencao'],
                'data' => $dtman,
                'dinheiro' =>  $manutencao['tipo'] ,
                'credito' =>  $manutencao['tiposervico'],
                'debito' =>  isset($produto->descricao) ? $produto->descricao.' - N° '.$produto->peso :   '',
                'debitoR' =>  isset($produtoR->descricao) ? $produtoR->descricao.' - N° '.$produtoR->peso : '',
                'abastecimento' => $manutencao['descricao'],
                'sangria' => $manutencao['custo'],
                'quitados' =>  isset($manutencao['moeda']) ?  $manutencao['moeda'] : 'Não Informado',
                'total' =>   isset($manutencao['valor']) ?  $manutencao['valor'] : 'Não Informado',
                'obs' =>   isset($manutencao['obs']) ?  $manutencao['obs'] : 'Não Informado',
            ]);
        }

        $content = View::render('admin/relacaomanutencao', [
            'tr' => $tr
        ]);

        return parent::getPageLogin('Controle',$content);
    }

    public static function addCliente($request)
    {
        $postVars = $request->getPostVars();
        $mesa = new M_Mesa();
        $mesa->codCli = $postVars['codcli'];

        $mesa->atualizarCliente();

        header("Location: https://juninhodoiphone.com/controle/admin/venda");
        die();
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

    }

