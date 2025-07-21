<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "product";
    protected $guarded = [];

    public function supplier(){
        return $this->has(Supplier::class);
    }
    public function category_id(){
        return $this->has(Product::class);
    }
}
