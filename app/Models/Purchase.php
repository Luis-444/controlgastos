<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, Builder};
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    public function supplier()
    {
        return $this->belongsTo(Supplier::class)->withTrashed();
    }

    public function purchase_details()
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class)->withTrashed();
    }

    public function getSubtotal(){
        return $this->purchase_details->sum('amount');
    }

    public function getTaxAmount(){
        $amount = 0;
        foreach ($this->purchase_details as $key => $pd) {
            $amount += $pd->getAmount();
        }
        return $amount;
    }

    public function getTotal(){
        return $this->getSubtotal() + $this->getTaxAmount();
    }

    public static function getTotalByMonth($month){
        $dates = [
            'Enero' => ['2023.01.01', '2023.01.31'],
            'Febrero' => ['2023.02.01', '2023.02.28'],
            'Marzo' => ['2023.03.01', '2023.03.31'],
            'Abril' => ['2023.04.01', '2023.04.30'],
            'Mayo' => ['2023.05.01', '2023.05.31'],
            'Junio' => ['2023.06.01', '2023.06.30'],
            'Julio' => ['2023.07.01', '2023.07.31'],
            'Agosto' => ['2023.08.01', '2023.08.31'],
            'Septiembre' => ['2023.09.01', '2023.09.30'],
            'Octubre' => ['2023.10.01', '2023.10.31'],
            'Noviembre' => ['2023.11.01', '2023.11.30'],
            'Diciembre' => ['2023.12.01', '2023.12.31'],
        ];
        $purchases = Purchase::whereBetween('date', $dates[$month])->get();
        $total = 0;
        foreach ($purchases as $key => $purchase) {
            $total += $purchase->getTotal();
        }
        return $total;
    }
}
