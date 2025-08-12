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

class ConferenciaCaixa extends Page
{
    /**     * Busca o valor da sangria em aberto     * @return string */
    public static function getSangria($dataCaixa)
    {
        $vl = M_Sangria::buscar('date(cxencerrado) = '.$dataCaixa, null, null, 'sum(valor) as valor')->fetchObject()->valor;
        if ($vl == '') {
            $vl = '0,00';
        }
        return $vl;
    }

    /**     * Busca o valor do sangrias em aberto     * @return string */
    public static function getSangrias($dataCaixa)
    {
        $tr = '';
        $sangrias = M_Sangria::buscar('date(cxencerrado) = '.$dataCaixa);
        while ($sangria = $sangrias->fetchObject()) {
            $tr .= View::render('admin/conferenciacaixa/sangria', ['codigo' => $sangria->id, 'descricao' => $sangria->descricao, 'valor' => $sangria->valor,]);
        }
        return $tr;
    }

    /**     * Busca o valor do abastecimento em aberto     * @return string */
    public static function getAbastecimento($dataCaixa)
    {
        $vl = M_Abastecimento::buscar('date(cxencerrado) = '.$dataCaixa, null, null, 'sum(valor) as valor')->fetchObject()->valor;
        if ($vl == '') {
            $vl = '0,00';
        }
        return $vl;
    }

    /**     * Busca o valor do abastecimento em aberto     * @return string */
    public static function getAbastecimentos($dataCaixa)
    {
        $tr = '';
        $abastecimentos = M_Abastecimento::buscar('date(cxencerrado) = '.$dataCaixa);
        while ($abastecimento = $abastecimentos->fetchObject()) {
            $tr .= View::render('admin/conferenciacaixa/abastecimento', ['codigo' => $abastecimento->id, 'descricao' => $abastecimento->descricao, 'valor' => $abastecimento->valor,]);
        }
        return $tr;
    }

    /**     * Busca o valor do abastecimento em aberto     * @return string */


    /**     * Busca o valor os pedidos em dinheiro no caixa     * @return string */
    public static function getPagDinheiro($dataCaixa)
    {

        $vlpedidos = M_PedidoPag::buscarPagPedidos('pedidopagamentos.moeda = "Dinheiro" and date(pedido.cxencerrado) = '.$dataCaixa, null, null, 'sum(valor) as valor')->fetchObject()->valor;
        $vlmanutencao = M_ManutencaoPag::buscar('manutencaopagamentos.moeda = "Dinheiro" and date(manutencaopagamentos.cxencerrado) = '.$dataCaixa, null, null, 'sum(valor) as valor')->fetchObject()->valor;;

        $vl = $vlpedidos + $vlmanutencao;

        if ($vl == 0) {
            $vl = '0,00';
        }
        return $vl;
    }

    /**     * Busca o valor os pedidos em cartão de credito no caixa     * @return string */
    public static function getPagCredito($dataCaixa)
    {
        $vlpedidos = M_PedidoPag::buscarPagPedidos('pedidopagamentos.moeda = "Cartão Credito" and date(pedido.cxencerrado) = '.$dataCaixa, null, null, 'sum(valor) as valor')->fetchObject()->valor;
        $vlmanutencao = M_ManutencaoPag::buscar('manutencaopagamentos.moeda = "Cartão Credito" and date(manutencaopagamentos.cxencerrado) = '.$dataCaixa, null, null, 'sum(valor) as valor')->fetchObject()->valor;;

        $vl = $vlpedidos + $vlmanutencao;

        if ($vl == 0) {
            $vl = '0,00';
        }
        return $vl;
    }

    /**     * Busca o valor os pedidos em cartão de debito no caixa     * @return string */
    public static function getPagDebito($dataCaixa)
    {
        $vlpedidos = M_PedidoPag::buscarPagPedidos('pedidopagamentos.moeda = "Cartão Debito"  and date(pedido.cxencerrado) = '.$dataCaixa, null, null, 'sum(valor) as valor')->fetchObject()->valor;
        $vlmanutencao = M_ManutencaoPag::buscar('manutencaopagamentos.moeda = "Cartão Debito" and date(manutencaopagamentos.cxencerrado) = '.$dataCaixa, null, null, 'sum(valor) as valor')->fetchObject()->valor;;

        $vl = $vlpedidos + $vlmanutencao;

        if ($vl == 0) {
            $vl = '0,00';
        }
        return $vl;
    }

    /**     * Busca o valor os pedidos em cartão de debito no caixa     * @return string */
    public static function getRecebidoPromissoria($dataCaixa)
    {
        $vl = M_Recebimento::buscar('date(cxencerrado) = '.$dataCaixa, null, null, 'sum(valor) as valor')->fetchObject()->valor;

        if ($vl == '') {
            $vl = '0,00';
        }
        return $vl;
    }

    /**     * Busca o valor as promissorias em aberto     * @return string */
    public static function getPagPix($dataCaixa)
    {
        $vlpedidos = M_PedidoPag::buscarPagPedidos('pedidopagamentos.moeda = "Pix" and date(pedido.cxencerrado) = '.$dataCaixa, null, null, 'sum(valor) as valor')->fetchObject()->valor;
        $vlmanutencao = M_ManutencaoPag::buscar('manutencaopagamentos.moeda = "Pix"  and date(manutencaopagamentos.cxencerrado) = '.$dataCaixa, null, null, 'sum(valor) as valor')->fetchObject()->valor;;

        $vl = $vlpedidos + $vlmanutencao;

        if ($vl == 0) {
            $vl = '0,00';
        }
        return $vl;
    }

    /**     * Busca o valor as promissorias em aberto     * @return string */
    public static function getPagPromissoria()
    {
        $vl = M_PedidoPag::buscarPagPedidos('pedidopagamentos.moeda = "Promissoria" and pedido.cxencerrado is null', null, null, 'sum(valor) as valor')->fetchObject()->valor;
        if ($vl == '') {
            $vl = '0,00';
        }
        return $vl;
    }

    /**
     * Retorna a tela inicial do caixa
     * @return string
     */
    public static function getRecebimentos($data)
    {
        $dataCaixa = $data;

        $tr = '';
        $pedidos = M_PedidoPag::buscarPagPedidos('date(cxencerrado) = '.$dataCaixa, null, null, '*');

        $vltotal = (floatval(self::getPagDinheiro($dataCaixa)) +
                floatval(self::getPagCredito($dataCaixa)) +
                floatval(self::getPagDebito($dataCaixa)) +
                floatval(self::getPagPix($dataCaixa)) +
                floatval(self::getAbastecimento($dataCaixa)) +
                floatval(self::getRecebidoPromissoria($dataCaixa))
            ) -  floatval(self::getSangria($dataCaixa))
        
        ;
        $manutencoes = M_ManutencaoPag::buscarJoin('date(cxencerrado) = '.$dataCaixa);

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
                'vlliq' => $pedido->valor,]);
        }

        $content = View::render('admin/conferenciacaixadia', [
            'tr' => $tr,
            'usuario' => $_SESSION['admin']['usuario']['nome'],
            'vldinheiro' => self::getPagDinheiro($dataCaixa),
            'vlcredito' => self::getPagCredito($dataCaixa),
            'vldebito' => self::getPagDebito($dataCaixa),
            'vlabastecimento' => self::getAbastecimento($dataCaixa),
            'vlsangria' => self::getSangria($dataCaixa),
            'vlpromissoria' => self::getPagPromissoria(),
            'trabastecimento' => self::getAbastecimentos($dataCaixa),
            'trsangria' => self::getSangrias($dataCaixa),
            'trrecebimento' => 'trrecebimento',
            'vlrecebimento' => self::getRecebidoPromissoria($dataCaixa),
            'vlpix' => self::getPagPix($dataCaixa),
            'vltotal' =>  $vltotal

        ]);
        return parent::getPageLogin('Controle', $content);
    }


}