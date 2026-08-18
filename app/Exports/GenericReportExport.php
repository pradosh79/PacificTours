<?php

declare(strict_types=1);

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * One export class for every report. ReportService already returns flat,
 * presentation-ready rows, so the export layer only needs headings and styling.
 */
class GenericReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function __construct(
        private readonly Collection $rows,
        private readonly array $columns,
        private readonly string $title = 'Report',
    ) {}

    public function collection(): Collection
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return array_values($this->columns);
    }

    /** @param array<string, mixed>|object $row */
    public function map($row): array
    {
        $row = is_object($row) ? (array) $row : $row;

        return array_map(
            fn (string $key) => data_get($row, $key) ?? '',
            array_keys($this->columns)
        );
    }

    public function title(): string
    {
        return substr($this->title, 0, 31);
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '10222B']],
            ],
        ];
    }
}
