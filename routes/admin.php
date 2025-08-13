<?php


use App\Controller\Admin;
use App\Http\Response;

$obRouter->get('/admin', [
    'middlewares' => [
        'required-admin-login'
    ],
    function () {
        return new Response(200, Admin\Dashboard::getDashboard());
    }
]);

$obRouter->get('/admin/relacaopercas',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Perca::getRelacaoPercas($request));
    }
]);



$obRouter->get('/admin/percas',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Perca::getPercas($request));
    }
]);

$obRouter->post('/admin/adicionaPerca',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Perca::addEntrada($request));
    }
]);

$obRouter->get('/admin/removePerca/{id}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200, Admin\Perca::removeEntrada($id));
    }
]);

$obRouter->get('/admin/venda',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200, Admin\Mesa::getMesa($request));
    }
]);

$obRouter->get('/admin/venda/{numped}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($numped){
        return new Response(200, Admin\PedidoAltera::getMesa($numped));
    }
]);

$obRouter->get('/admin/garantia',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200, Admin\Garantia::getGarantia($request));
    }
]);
// Rota garantia
$obRouter->post('/admin/addGarantia', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Garantia::addManutencao($request));
    }
]);


$obRouter->get('/admin/manutencao',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200, Admin\Manutencao::getManutencao($request));
    }
]);


// Rota realiza o Login
$obRouter->post('/admin/addManutencao', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Manutencao::addManutencao($request));
    }
]);

$obRouter->post('/admin/removeManutencao',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\Manutencao::removeManutencao($request));
    }
]);
// Rota realiza o Login
$obRouter->get('/admin/finalizaGarantia', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Garantia::finalizaGarantia($request));
    }
]);

// Rota realiza o Login
$obRouter->get('/admin/finalizaManutencao', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Manutencao::finalizaManutencao($request));
    }
]);


// Adiciona a tarefa
$obRouter->post('/admin/adicionatarefa', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Dashboard::addTarefa($request));
    }
]);

// atualizar a tarefa
$obRouter->post('/admin/atualizardtftarefa', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Dashboard::updateTarefa($request));
    }
]);

// Atualiza o cliente
$obRouter->post('/admin/adicionacliente', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Mesa::addCliente($request));
    }
]);

// Atualiza o cliente no pedido
$obRouter->post('/admin/atualizaacliente', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\PedidoAltera::addCliente($request));
    }
]);

// Atualiza o cliente
$obRouter->post('/admin/manadicionacliente', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Manutencao::addCliente($request));
    }
]);

// Atualiza o Desconto
$obRouter->post('/admin/adicionadesconto', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Mesa::addDesconto($request));
    }
]);

// Atualiza o Desconto
$obRouter->post('/admin/descontoPedido', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\PedidoAltera::addDesconto($request));
    }
]);

// Atualiza o Desconto
$obRouter->post('/admin/adicionaacrescimo', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Mesa::addAcrescimo($request));
    }
]);

// Atualiza o Desconto
$obRouter->post('/admin/pedidoacrescimo', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\PedidoAltera::addAcrescimo($request));
    }
]);

$obRouter->post('/admin/adicionaproduto', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Mesa::addProduto($request));
    }
]);
$obRouter->post('/admin/adicionatroca', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Mesa::addTroca($request));
    }
]);

$obRouter->post('/admin/adicionatrocaPedido', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\PedidoAltera::addTroca($request));
    }
]);

$obRouter->get('/admin/removeTroca/{coditem}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($coditem){
        return new Response(200,Admin\Mesa::removeTroca($coditem));
    }
]);
$obRouter->get('/admin/removemoeda/{coditem}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($coditem){
        return new Response(200,Admin\Mesa::removeMoeda($coditem));
    }
]);

$obRouter->get('/admin/removemoedapedido/{coditem}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($coditem){
        return new Response(200,Admin\PedidoAltera::removeMoeda($coditem));
    }
]);

$obRouter->get('/admin/mesa/{id}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200, Admin\Mesa::getMesa($request,$id));
    }
]);

// Rota realiza o Login
$obRouter->post('/admin/add', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Mesa::addProduto($request));
    }
]);

// Rota realiza o Login
$obRouter->post('/admin/addPordPedido', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\PedidoAltera::addProduto($request));
    }
]);
// Relação de Importador de produtos
$obRouter->get('/admin/importaproduto',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\ImportaProduto::getImportaProduto());
    }
]);

$obRouter->get('/admin/removeitem/{coditem}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($coditem){
        return new Response(200,Admin\Mesa::removeProduto($coditem));
    }
]);

$obRouter->get('/admin/removeitempedido/{coditem}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($coditem){
        return new Response(200,Admin\PedidoAltera::removeProduto($coditem));
    }
]);

$obRouter->post('/admin/addPmesa', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Pagamento::addPMesa($request));
    }
]);

$obRouter->post('/admin/addPpedido', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\PedidoAltera::addPMesa($request));
    }
]);

$obRouter->get('/admin/finalizamesa', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Pagamento::finaizaPedido($request));
    }
]);

$obRouter->get('/admin/finalizamesaabs', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Pagamento::finaizaPedidoAbs($request));
    }
]);

$obRouter->get('/admin/finalizaPedido/{coditem}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($coditem){
        return new Response(200,Admin\PedidoAltera::finalizaPedido($coditem));
    }
]);

// Rota que mostra a tela de login
$obRouter->get('/admin/login', [
    'middlewares' => [
        'required-admin-logout'
    ],
    function ($request) {
        return new Response(200, Admin\Login::getLogin($request));
    }
]);

// Rota realiza o Login
$obRouter->post('/admin/login', [
    'middlewares' => [
        'required-admin-logout'
    ],
    function ($request) {
        return new Response(200, Admin\Login::setLogin($request));
    }
]);

// Rota que realiza o Logout
$obRouter->get('/admin/logout', [
    function ($request) {

        return new Response(200, Admin\Login::setLogout($request));
    }
]);

// Rota que mostra a tela de empresa
$obRouter->get('/admin/empresa',[
    'middlewares' => [
        'required-admin-login'
    ],
    function(){
        return new Response(200,Admin\Empresa::getEmpresa());
    }
]);

// Rota que atuaiza os dados da emrpesa
$obRouter->post('/admin/empresa',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Empresa::atualizaEmpresa($request));
    }
]);

$obRouter->get('/admin/clientes',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Cliente::getClientes($request));
    }
]);

$obRouter->get('/admin/clientes/{idPagina}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$idPagina){
        return new Response(200, Admin\Cliente::editClientes($request,$idPagina));
    }
]);

$obRouter->post('/admin/clientes',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Cliente::atualizaClientes($request));
    }
]);

$obRouter->get('/admin/cliente',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Cliente::insereCliente($request));
    }
]);

$obRouter->post('/admin/cliente',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Cliente::cadastraCliente($request));
    }
]);


$obRouter->get('/admin/produtos',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Produto::getProdutos($request));
    }
]);

$obRouter->get('/admin/produtos/{id}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200, Admin\Produto::editProdutos($request,$id));
    }
]);

$obRouter->get('/admin/comboproduto',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Produto::getProdutoCombo($request));
    }
]);

$obRouter->get('/admin/removeprodutocombo/{id}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200, Admin\Produto::removeProdutoCombo($id));
    }
]);

$obRouter->get('/admin/removecombo/{id}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200, Admin\Produto::removeCombo($id));
    }
]);

$obRouter->post('/admin/produtos',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Produto::atualizaProduto($request));
    }
]);

$obRouter->get('/admin/relacaoprodutos',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\RelacaoProduto::getProdutos($request));
    }
]);

$obRouter->get('/admin/produto',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Produto::addProduto($request));
    }
]);

$obRouter->get('/admin/entrada',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Entrada::getProdutoCombo($request));
    }
]);


$obRouter->get('/admin/removeEntrada/{id}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200, Admin\Entrada::removeEntrada($id));
    }
]);

$obRouter->post('/admin/adicionaEntrada',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Entrada::addEntrada($request));
    }
]);

$obRouter->post('/admin/produto',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Produto::adicionaProduto($request));
    }
]);

$obRouter->post('/admin/adicionaCombo',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Produto::addCombo($request));
    }
]);

$obRouter->post('/admin/desistepedido',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\ControlePedido::desistePedido($request));
    }
]);

$obRouter->get('/admin/pedidos',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\ControlePedido::getPedidos());
    }
]);

$obRouter->get('/admin/lucratividadePedido',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\LucratividadePedido::getPedidos());
    }
]);

$obRouter->get('/admin/produtosVendidos',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\ProdutosVendidos::getPedidos());
    }
]);

$obRouter->get('/admin/pedidos/{id}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200,Admin\ControlePedido::getPedido($id));
    }
]);
$obRouter->post('/admin/extornapedido',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\ControlePedido::extornaPedido($request));
    }
]);
$obRouter->get('/admin/promissorias',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\Promissorias::getDevedores());
    }
]);

// Tela para adicionar um abastecimento
$obRouter->post('/admin/promissoriasextorno',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Promissorias::extornarecebimento($request));
    }
]);




// Tela do Caixa
$obRouter->get('/admin/conferenciacaixa',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200,Admin\ConferenciaPagamento::getRecebimento());
    }
]);

// Tela do Caixa
$obRouter->get('/admin/conferenciacaixa/{id}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200,Admin\ConferenciaCaixa::getRecebimentos($id));
    }
]);

// Tela para adicionar um abastecimento
$obRouter->post('/admin/abastecimentoAdd',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Abastecimento::addAbastecimento($request));
    }
]);

// Tela para remover um abastecimento
$obRouter->get('/admin/removeAbastecimento/{id}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($id){
        return new Response(200, Admin\Abastecimento::removeAbastecimento($id));
    }
]);

// Tela para receber um promissoria
$obRouter->get('/admin/baixaPromissoria/{id}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($id){
        return new Response(200, Admin\ConferenciaPagamento::baixaPromissoria($id));
    }
]);

// Atualiza o cliente
$obRouter->post('/admin/baixaPromissoria', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\ConferenciaPagamento::baixaPromissoriaParcial($request));
    }
]);


// Tela para adicionar uma sangria
$obRouter->post('/admin/sangriaAdd',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Sangria::addSangria($request));
    }
]);

// Tela para remover uma sangria
$obRouter->get('/admin/removeSangria/{id}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($id){
        return new Response(200, Admin\Sangria::removeSangria($id));
    }
]);


$obRouter->get('/admin/impressaopedido/{id}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200,Admin\Pedido::getPrint($id));
    }
]);

$obRouter->get('/admin/printmanutencao/{id}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200,Admin\Manutencao::getPrint($id));
    }
]);


$obRouter->get('/admin/acertaconta/{id}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200,Admin\ConferenciaPagamento::confirmaRecebientoFuncionario($id));
    }
]);



$obRouter->get('/admin/acertaconta',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200,Admin\ConferenciaPagamento::confirmaRecebientoFuncionario());
    }
]);

// Relação de Caixas Fechados
$obRouter->get('/admin/relacaocaixas',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\RelacaoCaixas::getCaixas());
    }
]); 
// Relação de sangria
$obRouter->get('/admin/relacaosangria',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\RelacaoSangria::getRelacaoSangria());
    }
]);

// Manutenções
$obRouter->get('/admin/manutencoes',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\RelacaoManutencoes::getManutencoes());
    }
]);

// Relação de Pedido Estornado
$obRouter->get('/admin/pedidoestornado',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\PedidoEstornado::getPedidoEstornado());
    }
]);
$obRouter->get('/admin/removeTarefa/{id}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200,Admin\Dashboard::removeTarefa($id));
    }
]);

$obRouter->get('/admin/relacaodespesas',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\Despesas::getRelacaoDespesas());
    }
]);

$obRouter->get('/admin/removeDespesas/{id}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200, Admin\Despesas::removeEntrada($id));
    }
]);

$obRouter->post('/admin/adicionaDespesa',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Despesas::addDespesa($request));
    }
]);

$obRouter->get('/admin/despesas',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Despesas::getDespesas($request));
    }
]);
