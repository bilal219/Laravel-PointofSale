<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;
    protected $table='sale_details';
    protected $fillable=[
       
        'product_name',
        'user_id',
        'customer_id',
        'product_id',
        'qty',
        'cost_price',
        'retail_price',
        'status',
        'batch_no',
        'total_costprice',
        'total_fretailprice',
        'fretail_price',
        'discount',
        'profit',
        'invoice_number',
    ];
}
