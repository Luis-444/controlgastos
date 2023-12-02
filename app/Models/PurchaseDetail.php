<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function purchase_detail_tax()
    {
        return $this->hasOne(PurchaseDetailTax::class);
    }

    public function getAmount(){
        return $this->purchase_detail_tax->amount;
    }
}
