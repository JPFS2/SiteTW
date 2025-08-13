<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\Produto as M_Produto;
use App\Model\Entity\Pedido as M_Pedido;
use App\Model\Entity\Credito as M_Credito;
use App\Model\Entity\ProdutoCombo as M_Combo;
use App\Model\Entity\Secao;
use App\Utils\View;

class RelacaoProduto extends Page
{    /*    * Metodo resposave por retornar o conteudo da view do home    *  @retunr string     */
    public static function addProduto($request)
    {
        $content = View::render('admin/produto_add', ['secao' => self::getSecao($request, 0)]);
        return parent::getPage('Controle', $content);
    }

    public static function getSecao($request, $id)
    {
        $secoes = '';
        $results = Secao::buscar(null, null, null, '*');
        $selectd = '';

        while ($secao = $results->fetchObject(Secao::class)) {
            if ($id == $secao->codsecao) {
                $selectd = 'selected="selected"';
            } else {
                $selectd = '';
            }
            $secoes .= View::render('admin/produtos/secoes', [
                'selectd' => $selectd,
                'codsecao' => $secao->codsecao,
                'secao' => $secao->secao]);
        }
        return $secoes;
    }

    public static function getEstado($estado)
    {
        $tr = "";
        $selection = '';
        $estados = ['S','N'];

        foreach ($estados as $est){
            $selection = ($est == $estado) ? 'selected="selected"' : '';
            $tr .= "<option $selection >$est</option>";
        }
        return $tr;
    }

    public static function adicionaProduto($request)
    {
        $postVars = $request->getPostVars();
        $obProduto = new M_Produto();
        $obProduto->descricao = $postVars['descricao'];
        $obProduto->codsecao = $postVars['codsecao'];
        $obProduto->ean13 = $postVars['ean13'];
        $obProduto->modelo = $postVars['modelo'];
        $obProduto->und = $postVars['und'];
        $obProduto->peso = $postVars['peso'];
        $obProduto->qtestoque = $postVars['qtestoque'];
        $obProduto->pcompra = $postVars['pcompra'];
        $obProduto->punit = $postVars['punit'];
        $obProduto->cadastrar();
        return self::getProdutos($request);
    }

    public static function getProdutoCombo(){


            $tr = '';
            $combos = M_Combo::buscar( 'codigocombo > 0 group by codigocombo','codigocombo',null,'codigocombo  ');

            while($combo = $combos->fetchObject()){

                $prodtos = '| ';
                $itens = M_Combo::buscarJoin( 'codigocombo = '.$combo->codigocombo,null,null,'*');


                while($item = $itens->fetchObject()){

                    $prodtos .= $item->quantidade.'- '.$item->descricao
                        .' <a href="https://juninhodoiphone.com/controle/admin/removeprodutocombo/"'
                        .$item->codprodutocombo
                        .'><i class="fa fa-trash text-danger"></i></a>'
                        .' | ';
                }

                $tr .= View::render('admin/comboproduto/pedidos', [
                    'codcombo' => $combo->codigocombo,
                    'produtos' =>  $prodtos
                ]);

            }

            $content = View::render('admin/produtocombo', [
                'tr' => $tr,
                'option' => self::getProdutoInsert(),
            ]);

            return parent::getPageLogin('Controle',$content);
        }

    public static function apagaCombo($codigo){

    }

    public static function removeProdutoCombo($codigo){
        M_Combo::deletar($codigo);

        header("Location: https://juninhodoiphone.com/controle/admin/comboproduto");
        die();
    }


    public static function removeCombo($codigo){
        M_Combo::deletarCombo($codigo);

        header("Location: https://juninhodoiphone.com/controle/admin/comboproduto");
        die();
    }

    public static function addCombo($request){

        $postVars = $request->getPostVars();

        $produto = explode('-',$postVars['produto']) ;

        $combo = new M_Combo();
        $combo->codigocombo = $postVars['codigoCombo'];
        $combo->codigoproduito =array_shift($produto);
        $combo->quantidade = $postVars['quantidade'];

        if($combo->codigocombo == 0){
            $combo->cadastrar();
        }else{
            $combo->cadastrarCombo();
        }

        header("Location: https://juninhodoiphone.com/controle/admin/comboproduto");
        die();

    }

    public static function getProdutoInsert()
    {
        $tr = '';
        $results = M_Produto::buscar('qtestoque > 0', null, null, '*');

        while ($produto = $results->fetchObject()) {
            $tr .= View::render('admin/mesa/produto_insert',
                ['codigo' => $produto->codprod,
                    'descricao' => $produto->descricao,
                    'ean13' => $produto->ean13,
                    'imei' => $produto->peso,
                    'preco' => $produto->punit ?? 'NÃO INFORMADO',
                ]
            );
        }

        return $tr;
    }

    public static function getPorAparelho($request)
    {
        $tr =  "";

        $resultados = M_Produto::buscar('Qtestoque > 0 and codsecao = 1 GROUP by descricao, ean13', 'descricao', null, 'descricao, ean13, SUM(qtestoque) as sum, SUM(punit) as punit');

        while ($secao = $resultados->fetchObject()){

            $tr .= View::render('admin/relacaoproduto/totalproduto',
                [
                    'descricao' => $secao->descricao,
                    'capacidade' => $secao->ean13,
                    'qtestoque' => $secao->sum,
                    'punitmedio' => round(($secao->punit / $secao->sum),2),
                    'punit' => $secao->punit,
                ]);


        }
        return $tr;

    }




    /**     * Realiza a Chamada da tela de produtos     * @param $request * @return string */

 public static function getProdutos($request)
    {
        $content = View::render('admin/relacaoproduto',
            [
                'tr' => self::getProduto($request),
                'tr2' => self::getSecaoTotal($request),
                'tr3' => self::getSecaoTotal($request)
            ]);
        return parent::getPageLogin('Controle', $content);
    }
    
    

    public static function getSecaoTotal($request)
    {
        $tr =  "";

        $resultados = M_Produto::buscar('qtestoque > 0 GROUP by codsecao', null, null, 'codsecao, SUM(qtestoque) as sum');

        $desc_secoes = array(
            "1" => "Celulares",
            "2" => "Acessórios",
            "3" => "Acessorios/Brindes",
            "4" => "Materia-Prima"
        );

        while ($secao = $resultados->fetchObject()){

            if (array_key_exists($secao->codsecao,$desc_secoes)) {
                $sec =  $desc_secoes[$secao->codsecao]; // Retornar a descrição correspondente
            } else {
                $sec = "Não Informada"; // Caso o código não exista
            }

            $tr .= View::render('admin/relacaoproduto/totalsecao',
                [
                    'codsecao' => $secao->codsecao,
                    'secao' => $sec,
                    'qtestoque' => $secao->sum,
                ]);


        }
        return $tr;

    }

    public static function getProduto($request)
    {
        $tr = '';

        $results = M_Produto::buscar('qtestoque > 0', null, null, '*');


        $desc_secoes = array(
            "1" => "Celulares",
            "2" => "Acessórios",
            "3" => "Acessorios/Brindes",
            "4" => "Materia-Prima"
        );


        while ($produto = $results->fetchObject(M_Produto::class)) {
            $secao = '';

            if (array_key_exists($produto->codsecao,$desc_secoes)) {
                $secao =  $desc_secoes[$produto->codsecao]; // Retornar a descrição correspondente
            } else {
                $secao = "Não Informada"; // Caso o código não exista
            }

            $tr .= View::render('admin/relacaoproduto/produto',
                [
                    'codprod' => $produto->codprod,
                    'descricao' => $produto->descricao,
                    'und' => $produto->und,
                    'ean13' => $produto->ean13,
                    'peso' => $produto->peso,
                    'secao' => $secao,
                    'qtestoque' => $produto->qtestoque,
                    'punit' => $produto->punit ?? 'NÃO INFORMADO',
                    'status' => 'Status'
                ]);
        }
        return $tr;
    }

    /**
     * Responsavel por buscar o produto especifico e mostrar na tela
     * @param $request
     * @param int $id (codigo do produto)
     * @return string
     */
    public static function editProdutos($request, $id)
    {
        $produto = M_Produto::buscar('codprod = ' . $id, null, null, '*')->fetchObject(M_Produto::class);
        $content = View::render('admin/produto_form',
            ['codigo' => $produto->codprod,
                'descricao' => $produto->descricao,
                'ean13' => $produto->ean13,
                'modelo' => self::getEstado($produto->modelo),
                'und' => $produto->und,
                'peso' => $produto->peso,
                'pcompra' => $produto->pcompra,
                'punit' => $produto->punit,
                'qtestoque' => $produto->qtestoque,
                'secao' => self::getSecao($request, $produto->codsecao)
            ]);
        return parent::getPage('Controle', $content);
    }

    /**     * Responsavel por atualizar os dados de um determinado produto     * @param Request $request * @return string */
    public static function atualizaProduto($request)
    {
        $postVars = $request->getPostVars();
        $obProduto = new M_Produto();
        $obProduto->codprod = $postVars['codprod'];
        $obProduto->descricao = $postVars['descricao'];
        $obProduto->ean13 = $postVars['ean13'];
        $obProduto->modelo = $postVars['modelo'];
        $obProduto->codsecao = $postVars['codsecao'];
        $obProduto->und = $postVars['und'];
        $obProduto->peso = $postVars['peso'];
        $obProduto->qtestoque = $postVars['estoque'];
        $obProduto->pcompra = $postVars['pcompra'];
        $obProduto->punit = $postVars['punit'];
        $obProduto->atualizar();
        return self::getProdutos($request);
    }
}