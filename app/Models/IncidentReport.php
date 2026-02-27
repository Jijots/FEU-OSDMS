<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Added for archiving

class IncidentReport extends Model
{
    use HasFactory, SoftDeletes; // Enabled SoftDeletes trait

    protected $guarded = [];
}
