<?php

namespace App\Model\Entity;

use DateTime;
use WilliamCosta\DatabaseManager\Database;

class Despesas
{
    public $id;
    public $fornecedor;
    public $historico;
    public $valor;
    public $data;

    public static function buscar($where = null, $order = null, $limit = null, $filds = '*')
    {
        return (new Database('despesas'))->select($where, $order, $limit, $filds);
    }

    public function cadastra()
    {

        $obDatabase = new Database('despesas');
        $id = $obDatabase->insert(
            [
                'fornecedor' => $this->fornecedor,
                'historico' => $this->historico,
                'valor' => $this->valor,
                'data' => $this->data
            ]);

        return $id;
    }

    public static function excluir($id)
    {
        $obDatabase = new Database('despesas');
        $success = $obDatabase->delete('id = ' . $id);
    }

}