<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class Perca
{
    public $codentrada;
    public $codprod;
    public $quantidade;
    public $valor;
    public $data;
    

    public static function buscar($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('entradas'))->select($where, $order, $limit, $filds);
    }

    public static function buscarComProduto($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('percas'))->selectJoin($where, $order, $limit, 'percas.*, cadprod.descricao', 'cadprod', 'percas.codprod = cadprod.codprod');
    }
    public static function buscarPorGP($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('manutencao RIGHT'))->selectJoin($where, $order, $limit, 'IF(manutencao.codmanutencao, "Garantia","Perca") as tipo, percas.*, cadprod.descricao', 'percas', 'manutencao.entrada = percas.codprod JOIN cadprod ON percas.codprod = cadprod.codprod');
    }


    public function cadastra()
    {
        $this->data = Date('Y-m-d H:i');
        $obDatabase = new Database('percas');
        $id = $obDatabase->insert(
            ['codprod' => $this->codprod,
                'qt' => $this->quantidade,
                'custo' => $this->valor,
                'data' => $this->data ,
                
            ]);
        return $id;
    }

    public static function excluir($codentrada)
    {
        $obDatabase = new Database('percas');
        $success = $obDatabase->delete('idperca = ' . $codentrada);
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