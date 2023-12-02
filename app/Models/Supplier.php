<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'exchange',
        'currency_id',
        'user_id'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class)->withTrashed();
    }
}
