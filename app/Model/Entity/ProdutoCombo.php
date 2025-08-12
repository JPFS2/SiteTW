<?php

namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class ProdutoCombo
{
    public $codprodutocombo;
    public $codigocombo;
    public $codigoproduito;
    public $quantidade;

    public static function buscar($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('produtocombo'))->select($where, $order, $limit, $filds);
    }

    public static function buscarJoin($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('produtocombo'))->selectJoin($where, $order, $limit, $filds, 'cadprod', 'produtocombo.codigoproduto = cadprod.codprod');
    }


    public function cadastrar()
    {
        $this->codigocombo = self::buscar(null,null,null,'max(codigocombo) as codigo')->fetchObject()->codigo;
        $this->codigocombo = $this->codigocombo + 1;

        $obDatabase = new Database('produtocombo');
        $success = $obDatabase->insert(
            [
                'codigocombo' => $this->codigocombo,
                'codigoproduto' => $this->codigoproduito,
                'quantidade' => $this->quantidade,
            ]
        );
        return $success;
    }

    public function cadastrarCombo()
    {
        $obDatabase = new Database('produtocombo');
        $success = $obDatabase->insert(
            [
                'codigocombo' => $this->codigocombo,
                'codigoproduto' => $this->codigoproduito,
                'quantidade' => $this->quantidade,
            ]
        );
        return $success;
    }

    public function atualizar()
    {
        $obDatabase = new Database('produtocombo');
        $success = $obDatabase->update('codigocombo =' . $this->codigocombo,
            [
                'codigocombo' => $this->codigocombo,
                'codigoproduto' => $this->codigoproduito,
                'quantidade' => $this->quantidade,
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


    public static function deletar($id){
        $obDatabase = new Database('produtocombo');
        $success = $obDatabase->delete('codprodutocombo = '.$id);
    }

    public static function deletarCombo($id){
        $obDatabase = new Database('produtocombo');
        $success = $obDatabase->delete('codigocombo = '.$id);
    }

}