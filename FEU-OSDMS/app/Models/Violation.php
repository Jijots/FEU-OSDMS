<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    protected $fillable = [
        'student_id',
        'reporter_id',
        'offense_type',
        'description',
        'findings',
        'recommendation',
        'final_action',
        'academic_term',
        'status'
    ];

    /**
     * Get the student associated with the violation.
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the staff member who reported the violation.
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
}
