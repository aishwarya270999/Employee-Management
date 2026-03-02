<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
    'name',
    'email',
    'position',
    'salary'
];

public function addresses()
{
    return $this->hasMany(EmployeeAddress::class);
}
}
