<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceNo extends Model
{
    use HasFactory;
    protected $table='invoice_nos';
    protected $fillable=[
       'invoice_no',
    ];
}
