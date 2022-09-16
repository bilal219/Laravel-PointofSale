<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturnDetail extends Model
{
    use HasFactory;
    protected $table='sale_return_details';
    protected $fillable=[
        'prod_id',
        'user_id',
        'invoice',
        'return_qty',
        'price',
        'total_price',
        'return_detail_status',
    ];
}
