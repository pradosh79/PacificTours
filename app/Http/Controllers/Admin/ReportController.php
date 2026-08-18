<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ExportReport;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function __construct(private readonly ReportService $reports)
    {
        $this->middleware('can:view-reports');
    }

    public function show(Request $request, string $type)
    {
        abort_unless(in_array($type, ['revenue', 'bookings', 'customers', 'tours', 'payments'], true), 404);

        $data = $this->reports->{$type}($request->all());

        return $request->wantsJson()
            ? $this->ok($data)
            : view("admin.reports.{$type}", $data + ['type' => $type, 'filters' => $request->all()]);
    }

    /** Small exports stream immediately; large ones are queued and notified. */
    public function export(Request $request, string $type, string $format)
    {
        abort_unless(in_array($format, ['xlsx', 'csv', 'pdf'], true), 404);

        $data = $this->reports->{$type}($request->all());

        if ($data['rows']->count() > 5000) {
            ExportReport::dispatch($type, $request->all(), $request->user()->id);

            return back()->with('success', 'That report is large, so we are building it in the background. You will get a notification when it is ready.');
        }

        return $format === 'pdf'
            ? \Barryvdh\DomPDF\Facade\Pdf::loadView("admin.reports.pdf.{$type}", $data)->download("{$type}-report.pdf")
            : \Maatwebsite\Excel\Facades\Excel::download(
                new \App\Exports\GenericReportExport($data['rows']),
                "{$type}-report.{$format}"
            );
    }

    public function download(Request $request)
    {
        $path = decrypt($request->string('path')->toString());

        abort_unless(Storage::disk('local')->exists($path), 404);

        return Storage::disk('local')->download($path);
    }
}
