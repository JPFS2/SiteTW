<?php

use App\Controller\Pages;
use App\Http\Response;

$obRouter->get('/',[
    'middlewares' => [
        'required-pages-logout'
    ],
    function(){
        return new Response(200, Pages\home::gethome());
    }
]);

$obRouter->get('/segmentos',[
    'middlewares' => [
        'required-pages-logout'
    ],
    function(){
        return new Response(200, Pages\segmentos::getsegmentos());
    }
]);
$obRouter->get('/sobre',[
    'middlewares' => [
        'required-pages-logout'
    ],
    function(){
        return new Response(200, Pages\about::getabout());
    }
]);
$obRouter->get('/politica',[
    'middlewares' => [
        'required-pages-logout'
    ],
    function(){
        return new Response(200, Pages\politica::getpolitica());
    }
]);
$obRouter->get('/ouvidoria',[
    'middlewares' => [
        'required-pages-logout'
    ],
    function(){
        return new Response(200, Pages\contact::getcontact());
    }
]);


