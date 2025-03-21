<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    public function products(){
        return $this->hasMany(Product::class);
    }

    public function orders(){
        return $this->hasMany(order::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
  

}

