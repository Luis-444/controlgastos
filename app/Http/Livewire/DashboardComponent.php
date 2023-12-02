<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithPagination, WithFileUploads};
use App\Models\{Purchase, PurchaseDetail, PurchaseDetailTax, Product, Supplier, Currency, Media, Tax, Category};
use Illuminate\Support\Facades\{Auth, DB};
use Carbon\Carbon;

class DashboardComponent extends Component
{
    public $purchase;
    public $date;
    public $labels = [
        'Enero',
        'Febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Agosto',
        'Septiembre',
        'Octubre',
        'Noviembre',
        'Diciembre'
    ];
    public $datasets = [];
    public $datasetsDoughnut = [];
    public $labelsDoughnut = [];
    public $colorsDoughnut = [];

    public function mount(){
        $data = [];
        foreach ($this->labels as $key => $label) {
            array_push($data, Purchase::getTotalByMonth($label));
        }
        $this->datasets = [
            [
                'label' => "Gasto mensual",
                'borderWidth' => 1,
                'data' => $data
            ],
        ];

        $categories = Category::all();
        $dataDoughnut = [];
        foreach ($categories as $key => $category) {
            array_push($dataDoughnut, $category->getTotalPurchases());
            array_push($this->labelsDoughnut, $category->name);
            array_push($this->colorsDoughnut, $this->getRandomColor());
        }
        $this->datasetsDoughnut = [
            [
                'label' => "Gasto por categoria",
                'backgroundColor'=> $this->colorsDoughnut,
                'hoverOffset' => 4,
                'data' => $dataDoughnut
            ]
        ];
    }

    function getRandomColor() {
        $shades = range(10, 120); // Array of shades from 100 to 900

        // Choose a random shade from the array
        $randomShade = $shades[array_rand($shades)];

        // Calculate the RGB color values based on Tailwind's cyan shades
        $r = 41 + $randomShade; // Adjust the base value to match Tailwind's cyan shade
        $g = 181 + $randomShade; // Adjust the base value to match Tailwind's cyan shade
        $b = 221 + $randomShade; // Adjust the base value to match Tailwind's cyan shade

        return "rgb($r, $g, $b)";
    }


    public function render()
    {
        return view('livewire.dashboard-component');
    }
}
