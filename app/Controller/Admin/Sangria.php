<?php namespace App\Controller\Admin;

use App\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\Sangria as M_Sangria;
use App\Utils\View;

class Sangria extends Page
{
    /**     * Realiza a adição do abastecimento     * @param Request $request * @return string */
    public static function addSangria($request)
    {
        $postVars = $request->getPostVars();

        $sangria = new M_Sangria();

        if(array_key_exists('tpSangria',$postVars)){
            $sangria->tipo = 'P';
        }elseif (array_key_exists('tpSangriaC',$postVars)){
            $sangria->tipo = 'C';
        }else{
            $sangria->tipo = 'D';
        }

        $sangria->descricao = $postVars['descricao'];
        $sangria->valor = $postVars['valor'];
        $sangria->cadastraSangria();
        header("Location: http://localhost/controle/admin/conferenciacaixa");
        die();
    }

    /**     * Realiza a remoção de um abastecimento     * @param $id * @return void */
    public static function removeSangria($id)
    {
        M_Sangria::removeSangria($id);
        header("Location: https://juninhodoiphone.com/controle/admin/conferenciacaixa");
        die();
    }
     /**     * Realiza a Chamada da tela de produtos     * @param $request * @return string */
    public static function getProdutos($request)
    {
        $content = View::render('admin/relacaoproduto',
            [
                'tr' => self::getProduto($request)
            ]);
        return parent::getPageLogin('Controle', $content);
    }
    public static function getProduto($request)
    {
        $tr = '';

        while ($produto = $results->fetchObject(M_Produto::class)) {
            $secao = '';

            if (array_key_exists($produto->codsecao,$desc_secoes)) {
                $secao =  $desc_secoes[$produto->codsecao]; // Retornar a descrição correspondente
            } else {
                $secao = "Não Informada"; // Caso o código não exista
            }

            $tr .= View::render('admin/relacaoproduto/produto',
                [
                    'codprod' => $produto->codprod,
                    'descricao' => $produto->descricao,
                    'und' => $produto->und,
                    'ean13' => $produto->ean13,
                    'peso' => $produto->peso,
                    'secao' => $secao,
                    'qtestoque' => $produto->qtestoque,
                    'punit' => $produto->punit ?? 'NÃO INFORMADO',
                    'status' => 'Status'
                ]);
        }
        return $tr;
    }
}