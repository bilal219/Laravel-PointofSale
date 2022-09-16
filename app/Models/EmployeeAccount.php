<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAccount extends Model
{
    use HasFactory;
    protected $table='employee_accounts';
    protected $fillable=[
        'emp_id',
        'user_id',
        'emp_earning',
        'emp_withdraw_amount',
        'note',
        'addedby',
        'balance',
    ];
}
