<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class Product extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'code',
        'price',
        'user_id',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class)->withTrashed();
    }
}
