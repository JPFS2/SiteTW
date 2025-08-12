<?php 

namespace App\Controller\Pages;
use App\Utils\View;
class Home {
    /*
    * Metodo resposave por retornar o conteudo da view do home
    *  @retunr string 
    */    
    public static function getHome(){


        $content = View::render('pages/home');
 return View::render('pages/home',[
            
        ]);
    }

}