<?php 


namespace App\Controller\Admin;
use App\Controller\Admin\Page;
use App\Model\Entity\Pedido as M_Pedido;
use App\Model\Entity\PedidoPagamento as M_PedidoPagamento;
use App\Model\Entity\Cliente as M_Cliente;
use App\Model\Entity\Produto as M_Produto;
use App\Model\Entity\tarefa;
use App\Model\Entity\Tarefa as M_Tarefa;
use App\Utils\View;
use App\Utils\MenuPermissions;




class Dashboard extends Page {

    /*
    * Metodo resposavel por retornar o conteudo da view do home
    *  @retunr string 
    */
    public static function getDashboard(){
        $userId = $_SESSION['admin']['usuario']['id'];
        $userType = $_SESSION['admin']['usuario']['tipo_usuario'] ?? 'user';

        if($userId == 999){
            $datacusto = self::getMesesLucro();
            $content = View::render('admin/dashboard',[
                'qtCadastros' => self::getQtCadastros(),
                'getQtPedidos' => self::getQtPedidos(),
                'getQtentradas' => self::getQtEntrada(),
                'getlucroDia' => self::getLucroDia(),
                'labels' => self::getMeses(),
                'valors' => self::getValoresMeses(),
                'custo' => self::getValoresCustoMeses(),
                'moedaMeses' => self::getMoedaPedidoMeses(),
                'valorMoedaMeses' => self::getValorMoedaPedidoMeses(),
                'tarefasLista' => self::getTarefas(),
                'diasMes' => $datacusto[0],
                'valorDiasMes' => $datacusto[1],
                'menu' => MenuPermissions::renderMenu($userType, '/admin')
            ]);
        } else {
            $datacusto = self::getMesesLucro();
            $content = View::render('admin/dashboarduser',[
                'tarefasLista' => self::getTarefas(),
                'menu' => MenuPermissions::renderMenu($userType, '/admin')
            ]);
        }
        return parent::getPageLogin('Controle',$content);
    }




    /**

     * Valor total dos pedidos do més

     * @return int

     */

    public static function getQtPedidos(){

        $qt = M_Pedido::buscarQt('date(dtpedido)  = CURRENT_DATE()',null,null,'SUM(vltotal-vldesconto+acrescimo) as qtd')->fetchObject()->qtd;

        if($qt == ''){

            $qt = 0;

        }

        return $qt;
    }


    public static function getQtEntrada(){

        $qt = M_Produto::buscar('date(dtimport) = date(CURRENT_DATE())',null,null,'count(*) as qtd')->fetchObject()->qtd;

        if($qt == ''){
            $qt = 0;
        }
        return $qt;
    }


    /**

     * Retorna quantidade de Clientes cadastrados

     * @return int

     */

    public static function getQtCadastros(){



        $qt = M_Cliente::buscar('`dtcadastro` = CURRENT_DATE()',null,null,'COUNT(*) as qtd')->fetchObject()->qtd;



        if($qt == ''){

            $qt = 0;

        }

        return $qt;

    }


 public static function getLucroDia(){

        $custos = M_Pedido::buscarQt('date(dtpedido) = current_date() group by date(dtpedido)'
            ,null
            ,null
            ,'COALESCE(sum(vltotal + acrescimo - vldesconto),0) as lucro')->fetchObject();


        if ($custos !== false) {
            // Se houver resultados, retorne o valor desejado
            $custo = $custos->lucro;
        } else {
            // Se não houver resultados, defina o valor como 0
            $custo = 0;
        }


        $ct = M_Pedido::buscarItensProdutos('date(pedido.dtpedido) = current_date()'
            ,null
            , null
            ,'sum(pedidoitens.qt * (cadprod.pcompra + COALESCE(cadprod.pcusto,0))) as ct')->fetchObject()->ct;

        if ($ct === false) {
            // Se não houver resultados, retorne 0 ou qualquer outro valor que desejar
            $ct = 0;
        }

        if($custo > 0){
            $lucro = round((($custo - $ct) / $custo ) * 100);
        }else{
            $lucro = 0;
        }


        return $lucro;
    }



    // Graficos do Dashboard



    /**

     * Lista Meses/ano de todos os pedidos

     * @return array|string|string[]

     */

    public static function getMeses()

    {

        $valor = M_Pedido::buscarQt('YEAR(dtpedido) <> 0000 GROUP BY YEAR(dtpedido), MONTH(dtpedido)','YEAR(dtpedido), MONTH(dtpedido)',null,'sum(vltotal) as total,  DATE_FORMAT(`dtpedido`,"%m/%Y") as data');

        $eixoX = '[';



        while($valo = $valor->fetchObject()){

            $eixoX .= "'".$valo->data."'".',';

        }



        $eixoX .= ']';

        $eixoX = str_replace(",'00/0000',]", "]", $eixoX);





        return $eixoX;

    }



    /**

     * Busca valores dos Meses/ano de todos os pedidos

     * @return array|string|string[]

     */

    public static function getValoresMeses()

    {

        $valor = M_Pedido::buscarQt('YEAR(dtpedido) <> 0000 GROUP BY YEAR(dtpedido), MONTH(dtpedido)','YEAR(dtpedido), MONTH(dtpedido)',null,'sum(vltotal - vldesconto + acrescimo) as total,  DATE_FORMAT(`dtpedido`,"%m/Y%") as data');





        $eixoX = '[';



        while($valo = $valor->fetchObject()){

            $eixoX .= "'".$valo->total."'".',';

        }



        $eixoX .= ']';

        $eixoX = str_replace(",]", "]", $eixoX);



        return $eixoX;

    }





    /**

     * Busca custo dos Meses/ano de todos os pedidos

     * @return array|string|string[]

     */

    public static function getValoresCustoMeses()

    {

        $eixoX = '[';

        $valor = M_Pedido::buscarQt('YEAR(dtpedido) <> 0000 GROUP BY YEAR(dtpedido), MONTH(dtpedido)','YEAR(dtpedido), MONTH(dtpedido)',null,'sum(vltotal - vldesconto + acrescimo) as total,  YEAR(dtpedido) as ano, MONTH(dtpedido) as mes');





        while($valo = $valor->fetchObject()){



            $custo = M_Pedido::buscarItensProdutos('YEAR(pedido.dtpedido) = '.$valo->ano.' and MONTH(pedido.dtpedido) = '. $valo->mes,null,null,'sum( pedidoitens.qt * (cadprod.pcompra + cadprod.pcusto)) as custo ')->fetchObject()->custo;



            $eixoX .= "'".$custo."'".',';

        }



        $eixoX .= ']';

        $eixoX = str_replace(",]", "]", $eixoX);





        return $eixoX;

    }



    /**

     * Busca Formas de Pagamento do més

     * @return array|string|string[]

     */

    public static function getMoedaPedidoMeses()

    {

        $valor = M_PedidoPagamento::buscarPagPedidos('pedido.cxencerrado is not null and MONTH(pedido.cxencerrado) = MONTH(CURRENT_DATE()) group by moeda',null,null,'pedidopagamentos.moeda, sum(pedidopagamentos.valor) as total');



        $eixoX = '[';



        while($valo = $valor->fetchObject()){

            $eixoX .= "'".$valo->moeda."'".',';

        }



        $eixoX .= ']';



        $eixoX = str_replace(",]", "]", $eixoX);


        

        return $eixoX;

    }



    /**

     * Busca valores das Formas de Pagamento do més

     * @return array|string|string[]

     */

    public static function getValorMoedaPedidoMeses()

    {

        $valor = M_PedidoPagamento::buscarPagPedidos('pedido.cxencerrado is not null and MONTH(pedido.cxencerrado) = MONTH(CURRENT_DATE()) group by moeda',null,null,'pedidopagamentos.moeda, sum(pedidopagamentos.valor) as total');



        $eixoX = '[';



        while($valo = $valor->fetchObject()){

            $eixoX .= "'".$valo->total."'".',';

        }



        $eixoX .= ']';



        $eixoX = str_replace(",]", "]", $eixoX);



        return $eixoX;

    }



    /**

     * @return array|string|string[]

     */
    public static function getMesesLucro()
    {

        $eixoX = '[';
        $eixoY = '[';

        $custo = M_Pedido::buscarQt('month(dtpedido) = month(current_date()) group by date(dtpedido)'
            ,null
            ,null
            ,'sum(vltotal + acrescimo - vldesconto) as lucro, date(dtpedido) as dtpedido');

        while($valo = $custo->fetchObject()){

            $ct = M_Pedido::buscarItensProdutos('date(pedido.dtpedido) = "'.$valo->dtpedido.'"'
                ,null
                , null
                ,'sum(pedidoitens.qt * (cadprod.pcompra + COALESCE(cadprod.pcusto,0))) as ct')->fetchObject()->ct;


            $valorx = $valo->lucro - $ct;

            $eixoX .= "'".$valorx."'".',';

            $data_hora = strtotime($valo->dtpedido);
            $data_hora_formatada = date("d/m", $data_hora);

            $eixoY .= "'".$data_hora_formatada."'".',';

        }

        $eixoX .= ']';
        $eixoY .= ']';

        $eixoX = str_replace(",]", "]", $eixoX);
        $eixoY = str_replace(",]", "]", $eixoY);

        $datacusto = [$eixoY,$eixoX];

        return $datacusto;
    }



    public static function getTarefas()

    {

        $tarefas = '';

        $busca = M_Tarefa::buscar();



        while ($tarefa = $busca->fetchObject()) {



            if(($tarefa->dtfinalizacao == '')){



            $tarefas .= View::render('admin/tarefas/tarefa',

                [

                    'id' => $tarefa->codigo,

                    'tarefa' => $tarefa->descricao,

                    'time' => $tarefa->dtlancamento,

                ]);

            }else{

                $tarefas .= View::render('admin/tarefas/tarefa2',

                [

                    'id' => $tarefa->codigo,

                    'tarefa' => $tarefa->descricao,

                    'time' => $tarefa->dtlancamento,

                ]);



            }

        }

        return $tarefas;

    }



    public static function addTarefa($request){



        $postVars = $request->getPostVars();





        $tarefa = new M_Tarefa();

        $dateTime = new \DateTime($postVars['data']);

        $formattedDateTime = $dateTime->format('Y-m-d H:i:s');



        $tarefa->descricao = $postVars['descricao'];

        $tarefa->dtlancamento = $formattedDateTime;



        $tarefa->cadastrar();

        header("Location: https://juninhodoiphone.com/controle/admin");

        die();



    }
    
    public static function removeTarefa($id)
    {
        $tarefa  = M_Tarefa::buscar('codigo = '.$id)->fetchObject(M_Tarefa::class);

        if ($tarefa instanceof M_Tarefa) {
            $tarefa->deletar($id);
        }

        header("Location: https://juninhodoiphone.com/controle/admin");
        die();
    }



    public static function updateTarefa($request){



        $postVars = $request->getPostVars();

        

        $dataAtual = date('Y-m-d H:i:s');

        $tarefa = new M_Tarefa();



        // verificar se está marcado

        if($postVars['status'] == 1){

            $tarefa->dtfinalizacao = $dataAtual;

        }else{

            $tarefa->dtfinalizacao = NULL;

        }



        $tarefa->codigo = $postVars['codigo'];



        $tarefa->updateDtFinalizacao();



        return 200;



    }









}