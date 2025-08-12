<?php


namespace App\Model\Entity;

use WilliamCosta\DatabaseManager\Database;

class Usuario
{
  /** @var int $codusur */
  public $codusur;

  /** @var string $usuario */
  public $usuario;

  /** @var string $senha */
  public $senha;

  /** @var string $email */
  public $email;

  /** @var string $tipo_usuario */
  public $tipo_usuario;

  public static function getUserByEmail($email){
      return (new Database('cadusuario'))->select('email = "'.$email.'"')->fetchObject(self::class);
  }

  public static function getUserById($id){
      return (new Database('cadusuario'))->select('codusur = '.$id)->fetchObject(self::class);
  }

  public function cadastrar(){
      $obDatabase = new Database('cadusuario');
      $id = $obDatabase->insert([
          'usuario' => $this->usuario,
          'senha' => $this->senha,
          'email' => $this->email,
          'tipo_usuario' => $this->tipo_usuario ?? 'user'
      ]);
      return $id;
  }

  public function atualizar(){
      return (new Database('cadusuario'))->update('codusur = '.$this->codusur,[
          'usuario' => $this->usuario,
          'senha' => $this->senha,
          'email' => $this->email,
          'tipo_usuario' => $this->tipo_usuario
      ]);
  }
}