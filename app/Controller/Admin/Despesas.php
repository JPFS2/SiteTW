<?php



namespace App\Controller\Admin;


use App\Controller\Admin\Page;

use App\Http\Request;

use App\Model\Entity\Entrada as M_Entrada;
use App\Model\Entity\Despesas as M_Despesa;
use App\Model\Entity\Produto as M_Produto;
use App\Model\Entity\Pedido as M_Pedido;
use App\Model\Entity\Secao;

use App\Utils\View;



class Despesas extends Page {
    
    public static function getRelacaoDespesas(){

        $tr = '';
        $despesas = M_Despesa::buscar();

        while($despesa = $despesas->fetchObject()){

            $tr .= View::render('admin/despesa/rpedidos', [
                'numped' => $despesa->id,
                'cliente' =>  $despesa->fornecedor,
                'moeda' =>  $despesa->historico,
                'dtpedido' => $despesa->data,
                'vlliq' => $despesa->valor,
            ]);

        }

        $content = View::render('admin/relacaodespesas', [
            'tr' => $tr
        ]);

        return parent::getPageLogin('Controle',$content);
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

    public static function getDespesas(){

            $tr = '';
            $despesa = M_Despesa::buscar();
              
            while($entrada = $despesa->fetchObject()){
                 $date = date_create($entrada->data);
                $tr .= View::render('admin/despesa/pedidos', [
                    'codcombo' => $entrada->id,
                    'produtos' =>  $entrada->fornecedor,
                    'quantidade' => $entrada->historico,
                    'custo' => $entrada->valor,
                     'data' => date_format($date,'d/m/Y'),
                ]);
            }

            $content = View::render('admin/despesas', [
                'tr' => $tr,
            ]);

            return parent::getPageLogin('Controle',$content);

        }



    public static function removeEntrada($codigo){

        $produto = M_Despesa::excluir($codigo);

        header("Location: https://juninhodoiphone.com/controle/admin/despesas");
        die();

    }



    public static function addDespesa($request){

        $postVars = $request->getPostVars();

        $despesa = new M_Despesa();
        $despesa->fornecedor = $postVars['fornecedor'];
        $despesa->historico = $postVars['Historico'];
        $despesa->valor = $postVars['valor'];
        $despesa->data = $postVars['data'];

        $despesa->cadastra();

        header("Location: https://juninhodoiphone.com/controle/admin/despesas");
        die();
    }



    public static function getProdutoInsert()

    {

        $tr = '';
        $results = M_Produto::buscar('qtestoque > 0 ', null, null, '*');



        while ($produto = $results->fetchObject()) {

            $tr .= View::render('admin/entrada/produto_insert',

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

            $tr .= View::render('admin/produtos/produto', ['codprod' => $produto->codprod, 'descricao' => $produto->descricao, 'und' => $produto->und,'ean13' => $produto->ean13,'dtimport' => $produto->dtimport,  'peso' => $produto->peso, 'qtestoque' => $produto->qtestoque, 'punit' => $produto->punit ?? 'NÃO INFORMADO', 'status' => 'Status']);

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