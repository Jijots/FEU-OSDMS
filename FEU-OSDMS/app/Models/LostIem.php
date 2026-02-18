<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LostItem extends Model
{
    protected $fillable = ['founder_id', 'item_category', 'description', 'location_found', 'image_path', 'is_claimed'];
}

