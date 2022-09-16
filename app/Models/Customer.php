<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table='customers';
    protected $fillable=[
        'cust_name',
        'address',
        'contact',
        'cnic',
        'email',
        'cust_image',
        'fathername',
        'area_id',
        'cust_type',
        'status',
        'supp_id',
        'witness1',
        'witness2',
        'witness3',
        'type_id'
    ];
}
