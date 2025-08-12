<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class Mesa
{
    public $codCli;
    public $codmesaitem;
    public $codmesa;
    public $codprod;
    public $qt;
    public $precounitario;
    public $precototal;
    public $vldesconto;
    public $acrescimo;

    public function atualizar()
    {
        $obDatabase = new Database('mesa');
        $success = $obDatabase->update('codcar =' . $this->codcar, [
            'codprod' => $this->codprod,
            'punit' => $this->punit,
            'qt' => $this->qt,
            'vlliq' => ($this->qt * $this->punit),
            'dtinclusao' => 'CURRENT_DATE()',
            'codcli' => $this->codcli
        ]);
    }

    public function atualizarCliente()
    {
        $obDatabase = new Database('mesa');
        $success = $obDatabase->update('1 = 1', ['codcli' => $this->codCli,]);
    }

    public function atualizarDesconto()
    {
        $obDatabase = new Database('mesa');
        $success = $obDatabase->update('1 = 1', [
            'desconto' => $this->vldesconto,
            ]);
    }

    public function atualizarAcrescimo()
    {
        $obDatabase = new Database('mesa');
        $success = $obDatabase->update('1 = 1', [
            'acrescimo' => $this->acrescimo,
        ]);
    }

    public static function zeraCliente()
    {
        $obDatabase = new Database('mesa');
        $success = $obDatabase->update('1 = 1', ['codcli' => 1,]);
    }

    public static function zeraDesconto()
    {
        $obDatabase = new Database('mesa');
        $success = $obDatabase->update('1 = 1', ['desconto' => '0',]);
    }

    public static function zeraAcrescimo()
    {
        $obDatabase = new Database('mesa');
        $success = $obDatabase->update('1 = 1', ['acrescimo' => '0',]);
    }

    public function cadastrarItem()
    {
        $obDatabase = new Database('mesaitens');
        $id = $obDatabase->insert([
            'codmesa' => $this->codmesa,
            'codprod' => $this->codprod,
            'qt' => $this->qt,
            'precounitario' => $this->precounitario,
            'precototal' => (doubleval($this->qt) * doubleval($this->precounitario)),]);
        return $id;
    }

    public static function excluir()
    {
        $obDatabase = new Database('mesaitens');
        $success = $obDatabase->delete('1 = 1');
    }

    public function excluirItem()
    {
        $obDatabase = new Database('mesaitens');
        $success = $obDatabase->delete('codmesaitem = ' . $this->codmesaitem);
    }

    public static function buscar($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('mesa'))->select($where, $order, $limit, $filds);
    }

    public static function buscarItens($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('mesaitens'))->select($where, $order, $limit, $filds);
    }

    public static function buscarJoin($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('mesaitens'))->selectJoin($where, $order, $limit, $filds, 'cadprod', 'cadprod.codprod = mesaitens.codprod');
    }
}