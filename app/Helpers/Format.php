<?php

declare(strict_types=1);

namespace App\Helpers;

class Format
{
    public static function date(?string $date, string $format = 'M d, Y h:i A'): string
    {
        if (!$date) {
            return 'N/A';
        }
        return (new \DateTime($date))->format($format);
    }

    public static function slug(string $string): string
    {
        $string = preg_replace('/[^a-zA-Z0-9\s-]/', '', strtolower(trim($string)));
        return preg_replace('/[\s-]+/', '-', $string);
    }

    public static function currency(float $amount, string $symbol = '₹'): string
    {
        return $symbol . ' ' . number_format($amount, 2);
    }
}
