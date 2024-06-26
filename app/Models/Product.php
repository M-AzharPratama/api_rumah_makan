<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    
    public $fillable = ["name", "price"];


    public function transaction(){

    return $this->hasMany(Transaction::class);

    }
}

