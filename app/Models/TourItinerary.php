<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourItinerary extends Model
{
    use Translatable;

    protected $fillable = ['tour_id', 'day_number', 'title', 'description', 'accommodation', 'meals', 'image', 'sort_order'];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }
}
