<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class Recebimentos
{
    public $id;
    public $numped;
    public $valor;
    public $data;
    public $cxencerrado;

    public static function buscar($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('recebimentos'))->select($where, $order, $limit, $filds);
    }

    public function cadastraRecebimentoPromissoria()
    {
        $data = Date('Y-m-d H:i');
        $obDatabase = new Database('recebimentos');
        $id = $obDatabase->insert(['numped' => $this->numped, 'valor' => str_replace(',', '.', $this->valor), 'data' => $data]);
        return $id;
    }

    public static function fechaRecebimentoPromissoria()
    {
        $cxencerrado = Date('Y-m-d H:i');
        $obDatabase = new Database('recebimentos');
        $success = $obDatabase->update('cxencerrado is null', ['cxencerrado' => $cxencerrado,]);
    }

    public static function removeAbastecimento($id)
    {
        $obDatabase = new Database('abastecimento');
        $success = $obDatabase->delete('id = ' . $id);
    }

    public function fechaAbastecimento()
    {
        $obDatabase = new Database('abastecimento');
        $success = $obDatabase->update('1 =1', ['cxencerrado' => 'CURRENT_DATE()',]);
    }

    public function atualizar()
    {
        $obDatabase = new Database('mesa');
        $success = $obDatabase->update('codcar =' . $this->codcar, ['codprod' => $this->codprod, 'punit' => $this->punit, 'qt' => $this->qt, 'vlliq' => ($this->qt * $this->punit), 'dtinclusao' => 'CURRENT_DATE()', 'codcli' => $this->codcli]);
    }

    public static function excluir($id)
    {
        $obDatabase = new Database('recebimentos');
        $success = $obDatabase->delete('id = '.$id);
    }

    public static function buscarItens($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('pedidopagamentos'))->select($where, $order, $limit, $filds);
    }

    public static function buscarPagPedidos($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('pedidopagamentos'))->selectJoin($where, $order, $limit, $filds, 'pedido', 'pedidopagamentos.numped = pedido.numped');
    }
}