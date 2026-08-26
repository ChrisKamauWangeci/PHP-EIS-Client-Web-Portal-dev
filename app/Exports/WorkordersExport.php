<?php

declare(strict_types=1);

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WorkordersExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
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
            'Workorder',
            'Company',
            'Hospital',
            'Contractor',
            'Owner',
            'First Name',
            'Last Name',
            'Status',
            'Received Date',
            'Completed Date',
            'Age',
        ];
    }

    public function map($row): array
    {
        return [
            $row->W_WorkOrder,
            $row->Requestor_R_Company,
            $row->Hospital_H_Hospital,
            $row->W_Contractor,
            $row->W_Owner,
            $row->W_FirstName,
            $row->W_LastName,
            $row->W_Status,
            $row->W_ReceiveDate?->format('m/d/Y'),
            $row->W_CompletedDate?->format('m/d/Y'),
            $this->calculateAge($row),
        ];
    }

    protected function calculateAge($row): ?int
    {
        if (! $row->W_ReceiveDate) {
            return null;
        }

        $end = $row->W_Status === 'Incomplete'
            ? now()
            : ($row->W_CompletedDate ?? now());

        return (int) $row->W_ReceiveDate->diffInDays($end);
    }
}
