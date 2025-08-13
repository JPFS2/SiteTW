<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class Sangria
{
    public $codigo;
    public $descricao;
    public $valor;
    public $data;
    public $tipo;
    public $cxencerrado;

    public function cadastraSangria()
    {
        $obDatabase = new Database('sangria');
        $id = $obDatabase->insert(['descricao' => $this->descricao, 'valor' => $this->valor, 'data' => "current_timestamp()", 'tipo' => $this->tipo ,]);
        return $id;
    }

    public static function removeSangria($id)
    {
        $obDatabase = new Database('sangria');
        $success = $obDatabase->delete('id = ' . $id);
    }

    public static function fechaSangria(){
        $cxencerrado = Date('Y-m-d H:i');
        $obDatabase = new Database('sangria');
        $success = $obDatabase->update('cxencerrado is null',[
            'cxencerrado' => $cxencerrado,
        ]);
    }

    public static function buscar($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('sangria'))->select($where, $order, $limit, $filds);
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