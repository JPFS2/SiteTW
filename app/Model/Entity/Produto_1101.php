<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class Produto
{
    public $codprod;
    public $descricao;
    public $ean13;
    public $modelo;
    public $codsecao;
    public $und = 'UND';
    public $peso;
    public $pcompra = 0;
    public $punit;
    public $qtestoque;

    public static function buscar($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('cadprod'))->select($where, $order, $limit, $filds);
    }

    public static function buscarJoin($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('cadprod'))->selectJoin($where, $order, $limit, $filds, 'cadsecao', 'cadprod.codsecao = cadsecao.codsecao');
    }

    public function atualizar()
    {
        $obDatabase = new Database('cadprod');
        $success = $obDatabase->update('codprod =' . $this->codprod, ['descricao' => $this->descricao, 'ean13' => $this->ean13, 'modelo' => $this->modelo, 'codsecao' => $this->codsecao, 'und' => $this->und, 'peso' => $this->peso, 'qtestoque' => $this->qtestoque, 'punit' => str_replace(',', '.', $this->punit), 'pcompra' => str_replace(',', '.', $this->pcompra)]);
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

    public function cadastrar()
    {
        $obDatabase = new Database('cadprod');
        $success = $obDatabase->insert(['descricao' => $this->descricao, 'ean13' => $this->ean13, 'modelo' => $this->modelo, 'codsecao' => $this->codsecao, 'und' => $this->und, 'peso' => $this->peso, 'qtestoque' => $this->qtestoque, 'punit' => str_replace(',', '.', $this->punit), 'pcompra' => str_replace(',', '.', $this->pcompra)]);
        return $success;
    }

    public static function deletar($id){
        $obDatabase = new Database('cadprod');
        $success = $obDatabase->delete('codprod = '.$id);
    }

}