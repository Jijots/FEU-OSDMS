<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // <--- 1. Import Sanctum
use App\Models\Violation;
use App\Models\LostItem;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable; // <--- 2. Add the Trait

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // 3. We added these fields to match your Database Migration
        'id_number',    
        'role',         // admin, guard, student
        'program_code', // BSIT, BSCS
        'campus',       // Manila, Makati
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get all violations for this user.
     */
    public function violations()
    {
        return $this->hasMany(Violation::class, 'student_id');
    }

    /**
     * Get all lost items reported by this user.
     */
    public function lostItems()
    {
        return $this->hasMany(LostItem::class, 'founder_id');
    }
}