<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = "payment";
    protected $guarded = [];
    public function payment_methods(){
        return $this->has(PaymentMethod::class);
    }
}
