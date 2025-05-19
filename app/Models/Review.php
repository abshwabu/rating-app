<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'user_id',
        'rating',
        'comment',
        'image',
    ];

    protected static function booted()
    {
        static::created(function ($review) {
            $review->business->updateTotalRating();
        });

        static::updated(function ($review) {
            $review->business->updateTotalRating();
        });

        static::deleted(function ($review) {
            $review->business->updateTotalRating();
        });
    }

    /**
     * Get the user that owns the review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the business that owns the review.
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
