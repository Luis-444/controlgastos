<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class BaseModel extends Model
{
    use HasFactory;

    protected static function booted(){
        static::addGlobalScope('user_id', function (Builder $builder) {
                $builder->where('user_id', Auth::user()->id);
        });
    }

    public function getNameAttribute(){
        if($this->trashed()){
            return $this->attributes['name'] . " ( Eliminado )";
        }
        return $this->attributes['name'];
    }
}
