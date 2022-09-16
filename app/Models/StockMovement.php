<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;
    protected $table="stock_movements";
    protected $fillable=
    [
        'prod_id',
        'supp_id',
        'qty',
        'cost_price',
        'total_cost',
        'fretial_price',
        'total_fretial',
        'invoice_no',
        'stock_status',
        'status',
    ];
}
