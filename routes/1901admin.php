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

$obRouter->get('/admin/venda',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200, Admin\Mesa::getMesa($request));
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

$obRouter->get('/admin/removeManutencao/{coditem}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($coditem){
        return new Response(200,Admin\Manutencao::removeManutencao($coditem));
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

// Atualiza o cliente
$obRouter->post('/admin/adicionacliente', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Mesa::addCliente($request));
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
$obRouter->post('/admin/adicionaacrescimo', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Mesa::addAcrescimo($request));
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

$obRouter->get('/admin/removeitem/{coditem}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($coditem){
        return new Response(200,Admin\Mesa::removeProduto($coditem));
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

$obRouter->get('/admin/finalizamesa', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Pagamento::finaizaPedido($request));
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

$obRouter->post('/admin/produtos',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Produto::atualizaProduto($request));
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

$obRouter->post('/admin/produto',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200, Admin\Produto::adicionaProduto($request));
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
$obRouter->get('/admin/extornapedido/{id}',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200,Admin\ControlePedido::extornaPedido($id));
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



// Tela do Caixa
$obRouter->get('/admin/conferenciacaixa',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request,$id){
        return new Response(200,Admin\ConferenciaPagamento::getRecebimento());
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

// Relação de Caixas Fechados
$obRouter->get('/admin/manutencoes',[
    'middlewares' => [
        'required-admin-login'
    ],
    function($request){
        return new Response(200,Admin\RelacaoManutencoes::getManutencoes());
    }
]);

