<?php

namespace Tests\Unit\Services;

use App\Services\GapCalculatorService;
use PHPUnit\Framework\TestCase;

class GapCalculatorServiceTest extends TestCase
{
    private GapCalculatorService $gap;

    protected function setUp(): void
    {
        parent::setUp();
        $this->gap = new GapCalculatorService();
    }

    public function test_convertToScale10_boundary_values(): void
    {
        $this->assertSame(1, $this->gap->convertToScale10(0.0));
        $this->assertSame(1, $this->gap->convertToScale10(12.0));
        $this->assertSame(2, $this->gap->convertToScale10(12.1));
        $this->assertSame(2, $this->gap->convertToScale10(15.0));
        $this->assertSame(5, $this->gap->convertToScale10(24.0));
        $this->assertSame(6, $this->gap->convertToScale10(24.1));
        $this->assertSame(9, $this->gap->convertToScale10(32.0));
        $this->assertSame(10, $this->gap->convertToScale10(32.1));
        $this->assertSame(10, $this->gap->convertToScale10(100.0));
    }

    public function test_getGapWeight_zero_gap_returns_perfect_score(): void
    {
        $this->assertSame(10.0, $this->gap->getGapWeight(0));
    }

    public function test_getGapWeight_positive_gaps_decrease(): void
    {
        $this->assertSame(9.5, $this->gap->getGapWeight(1));
        $this->assertSame(8.5, $this->gap->getGapWeight(2));
        $this->assertSame(7.5, $this->gap->getGapWeight(3));
        $this->assertSame(6.5, $this->gap->getGapWeight(4));
        $this->assertSame(5.5, $this->gap->getGapWeight(5));
    }

    public function test_getGapWeight_negative_gaps_penalized_more(): void
    {
        $this->assertSame(9.0, $this->gap->getGapWeight(-1));
        $this->assertSame(8.0, $this->gap->getGapWeight(-2));
        $this->assertSame(7.0, $this->gap->getGapWeight(-3));
        $this->assertSame(6.0, $this->gap->getGapWeight(-4));
        $this->assertSame(5.0, $this->gap->getGapWeight(-5));
        $this->assertSame(4.0, $this->gap->getGapWeight(-6));
        $this->assertSame(3.0, $this->gap->getGapWeight(-7));
        $this->assertSame(2.0, $this->gap->getGapWeight(-8));
        $this->assertSame(1.0, $this->gap->getGapWeight(-9));
    }

    public function test_getGapWeight_extreme_negative_clamps_to_minimum(): void
    {
        $this->assertSame(1.0, $this->gap->getGapWeight(-10));
        $this->assertSame(1.0, $this->gap->getGapWeight(-20));
    }

    public function test_getGapWeight_extreme_positive_clamps_to_minimum(): void
    {
        $this->assertSame(1.0, $this->gap->getGapWeight(10));
        $this->assertSame(1.0, $this->gap->getGapWeight(20));
    }

    public function test_ncf_nsf_formula_produces_valid_range(): void
    {
        // Semua kriteria bernilai 24 (skala => 5, gap = 5-10 = -5, weight = 5.0)
        $weightedScore = 24.0;
        $scale = $this->gap->convertToScale10($weightedScore);
        $gap = $scale - 10;
        $weight = $this->gap->getGapWeight($gap);

        $ncf = ($weight + $weight + $weight) / 3.0;
        $nsf = ($weight + $weight + $weight) / 3.0;
        $nilaiTotal = (0.7 * $ncf) + (0.3 * $nsf);

        $this->assertGreaterThanOrEqual(1.0, $nilaiTotal);
        $this->assertLessThanOrEqual(10.0, $nilaiTotal);
    }
}
