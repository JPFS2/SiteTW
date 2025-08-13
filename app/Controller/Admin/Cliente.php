<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Page;
use App\Model\Entity\Cliente as M_Cliente;
use App\Utils\View;
use WilliamCosta\DatabaseManager\Pagination;

class Cliente extends Page
{
    public static function getCliente($request, &$obPagination)
    {
        $tr = '';        // QUANTIDAD TOTAL DE REGISTROS        // Pagina atual
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['pg'] ?? 1;
        $condicao = isset($queryParams['cl']) ? 'cliente like "%'.$queryParams['cl'].'%"': '';
        $quantidadetotal = M_Cliente::buscar($condicao,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;
        $obPagination = new Pagination($quantidadetotal,$paginaAtual,1000000000);
        $results = M_Cliente::buscar($condicao,null,$obPagination->getLimit(),'*');
        while ($cliente = $results->fetchObject(M_Cliente::class)){
            $tr .= View::render('admin/clientes/cliente',[
                'codigo' => $cliente->codcli,
                'cliente' => $cliente->cliente,
                'fantasia' => $cliente->fantasia,
                'Liberado' => $cliente->Liberado,
                'Ativo' => $cliente->Ativo,
                'cliente' => $cliente->cliente,
                'cnpj' => $cliente->cnpj,
                'tel1' => $cliente->tel1 ?? 'NÃO INFORMADO',
                'email' => $cliente->email,
                'status' => 'Status'
            ]);
        }
        return $tr;
    }
    /*
     * Metodo resposave por retornar o conteudo da view do home
     *  @retunr string
     */

    public static function getClientes($request){
        $content = View::render('admin/cliente',[
            'tr' => self::getCliente($request,$obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
        ]);
        return parent::getPageLogin('Controle',$content);
    }
    public static function editClientes($request,$id){
        $cliente = M_Cliente::buscar('codcli = '.$id,null,null,'*')->fetchObject(M_Cliente::class);
        $content = View::render('admin/cliente_form',[
            'codigo' => $cliente->codcli,
            'cliente' => $cliente->cliente,
            'fantasia' => $cliente->fantasia,
            'cnpj' => $cliente->cnpj,
            'Liberado' => $cliente->Liberado,
            'Ativo' => $cliente->Ativo,
            'cnpj' => $cliente->cnpj,
            'ie' => $cliente->ie,
            'cpf' => $cliente->cpf,
            'tel1' => $cliente->tel1,
            'tel2' => $cliente->tel2,
            'cep' => $cliente->cep,
            'endereco' => $cliente->endereco,
            'numero' => $cliente->numero,
            'bairro' => $cliente->bairro,
            'cidade' => $cliente->cidade,
            'uf' => $cliente->uf,
            'complemento' => $cliente->complemento,
            'email' => $cliente->email,
            'cidade' => $cliente->cidade,
            'instagram' => $cliente->instagram,
            'facebook' => $cliente->facebook
            ]);        return parent::getPage('Controle',$content);
    }

    public static function atualizaClientes($request){
        $postVars = $request->getPostVars();
        $obCliente = new M_Cliente();
        $obCliente->codcli = $postVars['codcli'];
        $obCliente->cliente = $postVars['cliente'];
        $obCliente->fantasia = $postVars['fantasia'];
        $obCliente->cnpj = $postVars['cnpj'];
        $obCliente->Ativo = $postVars['Ativo'];
        $obCliente->Liberado = $postVars['Liberado'];
        $obCliente->cep = $postVars['cep'];
        $obCliente->tel1 = $postVars['tel1'];
        $obCliente->tel2 = $postVars['tel2'];
        $obCliente->endereco = $postVars['endereco'];
        $obCliente->numero = $postVars['numero'];
        $obCliente->bairro = $postVars['bairro'];
        $obCliente->cidade = $postVars['cidade'];
        $obCliente->uf = $postVars['uf'];
        $obCliente->complemento = $postVars['complemento'];
        $obCliente->email = $postVars['email'];
        $obCliente->atualizar();
        return self::getClientes($request);
    }

    public static function cadastraCliente($request)
    {
        $postVars = $request->getPostVars();
        $obCliente = new M_Cliente();
        $obCliente->cliente = $postVars['cliente'];
        $obCliente->fantasia = $postVars['fantasia'];
        $obCliente->cnpj = $postVars['cnpj'];
        $obCliente->cep = $postVars['cep'];
        $obCliente->tel1 = $postVars['tel1'];
        $obCliente->tel2 = $postVars['tel2'];
        $obCliente->endereco = $postVars['endereco'];
        $obCliente->numero = $postVars['numero'];
        $obCliente->bairro = $postVars['bairro'];
        $obCliente->Ativo = $postVars['Ativo'];
        $obCliente->Liberado = $postVars['Liberado'];
        $obCliente->cidade = $postVars['cidade'];;
        $obCliente->uf = $postVars['uf'];
        $obCliente->complemento = $postVars['complemento'];
        $obCliente->email = $postVars['email'];
        $obCliente->cadastrar();
        return self::getClientes($request);
    }

    public static function insereCliente($request)
    {
        $content = View::render('admin/cliente_add', []);
        return parent::getPage('Controle', $content);
    }
}