<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'customer',
        'invoice_number',
        'invoice_date',
        'total',
        'gym_id'
    ];

    public function gym(){
        return $this->belongsTo(Gym::class);
    }

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class);
    }

}
