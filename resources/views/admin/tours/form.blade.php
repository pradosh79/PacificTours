@extends('layouts.admin')
@section('title', $tour->exists ? 'Edit tour' : 'New tour')

@section('content')
<form method="POST" enctype="multipart/form-data"
      action="{{ $tour->exists ? route('admin.tours.update', $tour->uuid) : route('admin.tours.store') }}">
    @csrf
    @if ($tour->exists) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <section class="panel">
                <header class="panel-head"><h2 class="h6 mb-0">Basics</h2></header>
                <div class="panel-body row g-2">
                    <div class="col-md-8"><label class="form-label small">Title</label><input name="title" class="form-control" value="{{ old('title', $tour->title) }}" required></div>
                    <div class="col-md-4"><label class="form-label small">Slug</label><input name="slug" class="form-control" value="{{ old('slug', $tour->slug) }}" placeholder="auto"></div>
                    <div class="col-md-6">
                        <label class="form-label small">Category</label>
                        <select name="tour_category_id" class="form-select" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('tour_category_id', $tour->tour_category_id) == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Destination</label>
                        <select name="destination_id" class="form-select">
                            <option value="">—</option>
                            @foreach ($destinations as $destination)
                                <option value="{{ $destination->id }}" @selected(old('destination_id', $tour->destination_id) == $destination->id)>{{ $destination->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12"><label class="form-label small">Summary</label><textarea name="summary" rows="2" class="form-control">{{ old('summary', $tour->summary) }}</textarea></div>
                    <div class="col-12"><label class="form-label small">Description</label><textarea name="description" rows="8" class="form-control" data-editor>{{ old('description', $tour->description) }}</textarea></div>

                    {{-- Tour type & difficulty — both stored as short strings; the request layer
                         has DB-matching defaults for backwards compatibility if these get removed. --}}
                    <div class="col-md-6">
                        <label class="form-label small">Tour type</label>
                        <select name="tour_type" class="form-select">
                            @foreach (['group' => 'Small group', 'private' => 'Private / charter', 'custom' => 'Custom itinerary'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('tour_type', $tour->tour_type ?? 'group') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Difficulty</label>
                        <select name="difficulty" class="form-select">
                            @foreach (['easy' => 'Easy', 'moderate' => 'Moderate', 'challenging' => 'Challenging'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('difficulty', $tour->difficulty ?? 'easy') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>

            <section class="panel mt-3">
                <header class="panel-head"><h2 class="h6 mb-0">Duration &amp; capacity</h2></header>
                <div class="panel-body row g-2">
                    <div class="col-md-3"><label class="form-label small">Days</label><input type="number" name="duration_days" min="1" class="form-control" value="{{ old('duration_days', $tour->duration_days ?? 1) }}" required></div>
                    <div class="col-md-3"><label class="form-label small">Nights</label><input type="number" name="duration_nights" min="0" class="form-control" value="{{ old('duration_nights', $tour->duration_nights ?? 0) }}"></div>
                    <div class="col-md-3"><label class="form-label small">Max seats</label><input type="number" name="max_seats" min="1" class="form-control" value="{{ old('max_seats', $tour->max_seats) }}"></div>
                    <div class="col-md-3"><label class="form-label small">Cutoff (hours)</label><input type="number" name="booking_cutoff_hours" min="0" class="form-control" value="{{ old('booking_cutoff_hours', $tour->booking_cutoff_hours ?? 48) }}"></div>

                    {{-- Party size: the smallest booking accepted, and the largest. Sprinter fleet
                         seats 12 by default; edit up or down to reflect the vehicle used. --}}
                    <div class="col-md-3">
                        <label class="form-label small">Min party size</label>
                        <input type="number" name="min_booking" min="1" class="form-control"
                               value="{{ old('min_booking', $tour->min_booking ?? 1) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Max party size</label>
                        <input type="number" name="max_booking" min="1" class="form-control"
                               value="{{ old('max_booking', $tour->max_booking ?? 12) }}">
                    </div>
                    <div class="col-md-6"><label class="form-label small">Meeting point</label><input name="meeting_point" class="form-control" value="{{ old('meeting_point', $tour->meeting_point) }}"></div>
                    <div class="col-md-6"><label class="form-label small">Pickup location</label><input name="pickup_location" class="form-control" value="{{ old('pickup_location', $tour->pickup_location) }}"></div>
                </div>
            </section>

            <section class="panel mt-3">
                <header class="panel-head"><h2 class="h6 mb-0">Policies</h2></header>
                <div class="panel-body row g-2">
                    @foreach (['travel_information' => 'Travel information', 'visa_requirements' => 'Visa requirements', 'cancellation_policy' => 'Cancellation policy', 'terms_and_conditions' => 'Terms & conditions'] as $field => $label)
                        <div class="col-12">
                            <label class="form-label small">{{ $label }}</label>
                            <textarea name="{{ $field }}" rows="3" class="form-control">{{ old($field, $tour->{$field}) }}</textarea>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel mt-3">
                <header class="panel-head"><h2 class="h6 mb-0">SEO</h2></header>
                <div class="panel-body row g-2">
                    <div class="col-12"><label class="form-label small">Meta title</label><input name="seo[meta_title]" class="form-control" value="{{ old('seo.meta_title', $tour->seo?->meta_title) }}"></div>
                    <div class="col-12"><label class="form-label small">Meta description</label><textarea name="seo[meta_description]" rows="2" class="form-control">{{ old('seo.meta_description', $tour->seo?->meta_description) }}</textarea></div>
                    <div class="col-md-6"><label class="form-label small">Canonical URL</label><input name="seo[canonical_url]" class="form-control" value="{{ old('seo.canonical_url', $tour->seo?->canonical_url) }}"></div>
                    <div class="col-md-6">
                        <label class="form-label small">Robots</label>
                        <select name="seo[robots]" class="form-select">
                            @foreach (['index,follow', 'noindex,follow', 'index,nofollow', 'noindex,nofollow'] as $robots)
                                <option value="{{ $robots }}" @selected(old('seo.robots', $tour->seo?->robots) === $robots)>{{ $robots }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>
        </div>

        <div class="col-lg-4">
            <section class="panel">
                <header class="panel-head"><h2 class="h6 mb-0">Publish</h2></header>
                <div class="panel-body">
                    <label class="form-label small">Status</label>
                    <select name="status" class="form-select mb-3">
                        @foreach (\App\Enums\TourStatus::cases() as $status)
                            <option value="{{ $status->value }}" @selected(old('status', $tour->status?->value) === $status->value)>{{ Str::headline($status->value) }}</option>
                        @endforeach
                    </select>

                    <div class="form-check"><input class="form-check-input" type="checkbox" name="is_featured" value="1" id="f" @checked(old('is_featured', $tour->is_featured))><label class="form-check-label small" for="f">Featured</label></div>
                    <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="is_popular" value="1" id="p" @checked(old('is_popular', $tour->is_popular))><label class="form-check-label small" for="p">Popular</label></div>

                    <button class="btn btn-primary w-100">{{ $tour->exists ? 'Save tour' : 'Create tour' }}</button>
                    @if ($tour->exists)
                        <a class="btn btn-link w-100 mt-1" href="{{ route('tours.show', $tour->slug) }}" target="_blank">Preview</a>
                    @endif
                </div>
            </section>

            <section class="panel mt-3">
                <header class="panel-head"><h2 class="h6 mb-0">Pricing</h2></header>
                <div class="panel-body row g-2">
                    <div class="col-6"><label class="form-label small">Adult price</label><input type="number" step="0.01" name="base_price" class="form-control" value="{{ old('base_price', $tour->base_price) }}" required></div>
                    <div class="col-6"><label class="form-label small">Child price</label><input type="number" step="0.01" name="child_price" class="form-control" value="{{ old('child_price', $tour->child_price) }}"></div>
                    <div class="col-6"><label class="form-label small">Infant price</label><input type="number" step="0.01" name="infant_price" class="form-control" value="{{ old('infant_price', $tour->infant_price ?? 0) }}"></div>
                    <div class="col-6"><label class="form-label small">Tax %</label><input type="number" step="0.01" name="tax_percentage" class="form-control" value="{{ old('tax_percentage', $tour->tax_percentage ?? 5) }}"></div>
                    <div class="col-6">
                        <label class="form-label small">Discount type</label>
                        <select name="discount_type" class="form-select">
                            @foreach (\App\Enums\DiscountType::cases() as $type)
                                <option value="{{ $type->value }}" @selected(old('discount_type', $tour->discount_type?->value) === $type->value)>{{ Str::headline($type->value) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6"><label class="form-label small">Discount value</label><input type="number" step="0.01" name="discount_value" class="form-control" value="{{ old('discount_value', $tour->discount_value) }}"></div>
                    <div class="col-6">
                        <label class="form-label small">Deposit type</label>
                        <select name="deposit_type" class="form-select">
                            @foreach (\App\Enums\DepositType::cases() as $type)
                                <option value="{{ $type->value }}" @selected(old('deposit_type', $tour->deposit_type?->value) === $type->value)>{{ Str::headline($type->value) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6"><label class="form-label small">Deposit value</label><input type="number" step="0.01" name="deposit_value" class="form-control" value="{{ old('deposit_value', $tour->deposit_value) }}"></div>
                </div>
            </section>

            <section class="panel mt-3">
                <header class="panel-head"><h2 class="h6 mb-0">Media</h2></header>
                <div class="panel-body">
                    <label class="form-label small">Thumbnail</label>
                    <input type="file" name="thumbnail" accept="image/*" class="form-control mb-2">
                    @if ($tour->thumbnail)<img src="{{ upload_url($tour->thumbnail) }}" alt="" class="img-fluid rounded mb-3">@endif

                    <label class="form-label small">Banner</label>
                    <input type="file" name="banner" accept="image/*" class="form-control mb-2">

                    <label class="form-label small">Gallery</label>
                    <input type="file" name="gallery[]" multiple accept="image/*" class="form-control">
                </div>
            </section>
        </div>
    </div>
</form>
@endsection
