<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GateEntry extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Tells Laravel time_in is a date object
    protected function casts(): array
    {
        return [
            'time_in' => 'datetime',
        ];
    }

    // Relationship to the User (Student)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Relationship to the User (Guard/Admin)
    public function securityGuard()
    {
        return $this->belongsTo(User::class, 'guard_id');
    }
}
