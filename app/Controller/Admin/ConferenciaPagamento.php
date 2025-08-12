<?php namespace App\Controller\Admin;



use App\Controller\Admin\Page;

use App\Model\Entity\Mesa as M_Mesa;

use App\Model\Entity\Cliente as M_Cliente;

use App\Model\Entity\Pedido as M_Pedido;

use App\Model\Entity\PedidoPagamento as M_PedidoPag;

use App\Model\Entity\Abastecimento as M_Abastecimento;

use App\Model\Entity\Sangria as M_Sangria;

use App\Model\Entity\Recebimentos as M_Recebimento;

use App\Model\Entity\ManutencaoPagamentos as M_ManutencaoPag;

use App\Utils\View;



class ConferenciaPagamento extends Page

{

    /**

     * Retorna a tela inicial do caixa

     * @return string

     */

    public static function getRecebimento()

    {

        $tr = '';

        $pedidos = M_PedidoPag::buscarPagPedidos('cxencerrado is null and dtfechamento is not null', null, null, '*');



        $vltotal = (floatval(self::getPagDinheiro()) +
                floatval(self::getPagCredito()) +
                floatval(self::getPagDebito()) +
                floatval(self::getPagPix()) +
                floatval(self::getAbastecimento()) +
                floatval(self::getRecebidoPromissoria())
            ) -  floatval(self::getSangria())

        ;

        $vltotalrec = (floatval(self::getPagDinheiro()) +
                floatval(self::getPagCredito()) +
                floatval(self::getPagDebito()) +
                floatval(self::getPagPix()) +
                floatval(self::getAbastecimento()) +
                floatval(self::getRecebidoPromissoria())
            )

       ;

       $manutencoes = M_ManutencaoPag::buscarJoin('manutencaopagamentos.cxencerrado is null');

        // Listagem das Manutenções 
        while ($manutencao = $manutencoes->fetchObject()){

            $date = date_create($manutencao->dtpagamento);

            $tr .= View::render('admin/conferenciacaixa/pedidos', [
                'numped' => $manutencao->codmanutencao,
                'mesa' => 'M - '.$manutencao->descricao,
                'moeda' => $manutencao->moeda,
                'dtpedido' => date_format($date, 'd/m/Y - H:m'),
                'vlliq' => $manutencao->valor,
            ]);
        }

        // Listagem dos Pedidos

        while ($pedido = $pedidos->fetchObject()) {

            $cliente = M_Cliente::buscar('codcli = ' . $pedido->codcli, null, null, 'cliente')->fetchObject()->cliente;

            if (!isset($cliente)) {
                $cliente = ' ';
            }

            $date = date_create($pedido->dtpedido);

            $tr .= View::render('admin/conferenciacaixa/pedidos', [
                'numped' => $pedido->numped,
                'mesa' => $cliente,
                'moeda' => $pedido->moeda,
                'dtpedido' => date_format($date, 'd/m/Y - H:m'),
                'vlliq' => $pedido->valor,
            ]);
        }
    
     
       $recebimentos = M_Recebimento::buscar('cxencerrado is null', null, null, '*');

        while ($recebimento = $recebimentos->fetchObject()){

            $cliente =  'mesa'  ;

            $codcli = M_Pedido::buscar('numped = '.$recebimento->numped, null, null, 'pedido.codcli as codcli')->fetchObject()->codcli;
            $cliente = M_Cliente::buscar('codcli = ' . $codcli, null, null, 'cliente')->fetchObject()->cliente;

            $date = date_create($recebimento->data);

            $tr .= View::render('admin/conferenciacaixa/pedidos', [
                'numped' => $recebimento->numped,
                'mesa' => '*'.$cliente,
                'moeda' => 'Dinheiro',
                'dtpedido' => date_format($date, 'd/m/Y - H:m'),
                'vlliq' => $recebimento->valor,
            ]);

        }



        $content = View::render('admin/conferencia_detahes', [

            'tr' => $tr,
            'usuario' => $_SESSION['admin']['usuario']['nome'],
            'vldinheiro' => self::getPagDinheiro(),
            'vlcredito' => self::getPagCredito(),
            'vldebito' => self::getPagDebito(),
            'vlabastecimento' => self::getAbastecimento(),
            'vlsangria' => self::getSangria(),
            'vlpromissoria' => self::getPagPromissoria(),
            'trabastecimento' => self::getAbastecimentos(),
            'trsangria' => self::getSangrias(),
            'trrecebimento' => self::getRecebido(),
            'vlrecebimento' => self::getRecebidoPromissoria(),
            'vlpix' => self::getPagPix(),
            'vltotalrec' => $vltotalrec,
            'vltotal' =>  $vltotal

        ]);

        return parent::getPageLogin('Controle', $content);

    }





    /**

     * Busca o valor os pedidos em dinheiro no caixa

     * @return string

     */

    public static function getPagDinheiro()

    {

        $vlpedidos = M_PedidoPag::buscarPagPedidos('pedidopagamentos.moeda = "Dinheiro" and pedido.cxencerrado is null and pedido.dtfechamento is not null', null, null, 'sum(valor) as valor')->fetchObject()->valor;

        $vlmanutencao = M_ManutencaoPag::buscar('manutencaopagamentos.moeda = "Dinheiro" and manutencaopagamentos.cxencerrado is null', null, null, 'sum(valor) as valor')->fetchObject()->valor;;



        $vl = $vlpedidos + $vlmanutencao;



        if ($vl == 0) {

            $vl = '0,00';

        }

        return $vl;

    }



    /**

     * Busca o valor os pedidos em cartão de credito no caixa

     * @return string

     */

    public static function getPagCredito()

    {

        $vlpedidos = M_PedidoPag::buscarPagPedidos('pedidopagamentos.moeda = "Cartão Credito" and pedido.cxencerrado is null and pedido.dtfechamento is not null', null, null, 'sum(valor) as valor')->fetchObject()->valor;

        $vlmanutencao = M_ManutencaoPag::buscar('manutencaopagamentos.moeda = "Cartão Credito" and manutencaopagamentos.cxencerrado is null', null, null, 'sum(valor) as valor')->fetchObject()->valor;;



        $vl = $vlpedidos + $vlmanutencao;



        if ($vl == 0) {

            $vl = '0,00';

        }

        return $vl;

    }





    /**

     * Busca o valor os pedidos em cartão de debito no caixa

     * @return string

     */

    public static function getPagDebito()

    {

        $vlpedidos = M_PedidoPag::buscarPagPedidos('pedidopagamentos.moeda = "Cartão Debito" and pedido.cxencerrado is null and pedido.dtfechamento is not null', null, null, 'sum(valor) as valor')->fetchObject()->valor;

        $vlmanutencao = M_ManutencaoPag::buscar('manutencaopagamentos.moeda = "Cartão Debito" and manutencaopagamentos.cxencerrado is null', null, null, 'sum(valor) as valor')->fetchObject()->valor;;



        $vl = $vlpedidos + $vlmanutencao;



        if ($vl == 0) {

            $vl = '0,00';

        }

        return $vl;

    }





    /**

     * Busca o valor as promissorias em aberto

     * @return string

     */

    public static function getPagPix()

    {

        $vlpedidos = M_PedidoPag::buscarPagPedidos('pedidopagamentos.moeda = "Pix" and pedido.cxencerrado is null and pedido.dtfechamento is not null', null, null, 'sum(valor) as valor')->fetchObject()->valor;

        $vlmanutencao = M_ManutencaoPag::buscar('manutencaopagamentos.moeda = "Pix"  and manutencaopagamentos.cxencerrado is null', null, null, 'sum(valor) as valor')->fetchObject()->valor;;



        $vl = $vlpedidos + $vlmanutencao;



        if ($vl == 0) {

            $vl = '0,00';

        }

        return $vl;

    }



    /**

     * Busca o valor da sangria em aberto

     * @return string

     */

    public static function getSangria()

    {

        $vl = M_Sangria::buscar('cxencerrado is null and tipo = "D"', null, null, 'sum(valor) as valor')->fetchObject()->valor;

        if ($vl == '') {

            $vl = '0,00';

        }

        return $vl;

    }



    /**

     * Busca o valor do sangrias em aberto

     * @return string

     */

    public static function getSangrias()

    {

        $tr = '';

        $sangrias = M_Sangria::buscar('cxencerrado is null');

        while ($sangria = $sangrias->fetchObject()) {



            $tipo = ($sangria->tipo  == 'D') ? '<span class="badge bg-warning">Dinheiro</span>' : '<span class="badge bg-gradient-blue">Pix</span>';

            

            if($sangria->tipo  == 'C'){

                $tipo = '<span class="badge bg-black">Cartão</span>';

            }



            $tr .= View::render('admin/conferenciacaixa/sangria',

                [

                    'codigo' => $sangria->id,

                    'descricao' => $sangria->descricao,

                    'tipo' => $tipo,

                    'valor' => $sangria->valor,

                ]);

        }

        return $tr;

    }



    /**

     * Busca o valor do abastecimento em aberto

     * @return string

     */

    public static function getAbastecimento()

    {

        $vl = M_Abastecimento::buscar('cxencerrado is null', null, null, 'sum(valor) as valor')->fetchObject()->valor;

        if ($vl == '') {

            $vl = '0,00';

        }

        return $vl;

    }



    /**

     * Busca o valor do abastecimento em aberto

     * @return string

     */

    public static function getAbastecimentos()

    {

        $tr = '';

        $abastecimentos = M_Abastecimento::buscar('cxencerrado is null');

        while ($abastecimento = $abastecimentos->fetchObject()) {

            $tr .= View::render('admin/conferenciacaixa/abastecimento', ['codigo' => $abastecimento->id, 'descricao' => $abastecimento->descricao, 'valor' => $abastecimento->valor,]);

        }

        return $tr;

    }



    /**

     * Gera listagem dos pedidos que foram recebidos em promissorias e não foram acertados

     * @return string

     */

     public static function getRecebido()

    {

        $tr = '';

        $promissorias = M_PedidoPag::buscarPagPedidos('pedidopagamentos.moeda = "Promissoria" and pedidopagamentos.acertado = "N"');




        while ($promissoria = $promissorias->fetchObject()) {

            $cliente = M_Cliente::buscarComPedido('pedido.numped = ' . $promissoria->numped)->fetchObject(M_Cliente::class);

            $date = date_create($promissoria->vencimento);
            $dataAt = date_create();

     
            $color = ($date < $dataAt) ? 'bg-danger' : 'bg-success';

            $tr .= View::render('admin/conferenciacaixa/recebimentos', [

                'color'  =>  $color,

                'codigo' => $promissoria->codigo,

                'descricao' => $promissoria->moeda,

                'pedido' => $promissoria->numped,

                'dtpedido' => date_format($date, 'd/m/Y'),

                'valor' => $promissoria->valor,

                'cliente' => $cliente->cliente,]

            );

        }

        return $tr;

    }



    /**

     * Busca o valor das promissorias baixadas

     * @return string

     */

    public static function getRecebidoPromissoria()

    {

        $vl = M_Recebimento::buscar('cxencerrado is null', null, null, 'sum(valor) as valor')->fetchObject()->valor;



        if ($vl == '') {

            $vl = '0,00';

        }

        return $vl;

    }



    /**

     * Busca o valor as promissorias em aberto

     * @return string

     */

    public static function getPagPromissoria()

    {

        $vl = M_PedidoPag::buscarPagPedidos('pedidopagamentos.moeda = "Promissoria" and pedido.cxencerrado is null and pedido.dtfechamento is not null', null, null, 'sum(valor) as valor')->fetchObject()->valor;

        if ($vl == '') {

            $vl = '0,00';

        }

        return $vl;

    }



    /**

     * Baixa uma promissoria de acordo com o codigo dela

     * @param $id

     * @return void

     */

    public static function baixaPromissoria($id)

    {

        $pagamento = M_PedidoPag::buscar('codigo = ' . $id)->fetchObject();

        $recebimento = new M_Recebimento();

        $recebimento->numped = $pagamento->numped;

        $recebimento->valor = $pagamento->valor;

        $recebimento->cadastraRecebimentoPromissoria();

        M_PedidoPag::baixaPromissoria($id);

        header("Location: https://juninhodoiphone.com/controle/admin/conferenciacaixa");

        die();

    }



    public static function baixaPromissoriaParcial($request)

    {

        $postVars = $request->getPostVars();

        $id = $postVars['codigo'];

        (float)$valorPag =  str_replace(',', '.', $postVars['valor']);



        $pagamento = M_PedidoPag::buscar('codigo = ' . $id)->fetchObject();

        $recebimento = new M_Recebimento();

        $recebimento->numped = $pagamento->numped;





        if($valorPag > $pagamento->valor){

            header("Location: https://juninhodoiphone.com/controle/admin/conferenciacaixa");

            die();



        }elseif($valorPag == $pagamento->valor){

            $recebimento->valor = $pagamento->valor;

            $recebimento->cadastraRecebimentoPromissoria();

            M_PedidoPag::baixaPromissoria($id);

            header("Location: https://juninhodoiphone.com/controle/admin/conferenciacaixa");

            die();



        }elseif($valorPag < $pagamento->valor && $valorPag > 0){

            $recebimento->valor = $valorPag;

            $recebimento->cadastraRecebimentoPromissoria();

            M_PedidoPag::baixaPromissoriaParcial($id,$valorPag,$pagamento->valor);

            header("Location: https://juninhodoiphone.com/controle/admin/conferenciacaixa");

            die();

        }

            header("Location: https://juninhodoiphone.com/controle/admin/conferenciacaixa");

            die();

    }



    /**

     * Realiza o dechamento do caixa

     * @return string

     */

    public static function confirmaRecebientoFuncionario()

    {



        M_Pedido::atualizar();

        M_ManutencaoPag::atualizar();

        M_Sangria::fechaSangria();

        M_Mesa::zeraCliente();

        M_Abastecimento::fechaAbastecimento();

        M_Recebimento::fechaRecebimentoPromissoria();

        header("Location: https://juninhodoiphone.com/controle/admin/conferenciacaixa");

        die();

    }

}