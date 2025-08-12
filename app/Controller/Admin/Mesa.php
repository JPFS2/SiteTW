<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Page;
use App\Http\Request;
use App\Controller\Admin\Pagamento;
use App\Model\Entity\Credito as M_Credito;
use App\Model\Entity\Pagamento as M_Pagamento;
use App\Model\Entity\Pedido as M_Pedido;
use App\Model\Entity\Produto as M_Produto;
use App\Model\Entity\Mesa as M_Mesa;
use App\Model\Entity\Cliente as M_Cliente;
use App\Model\Entity\ProdutoCombo as M_Combo;
use App\Utils\View;

class Mesa extends Page
{

    /**
     * Metodo resposave por retornar o conteudo da view do Mesa
     * @retunr string
     */

    public static function getMesa($request)
    {
        $userType = $_SESSION['admin']['usuario']['tipo_usuario'] ?? 'user';

        $content = View::render('admin/mesa', [
            'cliente' => self::getCliente(),
            'opcliente' => self::getClientes(),
            'option' => self::getProdutoInsert(),
            'optionBrinde' => self::getProdutoBrinde(),
            'produtos' => self::getProduto(),
            'moedas' => self::getPago(),
            'codcli' => self::getCodCliente(),
            'vlcredito' => self::getVlCredito(),
            'vlpago' => Pagamento::getPGMesa(),
            'vlmesa' => self::getVlMesa(),
            'vldesconto' => self::getVlDesconto(),
            'Acrescimo' => self::getVlAcrescimo(),
            'trocaform' => self::getProdutoTrocaForm(),
            'trtroca' => self::getProdutoTroca(),
            'vlpendente' => (self::getVlMesa() - Pagamento::getPGMesa() - self::getVlCredito() - self::getVlDesconto() + self::getVlAcrescimo()),
            'menu' => \App\Utils\MenuPermissions::renderMenu($userType, '/admin')

        ]);

        return parent::getPageLogin('Controle', $content);

    }


    /**
     * PEGA O CLIENTE DO PEDIDO
     */
    public static function getCliente()
    {
        $tr = '';

        $results = M_Cliente::buscarDaVenda(null, null, null, '*');
        $cliente = $results->fetchObject();

        $tr = isset($cliente->cliente) ? $cliente->cliente : 'Não Informado';

        return $tr;
    }


    /**
     * PEGA A LISTA DE CLIENTES DO PEDIDO 
     */
    public static function getClientes()
    {

        $tr = '';
        $results = M_Cliente::buscar(null, null, null, '*');

        while ($cliente = $results->fetchObject()) {
            $tr .= View::render('admin/mesa/clientes', ['codigo' => $cliente->codcli, 'cliente' => $cliente->cliente,]);
        }

        return $tr;
    }

    /**
     * PEGA A LISTAGEM DE PRODUTOS PARA INSERIR 
     */
    public static function getProdutoInsert()
    {

        $tr = '';
        $results = M_Produto::buscar('qtestoque > 0', null, null, '*');

        while ($produto = $results->fetchObject()) {
            $tr .= View::render('admin/mesa/produto_insert',
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



    public static function getProdutoBrinde()
    {

        $tr = '';



        $combos = M_Combo::buscar( 'codigocombo > 0 group by codigocombo','codigocombo',null,'codigocombo  ');



        while($combo = $combos->fetchObject()){



            $prodtos = '| ';

            $itens = M_Combo::buscarJoin( 'codigocombo = '.$combo->codigocombo,null,null,'*');





            while($item = $itens->fetchObject()){

                $prodtos .= $item->quantidade.'- '.$item->descricao.' | ';

            }



            $tr .= View::render('admin/mesa/produto_combo', [

                'codigo' => $combo->codigocombo,

                'descricao' =>  $prodtos

            ]);



        }

        return $tr;

    }



    public static function getProdutoTrocaForm()
    {

        $tr = '';

        $codigoCliente = M_Mesa::buscar()->fetchObject()->codcli;

        if($tr == ''){
            $tr .= View::render('admin/mesa/trocaform',
                [
                    'codigo' => 0,
                    'codcli' => $codigoCliente,
                    'descricao' => '',
                    'cor' => '',
                    'armazenamento' => '',
                    'emai' => '',
                    'valor' => '',
                    'codCred' => '',
                    'pcompra' => '',
                    'punit' => '',
                ]
            );
        }
        return $tr;

    }







    public static function getProdutoTroca()

    {

        $tr = '';



        $codigoCliente = M_Mesa::buscar()->fetchObject()->codcli;

        $results = M_Credito::buscarJoin('credcli.dtbaixa is null and credcli.codcli = '.$codigoCliente,null,null,'*');



        while ($produto = $results->fetchObject()) {



            $tr .= View::render('admin/mesa/trocaitens',

                [

                    'codigo' => $produto->codprod,

                    'descricao' => $produto->descricao,

                    'cor' => $produto->und,

                    'armazenamento' => $produto->ean13,

                    'emai' => $produto->peso,

                    'valor' => $produto->vlcredito,

                    'codCred' => $produto->codcred,



                ]

            );

        }

        return $tr;

    }





    /** Metodo resposave por retornar os produtos inseridos na mesa

     * @retunr string

     */

    public static function getProduto()

    {

        $tr = '';

        $results = M_Mesa::buscarJoin(null, null, null, '*');



        while ($produto = $results->fetchObject()) {



            $tr .= View::render('admin/mesa/produto',

                [

                    'codmesaitem' => $produto->codmesaitem,

                    'codprod' => $produto->codprod,

                    'descricao' =>  $produto->descricao,

                    'ean13' => $produto->ean13,

                    'punit' => ($produto->precounitario == 0) ? ' Brinde ' : $produto->precounitario,

                    'qtd' => $produto->qt ?? 'NÃO INFORMADO',

                    'vlliq' => ($produto->precototal == 0) ? ' Brinde' : $produto->precototal,



                ]);

        }

        return $tr;

    }



    /**

     * @return string

     */

    public static function getPago()

    {

        $tr = '';

        $results = M_Pagamento::buscarPMesa();

        while ($pago = $results->fetchObject()) {

            $tr .= View::render('admin/mesa/pagamento',
            [
                'moeda' => $pago->moeda,
                'valor' => $pago->valor,
                'vencimento' => $pago->vencimento,
                'codpag' => $pago->codigo
            ]);

        }

        return $tr;

    }



    public static function getCodCliente()

    {

        $tr = '';

        $results = M_Cliente::buscarDaVenda(null, null, null, '*');

        $cliente = $results->fetchObject();

        $tr = isset($cliente->codcli) ? $cliente->codcli : 0;

        return $tr;

    }



    // Mostra os clientes para ser escolhido



    public static function getVlCredito()

    {



        $codcli = self::getCodCliente();

        $valor = M_Credito::buscar('codcli = '.$codcli.' and dtbaixa is null', null, null, 'SUM(vlcredito) as valor')->fetchObject()->valor;



        if($valor == ''){

            $valor = '0.00';

        }

        return $valor;

    }







    /**

     * Metodo resposave por retornar o (option) listagem dos produtos para inserir

     *  @retunr string

     **/



    // Produtos a inserir

    public static function getVlMesa()

    {



        $valor = M_Mesa::buscarItens(null, null, null, 'SUM(precototal) as valor')->fetchObject()->valor;



        if($valor == ''){

            $valor = '0.00';

        }



        return $valor;

    }



    public static function getVlDesconto()

    {



        $valor = M_Mesa::buscar(null, null, null, 'desconto')->fetchObject()->desconto;



        if($valor == ''){

            $valor = '0.00';

        }



        return $valor;

    }



    public static function getVlAcrescimo()

    {



        $valor = M_Mesa::buscar(null, null, null, 'acrescimo')->fetchObject()->acrescimo;



        if($valor == ''){

            $valor = '0.00';

        }



        return $valor;

    }





    // produtos de brinde



    /**

     * @param Request$request

     * @return void

     */



    public static function addTroca($request){

        $postVars = $request->getPostVars();




        $obProduto = new M_Produto();

        $codprod = 0;

        $obProduto->descricao = $postVars['descricao'];
        $obProduto->ean13 = $postVars['ean13'];
        $obProduto->codsecao = $postVars['codsecao'];
        $obProduto->und = $postVars['und'];
        $obProduto->peso = $postVars['peso'];
        $obProduto->qtestoque = $postVars['qtestoque'];
        $obProduto->pcompra = $postVars['pcompra'];
        $obProduto->punit = $postVars['punit'];

        $codprod = $obProduto->cadastrar();

        $credito = new M_Credito();
        $credito->codprod = $codprod;
        $credito->vlcredito = $obProduto->pcompra;
        $credito->codcli = $postVars['codcli'];

        $credito->cadastrar();

        header("Location: http://localhost/controle/admin/venda");
        die();

    }



    public static function removeMoeda($id)

    {

        $obCarrinho = M_Pagamento::buscarPMesa('codigo = '.$id)->fetchObject(M_Pagamento::class);



        if ($obCarrinho instanceof M_Pagamento) {

            $obCarrinho->excluirItem();

        }



        header("Location: http://localhost/controle/admin/venda");

        die();

    }

    public static function removeTroca($id)

    {



        $produto = M_Credito::buscar("codcred = ".$id,null,null,"codprod")->fetchObject()->codprod;

        M_Produto::deletar($produto);

        M_Credito::deletar($id);



        header("Location: http://localhost/controle/admin/venda");

        die();

    }



    public static function getPagamento(){







        $tr = '';



        $results = M_Mesa::buscarJoin(null,null,null,'*');







        while ($produto = $results->fetchObject()){







            $tr .= View::render('admin/mesa/produto',[



                'codmesaitem' => $produto->codmesaitem,



                'codprod' => $produto->codprod,



                'descricao' => $produto->descricao,



                'ean13' => $produto->ean13,



                'punit' => ($produto->precounitario == 0) ? 'COMBO' : $produto->precounitario ,



                'qtd' => $produto->qt ?? 'NÃO INFORMADO',



                'vlliq' => ($produto->precounitario == 0) ? 'COMBO' : $produto->precounitario,



            ]);



        }



        return $tr;



    }



    public static function addProduto($request)

    {

        $postVars = $request->getPostVars();



        $combo = isset($postVars['codigoBrinde']) ? $postVars['codigoBrinde'] : 0;



        if($combo > 0){



            $itens = M_Combo::buscarJoin( 'codigocombo = '.$combo,null,null,'*');



            while($item = $itens->fetchObject()){



                $mesa = new M_Mesa();

                $mesa->codprod = $item->codprod;

                $mesa->precounitario = 0;

                $mesa->qt = $item->quantidade;

                $mesa->codmesa = 0;



                M_Produto::baixaEstoque($mesa->codprod,$mesa->qt);

                $mesa->cadastrarItem();



            }



            header("Location: http://localhost/controle/admin/venda");

            die();

        }



        $produto = explode('-',$postVars['codigo']) ;



        $mesa = new M_Mesa();

        $mesa->codprod = array_shift($produto);

        $mesa->precounitario = array_pop($produto);

        $mesa->qt = $postVars['qt'];

        $mesa->codmesa = $postVars['mesa'];



        M_Produto::baixaEstoque($mesa->codprod,$mesa->qt);

        $mesa->cadastrarItem();



        header("Location: http://localhost/controle/admin/venda");

        die();

    }



    public static function addProdutoCombo($request)

    {

        $postVars = $request->getPostVars();



        $produto = explode('-',$postVars['codigo']) ;



        $mesa = new M_Mesa();

        $mesa->codprod = array_shift($produto);

        $mesa->precounitario = array_pop($produto);

        $mesa->qt = $postVars['qt'];

        $mesa->codmesa = $postVars['mesa'];



        M_Produto::baixaEstoque($mesa->codprod,$mesa->qt);

        $mesa->cadastrarItem();



        header("Location: http://localhost/controle/admin/venda");

        die();

    }





    public static function addCliente($request)

    {

        $postVars = $request->getPostVars();

        $mesa = new M_Mesa();

        $mesa->codCli = $postVars['codcli'];



        $mesa->atualizarCliente();



        header("Location: http://localhost/controle/admin/venda");

        die();

    }



    public static function addDesconto($request)

    {

        $postVars = $request->getPostVars();

        $mesa = new M_Mesa();

        $mesa->vldesconto = $postVars['desconto'];



        $mesa->atualizarDesconto();



        header("Location: http://localhost/controle/admin/venda");

        die();

    }



    public static function addAcrescimo($request)

    {

        $postVars = $request->getPostVars();

        $mesa = new M_Mesa();

        $mesa->acrescimo = $postVars['acrescimo'];



        $mesa->atualizarAcrescimo();



        header("Location: http://localhost/controle/admin/venda");

        die();

    }



    public static function removeProduto($id)



    {



        $obCarrinho = M_Mesa::buscarItens("codmesaitem = $id")->fetchObject(M_Mesa::class);



        if($obCarrinho instanceof M_Mesa){

            M_Produto::retornaEstoque($obCarrinho->codprod, $obCarrinho->qt);

            $obCarrinho->excluirItem();

        }







        header("Location: http://localhost/controle/admin/venda");



        die();







    }











}