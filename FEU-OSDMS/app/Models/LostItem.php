<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LostItem extends Model
{
    protected $fillable = [
        'founder_id',
        'report_type', // NEW
        'item_category',
        'description',
        'location_found',
        'date_lost',
        'image_path',
        'status',
        'is_claimed',
        'is_stock_image',
        'flagged_for_review' // NEW
    ];

    public function founder()
    {
        return $this->belongsTo(User::class, 'founder_id');
    }
}
