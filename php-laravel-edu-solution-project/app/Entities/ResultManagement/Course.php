<?php

namespace App\Entities\ResultManagement;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */

    protected $fillable = [

        'program_id', 'semester_id', 'name', 'code', 'description'

    ];
}
