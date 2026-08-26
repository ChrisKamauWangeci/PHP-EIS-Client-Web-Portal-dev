<?php

declare(strict_types=1);

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EhrorderssearchresultsExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    use Exportable;

    public function __construct(
        protected Collection $rows
    ) {}

    public function collection()
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Workorder ID',
            'EHR Order ID',
            'Status',
            'Managing Organization',
            'Company Name',
            'First Name',
            'Last Name',
            'Operation Outcome',
            'Operation Outcome At',
            'Received At',
            'Created At',
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->workorder_id,
            $row->ehrorder_id,
            $row->status,
            $row->managing_organization,
            $row->company_name,
            $row->first_name,
            $row->last_name,
            $row->operation_outcome,
            $row->operation_outcome_at?->format('m/d/Y H:i:s'),
            $row->received_at?->format('m/d/Y H:i:s'),
            $row->created_at?->format('m/d/Y H:i:s'),
        ];
    }
}
