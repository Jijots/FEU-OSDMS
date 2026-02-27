<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Added for archiving

class ConfiscatedItem extends Model
{
    use HasFactory, SoftDeletes; // Enabled SoftDeletes trait

    protected $fillable = [
        'student_id',
        'item_name',
        'description',
        'photo_path',
        'confiscated_by',
        'confiscated_date',
        'storage_location',
        'status',
        'resolution_notes',
    ];

    // Link this confiscated item back to the specific student in the system
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'id_number');
    }
}
