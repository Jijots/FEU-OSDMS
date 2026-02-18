<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GateEntry extends Model
{
    protected $fillable = ['student_id', 'guard_id', 'reason', 'time_in'];
}