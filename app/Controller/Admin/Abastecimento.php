<?php namespace App\Controller\Admin;

use App\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\Abastecimento as M_Abastecimento;
use App\Utils\View;

class Abastecimento extends Page
{
    /**     * Realiza a adição do abastecimento     * @param Request $request * @return string */
    public static function addAbastecimento($request)
    {
        $postVars = $request->getPostVars();
        $abastecimento = new M_Abastecimento();
        $abastecimento->descricao = $postVars['descricao'];
        $abastecimento->valor = $postVars['valor'];
        $abastecimento->cadastraAbastecimento();
        header("Location: https://juninhodoiphone.com/controle/admin/conferenciacaixa");
        die();
    }

    /**     * Realiza a remoção de um abastecimento     * @param $id * @return void */
    public static function removeAbastecimento($id)
    {
        M_Abastecimento::removeAbastecimento($id);
        header("Location: https://juninhodoiphone.com/controle/admin/conferenciacaixa");
        die();
    }
}