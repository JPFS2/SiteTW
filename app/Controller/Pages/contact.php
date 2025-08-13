<?php 

namespace App\Controller\Pages;
use App\Utils\View;
class Contact {
    /*
    * Metodo resposave por retornar o conteudo da view do home
    *  @retunr string 
    */    
    public static function getContact(){


        $content = View::render('pages/contact');
 return View::render('pages/contact',[
            
        ]);
    }

}