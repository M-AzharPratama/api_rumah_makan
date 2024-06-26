<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Transaction extends Model
{
    
    public $fillable = ["product_id", "order_date", "quantity"];


    public function product(){

        return $this->belongsTo(Product::class);

        }
    }
