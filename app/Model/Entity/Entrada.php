<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class Entrada
{
    public $codentrada;
    public $codprod;
    public $quantidade;
    public $valor;

    public static function buscar($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('entradas'))->select($where, $order, $limit, $filds);
    }

    public static function buscarComProduto($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('entradas'))->selectJoin($where, 'entradas.codentrada desc', $limit, 'entradas.*, cadprod.descricao', 'cadprod', 'entradas.codprod = cadprod.codprod');
    }


    public function cadastra()
    {
        $obDatabase = new Database('entradas');
        $id = $obDatabase->insert(
            ['codprod' => $this->codprod,
                'qt' => $this->quantidade,
                'valor' => $this->valor
            ]);
        return $id;
    }


    public function atualizar()
    {
        $obDatabase = new Database('mesa');
        $success = $obDatabase->update('codcar =' . $this->codcar, ['codprod' => $this->codprod, 'punit' => $this->punit, 'qt' => $this->qt, 'vlliq' => ($this->qt * $this->punit), 'dtinclusao' => 'CURRENT_DATE()', 'codcli' => $this->codcli]);
    }

    public static function excluir($codentrada)
    {
        $obDatabase = new Database('entradas');
        $success = $obDatabase->delete('codentrada = ' . $codentrada);
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