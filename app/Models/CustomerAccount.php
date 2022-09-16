<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAccount extends Model
{
    use HasFactory;
    protected $table="customer_accounts";
    protected $fillable=[
        'total_bill_amount',
        'paid_amount',
        'payment_type',
        'cust_invoice_no',
        'cust_id',
        'payment_method',
        'supp_id',
        'balance',

    ];
}
