<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class ManutencaoPagamentos
{
    public $idmanutencaopag;
    public $codmanutencao;
    public $moeda;
    public $valor;
    public $dtpagamento;
    public $cxencerrado;


    public static function buscar($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('manutencaopagamentos'))->select($where, $order, $limit, $filds);
    }

    public static function buscarJoin($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('manutencaopagamentos'))->selectJoin($where, $order, $limit, $filds, 'manutencao', 'manutencao.codmanutencao = manutencaopagamentos.codmanutencao');
    }

    public static function finalizar()
    {
        $dtencerrado = Date('Y-m-d H:i');
        $obDatabase = new Database('manutencao');
        $success = $obDatabase->update('dtencerrado is null',
            [
                'dtencerrado' => $dtencerrado,
            ]);
    }



    public static function atualizar(){

        $cxencerrado = Date('Y-m-d H:i');
        $obDatabase = new Database('manutencaopagamentos');
        $success = $obDatabase->update('cxencerrado is null',[
            'cxencerrado' =>  $cxencerrado
        ]);
    }

    public function cadastrar()
    {
        $this->dtpagamento = Date('Y-m-d H:i');
        $obDatabase = new Database('manutencaopagamentos');
        $success = $obDatabase->insert(            [
            'codmanutencao' => $this->codmanutencao,
            'moeda' => $this->moeda,
            'valor' => $this->valor,
            'dtpagamento' => $this->dtpagamento,
        ]);
        return $success;
    }

    
    public function cadastrarCancel()
    {
        $this->dtpagamento = Date('Y-m-d H:i');
        $obDatabase = new Database('manutencaopagamentoscopia');
        $success = $obDatabase->insert(            [
            'codmanutencao' => $this->codmanutencao,
            'moeda' => $this->moeda,
            'valor' => $this->valor,
            'dtpagamento' => $this->dtpagamento,
        ]);
        return $success;
    }


    public static function deletar($id){
        $obDatabase = new Database('manutencaopagamentos');
        $success = $obDatabase->delete('codmanutencao = '.$id);
    }

}