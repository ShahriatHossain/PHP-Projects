<?php

namespace App\Entities\ResultManagement;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [

        'code', 'name', 'total_semester', 'description'

    ];
}
