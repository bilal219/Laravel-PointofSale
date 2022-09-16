<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table='companies';
    protected $fillable=[
        'comp_name',
        'comp_address',
        'comp_contact',
        'comp_email',
        'comp_status'
    ];
}
