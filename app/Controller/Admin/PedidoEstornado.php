<?php 

namespace App\Controller\Admin;
use App\Controller\Admin\Page;
use App\Model\Entity\Pedido as M_Pedido;
use App\Model\Entity\PedidoItens as M_PedidoItens;
use App\Model\Entity\PedidoPagamento as M_PedidoPagamento;
use App\Model\Entity\PedidoExcluido as M_PedidoEX;
use App\Utils\View;

class PedidoEstornado extends Page {

    /*
    * Metodo resposave por retornar o conteudo da view do home
    *  @retunr string 
    */
    public static function getPedidoEstornado(){

        {

            $tr = '';
    
            $results = M_PedidoEX::buscarex('numped is not null', null, null, '*');
            
    
    
            while ($pedidoex = $results->fetchObject(M_PedidoEX::class)) {


                $tr .= View::render('admin/pedidoestornado/pedidoestornado',
    
                    [
                        'numped' => $pedidoex->numped,
    
                        'codcli' => $pedidoex->codcli,                  
                        'cliente' => $pedidoex->cliente,
                        'desconto' => $pedidoex->desconto,

                        'acrescimo' => $pedidoex->acrescimo,

                        'vlliq' => $pedidoex->vlliq,
                        'obs' => $pedidoex->observacao,

                        'dtpedido' => $pedidoex->dtpedido,

                        'dtexclusao' => $pedidoex->dtexclusao,
    
                    ]
    
                );
    
                
            }
            $content = View::render('admin/pedidoestornado', [
                'tr' => $tr,
            ]);
    
            return parent::getPageLogin('Controle',$content);
    
    
     }

    }
}