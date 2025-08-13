<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class Pedido

{

    public $numped;
    public $codcli;
    public $codmesa;
    public $dtpedido;
    public $vltotal;
    public $vldesconto;
    public $acrescimo;
    public $cxencerrado;
    public $fechador_caixa;
    public $imprimir;
    public $coditem;


    public function cadastrar(){

        $this->dtpedido = Date('Y-m-d H:i');

        $obDatabase = new Database('pedido');
        $id = $obDatabase->insert([
            'codcli' => $this->codcli,
            'vldesconto' => $this->vldesconto,
            'acrescimo' => $this->acrescimo,
            'dtpedido' => $this->dtpedido,
            'vltotal' => $this->vltotal,
        ]);

        return $id;
    }

    public static function deletar($id){
        $obDatabase = new Database('pedido');
        $success = $obDatabase->delete('numped = '.$id);
    }


    public static function buscar($where = null, $order = null, $limit = null, $filds = '*'){

        return  (new Database('pedido'))->selectJoin($where,$order,$limit,$filds,
            'cadcliente', 'pedido.codcli = cadcliente.codcli');

    }

    public function excluirItem()
    {
        $obDatabase = new Database('pedidoitens');
        $success = $obDatabase->delete('coditem = ' . $this->coditem);
    }

    public static function buscarQt($where = null, $order = null, $limit = null, $filds = '*'){

        return  (new Database('pedido'))->select($where,$order,$limit,$filds);

    }

    public static function atualizar(){

        $cxencerrado = Date('Y-m-d H:i');
        $obDatabase = new Database('pedido');
        $success = $obDatabase->update('cxencerrado is null',[
            'cxencerrado' =>  $cxencerrado
        ]);
    }

    public static function finaliza($numped){

        $cxencerrado = Date('Y-m-d H:i');
        $obDatabase = new Database('pedido');
        $success = $obDatabase->update('numped = '.$numped,
            [
                'dtfechamento' =>  $cxencerrado
            ]);
    }

    public function atualizarCliente($numped,$codcli){

        $obDatabase = new Database('pedido');
        $success = $obDatabase->update('numped = '.$numped,[
            'codcli' =>  $codcli
        ]);
    }


    public function atualizarDesconto($numped,$desconto){

        $obDatabase = new Database('pedido');
        $success = $obDatabase->update('numped = '.$numped,[
            'vldesconto' =>  $desconto
        ]);
    }


    public function atualizaracrescimo($numped,$acrescimo){

        $obDatabase = new Database('pedido');
        $success = $obDatabase->update('numped = '.$numped,[
            'acrescimo' =>  $acrescimo
        ]);
    }

    public static function buscarItens($where = null, $order = null, $limit = null, $filds = '*'){

        return  (new Database('pedidoitens'))->selectJoin($where,$order,$limit,$filds,'cadprod', 'pedidoitens.codprod = cadprod.codprod');

    }

    public static function buscarAbertos($where = null, $order = null, $limit = null, $filds = '*'){

        return  (new Database('pedido'))->selectJoin($where,$order,$limit,$filds,'pedidopagamentos', 'pedidopagamentos.numped = pedido.numped');

    }


    public static function buscarItensCodcli($where = null, $order = null, $limit = null, $filds = '*'){

        return  (new Database('pedidoitens'))->selectJoin($where,$order,$limit,$filds,'pedido', 'pedidoitens.numped = pedido.numped');

    }

    public static function buscarItensProdutos($where = null, $order = null, $limit = null, $filds = '*'){

        return  (new Database('pedidoitens'))->selectJoin($where,$order,$limit,$filds,'pedido', 'pedidoitens.numped = pedido.numped join cadprod on pedidoitens.codprod = cadprod.codprod ');

    }

}