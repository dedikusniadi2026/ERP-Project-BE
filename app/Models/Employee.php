<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'employee_code',
        'name',
        'email',
        'phone',
        'position',
        'hire_date',
        'status',
    ];

    protected $casts = [
        'hire_date' => 'date',
    ];
}
