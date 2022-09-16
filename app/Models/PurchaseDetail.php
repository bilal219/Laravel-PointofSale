<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;
    protected $table="purchase_details";
    protected $fillable=[
        'prod_id',
        'Invoice_no',
        'prod_name',
        'UPC_EAN',
        'QTY',
        'cost_price',
        'total_cost',
        'status',
    ];
}
