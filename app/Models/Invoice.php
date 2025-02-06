<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['invoice_number', 'invoice_date', 'status', 'discount', 'tax', 'total_amount', 'sale_id'];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
