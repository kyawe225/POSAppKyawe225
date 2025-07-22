<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $guarded = [];

    public function payments(){
        return $this->belongsToMany(Payment::class);
    }
}
