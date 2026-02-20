<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LostItem extends Model
{
    protected $fillable = [
        'founder_id',
        'report_type',
        'item_category',
        'description',
        'location_found',
        'date_lost',
        'image_path',
        'status',
        'is_claimed',
        'is_stock_image',
        'flagged_for_review'
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return asset('images/placeholder.png');
        }

        // Clean up any accidental 'public/' prefixes that might have saved to the DB
        $cleanPath = str_replace('public/', '', $this->image_path);

        // Remove 'storage/' if it's already there to prevent 'storage/storage/assets...'
        $cleanPath = str_replace('storage/', '', $cleanPath);

        // Force the correct absolute web path
        return asset('storage/' . $cleanPath);
    }
}
