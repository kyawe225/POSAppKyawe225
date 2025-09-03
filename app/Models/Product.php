<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "product";
    protected $guarded = [];

    public function supplier(){
        return $this->belongsTo(Supplier::class,"provider_id","id");
    }
    public function category(){
        return $this->belongsTo(ProductCategory::class,"product_category_id","id");
    }
    public function inventory_order(){
        return $this->hasMany(InventoryOrder::class);
    }
    public function inventory_log(){
        return $this->hasMany(InventoryLog::class);
    }
}
