<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class Abastecimento
{
    public $codigo;
    public $descricao;
    public $valor;
    public $data;
    public $cxencerrado;

    public static function buscar($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('abastecimento'))->select($where, $order, $limit, $filds);
    }

    public function cadastraAbastecimento()
    {
        $obDatabase = new Database('abastecimento');
        $id = $obDatabase->insert(['descricao' => $this->descricao, 'valor' => str_replace(',', '.', $this->valor), 'data' => "current_timestamp()"]);
        return $id;
    }

    public static function removeAbastecimento($id)
    {
        $obDatabase = new Database('abastecimento');
        $success = $obDatabase->delete('id = ' . $id);
    }

    public static function fechaAbastecimento(){
        $cxencerrado = Date('Y-m-d H:i');
        $obDatabase = new Database('abastecimento');
        $success = $obDatabase->update('cxencerrado is null',[
            'cxencerrado' => $cxencerrado,
        ]);
    }

    public function atualizar()
    {
        $obDatabase = new Database('mesa');
        $success = $obDatabase->update('codcar =' . $this->codcar, ['codprod' => $this->codprod, 'punit' => $this->punit, 'qt' => $this->qt, 'vlliq' => ($this->qt * $this->punit), 'dtinclusao' => 'CURRENT_DATE()', 'codcli' => $this->codcli]);
    }

    public function excluir()
    {
        $obDatabase = new Database('mesa');
        $success = $obDatabase->delete('codcar = ' . $this->codcar);
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