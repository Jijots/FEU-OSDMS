<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    protected $fillable = [
        'student_id',
        'reporter_id', // Matches your migration
        'offense_type',
        'description',
        'findings',
        'recommendation',
        'final_action',
        'academic_term',
        'status'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
}
