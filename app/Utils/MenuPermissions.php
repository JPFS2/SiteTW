<?php

namespace App\Utils;

class MenuPermissions {
    private static $menuItems = [
        'admin' => [
            [
                'title' => 'Dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'url' => '/controle/admin',
                'permission' => 'dashboard'
            ],
           
            [
                'title' => 'Cadastros',
                'type' => 'header'
            ],
            [
                'title' => 'Empresa',
                'icon' => 'fa fa-university',
                'url' => '/controle/admin/empresa',
                'permission' => 'empresa'
            ],
            [
                'title' => 'Clientes',
                'icon' => 'fa fa-user-circle',
                'url' => '/controle/admin/clientes',
                'permission' => 'clientes'
            ],
            [
                'title' => 'Produto',
                'icon' => 'fa fa-archive',
                'url' => '/controle/admin/produtos',
                'permission' => 'produtos'
            ],
            [
                'title' => 'Importar Produtos',
                'icon' => 'fas fa-upload',
                'url' => '/controle/admin/importaproduto',
                'permission' => 'importar_produtos'
            ],
            [
                'title' => 'Relatórios',
                'type' => 'header'
            ],
            [
                'title' => 'Estoque',
                'icon' => 'fa fa-th',
                'url' => '/controle/admin/relacaoprodutos',
                'permission' => 'relatorio_estoque'
            ],
            [
                'title' => 'Relação de pedidos',
                'icon' => 'fa fa-shopping-cart',
                'url' => '/controle/admin/pedidos',
                'permission' => 'relatorio_pedidos'
            ],
            [
                'title' => 'Relação de Manutenções',
                'icon' => 'fa fa-wrench',
                'url' => '/controle/admin/manutencoes',
                'permission' => 'relatorio_manutencoes'
            ],
            [
                'title' => 'Relação de caixas',
                'icon' => 'fa fa-inbox',
                'url' => '/controle/admin/relacaocaixas',
                'permission' => 'relatorio_caixas'
            ],
            [
                'title' => 'Relação de sangrias',
                'icon' => 'fa fa-cloud-download-alt',
                'url' => '/controle/admin/relacaosangria',
                'permission' => 'relatorio_sangrias'
            ],
            [
                'title' => 'Produtos Vendidos',
                'icon' => 'fa fa-shopping-basket',
                'url' => '/controle/admin/produtosVendidos',
                'permission' => 'relatorio_produtos_vendidos'
            ],
            [
                'title' => 'Pedidos Estornados',
                'icon' => 'fa fa-table',
                'url' => '/controle/admin/pedidoestornado',
                'permission' => 'relatorio_pedidos_estornados'
            ],
            [
                'title' => 'Relação de devedores',
                'icon' => 'fa fa-users',
                'url' => '/controle/admin/promissorias',
                'permission' => 'relatorio_devedores'
            ],
            [
                'title' => 'Lucro por pedido',
                'icon' => 'fa fa-signal',
                'url' => '/controle/admin/lucratividadePedido',
                'permission' => 'relatorio_lucro_pedido'
            ],
            [
                'title' => 'Relação de Despesas',
                'icon' => 'fa fa-tag',
                'url' => '/controle/admin/relacaodespesas',
                'permission' => 'relatorio_despesas'
            ],
            [
                'title' => 'Relação de percas',
                'icon' => 'fa fa-trash',
                'url' => '/controle/admin/relacaopercas',
                'permission' => 'relatorio_percas'
            ]
        ],
        'atendente' => [
            [
                'title' => 'Dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'url' => '/controle/admin',
                'permission' => 'dashboard'
            ],
            [
                'title' => 'Operações',
                'type' => 'header'
            ],
            [
                'title' => 'Pedido',
                'icon' => 'fa fa-edit',
                'url' => '/controle/admin/venda',
                'permission' => 'pedido'
            ],
            [
                'title' => 'Serviços Manutenções',
                'icon' => 'fa fa-wrench',
                'url' => '/controle/admin/manutencao',
                'permission' => 'manutencao'
            ],
            [
                'title' => 'Garantia',
                'icon' => 'fa fa-book',
                'url' => '/controle/admin/garantia',
                'permission' => 'garantia'
            ],
            [
                'title' => 'Perda Avulsa',
                'icon' => 'fa fa-trash',
                'url' => '/controle/admin/percas',
                'permission' => 'perdas'
            ],
            [
                'title' => 'Caixa',
                'icon' => 'fas fa-cart-plus',
                'url' => '/controle/admin/conferenciacaixa',
                'permission' => 'caixa'
            ],
            [
                'title' => 'Cadastros',
                'type' => 'header'
            ],
            [
                'title' => 'Empresa',
                'icon' => 'fa fa-university',
                'url' => '/controle/admin/empresa',
                'permission' => 'empresa'
            ],
            [
                'title' => 'Clientes',
                'icon' => 'fa fa-user-circle',
                'url' => '/controle/admin/clientes',
                'permission' => 'clientes'
            ],
            [
                'title' => 'Produto',
                'icon' => 'fa fa-archive',
                'url' => '/controle/admin/produtos',
                'permission' => 'produtos'
            ],
            [
                'title' => 'Importar Produtos',
                'icon' => 'fas fa-upload',
                'url' => '/controle/admin/importaproduto',
                'permission' => 'importar_produtos'
            ],
            [
                'title' => 'Relatórios',
                'type' => 'header'
            ],
            [
                'title' => 'Estoque',
                'icon' => 'fa fa-th',
                'url' => '/controle/admin/relacaoprodutos',
                'permission' => 'relatorio_estoque'
            ],
            [
                'title' => 'Relação de pedidos',
                'icon' => 'fa fa-shopping-cart',
                'url' => '/controle/admin/pedidos',
                'permission' => 'relatorio_pedidos'
            ],
            [
                'title' => 'Relação de Manutenções',
                'icon' => 'fa fa-wrench',
                'url' => '/controle/admin/manutencoes',
                'permission' => 'relatorio_manutencoes'
            ],
            [
                'title' => 'Relação de caixas',
                'icon' => 'fa fa-inbox',
                'url' => '/controle/admin/relacaocaixas',
                'permission' => 'relatorio_caixas'
            ],
            [
                'title' => 'Relação de sangrias',
                'icon' => 'fa fa-cloud-download-alt',
                'url' => '/controle/admin/relacaosangria',
                'permission' => 'relatorio_sangrias'
            ],
            [
                'title' => 'Produtos Vendidos',
                'icon' => 'fa fa-shopping-basket',
                'url' => '/controle/admin/produtosVendidos',
                'permission' => 'relatorio_produtos_vendidos'
            ],
            [
                'title' => 'Pedidos Estornados',
                'icon' => 'fa fa-table',
                'url' => '/controle/admin/pedidoestornado',
                'permission' => 'relatorio_pedidos_estornados'
            ],
            [
                'title' => 'Relação de devedores',
                'icon' => 'fa fa-users',
                'url' => '/controle/admin/promissorias',
                'permission' => 'relatorio_devedores'
            ],
            [
                'title' => 'Lucro por pedido',
                'icon' => 'fa fa-signal',
                'url' => '/controle/admin/lucratividadePedido',
                'permission' => 'relatorio_lucro_pedido'
            ],
            [
                'title' => 'Relação de percas',
                'icon' => 'fa fa-trash',
                'url' => '/controle/admin/relacaopercas',
                'permission' => 'relatorio_percas'
            ]
        ],
        'tecnico' => [
            [
                'title' => 'Dashboard',
                'icon' => 'fas fa-tachometer-alt',
                'url' => '/controle/admin',
                'permission' => 'dashboard'
            ],
            [
                'title' => 'Operações',
                'type' => 'header'
            ],
            [
                'title' => 'Serviços Manutenções',
                'icon' => 'fa fa-wrench',
                'url' => '/controle/admin/manutencao',
                'permission' => 'manutencao'
            ],
            [
                'title' => 'Garantia',
                'icon' => 'fa fa-book',
                'url' => '/controle/admin/garantia',
                'permission' => 'garantia'
            ],
            [
                'title' => 'Relatórios',
                'type' => 'header'
            ],
            [
                'title' => 'Relação de Manutenções',
                'icon' => 'fa fa-wrench',
                'url' => '/controle/admin/manutencoes',
                'permission' => 'relatorio_manutencoes'
            ],
            [
                'title' => 'Relação de percas',
                'icon' => 'fa fa-trash',
                'url' => '/controle/admin/relacaopercas',
                'permission' => 'relatorio_percas'
            ]
        ]
    ];

    public static function getMenuItems($userType) {
        return self::$menuItems[$userType] ?? [];
    }

    public static function renderMenu($userType, $currentUrl = '') {
        $items = self::getMenuItems($userType);
        $html = '<ul class="nav nav-pills nav-sidebar flex-column" data-accordion="false" data-widget="treeview" role="menu">';
        
        foreach ($items as $item) {
            if (isset($item['type']) && $item['type'] === 'header') {
                $html .= '<li class="nav-header">' . $item['title'] . '</li>';
            } else {
                $isActive = $currentUrl === $item['url'] ? 'active' : '';
                $html .= '<li class="nav-item">';
                $html .= '<a class="nav-link ' . $isActive . '" href="' . $item['url'] . '">';
                $html .= '<i class="nav-icon ' . $item['icon'] . '"></i>';
                $html .= '<p>' . $item['title'] . '</p>';
                $html .= '</a>';
                $html .= '</li>';
            }
        }
        
        $html .= '</ul>';
        return $html;
    }
} 