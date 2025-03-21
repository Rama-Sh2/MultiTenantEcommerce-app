<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded=['id','created_at','updated_at'];

    public function tenant(){
        return $this->belongsTo(Tenant::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
