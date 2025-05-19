<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'city',
        'state',
        'zip_code',
        'phone',
        'email',
        'website',
        'image',
        'is_featured',
        'category_id',
        'user_id',
        'total_rating',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    /**
     * Get the category that owns the business.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user that owns the business.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reviews for the business.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function updateTotalRating(): void
    {
        $this->total_rating = $this->reviews()->sum('rating');
        $this->save();
    }

    public function getAverageRatingAttribute(): float
    {
        return $this->reviews()->count() > 0 
            ? round($this->total_rating / $this->reviews()->count(), 1)
            : 0;
    }
}
