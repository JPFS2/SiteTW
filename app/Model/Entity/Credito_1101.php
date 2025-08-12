<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class Credito
{
    public $codcred;
    public $codcli;
    public $vlcredito;
    public $dtbaixa;
    public $codprod;
    public $numpedBaixa;

    public static function buscar($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('credcli'))->select($where, $order, $limit, $filds);
    }

    public static function buscarJoin($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('credcli'))->selectJoin($where, $order, $limit, $filds, 'cadprod', 'credcli.codprod = cadprod.codprod');
    }

    public static function deletar($id)
    {
        $obDatabase = new Database('credcli');
        $success = $obDatabase->delete('codcred = ' . $id);
    }

    public static function atualizar($cliente, $numped)
    {
        $dtpedido = Date('Y-m-d H:i');
        $obDatabase = new Database('credcli');
        $success = $obDatabase->update('codcli =' . $cliente . ' and dtbaixa is null', ['dtbaixa' => $dtpedido, 'numpedBaixa' => $numped,]);
    }

    public function cadastrar()
    {
        $obDatabase = new Database('credcli');
        $success = $obDatabase->insert(['codcli' => $this->codcli, 'vlcredito' => $this->vlcredito, 'codprod' => $this->codprod,]);
        return $success;
    }
}