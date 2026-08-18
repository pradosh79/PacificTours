<!doctype html>
<html><head><meta charset="utf-8">
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1b1b1b; }
    .head { display: flex; justify-content: space-between; border-bottom: 2px solid #0f3d56; padding-bottom: 12px; }
    table { width: 100%; border-collapse: collapse; margin-top: 18px; }
    th, td { padding: 6px 8px; border-bottom: 1px solid #e5e5e5; text-align: left; }
    .right { text-align: right; }
    .total { font-weight: 700; font-size: 14px; }
</style></head>
<body>
    <div class="head">
        <div>
            <h1 style="margin:0">{{ setting('general.company_name') }}</h1>
            <p style="margin:2px 0">{{ setting('general.company_address') }}</p>
            <p style="margin:2px 0">{{ setting('general.company_email') }} · {{ setting('general.company_phone') }}</p>
        </div>
        <div class="right">
            <h2 style="margin:0">Invoice</h2>
            <p style="margin:2px 0">{{ $invoice->invoice_number }}</p>
            <p style="margin:2px 0">Issued {{ $invoice->issued_at->format('d M Y') }}</p>
            <p style="margin:2px 0">Due {{ $invoice->due_at?->format('d M Y') }}</p>
        </div>
    </div>

    <p style="margin-top:16px"><strong>Billed to</strong><br>
        {{ $booking->customer_name }}<br>
        {{ $booking->customer_email }}<br>
        {{ $booking->customer_address }}
    </p>

    <table>
        <thead><tr><th>Description</th><th class="right">Qty</th><th class="right">Unit</th><th class="right">Amount</th></tr></thead>
        <tbody>
            <tr>
                <td>{{ $booking->tour->title }} — departing {{ $booking->travel_date->format('d M Y') }} (adults)</td>
                <td class="right">{{ $booking->adults }}</td>
                <td class="right">{{ money($booking->adult_unit_price) }}</td>
                <td class="right">{{ money($booking->adult_unit_price * $booking->adults) }}</td>
            </tr>
            @if ($booking->children)
                <tr><td>Children</td><td class="right">{{ $booking->children }}</td>
                    <td class="right">{{ money($booking->child_unit_price) }}</td>
                    <td class="right">{{ money($booking->child_unit_price * $booking->children) }}</td></tr>
            @endif
            @if ($booking->infants)
                <tr><td>Infants</td><td class="right">{{ $booking->infants }}</td>
                    <td class="right">{{ money($booking->infant_unit_price) }}</td>
                    <td class="right">{{ money($booking->infant_unit_price * $booking->infants) }}</td></tr>
            @endif
            <tr><td colspan="3" class="right">Subtotal</td><td class="right">{{ money($invoice->subtotal) }}</td></tr>
            <tr><td colspan="3" class="right">Discounts</td><td class="right">−{{ money($invoice->discount_total) }}</td></tr>
            <tr><td colspan="3" class="right">Tax</td><td class="right">{{ money($invoice->tax_total) }}</td></tr>
            <tr class="total"><td colspan="3" class="right">Total</td><td class="right">{{ money($invoice->total) }}</td></tr>
            <tr><td colspan="3" class="right">Paid</td><td class="right">{{ money($invoice->amount_paid) }}</td></tr>
            <tr class="total"><td colspan="3" class="right">Balance</td><td class="right">{{ money($invoice->balance) }}</td></tr>
        </tbody>
    </table>

    <p style="margin-top:24px; font-size:11px; color:#666">
        Booking reference {{ $booking->booking_number }}. Cancellation terms as published on the tour page at time of booking.
    </p>
</body></html>
