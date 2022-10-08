<?php

namespace App\Models\react_crud;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $table = 'employees';
    protected $connection = 'react_crud';

    protected $fillable = [
        'name', 'age','status'
    ];

    protected $hidden = [
        'status','created_at','updated_at'
    ];
}
