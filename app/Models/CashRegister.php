<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashRegister extends Model
{
    use HasFactory;
    protected $table="cash_registers";
    protected $fillable=[
        'user_id',
        'opening_date',
        'closing_date',
        'cash_in_hand',
        'total_sale',
        'total_return',
        'closing_amount',
        'status',
    ];
}
