<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $table='sales';
    protected $fillable=[

        'cust_id',
        'user_id',
        'sale_date',
        'order_total',
        'discount',
        'total_amount',
        'payment_amount',
        'change_amount',
        'payment_method',
        'status',
        'profit',
        'invoice_number',
    ];
}
