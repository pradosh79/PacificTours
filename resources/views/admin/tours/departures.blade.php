@extends('layouts.admin')
@section('title', 'Departures · '.$tour->title)

@section('content')
<div class="alert alert-info small">
    Departures are the inventory this tour actually sells. Capacity can never be set below the
    seats already booked, and a departure with bookings is closed rather than deleted.
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="panel">
            <table class="table align-middle mb-0">
                <thead><tr><th>Departs</th><th>Returns</th><th class="text-center">Seats</th><th class="text-end">Price</th><th>Status</th><th></th></tr></thead>
                <tbody>
                @forelse ($departures as $departure)
                    <tr>
                        <td>{{ $departure->start_date->format('D d M Y') }}</td>
                        <td>{{ $departure->end_date?->format('D d M Y') ?? '—' }}</td>
                        <td class="text-center">
                            {{ $departure->seats_booked }} / {{ $departure->seats_total }}
                            <span class="d-block small text-muted">{{ $departure->seats_available }} left</span>
                        </td>
                        <td class="text-end">{{ $departure->price_override ? money($departure->price_override) : '—' }}</td>
                        <td><span class="badge text-bg-{{ $departure->status === 'open' ? 'success' : 'secondary' }}">{{ ucfirst($departure->status) }}</span></td>
                        <td class="text-end">
                            <form class="d-inline-flex gap-1" method="POST" action="{{ route('admin.departures.update', $departure->uuid) }}">
                                @csrf @method('PUT')
                                <input type="number" name="seats_total" value="{{ $departure->seats_total }}"
                                       min="{{ $departure->seats_booked }}" class="form-control form-control-sm" style="width:5rem">
                                <select name="status" class="form-select form-select-sm" style="width:7rem">
                                    @foreach (['open', 'closed', 'cancelled', 'full'] as $status)
                                        <option value="{{ $status }}" @selected($departure->status === $status)>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-sm btn-outline-secondary">Save</button>
                            </form>
                            @if ($departure->seats_booked === 0)
                                <form class="d-inline" method="POST" action="{{ route('admin.departures.destroy', $departure->uuid) }}">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">
                        No departures yet — this tour cannot be booked until you add one.
                    </td></tr>
                @endforelse
                </tbody>
            </table>
            <div class="panel-foot">{{ $departures->links() }}</div>
        </div>
    </div>

    <div class="col-lg-4">
        <section class="panel">
            <header class="panel-head"><h2 class="h6 mb-0">Add one departure</h2></header>
            <form class="panel-body" method="POST" action="{{ route('admin.departures.store', $tour->uuid) }}">
                @csrf
                <label class="form-label small">Date</label>
                <input type="date" name="start_date" class="form-control form-control-sm mb-2" min="{{ now()->addDay()->toDateString() }}" required>
                <label class="form-label small">Seats</label>
                <input type="number" name="seats_total" value="{{ $tour->max_seats ?: 20 }}" min="1" class="form-control form-control-sm mb-2" required>
                <label class="form-label small">Price override</label>
                <input type="number" step="0.01" name="price_override" class="form-control form-control-sm mb-2" placeholder="use tour price">
                <input type="hidden" name="status" value="open">
                <button class="btn btn-sm btn-primary w-100">Add departure</button>
            </form>
        </section>

        <section class="panel mt-3">
            <header class="panel-head"><h2 class="h6 mb-0">Generate a season</h2></header>
            <form class="panel-body" method="POST" action="{{ route('admin.departures.generate', $tour->uuid) }}">
                @csrf
                <label class="form-label small">From</label>
                <input type="date" name="from" class="form-control form-control-sm mb-2" required>
                <label class="form-label small">Until</label>
                <input type="date" name="until" class="form-control form-control-sm mb-2" required>

                <label class="form-label small">On these days</label>
                <div class="d-flex flex-wrap gap-2 mb-2">
                    @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $index => $day)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="weekdays[]" value="{{ $index }}" id="d{{ $index }}">
                            <label class="form-check-label small" for="d{{ $index }}">{{ $day }}</label>
                        </div>
                    @endforeach
                </div>

                <label class="form-label small">Seats each</label>
                <input type="number" name="seats_total" value="{{ $tour->max_seats ?: 20 }}" min="1" class="form-control form-control-sm mb-2" required>
                <button class="btn btn-sm btn-outline-secondary w-100">Generate</button>
                <p class="form-text small mb-0">Existing dates are skipped, so this is safe to re-run.</p>
            </form>
        </section>
    </div>
</div>
@endsection
