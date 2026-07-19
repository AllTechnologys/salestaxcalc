<?php

declare(strict_types=1);

class SalesTaxCalculator
{
    /**
     * Example state tax rates.
     * (Replace these with your own database/API.)
     */
    private array $rates = [
        'AL' => 4.00,
        'AK' => 0.00,
        'AZ' => 5.60,
        'CA' => 7.25,
        'FL' => 6.00,
        'GA' => 4.00,
        'IL' => 6.25,
        'NJ' => 6.625,
        'NY' => 4.00,
        'TX' => 6.25,
        'WA' => 6.50,
    ];

    /**
     * Calculate sales tax.
     */
    public function calculate(float $amount, string $state): array
    {
        $state = strtoupper(trim($state));

        if (!isset($this->rates[$state])) {
            throw new Exception("Unknown state: {$state}");
        }

        $rate = $this->rates[$state];

        $tax = round($amount * ($rate / 100), 2);

        $total = round($amount + $tax, 2);

        return [
            'state'      => $state,
            'tax_rate'   => $rate,
            'subtotal'   => round($amount, 2),
            'tax_amount' => $tax,
            'total'      => $total
        ];
    }

    /**
     * Reverse sales tax.
     */
    public function reverse(float $totalAmount, string $state): array
    {
        $state = strtoupper(trim($state));

        if (!isset($this->rates[$state])) {
            throw new Exception("Unknown state: {$state}");
        }

        $rate = $this->rates[$state];

        $subtotal = round($totalAmount / (1 + ($rate / 100)), 2);

        $tax = round($totalAmount - $subtotal, 2);

        return [
            'state'      => $state,
            'tax_rate'   => $rate,
            'subtotal'   => $subtotal,
            'tax_amount' => $tax,
            'total'      => round($totalAmount, 2)
        ];
    }

    /**
     * Get tax rate.
     */
    public function getRate(string $state): float
    {
        $state = strtoupper(trim($state));

        return $this->rates[$state] ?? 0;
    }

    /**
     * Return all configured rates.
     */
    public function getRates(): array
    {
        return $this->rates;
    }
}
