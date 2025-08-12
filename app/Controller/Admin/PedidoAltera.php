<?php



namespace App\Controller\Admin;



use App\Controller\Admin\Mesa as C_Mesa;

use App\Controller\Admin\Page;

use App\Http\Request;

use App\Controller\Admin\Pagamento;

use App\Model\Entity\Credito as M_Credito;

use App\Model\Entity\Pagamento as M_Pagamento;

use App\Model\Entity\Pedido as M_Pedido;

use App\Model\Entity\PedidoItens as M_PedidoItem;

use App\Model\Entity\PedidoPagamento as M_PedidoPag;

use App\Model\Entity\Produto as M_Produto;

use App\Model\Entity\Mesa as M_Mesa;

use App\Model\Entity\Cliente as M_Cliente;

use App\Model\Entity\ProdutoCombo as M_Combo;

use App\Utils\View;



class PedidoAltera extends Page

{

    /**

     * Metodo resposave por retornar o conteudo da view do Mesa

     * @retunr string

     */

    public static function getMesa($numped)

    {

        $pedido = M_Pedido::buscar('numped = '.$numped)->fetchObject();







        $content = View::render('admin/pedidoaltera', [

            'numped' => $numped, // Ok

            'cliente' => self::getCliente($pedido->codcli), // Ok

            'opcliente' => self::getClientes(), // Ok

            'option' => self::getProdutoInsert(), // Ok

            'optionBrinde' => self::getProdutoBrinde(), // Ok

            'produtos' => self::getProduto($numped), // Ok

            'moedas' => self::getPago($numped),

            'codcli' => $pedido->codcli, // Ok

            'vlcredito' => self::getVlCredito($pedido->codcli), // Ok

            'vlpago' => self::getValorPagoPedido($numped), //ok

            'vlmesa' => self::getVlMesa($numped),

            'vldesconto' => self::getVlDesconto($numped), // ok

            'Acrescimo' => self::getVlAcrescimo($numped), // ok

            'trocaform' => self::getProdutoTrocaForm($pedido->codcli), // ok

            'trtroca' => self::getProdutoTroca($pedido->codcli),

            'vlpendente' => (self::getVlMesa($numped) - self::getValorPagoPedido($numped) - self::getVlCredito($pedido->codcli)

                - self::getVlDesconto($numped) + self::getVlAcrescimo($numped))

        ]);

        return parent::getPageLogin('Controle', $content);

    }



    public static function getCliente($codcli)

    {

        $tr = '';

        $results = M_Cliente::buscar('codcli = '.$codcli, null, null, '*');

        $cliente = $results->fetchObject();

        $tr = isset($cliente->cliente) ? $cliente->cliente : 'Não Informado';

        return $tr;

    }



    public static function getValorPagoPedido($numped)

    {

        $valor = M_PedidoPag::buscar('numped = '.$numped,null,null,'SUM(valor) as valor')->fetchObject()->valor;;



        if($valor == ''){

            $valor = '0.00';

        }

        return $valor;

    }



    public static function getClientes()

    {

        $tr = '';

        $results = M_Cliente::buscar(null, null, null, '*');

        while ($cliente = $results->fetchObject()) {

            $tr .= View::render('admin/mesa/clientes',

                ['codigo' => $cliente->codcli, 'cliente' => $cliente->cliente,]);

        }

        return $tr;

    }



    /**

     * Busca produtos a inserir no pedido

     * @return string

     */

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



    /**

     * Busca os brinds para inserir no pedido

     * @return string

     */

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





    /**

     * Busca o formularido de troca de acordo com o cliente do pedido

     * @param $codigoCliente

     * @return string

     */

    public static function getProdutoTrocaForm($codigoCliente)

    {

        $tr = '';



        $results = M_Credito::buscarJoin('credcli.dtbaixa is null and credcli.codcli = '.$codigoCliente,null,null,'*');



        while ($produto = $results->fetchObject()) {



            $tr .= View::render('admin/pedidoaltera/trocaform',

                [

                    'codigo' => $produto->codprod,

                    'codcli' => isset($produto->codcli) ? $produto->codcli : $codigoCliente,

                    'descricao' => $produto->descricao,

                    'cor' => $produto->und,

                    'armazenamento' => $produto->ean13,

                    'emai' => $produto->peso,

                    'valor' => $produto->vlcredito,

                    'codCred' => $produto->codcred,

                    'pcompra' => $produto->pcompra,

                    'punit' => $produto->punit,



                ]

            );

        }



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





    /**

     * Cria a listagem de trocas do pedido do cliente de acordo com o pedido

     * @param $codigoCliente

     * @return string

     */

    public static function getProdutoTroca($codigoCliente)

    {

        $tr = '';



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

    public static function getProduto($numped)

    {

        $tr = '';

        $results = M_Pedido::buscarItens('numped = '.$numped,null,null,'pedidoitens.*, cadprod.und, cadprod.peso, cadprod.ean13, cadprod.descricao');



        while ($produto = $results->fetchObject()) {



            $tr .= View::render('admin/pedidoaltera/produto',

                [

                    'codmesaitem' => $produto->coditem,

                    'codprod' => $produto->codprod,

                    'descricao' =>  $produto->descricao,

                    'ean13' => $produto->peso,

                    'punit' => ($produto->punit == 0) ? ' Brinde ' : $produto->punit,

                    'qtd' => $produto->qt ?? 'NÃO INFORMADO',

                    'vlliq' => ($produto->vlliq == 0) ? ' Brinde' : $produto->vlliq,



                ]);

        }

        return $tr;

    }



    public static function addPMesa($request)

    {



        $postVars = $request->getPostVars();

        $pedidoPag = new M_PedidoPag();



        $pedidoPag->numped = $postVars['numped'];

        $pedidoPag->valor = str_replace(',','.',$postVars['valor']);

        $pedidoPag->moeda = $postVars['ForaPag'];

        if( $pedidoPag->moeda  == "Promissoria"){
            $pedidoPag->vencimento = $postVars['dtvencimento'];
        }else{
            $pedidoPag->vencimento = "null";
        }



        $codcli = M_Pedido::buscar('numped = '.$pedidoPag->numped, null, null,'pedido.codcli as codcli')->fetchObject()->codcli;





        if((self::getVlMesa($pedidoPag->numped) + self::getVlAcrescimo($pedidoPag->numped) - self::getVlDesconto($pedidoPag->numped) - self::getValorPagoPedido($pedidoPag->numped) - self::getVlCredito($codcli) -  $pedidoPag->valor ) < 0){



            header("Location: https://juninhodoiphone.com/controle/admin/venda/".$pedidoPag->numped);

            die();



        }elseif((self::getVlMesa($pedidoPag->numped) + self::getVlAcrescimo($pedidoPag->numped) - self::getVlDesconto($pedidoPag->numped)

                - self::getValorPagoPedido($pedidoPag->numped) - self::getVlCredito($codcli) -  $pedidoPag->valor ) == 0){



            $pedidoPag->cadastrar();



            header("Location: https://juninhodoiphone.com/controle/admin/venda/".$pedidoPag->numped);

            die();

        }

        $pedidoPag->cadastrar();



        header("Location: https://juninhodoiphone.com/controle/admin/venda/".$pedidoPag->numped);

        die();



    }



    public static function finalizaPedido($numped)

    {



        $codcli = M_Pedido::buscar('numped = '.$numped, null, null,'pedido.codcli as codcli')->fetchObject()->codcli;



        if((self::getVlMesa($numped) + self::getVlAcrescimo($numped) - self::getVlDesconto($numped) - self::getValorPagoPedido($numped) - self::getVlCredito($codcli)) < 0){



            header("Location: https://juninhodoiphone.com/controle/admin/venda/".$numped);

            die();



        }elseif((self::getVlMesa($numped) + self::getVlAcrescimo($numped) - self::getVlDesconto($numped) - self::getValorPagoPedido($numped) - self::getVlCredito($codcli)) == 0){



            M_Pedido::finaliza($numped);

            M_Credito::atualizar($codcli, $numped);



            header("Location: https://juninhodoiphone.com/controle/admin/impressaopedido/".$numped);

            die();

        }



        header("Location: https://juninhodoiphone.com/controle/admin/venda/".$numped);

        die();



    }





    /**

     * @return string

     */

    public static function getPago($numped)

    {

        $tr = '';

        $results =  M_PedidoPag::buscar('numped = '.$numped);



        while ($pago = $results->fetchObject()) {
            $tr .= View::render('admin/pedidoaltera/pagamento',
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



    /**

     * Busca o credito do cliente

     * @param $codcli

     * @return string

     */

    public static function getVlCredito($codcli)

    {

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



    /**

     * Pega o valor do somatorio dos itens do pedido

     * @param $numped

     * @return string

     */

    public static function getVlMesa($numped)

    {

        $valor = M_PedidoItem::busca('numped = '.$numped, null, null, 'SUM(vlliq) as valor')->fetchObject()->valor;



        if($valor == ''){

            $valor = '0.00';

        }



        return $valor;

    }



    /**

     * Pega o valor do desconto em determeninado pedido

     * @param $numped

     * @return string

     */

    public static function getVlDesconto($numped)

    {



        $valor =  M_Pedido::buscar('numped = '.$numped,null,null,'vldesconto')->fetchObject()->vldesconto;



        if($valor == ''){

            $valor = '0.00';

        }



        return $valor;

    }



    /**

     * Pega o valor do Acrescimo em determeninado pedido

     * @param $numped

     * @return string

     */

    public static function getVlAcrescimo($numped)

    {



        $valor =  M_Pedido::buscar('numped = '.$numped,null,null,'acrescimo')->fetchObject()->acrescimo;



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



        $numped = $postVars['numped'];



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





        if($postVars['codprod'] <> 0){

            $obProduto->codprod = $postVars['codprod'];

            $codprod = $postVars['codprod'];

            $obProduto->atualizar();

        }else{

            $codprod = $obProduto->cadastrar();

        }



        $credito = new M_Credito();

        $credito->codprod = $codprod;

        $credito->vlcredito = $obProduto->pcompra;

        $credito->codcli = $postVars['codcli'];

        $credito->numpedBaixa = $numped;



        if($postVars['codprod'] <> 0){

            $credito->atualizarDados();

        }else{

            $credito->cadastrar();

        }



        header("Location: https://juninhodoiphone.com/controle/admin/venda/".$numped);

        die();

    }



    public static function removeMoeda($id)

    {

        $obPagamento = M_PedidoPag::buscar('codigo = '.$id)->fetchObject(M_PedidoPag::class);;



        if ($obPagamento instanceof M_PedidoPag) {

            $obPagamento->excluirItem();

        }



        header("Location: https://juninhodoiphone.com/controle/admin/venda/".$obPagamento->numped);

        die();

    }

    public static function removeTroca($id)

    {



        $produto = M_Credito::buscar("codcred = ".$id,null,null,"codprod")->fetchObject()->codprod;

        $produto = M_Credito::buscar("codcred = ".$id,null,null,"numpedBaixa")->fetchObject()->numpedBaixa;



        M_Produto::deletar($produto);

        M_Credito::deletar($id);



        header("Location: https://juninhodoiphone.com/controle/admin/venda/");

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



    /**

     * Adicionar Produtos na tabela pedidoitens

     * @param $request

     * @return void

     */

    public static function addProduto($request)

    {



        $postVars = $request->getPostVars();



        $combo = isset($postVars['codigoBrinde']) ? $postVars['codigoBrinde'] : 0;



        if($combo > 0){



            $itens = M_Combo::buscarJoin( 'codigocombo = '.$combo,null,null,'*');



            while($item = $itens->fetchObject()){



                $pedidoItem = new M_PedidoItem();

                $pedidoItem->codprod = $item->codprod;

                $pedidoItem->punit = 0;

                $pedidoItem->qt = $item->quantidade;

                $pedidoItem->numped = $postVars['numped'];



                M_Produto::baixaEstoque($pedidoItem->codprod,$pedidoItem->qt);

                $pedidoItem->cadastrar();



            }



            header("Location: https://juninhodoiphone.com/controle/admin/venda/".$postVars['numped']);

            die();

        }



        $produto = explode('-',$postVars['codigo']) ;



        $item = new M_PedidoItem();



        $item->codprod = floatval(array_shift($produto));

        $item->punit = floatval(array_pop($produto));

        $item->qt = floatval($postVars['qt']);

        $item->numped = $postVars['numped'];

        $item->vlliq = ($item->qt * $item->punit);



        M_Produto::baixaEstoque($item->codprod,$item->qt);

        $item->cadastrar();



        header("Location: https://juninhodoiphone.com/controle/admin/venda/".$item->numped);



        die();







    }



    public static function addCliente($request)

    {

        $postVars = $request->getPostVars();

        $pedido = new M_Pedido();

        $codcli = $postVars['codcli'];

        $numped = $postVars['numped'];



        $pedido->atualizarCliente($numped,$codcli);



        header("Location: https://juninhodoiphone.com/controle/admin/venda/".$numped);

        die();

    }



    public static function addDesconto($request)

    {

        $postVars = $request->getPostVars();



        $pedido = new M_Pedido();

        $codcli = $postVars['desconto'];

        $numped = $postVars['numped'];



        $pedido->atualizarDesconto($numped,$codcli);



        header("Location: https://juninhodoiphone.com/controle/admin/venda/".$numped);

        die();

    }



    public static function addAcrescimo($request)

    {

        $postVars = $request->getPostVars();



        $pedido = new M_Pedido();

        $codcli = $postVars['acrescimo'];

        $numped = $postVars['numped'];



        $pedido->atualizaracrescimo($numped,$codcli);



        header("Location: https://juninhodoiphone.com/controle/admin/venda/".$numped);

        die();

    }



    public static function removeProduto($id)

    {

        $obitem = M_Pedido::buscarItens("coditem = $id")->fetchObject(M_Pedido::class);



        if($obitem instanceof M_Pedido){

            M_Produto::retornaEstoque($obitem->codprod, $obitem->qt);

            $obitem->excluirItem();

        }



        header("Location: https://juninhodoiphone.com/controle/admin/venda/".$obitem->numped);

        die();



    }









}