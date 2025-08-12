<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class tarefa
{
    public $codigo;
    public $descricao;
    public $dtlancamento;
    public $dtfinalizacao;

    public static function buscar($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('tarefas'))->select($where, $order, $limit, $filds);
    }

    public function cadastrar()
    {
        $obDatabase = new Database('tarefas');
        $success = $obDatabase->insert(
            [
                'descricao' => $this->descricao,
                'dtlancamento' => $this->dtlancamento,
            ]
        );
        return $success;
    }


    public static function buscarJoin($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('cadprod'))->selectJoin($where, $order, $limit, $filds, 'cadsecao', 'cadprod.codsecao = cadsecao.codsecao');
    }

    public function atualizar()
    {
        $obDatabase = new Database('cadprod');
        $success = $obDatabase->update('codprod =' . $this->codprod,
            ['descricao' => $this->descricao,
                'ean13' => $this->ean13,
                'modelo' => $this->modelo,
                'codsecao' => $this->codsecao,
                'und' => $this->und,
                'peso' => $this->peso,
                'qtestoque' => $this->qtestoque,
                'punit' => str_replace(',', '.', $this->punit),
                'pcompra' => str_replace(',', '.', $this->pcompra)
            ]);
    }

    public static function baixaEstoque($codprod,$qt)
    {

        $qtant = (new Database('cadprod'))->select(' codprod = '.$codprod, null, null, 'qtestoque')->fetchObject()->qtestoque;
        $qtnovo = $qtant - $qt;

        $obDatabase = new Database('cadprod');
        $success = $obDatabase->update('codprod =' .$codprod, [
            'qtestoque' => $qtnovo,
            ]
        );
    }

    public static function retornaEstoque($codprod, $qt)
    {

        $qtestoque = self::buscar('codprod = '.$codprod,null,null,'qtestoque as qt')->fetchObject()->qt;;
        $qtnovo = $qtestoque + $qt;

        $obDatabase = new Database('cadprod');
        $success = $obDatabase->update('codprod =' . $codprod, [
                'qtestoque' => $qtnovo,
            ]
        );
    }
    
    public static function deletar($id){
        $obDatabase = new Database('tarefas');
        $success = $obDatabase->delete('codigo = '.$id);
    }

    public function aumentaCusto($custo)
    {

        $custoAtual = self::buscar('codprod = '.$this->codprod,null,null,'pcusto as qt')->fetchObject()->qt;;
        $custoNovo = $custoAtual + $custo;

        $obDatabase = new Database('cadprod');
        $success = $obDatabase->update('codprod =' . $this->codprod, [
                'pcusto' => $custoNovo,
            ]
        );
    }



    public function updateDtFinalizacao()
    {
        $obDatabase = new Database('tarefas');
        $success = $obDatabase->update('codigo  =' . $this->codigo,
            [
                'dtfinalizacao' => $this->dtfinalizacao
            ]);
    }
    
}