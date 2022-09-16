<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{
    use HasFactory;
    protected $table='sale_returns';
    protected $fillable=[
        'user_id',
        'return_amount',
        'status',
        'return_invoice_no',
    ];
}
