<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\DepositType;
use App\Enums\DiscountType;
use App\Enums\TourStatus;
use App\Traits\Filterable;
use App\Traits\HasSeoMeta;
use App\Traits\HasSlug;
use App\Traits\HasUuid;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tour extends Model
{
    use Filterable;
    use HasFactory;
    use HasSeoMeta;
    use HasSlug;
    use HasUuid;
    use SoftDeletes;
    use Translatable;

    protected $fillable = [
        'uuid', 'code', 'title', 'slug', 'tour_category_id', 'destination_id', 'country_id', 'city_id',
        'summary', 'description', 'travel_information', 'terms_and_conditions', 'cancellation_policy',
        'visa_requirements', 'duration_days', 'duration_nights', 'tour_type', 'difficulty',
        'pickup_location', 'drop_location', 'meeting_point', 'base_price', 'child_price', 'infant_price',
        'discount_type', 'discount_value', 'sale_price', 'tax_percentage', 'service_fee',
        'deposit_type', 'deposit_value', 'currency', 'max_seats', 'min_booking', 'max_booking',
        'booking_cutoff_hours', 'thumbnail', 'banner', 'video_url', 'map_latitude', 'map_longitude',
        'status', 'is_featured', 'is_popular', 'is_recommended', 'published_at', 'created_by', 'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'status'         => TourStatus::class,
            'discount_type'  => DiscountType::class,
            'deposit_type'   => DepositType::class,
            'is_featured'    => 'boolean',
            'is_popular'     => 'boolean',
            'is_recommended' => 'boolean',
            'published_at'   => 'datetime',
            'base_price'     => 'decimal:2',
            'child_price'    => 'decimal:2',
            'infant_price'   => 'decimal:2',
            'sale_price'     => 'decimal:2',
            'discount_value' => 'decimal:2',
            'service_fee'    => 'decimal:2',
            'tax_percentage' => 'decimal:2',
            'average_rating' => 'decimal:2',
        ];
    }

    // ---------------------------------------------------------------- relations

    public function category(): BelongsTo
    {
        return $this->belongsTo(TourCategory::class, 'tour_category_id');
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function images(): HasMany
    {
        return $this->hasMany(TourImage::class)->orderBy('sort_order');
    }

    public function itineraries(): HasMany
    {
        return $this->hasMany(TourItinerary::class)->orderBy('day_number');
    }

    public function inclusions(): HasMany
    {
        return $this->hasMany(TourInclusion::class)->orderBy('sort_order');
    }

    public function included(): HasMany
    {
        return $this->inclusions()->where('type', 'included');
    }

    public function excluded(): HasMany
    {
        return $this->inclusions()->where('type', 'excluded');
    }

    public function highlights(): HasMany
    {
        return $this->hasMany(TourHighlight::class)->orderBy('sort_order');
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(TourFaq::class)->orderBy('sort_order');
    }

    public function departures(): HasMany
    {
        return $this->hasMany(TourDeparture::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->reviews()->where('status', 'approved');
    }

    public function tags(): BelongsToMany
    {
        // Pivot table is named tour_tag (created by the tours migration) rather
        // than Laravel's default alphabetical guess of tag_tour. Explicit here so
        // both models agree on the same table without renaming production data.
        return $this->belongsToMany(Tag::class, 'tour_tag');
    }
    public function flashSales(): BelongsToMany
    {
        return $this->belongsToMany(FlashSale::class);
    }

    public function wishlistedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wishlists');
    }

    // ------------------------------------------------------------------- scopes

    public function scopePublished(Builder $q): Builder
    {
        return $q->where('status', TourStatus::Published->value)
            ->where(fn ($sub) => $sub->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    public function scopeFeatured(Builder $q): Builder
    {
        return $q->where('is_featured', true);
    }

    public function scopePopular(Builder $q): Builder
    {
        return $q->where('is_popular', true);
    }

    // ------------------------------------------------------------------ filters
    // Consumed by the Filterable trait: ->filter($request->all())

    protected function filterKeyword(Builder $q, string $value): void
    {
        $q->where(fn ($sub) => $sub->where('title', 'like', "%{$value}%")
            ->orWhere('code', 'like', "%{$value}%")
            ->orWhere('summary', 'like', "%{$value}%"));
    }

    protected function filterCategory(Builder $q, mixed $value): void
    {
        $q->whereHas('category', fn ($sub) => $sub->whereIn('slug', (array) $value));
    }

    protected function filterDestination(Builder $q, mixed $value): void
    {
        $q->whereHas('destination', fn ($sub) => $sub->whereIn('slug', (array) $value));
    }

    protected function filterCountry(Builder $q, mixed $value): void
    {
        $q->whereHas('country', fn ($sub) => $sub->whereIn('slug', (array) $value));
    }

    protected function filterCity(Builder $q, mixed $value): void
    {
        $q->whereHas('city', fn ($sub) => $sub->whereIn('slug', (array) $value));
    }

    protected function filterMinPrice(Builder $q, mixed $value): void
    {
        $q->where('sale_price', '>=', (float) $value);
    }

    protected function filterMaxPrice(Builder $q, mixed $value): void
    {
        $q->where('sale_price', '<=', (float) $value);
    }

    protected function filterMinDuration(Builder $q, mixed $value): void
    {
        $q->where('duration_days', '>=', (int) $value);
    }

    protected function filterMaxDuration(Builder $q, mixed $value): void
    {
        $q->where('duration_days', '<=', (int) $value);
    }

    protected function filterRating(Builder $q, mixed $value): void
    {
        $q->where('average_rating', '>=', (float) $value);
    }

    protected function filterTravelDate(Builder $q, mixed $value): void
    {
        $q->whereHas('departures', fn ($sub) => $sub
            ->whereDate('start_date', '>=', $value)
            ->where('status', 'open')
            ->whereColumn('seats_booked', '<', 'seats_total'));
    }

    protected function filterAvailableOnly(Builder $q, mixed $value): void
    {
        if (filter_var($value, FILTER_VALIDATE_BOOL)) {
            $q->whereHas('departures', fn ($sub) => $sub
                ->whereDate('start_date', '>=', today())
                ->where('status', 'open')
                ->whereColumn('seats_booked', '<', 'seats_total'));
        }
    }

    protected function filterFeatured(Builder $q, mixed $value): void
    {
        if (filter_var($value, FILTER_VALIDATE_BOOL)) {
            $q->featured();
        }
    }

    protected function filterStatus(Builder $q, mixed $value): void
    {
        $q->where('status', $value);
    }

    protected function filterSort(Builder $q, string $value): void
    {
        match ($value) {
            'price_asc'   => $q->orderBy('sale_price'),
            'price_desc'  => $q->orderByDesc('sale_price'),
            'rating'      => $q->orderByDesc('average_rating'),
            'popular'     => $q->orderByDesc('bookings_count'),
            'duration'    => $q->orderBy('duration_days'),
            default       => $q->latest('id'),
        };
    }

    // ------------------------------------------------------------------ helpers

    public function hasDiscount(): bool
    {
        return $this->discount_type !== DiscountType::None && (float) $this->discount_value > 0;
    }

    public function discountAmount(): float
    {
        return $this->discount_type->apply((float) $this->base_price, (float) $this->discount_value);
    }

    public function isBookable(): bool
    {
        return $this->status->isBookable();
    }

    public function nextDeparture(): ?TourDeparture
    {
        return $this->departures()
            ->whereDate('start_date', '>=', today())
            ->where('status', 'open')
            ->orderBy('start_date')
            ->first();
    }
}
