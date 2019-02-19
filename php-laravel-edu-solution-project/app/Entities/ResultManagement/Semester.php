<?php

namespace App\Entities\ResultManagement;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $fillable = [

        'program_id', 'code', 'name', 'type', 'description', 'year', 'start_date', 'end_date'

    ];
}
