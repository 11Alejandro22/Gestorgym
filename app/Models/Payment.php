<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'installment_id',
        'payment_method_id',
        'payment_status_id',
        'amount_paid',
        'payment_date',
        'gateway_transaction_id',
        'gateway_preference_id',
        'gateway_status_detail',
    ];

    public function installment()
    {
        return $this->belongsTo(Installment::class);
    }
}
