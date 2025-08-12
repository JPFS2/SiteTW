<?php







namespace App\Controller\Admin;







use App\Controller\Pages\Page;



use App\Http\Request;



use App\Model\Entity\Pedido as M_Pedido;

use App\Model\Entity\PedidoItens as M_PedidoItens;

use App\Model\Entity\PedidoPagamento as M_PedidoPag;

use App\Model\Entity\Pagamento as M_Pagamento;

use App\Model\Entity\Credito as M_Credito;

use App\Model\Entity\Produto as M_Produto;

use App\Model\Entity\Mesa as M_Mesa;

use App\Controller\Admin\Mesa as C_Mesa;

use App\Utils\View;







class Pagamento extends Page

{

    /**



    * Metodo resposave por retornar o conteudo da view do Mesa



    *  @retunr string



    */



    public static function getMesa($request,$codmesa)

    {

        $content = View::render('pages/mesa', [

            'mesa' => $codmesa,

            'option' => self::getProdutoInsert(),

            'produtos' => self::getProduto($codmesa),

            'vlmesa' => self::getVlMesa($codmesa)

        ]);

        return parent::getPageLogin('Controle', $content);



    }







    /**



     * Metodo resposave por retornar o (option) listagem dos produtos para inserir



     *  @retunr string



     **/







    public static function addPMesa($request)

    {



        $postVars = $request->getPostVars();


        $pagamento = new M_Pagamento;

        $pagamento->codmesa = $postVars['codmesa'];

        $pagamento->valor = str_replace(',','.',$postVars['valor']);

        $pagamento->moeda = $postVars['ForaPag'];

        if($pagamento->moeda == "Promissoria"){
            if($postVars['dtvencimento'] <> ''){
                $pagamento->vencimento = $postVars['dtvencimento'];
            }else{
                header("Location: https://juninhodoiphone.com/controle/admin/venda");
                die();
    
            }
           
        }else{
            $pagamento->vencimento = "null";
        }



        if((self::getVlMesa() + self::getVlAcrescimo() - self::getPGMesa() - C_Mesa::getVlCredito() - self::getVlDesconto() - $pagamento->valor) < 0){



            header("Location: https://juninhodoiphone.com/controle/admin/venda");

            die();



        }elseif((self::getVlMesa() + self::getVlAcrescimo() - self::getPGMesa() - C_Mesa::getVlCredito() - self::getVlDesconto() - $pagamento->valor) == 0){



            $pagamento->cadastrarPmesa();



            header("Location: https://juninhodoiphone.com/controle/admin/venda");

            die();

        }



        $pagamento->cadastrarPmesa();



        header("Location: https://juninhodoiphone.com/controle/admin/venda");

        die();



    }



    public static function finaizaPedido(){





        $diff = (self::getVlMesa() + self::getVlAcrescimo() - self::getPGMesa() - C_Mesa::getVlCredito()) - self::getVlDesconto();





        if($diff == 0) {



            $pedido = new M_Pedido();

            $pedido->vltotal = self::getVlMesa();

            $pedido->vldesconto = self::getVlDesconto();

            $pedido->acrescimo = self::getVlAcrescimo();

            $pedido->codcli = M_Mesa::buscar(null, null, null, "codcli")->fetchObject()->codcli;

            $numped = $pedido->cadastrar();



            $results = M_Mesa::buscarJoin(null, null, null, '*');



            while ($produto = $results->fetchObject()) {



                $pedidoitem = new M_PedidoItens();

                $pedidoitem->numped = $numped;

                $pedidoitem->codprod = $produto->codprod;

                $pedidoitem->qt = $produto->qt;

                $pedidoitem->punit = $produto->precounitario;

                $pedidoitem->vlliq = $produto->precototal;



                $pedidoitem->cadastrar();

            }



            $pagamentos = M_Pagamento::buscarPMesa();



            while ($pag = $pagamentos->fetchObject(M_Pagamento::class)) {

                $pedidoPag = new M_PedidoPag();

                $pedidoPag->numped = $numped;

                $pedidoPag->moeda = $pag->moeda;
                $pedidoPag->vencimento = $pag->vencimento;
                $pedidoPag->valor = $pag->valor;

                $pedidoPag->cadastrar();

            }



            M_Mesa::excluir();

            M_Pagamento::excluir();



            M_Mesa::zeraCliente();

            M_Mesa::zeraDesconto();

            M_Mesa::zeraAcrescimo();



            header("Location: https://juninhodoiphone.com/controle/admin/impressaopedido/".$numped);

            die();



        }elseif ($diff > 0){



            $pedido = new M_Pedido();

            $pedido->vltotal = self::getVlMesa();

            $pedido->vldesconto = self::getVlDesconto();

            $pedido->acrescimo = self::getVlAcrescimo();

            $pedido->codcli = M_Mesa::buscar(null, null, null, "codcli")->fetchObject()->codcli;

            $numped = $pedido->cadastrar();



            $results = M_Mesa::buscarJoin(null, null, null, '*');



            while ($produto = $results->fetchObject()) {



                $pedidoitem = new M_PedidoItens();

                $pedidoitem->numped = $numped;

                $pedidoitem->codprod = $produto->codprod;

                $pedidoitem->qt = $produto->qt;

                $pedidoitem->punit = $produto->precounitario;

                $pedidoitem->vlliq = $produto->precototal;



                $pedidoitem->cadastrar();



            }



            $pagamentos = M_Pagamento::buscarPMesa();



            while ($pag = $pagamentos->fetchObject(M_Pagamento::class)) {

                $pedidoPag = new M_PedidoPag();

                $pedidoPag->numped = $numped;

                $pedidoPag->moeda = $pag->moeda;

                $pedidoPag->valor = $pag->valor;

                $pedidoPag->cadastrar();

            }



            M_Mesa::excluir();

            M_Pagamento::excluir();

            M_Mesa::zeraCliente();

            M_Mesa::zeraDesconto();

            M_Mesa::zeraAcrescimo();



            header("Location: https://juninhodoiphone.com/controle/admin/venda");

            die();

        }



        header("Location: https://juninhodoiphone.com/controle/admin/venda");

        die();



    }



    public static function finaizaPedidoAbs(){





        $diff = (self::getVlMesa() + self::getVlAcrescimo() - self::getPGMesa() - C_Mesa::getVlCredito()) - self::getVlDesconto();





        if($diff == 0) {



            $pedido = new M_Pedido();

            $pedido->vltotal = self::getVlMesa();

            $pedido->vldesconto = self::getVlDesconto();

            $pedido->acrescimo = self::getVlAcrescimo();

            $pedido->codcli = M_Mesa::buscar(null, null, null, "codcli")->fetchObject()->codcli;

            $numped = $pedido->cadastrar();



            $results = M_Mesa::buscarJoin(null, null, null, '*');



            while ($produto = $results->fetchObject()) {



                $pedidoitem = new M_PedidoItens();

                $pedidoitem->numped = $numped;

                $pedidoitem->codprod = $produto->codprod;

                $pedidoitem->qt = $produto->qt;

                $pedidoitem->punit = $produto->precounitario;

                $pedidoitem->vlliq = $produto->precototal;



                $pedidoitem->cadastrar();

            }



            $pagamentos = M_Pagamento::buscarPMesa();



            while ($pag = $pagamentos->fetchObject(M_Pagamento::class)) {

                $pedidoPag = new M_PedidoPag();

                $pedidoPag->numped = $numped;

                $pedidoPag->moeda = $pag->moeda;

                $pedidoPag->valor = $pag->valor;
                $pedidoPag->vencimento = $pag->vencimento;

                $pedidoPag->cadastrar();

            }



            M_Mesa::excluir();

            M_Pagamento::excluir();

            M_Credito::atualizar($pedido->codcli, $numped);

            M_Mesa::zeraCliente();

            M_Mesa::zeraDesconto();

            M_Mesa::zeraAcrescimo();

            M_Pedido::finaliza($numped);



            header("Location: https://juninhodoiphone.com/controle/admin/impressaopedido/".$numped);

            die();



        }



        header("Location: https://juninhodoiphone.com/controle/admin/venda");

        die();



    }



    public static function removePagamento($id)

    {

        $obCarrinho = M_Mesa::buscarItens("codmesaitem = $id")->fetchObject(M_Mesa::class);



        if($obCarrinho instanceof M_Mesa){

            $obCarrinho->excluirItem();

        }





        header("Location: https://juninhodoiphone.com/controle/mesa/$obCarrinho->codmesa");

        die();



    }







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





    public static function getPGMesa()

    {

        $valor = M_Pagamento::buscarPMesa(null, null, null, 'SUM(valor) as valor')->fetchObject()->valor;

        if($valor == ''){

            $valor = '0.00';

        }

        return $valor;

    }



}