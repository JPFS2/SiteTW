<?php

namespace App\Session\Admin;

use App\Model\Entity\Usuario;

class Login
{

    public static function init(){
        if(session_status() != PHP_SESSION_ACTIVE){
            session_start();
        }
    }

    /**
     * Metodo responsavel por realizar o login
     * @param Usuario $obUser
     * @return boolean
     */
    public static function login($obUsuario){
        self::init();

        $_SESSION['admin']['usuario'] = [
            'id' => $obUsuario->codusur,
            'nome' => $obUsuario->usuario,
            'email' => $obUsuario->email,
            'tipo_usuario' => $obUsuario->tipo_usuario ?? 'user'
        ];

        return true;
    }

    public static function isLogged(){
        self::init();

        return isset($_SESSION['admin']['usuario']['id']);
    }

    public static function getUsuarioLogado(){
        self::init();
        return $_SESSION['admin']['usuario'] ?? null;
    }

    /**
     * Metodo Responsavel por realziar o logout
     * @return boolean
     */
    public static function logout(){
        self::init();

        unset($_SESSION['admin']['usuario']);
        return true;
    }

}