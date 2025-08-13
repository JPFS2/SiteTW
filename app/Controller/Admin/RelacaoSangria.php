<?php 

namespace App\Controller\Admin;

use App\Controller\Admin\Page;
use App\Model\Entity\Sangria as M_Sangria;
use App\Utils\View;

class RelacaoSangria extends Page {

    public static function getRelacaoSangria()

    {

        $tr = '';

        $results = M_Sangria::buscar('cxencerrado is not null', null, null, '*');
        


               while ($sangria = $results->fetchObject(M_Sangria::class)) {

            $tipo = ($sangria->tipo  == 'D') ? '<span class="badge bg-warning">Dinheiro</span>' : '<span class="badge bg-gradient-blue">Pix</span>';
            
           if($sangria->tipo  == 'C'){
                $tipo = '<span class="badge bg-black">Cartão</span>';
            }

            $tr .= View::render('admin/sangria/sangria',
                [
                    'id' => $sangria->id,
                    'descricao' => $sangria->descricao,
                    'valor' => $sangria->valor,
                    'tipo' => $tipo,
                    'cxencerrado' => $sangria->cxencerrado,
                ]
            );

            
        }
        
        $content = View::render('admin/relacaosangria', [
            'tr' => $tr,
        ]);

        return parent::getPageLogin('Controle',$content);


 }
}
