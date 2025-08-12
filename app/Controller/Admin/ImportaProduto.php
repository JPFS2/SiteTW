<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Page;
use App\Http\Request;
use App\Model\Entity\Produto as M_Produto;
use App\Model\Entity\Pedido as M_Pedido;
use App\Model\Entity\Credito as M_Credito;
use App\Model\Entity\ProdutoCombo as M_Combo;
use App\Model\Entity\Secao;
use App\Utils\View;

class ImportaProduto extends Page
{    /*    * Metodo resposave por retornar o conteudo da view do home    *  @retunr string     */


    /**     * Realiza a Chamada da tela de produtos     * @param $request * @return string */
    public static function getImportaProduto()
    {

        $tr = '';

        $results = M_Produto::ImportaProduto('dtimport is not null group by dtimport', null, null, '*');
        


        while ($produto = $results->fetchObject(M_Produto::class)) {

            $tr .= View::render('admin/importaproduto/importa',

                [
                   'dtimport' => $produto->dtimport,

                ]

            );

            
        }
        $content = View::render('admin/importaproduto', [
            'tr' => $tr,
        ]);

        return parent::getPageLogin('Controle',$content);


 }
}