<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $table="purchases";
    protected $fillable=[
        'invoice_no',
        'supp_id',
        'refrence_no',
        'user_id',
        'purchase_date',
        'order_total',
        'satatus',
    ];

}
