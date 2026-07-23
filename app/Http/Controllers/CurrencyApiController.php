<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrencyApiController extends Controller
{
    /**
     * Currencies exchange rates based on 1 USD.
     *
     * @var array<string, float>
     */
    protected $rates = [
        'USD' => 1.0,
        'EUR' => 0.92,
        'GBP' => 0.78,
        'JPY' => 155.0,
        'AUD' => 1.50,
        'CAD' => 1.37,
        'CHF' => 0.89,
        'CNY' => 7.25,
        'SEK' => 10.50,
        'NZD' => 1.63,
        'SGD' => 1.35,
        'HKD' => 7.80,
        'INR' => 83.50,
        'LKR' => 300.0,
        'AED' => 3.67,
        'SAR' => 3.75,
        'ZAR' => 18.20,
    ];

    /**
     * Convert currency.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function convert(Request $request)
    {
        $request->validate([
            'base' => 'required|string|size:3',
            'target' => 'required|string|size:3',
            'amount' => 'required|numeric|min:0',
        ]);

        $base = strtoupper($request->query('base'));
        $target = strtoupper($request->query('target'));
        $amount = (float) $request->query('amount');

        if (!array_key_exists($base, $this->rates) || !array_key_exists($target, $this->rates)) {
            return response()->json([
                'detail' => 'Unsupported currency code'
            ], 400);
        }

        // Calculate rate based on USD
        $usdRateBase = $this->rates[$base];
        $usdRateTarget = $this->rates[$target];

        $rate = $usdRateTarget / $usdRateBase;
        $convertedAmount = $amount * $rate;

        return response()->json([
            'base' => $base,
            'target' => $target,
            'amount' => $amount,
            'converted_amount' => $convertedAmount,
            'rate' => $rate,
            'cached' => true,
        ]);
    }
}
