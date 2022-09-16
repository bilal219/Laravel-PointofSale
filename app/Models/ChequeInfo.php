<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChequeInfo extends Model
{
    use HasFactory;
    protected $table="cheque_infos";
    protected $fillable=[
        'cust_id',
        'chq_number',
        'chq_amount',
        'status',
        'note',
        'supp_id',
        'user_id',
        'clear_note',
        'payment_method',
        'clear_date',

    ];
}
