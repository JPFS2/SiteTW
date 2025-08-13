<?php 

namespace App\Controller\Admin;
use App\Controller\Admin\Page;

use App\Model\Entity\Pedido as M_Pedido;
use App\Model\Entity\Manutencao as M_Manutencao;
use App\Model\Entity\Abastecimento as M_Abastecimento;
use App\Model\Entity\Sangria as M_Sangria;
use App\Model\Entity\Empresa as M_Empresa;
use App\Model\Entity\Cliente as M_Cliente;
use App\Model\Entity\Recebimentos as M_Recebido;


use App\Utils\View;

class RelacaoCaixas extends Page {

    /*
    * Metodo resposave por retornar o conteudo da view do home
    *  @retunr string 
    */
    public static function getCaixas(){

        $tr = '';
        $datas = array();

       $pedidos = M_Pedido::buscar('cxencerrado is not null','cxencerrado desc',null,'cxencerrado');

        while($pedido = $pedidos->fetchObject()){
            $datas[] = date_format(date_create($pedido->cxencerrado), 'Ymd');
        }


        $abastecimentos = M_Abastecimento::buscar('cxencerrado is not null',null,null,'cxencerrado');

        while($abastecimento = $abastecimentos->fetchObject()){
            $datas[] = date_format(date_create($abastecimento->cxencerrado), 'Ymd');
        }

        $sangrias = M_Sangria::buscar('cxencerrado is not null',null,null,'cxencerrado');

        while($sangria = $sangrias->fetchObject()){
            $datas[] = date_format(date_create($sangria->cxencerrado), 'Ymd');
        }

        $data = array_unique($datas);
        unset($data['17']);

        foreach ($data as $dt){


            $dinheiro = floatval(M_Pedido::buscarAbertos("date(cxencerrado) = '$dt' and moeda = 'Dinheiro'",null,null,'sum(valor) as valor')->fetchObject()->valor);
            $dinheiro += floatval(M_Manutencao::buscarJoinPag("date(cxencerrado) = '$dt' and moeda = 'Dinheiro'",null,null,'sum(valor) as valor')->fetchObject()->valor);;

            $credito = floatval(M_Pedido::buscarAbertos("date(cxencerrado) = '$dt' and moeda = 'Cartao Credito'",null,null,'sum(valor) as valor')->fetchObject()->valor);
            $dinheiro += floatval(M_Manutencao::buscarJoinPag("date(cxencerrado) = '$dt' and moeda = 'Cartao Credito'",null,null,'sum(valor) as valor')->fetchObject()->valor);;


            $debito = floatval(M_Pedido::buscarAbertos("date(cxencerrado) = '$dt' and moeda = 'Cartao debito'",null,null,'sum(valor) as valor')->fetchObject()->valor);
            $debito += floatval(M_Manutencao::buscarJoinPag("date(cxencerrado) = '$dt' and moeda = 'Cartao debito'  ",null,null,'sum(valor) as valor')->fetchObject()->valor);;

            $pix  =  floatval(M_Pedido::buscarAbertos("date(cxencerrado) = '$dt' and moeda = 'Pix'",null,null,'sum(valor) as valor')->fetchObject()->valor);
            $pix += floatval(M_Manutencao::buscarJoinPag("date(cxencerrado) = '$dt' and moeda = 'Pix'",null,null,'sum(valor) as valor')->fetchObject()->valor);;

            $link = floatval(M_Pedido::buscarAbertos("date(cxencerrado) = '$dt' and moeda = 'Link'",null,null,'sum(valor) as valor')->fetchObject()->valor);
            $link += floatval(M_Manutencao::buscarJoinPag("date(cxencerrado) = '$dt' and moeda = 'Link'  ",null,null,'sum(valor) as valor')->fetchObject()->valor);;


            $abs = M_Abastecimento::buscar("date(cxencerrado) = '$dt'",null,null,'sum(valor) as valor')->fetchObject()->valor;
            $sang = M_Sangria::buscar("date(cxencerrado) = '$dt'",null,null,'sum(valor) as valor')->fetchObject()->valor;



            $recebidos = M_Recebido::buscar("date(cxencerrado) = '$dt'",null,null,'sum(valor) as valor')->fetchObject()->valor;

            $data = substr($dt,6,2).'/'.substr($dt,4,2).'/'.substr($dt,0,4);

            $tr .= View::render('admin/relacaocaixa/produtos', [
                'dtlink' => $dt ,
                'data' => $data ,
                'dinheiro' =>  $dinheiro,
                'credito' =>  $credito,
                'debito' =>  $debito,
                'pix' =>  $pix,
                'link' =>  $link,
                'abastecimento' =>  $abs,
                'sangria' =>  isset($sang) ? $sang : '0,00',
                'quitados' => isset($recebidos) ? $recebidos : '0,00',
                'total' =>  round($dinheiro+$credito+$debito+$abs-$sang+$recebidos+$pix,2),
            ]);
        }




        $content = View::render('admin/relacao_caixas', [
            'tr' => $tr
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

    }

