<?php



namespace App\Model\Entity;



use WilliamCosta\DatabaseManager\Database;



class Cliente

{

    public $codcli;
    public $cnpj;
    public $ie;
    public $cpf;
    public $cliente;
    public $fantasia;
    public $endereco;
    public $numero;
    public $bairro;
    public $cidade;
    public $uf;
    public $cep;
    public $importado;
    public $tel1;
    public $tel2;
    public $complemento;
    public $email;
    public $instagram;
    public $facebook;
    public $Prazo;
    public $Bloqueado;
    public $codexterno;
    public $codtabela;
    public $Ativo;
    public $Liberado;

    public function atualizar(){

        $obDatabase = new Database('cadcliente');
        $success = $obDatabase->update('codcli ='.$this->codcli,[
            'cliente' => $this->cliente,
            'fantasia' => $this->fantasia,
            'cpf'=> $this->cpf,
            'cnpj'=> $this->cnpj,
            'Ativo'=> $this->Ativo,
            'Liberado'=> $this->Liberado,
            'tel1' => $this->tel1,
            'tel2' => $this->tel2,
            'cep' => $this->cep,
            'endereco' => $this->endereco,
            'numero' => $this->numero,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'uf' => $this->uf,
            'complemento' => $this->complemento,
            'email' => $this->email,
        ]);
    }
    public function cadastrar(){
        $date = Date('Y-m-d');
        $obDatabase = new Database('cadcliente');
        $id = $obDatabase->insert([
            'cliente' => $this->cliente,
            'fantasia' => $this->fantasia,
            'cnpj'=> $this->cnpj,
            'tel1' => $this->tel1,
            'tel2' => $this->tel2,
            'cep' => $this->cep,
            'endereco' => $this->endereco,
            'numero' => $this->numero,
            'Ativo' => $this->Ativo,
            'Liberado' => $this->Liberado,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'uf' => $this->uf,
            'complemento' => $this->complemento,
            'email' => $this->email,
            'dtcadastro' => $date,

        ]);
        return $id;

    }



    public static function buscar($where = null, $order = null, $limit = null, $filds = '*'){
        return  (new Database('cadcliente'))->select($where,$order,$limit,$filds);
    }

    public static function buscarDaVenda($where = null, $order = null, $limit = null, $filds = '*'){
        return  (new Database('cadcliente'))->selectJoin($where,$order,$limit,$filds,'mesa', 'cadcliente.codcli = mesa.codcli');
    }

    public static function buscarDaManutencao($where = null, $order = null, $limit = null, $filds = '*'){
        return  (new Database('cadcliente'))->selectJoin('manutencao.dtencerrado is null',$order,$limit,$filds,'manutencao', 'cadcliente.codcli = manutencao.codcliente');
    }

    public static function buscarComPedido($where = null, $order = null, $limit = null, $filds = '*'){
        return  (new Database('cadcliente'))->selectJoin($where,$order,$limit,$filds,'pedido', 'cadcliente.codcli = pedido.codcli');
    }


    public static function getUserByEmail($email){

        return  (new Database('cadcliente'))->select('email = "'.$email.'"')->fetchObject(self::class);

    }





}