<?php



namespace App\Controller\Admin;


use App\Controller\Admin\Page;

use App\Http\Request;

use App\Model\Entity\Entrada as M_Entrada;
use App\Model\Entity\Perca as M_Perca;
use App\Model\Entity\Produto as M_Produto;
use App\Model\Entity\Pedido as M_Pedido;
use App\Model\Entity\Secao;

use App\Utils\View;



class Perca extends Page

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
                'secao' => $secao->secao
            ]);
        }
        return $secoes;
    }



    public static function getEstado($estado)
    {

        $tr = "";
        $selection = '';
        $estados = ['S', 'N'];

        foreach ($estados as $est) {
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

        if ($obProduto->codsecao == 1) {
            $obProduto->qtestoque = 1;
        } else {
            $obProduto->qtestoque = $postVars['qtestoque'];
        }

        $obProduto->pcompra = $postVars['pcompra'];
        $obProduto->punit = $postVars['punit'];
        $obProduto->cadastrar();

        return self::getProdutos($request);
    }



    public static function getPercas()
    {

        $tr = '';
        $entradas = M_Perca::buscarComProduto();

        while ($entrada = $entradas->fetchObject()) {

            $prodtos = $entrada->codprod . ' - ' . $entrada->descricao;
            $date = date_create($entrada->data);

            $tr .= View::render('admin/perca/pedidos', [
                'codcombo' => $entrada->idperca,
                'produtos' =>  $prodtos,
                'quantidade' => $entrada->qt,
                'custo' => $entrada->custo,
                'custoTotal' => ($entrada->custo * $entrada->qt),
                'data' => date_format($date, 'd/m/Y'),
            ]);
        }

        $content = View::render('admin/percas', [
            'tr' => $tr,
            'option' => self::getProdutoInsert(),
        ]);

        return parent::getPageLogin('Controle', $content);
    }

    public static function getRelacaoPercas()
    {

        $tr = '';
        $entradas = M_Perca::buscarPorGP(null, 'data desc', null);

        while ($entrada = $entradas->fetchObject()) {


            $prodtos = $entrada->codprod . ' - ' . $entrada->descricao;
            $date = date_create($entrada->data);

            $tr .= View::render('admin/perca/pedido', [
                'codcombo' => $entrada->idperca,
                'dtperca' => date_format($date, 'd/m/Y'),
                'tipo' => $entrada->tipo,
                'produtos' =>  $prodtos,
                'quantidade' => $entrada->qt,
                'custo' => $entrada->custo,
                'custoTotal' => ($entrada->custo * $entrada->qt),
            ]);
        }

        $content = View::render('admin/relacaopercas', [
            'tr' => $tr,
            'option' => self::getProdutoInsert(),
        ]);

        return parent::getPageLogin('Controle', $content);
    }




    public static function removeEntrada($codigo)
    {

        $produto = M_Perca::buscarComProduto('', null, null, '*')->fetchObject();

        M_Produto::retornaEstoque($produto->codprod, $produto->qt);
        M_Perca::excluir($codigo);

        header("Location: https://juninhodoiphone.com/controle/admin/percas");
        die();
    }



    public static function addEntrada($request)
    {

        $postVars = $request->getPostVars();

        $produto = explode('-', $postVars['produto']);

        $entrada = new M_Perca();
        $entrada->codprod = array_shift($produto);
        $entrada->quantidade = $postVars['quantidade'];

        $custo = M_Produto::buscar('codprod = ' . $entrada->codprod, null, null, 'pcompra')->fetchObject()->pcompra;

        $entrada->valor = $custo;

        $entrada->cadastra();

        M_Produto::baixaEstoque($entrada->codprod, $entrada->quantidade);

        header("Location: https://juninhodoiphone.com/controle/admin/percas");
        die();
    }



    public static function getProdutoInsert()

    {

        $tr = '';
        $results = M_Produto::buscar('qtestoque > 0 ', null, null, '*');



        while ($produto = $results->fetchObject()) {

            $tr .= View::render(
                'admin/entrada/produto_insert',

                [
                    'codigo' => $produto->codprod,
                    'descricao' => $produto->descricao,
                    'ean13' => $produto->ean13,
                    'imei' => $produto->peso,
                    'preco' => $produto->punit ?? 'NÃO INFORMADO',
                ]

            );
        }



        return $tr;
    }











    /**     * Realiza a Chamada da tela de produtos     * @param $request * @return string */

    public static function getProdutos($request)

    {

        $content = View::render('admin/produto', ['tr' => self::getProduto($request, $obPagination)]);

        return parent::getPageLogin('Controle', $content);
    }



    /**     * Responsavel por buscar cada produto e montar a tela de produtos     * @param Request $request * @param $obPagination     * @return string */

    public static function getProduto($request, &$obPagination)

    {

        $tr = '';

        // QUANTIDAD TOTAL DE REGISTROS

        $queryParams = $request->getQueryParams();

        $condicao = isset($queryParams['ds']) ? 'peso like "%' . $queryParams['ds'] . '%"' : '';

        $results = M_Produto::buscar($condicao, null, null, '*');

        while ($produto = $results->fetchObject(M_Produto::class)) {

            $tr .= View::render('admin/produtos/produto', ['codprod' => $produto->codprod, 'descricao' => $produto->descricao, 'und' => $produto->und, 'ean13' => $produto->ean13, 'dtimport' => $produto->dtimport,  'peso' => $produto->peso, 'qtestoque' => $produto->qtestoque, 'punit' => $produto->punit ?? 'NÃO INFORMADO', 'status' => 'Status']);
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

        $content = View::render(
            'admin/produto_form',

            [
                'codigo' => $produto->codprod,

                'descricao' => $produto->descricao,

                'ean13' => $produto->ean13,

                'modelo' => self::getEstado($produto->modelo),

                'und' => $produto->und,

                'peso' => $produto->peso,

                'pcompra' => $produto->pcompra,

                'punit' => $produto->punit,

                'qtestoque' => $produto->qtestoque,

                'secao' => self::getSecao($request, $produto->codsecao)

            ]
        );

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
