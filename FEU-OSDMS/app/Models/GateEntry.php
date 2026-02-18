<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GateEntry extends Model
{
    // Added 'time_out' to fillable to match your migration
    protected $fillable = ['student_id', 'guard_id', 'reason', 'time_in', 'time_out'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // RENAMED from 'guard' to 'securityGuard' to fix the FatalError
    public function securityGuard()
    {
        return $this->belongsTo(User::class, 'guard_id');
    }
}
