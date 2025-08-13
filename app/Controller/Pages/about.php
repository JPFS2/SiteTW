<?php 

namespace App\Controller\Pages;
use App\Utils\View;
class About {
    /*
    * Metodo resposave por retornar o conteudo da view do home
    *  @retunr string 
    */    
    public static function getAbout(){


        $content = View::render('pages/about');
 return View::render('pages/about',[
            
        ]);
    }

}