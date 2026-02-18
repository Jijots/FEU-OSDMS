<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'id_number',
        'role',
        'program_code',
        'campus',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function violations()
    {
        return $this->hasMany(Violation::class, 'student_id');
    }

    /**
     * Items found by this user (intended for staff/guards).
     */
    public function foundItems()
    {
        return $this->hasMany(LostItem::class, 'founder_id');
    }

    /**
     * (Optional) Items lost by this user. You may need a 'student_id' in your lost_items table for this.
     */
    public function lostItems()
    {
        return $this->hasMany(LostItem::class, 'student_id');
    }
}
