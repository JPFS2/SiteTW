<?php



namespace App\Controller\Admin;



use App\Controller\Admin\Page;

use App\Http\Request;

use App\Controller\Admin\Pagamento;

use App\Model\Entity\Credito as M_Credito;

use App\Model\Entity\ManutencaoPagamentos;

use App\Model\Entity\Pagamento as M_Pagamento;

use App\Model\Entity\Pedido as M_Pedido;

use App\Model\Entity\Produto as M_Produto;

use App\Model\Entity\Mesa as M_Mesa;

use App\Model\Entity\Cliente as M_Cliente;

use App\Model\Entity\Manutencao as M_Manutencao;

use App\Model\Entity\ManutencaoPagamentos as M_ManutencaoPag;

use App\Model\Entity\Sangria as M_Sangria;

use App\Utils\View;



class Manutencao extends Page

{

    /**     * Metodo resposave por retornar o conteudo da view do Mesa     * @retunr string */

    public static function getManutencao($request)
    {
        $userType = $_SESSION['admin']['usuario']['tipo_usuario'] ?? 'user';
        $content = View::render('admin/garantia', [
            'cliente' => self::getCliente(),
            'opcliente' => self::getClientes(),
            'optionVendido' => self::getProdutoVendido(), // Options dos produtos a realizar manutenção serem inseridos
            'opMateriaPrima' => self::getMateriaPrima(), // Options dos produtos a serem utilizados na manutenção
            'option' => self::getProdutoInsert(), // Options dos produtos a serem inseridos
            'produtos' => self::getProduto(),  // produtos que Foram inseridos
            'moedas' => self::getPago(),
            'codcli' => self::getCodCliente(),
            'vlcredito' => self::getVlCredito(),
            'vlpago' => Pagamento::getPGMesa(),
            'vlmesa' => self::getVlMesa(),
            'trtroca' => self::getProdutoTroca(),
            'vlpendente' => (self::getVlMesa() - Pagamento::getPGMesa() - self::getVlCredito()),
            'menu' => \App\Utils\MenuPermissions::renderMenu($userType, '/admin')
        ]);
        return parent::getPageLogin('Controle', $content);
    }



    public static function getCliente()

    {

        $tr = '';

        $results = M_Cliente::buscarDaManutencao(null, null, null, '*');

        $cliente = $results->fetchObject();

        $tr = isset($cliente->cliente) ? $cliente->cliente : 'Não Informado';

        return $tr;
    }



    public static function getClientes()

    {

        $tr = '';

        $results = M_Cliente::buscar(null, null, null, '*');

        while ($cliente = $results->fetchObject()) {

            $tr .= View::render(
                'admin/manutencao/clientes',

                [

                    'codigo' => $cliente->codcli,

                    'cliente' => $cliente->cliente,

                ]
            );
        }

        return $tr;
    }



    public static function getProdutoInsert()

    {

        $tr = '';

        $results = M_Produto::buscar('codsecao = 1 and qtestoque > 0', null, null, '*');

        while ($produto = $results->fetchObject()) {

            $tr .= View::render(
                'admin/mesa/produto_insert',

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



    public static function getMateriaPrima()

    {

        $tr = '';

        $results = M_Produto::buscar('codsecao = 4 and qtestoque > 0', null, null, '*');

        while ($produto = $results->fetchObject()) {

            $tr .= View::render(
                'admin/manutencao/produto_manutencao',

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



    public static function getProdutoVendido()

    {

        $tr = '';

        $results = M_Produto::buscar('codsecao = 1 and qtestoque <= 0', null, null, '*');

        while ($produto = $results->fetchObject()) {

            $tr .= View::render(
                'admin/manutencao/produto_insert',

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

        $results = M_Produto::buscar('qtestoque > 0 and codsecao = 3', null, null, '*');

        while ($produto = $results->fetchObject()) {

            $tr .= View::render('admin/mesa/produto_combo', [

                'codigo' => $produto->codprod,

                'descricao' => $produto->descricao,

                'ean13' => $produto->ean13,

                'preco' => 0,
            ]);
        }

        return $tr;
    }



    public static function getProdutoTroca()

    {

        $tr = '';



        $codigoCliente = M_Mesa::buscar()->fetchObject()->codcli;

        $results = M_Credito::buscarJoin('credcli.dtbaixa is null and credcli.codcli = ' . $codigoCliente, null, null, '*');



        while ($produto = $results->fetchObject()) {



            $tr .= View::render(
                'admin/mesa/trocaitens',

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





    /**     * Metodo resposave por retornar os produtos inseridos na mesa     * @retunr string     * */

    public static function getProduto()

    {

        $tr = '';

        $results = M_Manutencao::buscarJoinPag('dtencerrado is null and tipo = ' . '"Servico"', null, null, 'manutencao.*, manutencaopagamentos.moeda,  manutencaopagamentos.valor');





        while ($produto = $results->fetchObject()) {





            $codcliente = ($produto->codcliente > 0) ? $produto->codcliente : 1;

            $cliente = M_Cliente::buscar('codcli = ' . $codcliente, null, null, 'cliente')->fetchObject()->cliente;



            $produto_entrada = M_Produto::buscar('codprod = ' . $produto->entrada, null, null, '*')->fetchObject();

            $produto_saida = M_Produto::buscar('codprod = ' . $produto->saida, null, null, '*')->fetchObject();

            $materiais_utilizados = explode(',', $produto->materiaprima);



            $materiais =  '';


            if ($produto->materiaprima <> '') {

                $materiais_utilizados = explode(',', $produto->materiaprima);

                foreach ($materiais_utilizados as $item) {

                    $materiais .= M_Produto::buscar('codprod = ' . $item, null, null, 'descricao')->fetchObject()->descricao . ' ,';
                }
            }





            $tr .= View::render(
                'admin/manutencao/produto',

                [

                    'codmanutencao' => $produto->codmanutencao,

                    'debito' => isset($produto_entrada->descricao) ? $produto_entrada->descricao : 'Não informado',

                    'debitoR' => isset($produto_saida->descricao) ? $produto_saida->descricao : 'Não informado',

                    'cliente' => $cliente,

                    'defeito' => $produto->descricao,

                    'tipo' => $produto->tipo,

                    'tiposervico' => $produto->tiposervico,

                    'vlliq' => $produto->custo,

                    'moeda' => $produto->moeda,

                    'diferencial' => $produto->valor,

                    'materiaPrima' => $materiais,



                ]
            );
        }

        return $tr;
    }



    public static function getPago()

    {

        $tr = '';

        $results = M_Pagamento::buscarPMesa();

        while ($pago = $results->fetchObject()) {

            $tr .= View::render('admin/mesa/pagamento', ['moeda' => $pago->moeda, 'valor' => $pago->valor, 'codpag' => $pago->codigo]);
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

        $valor = M_Credito::buscar('codcli = ' . $codcli . ' and dtbaixa is null', null, null, 'SUM(vlcredito) as valor')->fetchObject()->valor;



        if ($valor == '') {

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

        $valor = M_Manutencao::buscar('dtencerrado is null', null, null, 'SUM(custo) as valor')->fetchObject()->valor;



        if ($valor == '') {

            $valor = '0.00';
        }



        return $valor;
    }



    // produtos de brinde

    /**

     * @param Request$request

     * @return void

     */



    public static function addTroca($request)
    {



        $postVars = $request->getPostVars();



        $obProduto = new M_Produto();



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



        header("Location:  http://localhost/controle/admin/venda");

        die();
    }



    public static function removeManutencao($request)

    {
        $postVars = $request->getPostVars();


        $id =  $postVars['modal-id'];

        $manutencao = M_Manutencao::buscar('codmanutencao = ' . $id)->fetchObject(M_Manutencao::class);

        if ($manutencao instanceof M_Manutencao) {

            $produto = M_Produto::buscar('codprod = ' . $manutencao->entrada)->fetchObject(M_Produto::class);

            if ($manutencao->custo > 0 & $manutencao->entrada <> 0) {

                $manutencao->custo = $manutencao->custo * -1;

                if ($produto->codsecao == 1) {
                    $produto->aumentaCusto($manutencao->custo);
                }
            }

            $manutencao->obsCancel =  $postVars['observacao'];
            $manutencao->cadastrarCancel();
            $manutencao->deletar();

            $manutencaoPag = M_ManutencaoPag::buscar('codmanutencao = ' . $id)->fetchObject(M_ManutencaoPag::class);

            if ($manutencaoPag instanceof M_ManutencaoPag) {
                $manutencaoPag->cadastrarCancel();
            }
            
            ManutencaoPagamentos::deletar($id);
        }


        header("Location:  http://localhost/controle/admin/manutencoes");

        die();
    }

    public static function finalizaManutencao($request)

    {



        M_Manutencao::finalizar();



        header("Location:  http://localhost/controle/admin/manutencao");

        die();
    }



    public static function getPagamento()
    {



        $tr = '';

        $results = M_Mesa::buscarJoin(null, null, null, '*');



        while ($produto = $results->fetchObject()) {



            $tr .= View::render('admin/mesa/produto', [

                'codmesaitem' => $produto->codmesaitem,

                'codprod' => $produto->codprod,

                'descricao' => $produto->descricao,

                'ean13' => $produto->ean13,

                'punit' => ($produto->precounitario == 0) ? 'COMBO' : $produto->precounitario,

                'qtd' => $produto->qt ?? 'NÃO INFORMADO',

                'vlliq' => ($produto->precounitario == 0) ? 'COMBO' : $produto->precounitario,



            ]);
        }

        return $tr;
    }



    /**
     * Adiciona os produtos a Garantia/Manutenção
     * @param $request
     * @return void
     */

    public static function addManutencao($request)
    {

        $postVars = $request->getPostVars();

        $cliente = explode('-', $postVars['codcli']);


        $produtoRecebido  = explode('-', $postVars['codigo']);
        $produtoDevolvido = '';
        $produtosManutencao = '';
        $manutenção = new M_Manutencao();

        $manutenção->custo = ($postVars['custo']) ?  $postVars['custo'] : 0;

        if (isset($postVars['itensUtilizados'])) {

            $produtosManutencao = implode(", ", $postVars['itensUtilizados']);

            foreach ($postVars['itensUtilizados'] as $produto) {
                
                M_Produto::baixaEstoque($produto, 1);
                $custoProdutoUtilizado = floatval(M_Produto::buscar('codprod = ' . $produto, null, null, 'pcompra')->fetchObject()->pcompra);
                $manutenção->custo += $custoProdutoUtilizado;
            }
        }

        $manutenção->codcliente = array_shift($cliente);

        $manutenção->descricao = $postVars['defeito'];
        $manutenção->obs = isset($postVars['obs']) ? $postVars['obs'] : 'Nao Informado';
        $manutenção->imei =  isset($postVars['imei']) ? $postVars['imei'] : 'Nao Informado';
        $manutenção->materiaprima = $produtosManutencao;

        $manutenção->tipo =  '';
        $manutenção->tiposervico =  '';
        $manutenção->entrada =  '';
        $manutenção->saida =  '';
        

        if (isset($postVars['garantia'])) {

            $manutenção->tipo =  'Garrantia';
            if (isset($postVars['manutencao'])) {

                $manutenção->tiposervico = 'Manutencao';

                $manutenção->entrada = array_shift($produtoRecebido);

                $manutenção->saida = 0;



                $produto = M_Produto::buscar('codprod = ' . $manutenção->entrada)->fetchObject(M_Produto::class);

                if ($produto->codsecao == 1) {
                    $produto->aumentaCusto(0);
                }
            } else {

                $manutenção->tiposervico = 'Troca';

                $manutenção->entrada = array_shift($produtoRecebido);

                $manutenção->saida = array_shift($produtoDevolvido[]);



                M_Produto::retornaEstoque($manutenção->entrada, 1);

                M_Produto::baixaEstoque($manutenção->saida, 1);

                $codManutencao = $manutenção->cadastrar();

                if ($postVars['punit'] > 0) {

                    if (isset($postVars['extorno'])) {

                        $sangria = new M_Sangria();

                        $sangria->descricao = 'Extorno de compra referenta a manutenção';

                        $sangria->valor = $postVars['punit'];

                        $sangria->cadastraSangria();

                        M_Manutencao::finalizar();

                        header("Location:  http://localhost/controle/admin/manutencao");
                        die();
                    }

                    $manPagamento = new M_ManutencaoPag();
                    $manPagamento->codmanutencao = $codManutencao;
                    $manPagamento->moeda = $postVars['ForaPag'];
                    $manPagamento->valor = $postVars['punit'];
                    $manPagamento->cadastrar();
                }

                M_Manutencao::finalizar();

                header("Location:  http://localhost/controle/admin/manutencao");
                die();
            }
        } else {

            $manutenção->tipo = 'Servico';
            $manutenção->entrada = 0;
            $manutenção->saida = 0;
            $manutenção->aparelho = $postVars['aparelho'];

            $codManutencao = $manutenção->cadastrar();

            if ($postVars['punit'] > 0) {

                $manPagamento = new M_ManutencaoPag();
                $manPagamento->codmanutencao = $codManutencao;
                $manPagamento->moeda = $postVars['ForaPag'];
                $manPagamento->valor = $postVars['punit'];
                $manPagamento->cadastrar();
            }

            M_Manutencao::finalizar();


            echo
            "<script>
                   // Abre a página em uma nova aba
                   // Abre a página em uma nova janela com tamanho especificado
                   window.open('http://localhost/controle/admin/printmanutencao/" . $codManutencao . "', '_blank', 'width=800,height=600');
    
                   // Redireciona a página atual para outra URL
                   window.location.href = 'http://localhost/controle/admin/manutencao';
             </script>";
             exit();
        }

        $manutenção->cadastrar();

        M_Manutencao::finalizar();


        echo
        "<script>
                
            // Redireciona a página atual para outra URL
                window.location.href = 'http://localhost/controle/admin/manutencao';
         </script>";
    }


    public static function getPrint($id)
    {



        $manutencao = M_Manutencao::buscar('codmanutencao = ' . $id, null, null, '*')->fetchObject();

        $cliente = M_Cliente::buscar('codcli = ' . $manutencao->codcliente, null, null, '*')->fetchObject();



        $dataComBarras = date("d/m/Y H:i:s", strtotime($manutencao->dtmanutencao));



        $content = View::render(
            'admin/invoice-print3',

            [

                'usuario' => $_SESSION['admin']['usuario']['nome'],

                'data' => $dataComBarras,

                'variavel' => $manutencao->descricao,
                'peso' => $manutencao->imei,

                'clientec' => $cliente->cliente,

                'cpf' => $cliente->cpf,

                'telefone' => $cliente->telefone,

                'cidade' => $cliente->cidade,

                'endereco' => $cliente->endereco,

                'bairro' => $cliente->bairro,

                'numero' => $cliente->numero,

                'descricao' => $manutencao->aparelho

            ]

        );



        return parent::getPageLogin('Controle', $content);
    }


    public static function addCliente($request)
    {



        $postVars = $request->getPostVars();

        $manutencao = new M_Manutencao();

        $manutencao->codcliente = $postVars['codcli'];

        $manutencao->atualizarCliente();



        header("Location:  http://localhost/controle/admin/manutencao");

        die();
    }

    public static function removeProduto($id)
    {



        $obCarrinho = M_Mesa::buscarItens("codmesaitem = $id")->fetchObject(M_Mesa::class);



        if ($obCarrinho instanceof M_Mesa) {

            M_Produto::retornaEstoque($obCarrinho->codprod, $obCarrinho->qt);

            $obCarrinho->excluirItem();
        }



        header("Location:  http://localhost/controle/admin/venda");

        die();
    }
}
