<?php 

namespace App\Controller\Pages;
use App\Utils\View;
class Segmentos {
    /*
    * Metodo resposave por retornar o conteudo da view do home
    *  @retunr string 
    */    
    public static function getSegmentos(){


        $content = View::render('pages/segmentos');
 return View::render('pages/segmentos',[
            
        ]);
    }

}