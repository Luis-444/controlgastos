<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NavigationMenuComponent extends Component
{
    public $message = null;
    public $validationErrors = [];
    public $user = null;
    public $menus = [];
    public $currentRoute = '';

    public function mount(){
        $this->user = Auth::user();
        $this->getRoute();
        if($this->user){
            $this->menus = [
                [
                    'text' => 'Acciones',
                    'subMenu' => [
                        [
                            'text' => 'Inicio',
                            'route' => '/inicio',
                            'icon' => 'components.icons.purchases'
                        ],
                        [
                            'text' => 'Compras',
                            'route' => '/compra',
                            'icon' => 'components.icons.dollar'
                        ],
                    ]
                ],
                [
                    'text' => 'Catalogos',
                    'subMenu' => [
                        [
                            'text' => 'Productos',
                            'route' => '/productos',
                            'icon' => 'components.icons.products'
                        ],
                        [
                            'text' => 'Proveedores',
                            'route' => '/proveedores',
                            'icon' => 'components.icons.suppliers'
                        ],
                        [
                            'text' => 'Monedas',
                            'route' => '/monedas',
                            'icon' => 'components.icons.dollar'
                        ],
                        [
                            'text' => 'Impuestos',
                            'route' => '/impuestos',
                            'icon' => 'components.icons.taxes'
                        ],
                        [
                            'text' => 'Categorias',
                            'route' => '/categorias',
                            'icon' => 'components.icons.categories'
                        ]
                    ]
                ],
            ];
        }
    }

    public function getRoute()
    {
        $this->currentRoute = request()->path();
    }


    public function render()
    {
        return view('livewire.navigation-menu-component');
    }
}
