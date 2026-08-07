<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FoodSalesReportExport implements FromArray, WithHeadings
{
    protected $foodSalesData;

    public function __construct($foodSalesData)
    {
        $this->foodSalesData = $foodSalesData;
    }

    public function array(): array
    {
        return $this->foodSalesData;
    }

    public function headings(): array
    {
        return [
            'Food Item Name',
            'Unit Price (LKR)',
            'Quantity Sold',
            'Total Sales (LKR)',
        ];
    }
}
