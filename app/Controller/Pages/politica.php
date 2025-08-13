<?php 

namespace App\Controller\Pages;
use App\Utils\View;
class Politica {
    /*
    * Metodo resposave por retornar o conteudo da view do home
    *  @retunr string 
    */    
    public static function getPolitica(){


        $content = View::render('pages/politica');
 return View::render('pages/politica',[
            
        ]);
    }

}