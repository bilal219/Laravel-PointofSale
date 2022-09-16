<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    use HasFactory;
    protected $table="purchase_returns";
    protected $fillable=[
        'user_id',
        'return_amount',
        'supp_id',
        'status',
        'return_invoice_no',
    ];
}
