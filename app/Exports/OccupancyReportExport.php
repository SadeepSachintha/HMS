<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OccupancyReportExport implements FromArray, WithHeadings
{
    protected $roomDetails;

    public function __construct($roomDetails)
    {
        $this->roomDetails = $roomDetails;
    }

    public function array(): array
    {
        return $this->roomDetails;
    }

    public function headings(): array
    {
        return [
            'Room no',
            'Room type',
            'Check-in date',
            'Check-out date',
            'Status',
        ];
    }
}
