<?php







namespace App\Model\Entity;







use WilliamCosta\DatabaseManager\Database;







class PedidoPagamento

{

    public $codigo;

    public $moeda;

    public $valor;
    public $vencimento;
    public $valorpago;

    public $numped;

    public $acertado;



    public static function baixaPromissoria($codigo){

        $obDatabase = new Database('pedidopagamentos');
        $success = $obDatabase->update('codigo ='.$codigo,[
            'acertado' => 'S',
        ]);

    }

    public static function ExtornaBaixaTotal($numped){

        $obDatabase = new Database('pedidopagamentos');
        $success = $obDatabase->update('numped ='.$numped,[
            'acertado' => 'N',
        ]);
    }

    public static function ExtornaBaixaParcial($numped,$valor,$pago){

        $obDatabase = new Database('pedidopagamentos');
        $success = $obDatabase->update('numped ='.$numped,[
            'valor' => $valor + $pago,
        ]);
    }   



    public static function baixaPromissoriaParcial($codigo,$valorP,$valor){

        $obDatabase = new Database('pedidopagamentos');
        $success = $obDatabase->update('codigo ='.$codigo,[

            'valor' => $valor - $valorP,
            'valorpago' => $valorP,

        ]);



    }



    public static function deletar($id){
        $obDatabase = new Database('pedidopagamentos');
        $success = $obDatabase->delete('numped = '.$id);

    }


    public function atualizar(){

        $obDatabase = new Database('mesa');
        $success = $obDatabase->update('codcar ='.$this->codcar,[
            'codprod' => $this->codprod,
            'punit' => $this->punit,
            'qt' => $this->qt,
            'vlliq' => ($this->qt * $this->punit),
            'dtinclusao' => 'CURRENT_DATE()',
            'codcli' => $this->codcli
        ]);

    }






    public function cadastrar(){

        $obDatabase = new Database('pedidopagamentos');
        $id = $obDatabase->insert([
            'numped' => $this->numped,
            'moeda' => $this->moeda,
            'valor' => $this->valor,
            'vencimento' => $this->vencimento
        ]);
        return $id;
    }



    public function cadastrarExclusao(){



        $obDatabase = new Database('pedidopagamentos_excluidos');

        $id = $obDatabase->insert([

            'numped' => $this->numped,

            'moeda' => $this->moeda,

            'valor' => $this->valor,

            'acertado' => $this->acertado,

            'valorpago' => $this->valorpago

        ]);

        return $id;

    }





    public function excluir(){



        $obDatabase = new Database('mesa');



        $success = $obDatabase->delete('codcar = '.$this->codcar);



    }







    public function excluirItem(){



        $obDatabase = new Database('pedidopagamentos');



        $success = $obDatabase->delete('codigo = '.$this->codigo);



    }











    public static function buscar($where = null, $order = null, $limit = null, $filds = '*'){



        return  (new Database('pedidopagamentos'))->select($where,$order,$limit,$filds);



    }







    public static function buscarItens($where = null, $order = null, $limit = null, $filds = '*'){



        return  (new Database('pedidopagamentos'))->select($where,$order,$limit,$filds);



    }







    public static function buscarPagPedidos($where = null, $order = null, $limit = null, $filds = '*'){



        return  (new Database('pedidopagamentos'))->selectJoin($where,$order,$limit,$filds,'pedido', 'pedidopagamentos.numped = pedido.numped');



    }











}