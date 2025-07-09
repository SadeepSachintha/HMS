<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReservationsReportExport implements FromArray, WithHeadings
{
    protected $reservationsData;

    public function __construct($reservationsData)
    {
        $this->reservationsData = $reservationsData;
    }

    public function array(): array
    {
        return $this->reservationsData;
    }

    public function headings(): array
    {
        return [
            'Customer',
            'Reservation date',
            'Check-in',
            'Check-out',
            'Status',
        ];
    }
}
