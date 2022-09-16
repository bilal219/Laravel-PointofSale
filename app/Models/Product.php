<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table='products';
    protected $fillable=[
        'product_name',
        'generic_name',
        'UPC_EAN',
        'inventory',
        'product_status',
        'product_type',
        'manage_stock',
        'reorder_qty',
    ];
}
