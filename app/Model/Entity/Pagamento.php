<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class Pagamento
{
    public $codigo;
    public $moeda;
    public $valor;
    public $vencimento;
    public $codmesa;

    public static function excluir()
    {
        $obDatabase = new Database('mesapagamentos');
        $success = $obDatabase->delete('1 = 1');
    }

    public static function buscarPMesa($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('mesapagamentos'))->select($where, $order, $limit, $filds);
    }

    public static function buscarItens($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('mesaitens'))->select($where, $order, $limit, $filds);
    }

    public static function buscarJoin($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('mesaitens'))->selectJoin($where, $order, $limit, $filds, 'cadprod', 'cadprod.codprod = mesaitens.codprod');
    }

    public function atualizar()
    {
        $obDatabase = new Database('mesa');
        $success = $obDatabase->update('codcar =' . $this->codcar, ['codprod' => $this->codprod, 'punit' => $this->punit, 'qt' => $this->qt, 'vlliq' => ($this->qt * $this->punit), 'dtinclusao' => 'CURRENT_DATE()', 'codcli' => $this->codcli]);
    }
    
    public function cadastrarPmesa()
    {
        if($this->valor > 0){
            $obDatabase = new Database('mesapagamentos  ');
            $id = $obDatabase->insert(
                [
                    'codmesa' => $this->codmesa,
                    'moeda' => $this->moeda,
                    'valor' => $this->valor,
                    'vencimento' => $this->vencimento
                ]);
            return $id;
        }
        return 0;
    }

    public function excluirItem()
    {
        $obDatabase = new Database('mesapagamentos');
        $success = $obDatabase->delete('codigo = ' . $this->codigo);
    }
}