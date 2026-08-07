<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TaxLeviesReportExport implements FromArray, WithHeadings
{
    protected $taxLeviesData;

    public function __construct($taxLeviesData)
    {
        $this->taxLeviesData = $taxLeviesData;
    }

    public function array(): array
    {
        return $this->taxLeviesData;
    }

    public function headings(): array
    {
        return [
            'Invoice Number',
            'Invoice Date',
            'Subtotal (LKR)',
            'Service Charge (LKR)',
            'SSCL (LKR)',
            'TDL (LKR)',
            'VAT (LKR)',
            'Grand Total (LKR)',
        ];
    }
}
