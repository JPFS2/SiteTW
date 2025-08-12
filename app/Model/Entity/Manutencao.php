<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class Manutencao
{
    public $codmanutencao;
    public $codcliente;
    public $descricao;
    public $tipo;
    public $tiposervico;
    public $entrada;
    public $saida;
    public $materiaprima;
    public $custo;
    public $dtmanutencao;
    public $dtencerrado;
    public $aparelho;
    public $imei;
    public $obs;
    public $obsCancel;


    public static function buscar($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('manutencao'))->select($where, $order, $limit, $filds);
    }

    public static function buscarJoin($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('manutencao left'))->selectJoin($where, $order, $limit, $filds, 'cadprod', 'manutencao.entrada = cadprod.codprod');
    }

    public static function buscarJoinPag($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('manutencao left'))->selectJoin($where, 'manutencao.dtmanutencao desc', $limit, $filds, 'manutencaopagamentos', 'manutencaopagamentos.codmanutencao = manutencao.codmanutencao');
    }
    public function atualizarCliente()
    {
        $obDatabase = new Database('manutencao');
        $success = $obDatabase->update('dtencerrado is null', ['codcliente' => $this->codcliente,]);
    }

    public static function finalizar()
    {
        $dtencerrado = Date('Y-m-d H:i');
        $obDatabase = new Database('manutencao');
        $success = $obDatabase->update('dtencerrado is null and tipo = '. '"Servico"',
            [
                'dtencerrado' => $dtencerrado,
            ]);
    }

    public static function finalizarGarantia()
    {
        $dtencerrado = Date('Y-m-d H:i');
        $obDatabase = new Database('manutencao');
        $success = $obDatabase->update('dtencerrado is null and tipo = '. '"Garrantia"',
            [
                'dtencerrado' => $dtencerrado,
            ]);
    }


    public function atualizar()
    {

        $obDatabase = new Database('manutencao');
        $success = $obDatabase->update('codprod =' . $this->codmanutencao,
            [
                'descricao' => $this->descricao,
                'tipo' => $this->tipo,
                'tiposervico' => $this->tiposervico,
                'entrada' => $this->entrada,
                'saida' => $this->saida,
                'custo' => $this->custo,
            ]);
    }

    public function cadastrar()
    {
        $this->dtmanutencao = Date('Y-m-d H:i');
        $obDatabase = new Database('manutencao');
        $success = $obDatabase->insert([
            'codcliente' => $this->codcliente,
            'descricao' => $this->descricao,
            'tipo' => $this->tipo,
            'tiposervico' => $this->tiposervico,
            'entrada' => $this->entrada,
            'saida' => $this->saida,
            'materiaprima' => $this->materiaprima,
            'custo' => $this->custo,
            'dtmanutencao' => $this->dtmanutencao,
            'aparelho' => $this->aparelho,
            'imei' => $this->imei,
            'obs' => $this->obs,
            ]);

        return $success;
    }

    public function cadastrarCancel()
    {
        $this->dtmanutencao = Date('Y-m-d H:i');
        $obDatabase = new Database('manutencaocopia');
        $success = $obDatabase->insert([
            'codcliente' => $this->codcliente,
            'descricao' => $this->descricao,
            'tipo' => $this->tipo,
            'tiposervico' => $this->tiposervico,
            'entrada' => $this->entrada,
            'saida' => $this->saida,
            'materiaprima' => $this->materiaprima,
            'custo' => $this->custo,
            'dtmanutencao' => $this->dtmanutencao,
            'aparelho' => $this->aparelho,
            'imei' => $this->imei,
            'obs' => $this->obs,
            'obsCancel' => $this->obsCancel,
            ]);

        return $success;
    }


    public function deletar(){
        $obDatabase = new Database('manutencao');
        $success = $obDatabase->delete('codmanutencao = '.$this->codmanutencao);
    }

}