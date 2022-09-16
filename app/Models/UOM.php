<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UOM extends Model
{
    use HasFactory;
    protected $table='u_o_m_s';
    protected $fillable=[
      'uom_name',
      'uom_status',
    ];
}
