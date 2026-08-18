<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\User;
use App\Services\ReportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Large exports run off-request so the admin never waits on a 30k-row query.
 */
class ExportReport implements ShouldQueue
{
    use Queueable;

    public int $timeout = 600;

    public function __construct(
        public readonly string $type,
        public readonly array $filters,
        public readonly int $requestedBy,
    ) {
        $this->onQueue('documents');
    }

    public function handle(ReportService $reports): void
    {
        $data = $reports->{$this->type}($this->filters);
        $path = "exports/{$this->type}-".now()->format('Ymd-His').'.xlsx';

        Excel::store(new \App\Exports\GenericReportExport($data['rows']), $path, 'local');

        User::find($this->requestedBy)?->notify(
            new \Illuminate\Notifications\Messages\DatabaseMessage([
                'type'    => 'export.ready',
                'title'   => 'Export ready',
                'message' => ucfirst($this->type).' report is ready to download.',
                'url'     => route('admin.reports.download', ['path' => encrypt($path)]),
            ])
        );
    }
}
