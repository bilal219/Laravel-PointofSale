<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $table='expenses';
    protected $fillable=[
        'cat_id',
        'exp_amount',
        'exp_addedby',
        'exp_desc',
        'exp_date',
        'exp_status',
    ];
}
