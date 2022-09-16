<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table='suppliers';
    protected $fillable=[
        'supp_name',
        'company_name',
        'agancy_name',
        'address',
        'contact',
        'email',
        'status',
        'supp_image',
        'area',
        'is_customer',
        
    ];
}
