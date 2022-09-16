<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table='employees';
    protected $fillable=[
        'emp_name',
        'address',
        'contact',
        'cnic',
        'email',
        'status',
        'emp_image',
        'emp_type',
    ];
}
