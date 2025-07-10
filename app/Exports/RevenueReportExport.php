<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RevenueReportExport implements FromArray, WithHeadings
{
    protected $revenueData;

    public function __construct($revenueData)
    {
        $this->revenueData = $revenueData;
    }

    public function array(): array
    {
        return $this->revenueData;
    }

    public function headings(): array
    {
        return [
            'Payment id',
            'Payment method',
            'Payment date',
            'Total amount (LKR)',
        ];
    }
}
