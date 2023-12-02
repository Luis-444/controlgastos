<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, Builder};
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'user_id',
    ];

    public function getTotalPurchases(){
        $purchaseDetails = PurchaseDetail::whereHas('product', function(Builder $query){
            $query->where('category_id', $this->id);
        })->get();
        $totalTax = 0;
        foreach ($purchaseDetails as $key => $pd) {
            $totalTax += $pd->purchase_detail_tax->amount;
        }
        $total = $purchaseDetails->sum('amount') + $totalTax;
        return $total;
    }
}
