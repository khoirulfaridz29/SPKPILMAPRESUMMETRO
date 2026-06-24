<?php

namespace App\Services;

class GapCalculatorService
{
    public function convertToScale10(float $score): int
    {
        if ($score <= 12.0) return 1;
        if ($score <= 15.0) return 2;
        if ($score <= 18.0) return 3;
        if ($score <= 21.0) return 4;
        if ($score <= 24.0) return 5;
        if ($score <= 26.0) return 6;
        if ($score <= 28.0) return 7;
        if ($score <= 30.0) return 8;
        if ($score <= 32.0) return 9;
        return 10;
    }

    public function getGapWeight(int $gap): float
    {
        return match ($gap) {
            0  => 10.0,
            1  => 9.5,
            -1 => 9.0,
            2  => 8.5,
            -2 => 8.0,
            3  => 7.5,
            -3 => 7.0,
            4  => 6.5,
            -4 => 6.0,
            5  => 5.5,
            -5 => 5.0,
            -6 => 4.0,
            -7 => 3.0,
            -8 => 2.0,
            -9 => 1.0,
            default => $gap < 0 ? max(1.0, 10.0 + $gap) : max(1.0, 10.0 - $gap)
        };
    }
}
