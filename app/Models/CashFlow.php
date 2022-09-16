<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
    use HasFactory;
    protected $table="cash_flows";
    protected $fillable=[
       'party',
       'cash_in',
       'cash_out',
       'balance',
    ];
}
