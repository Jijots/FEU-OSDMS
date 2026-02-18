<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    protected $fillable = ['student_id', 'reporter_id', 'offense_type', 'description', 'findings', 'recommendation', 'final_action', 'academic_term', 'status'];
}