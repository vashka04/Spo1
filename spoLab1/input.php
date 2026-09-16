<?php

namespace MetricsDemo;

class HalsteadAnalyzer
{
    private array $dataset;
    private float $multiplier;

    public function __construct(array $dataset, float $multiplier)
    {
        $this->dataset = $dataset;
        $this->multiplier = $multiplier;
    }

    public function computeProcessed(): array
    {
        $output = [];
        $accumulator = 0.0;

        foreach ($this->dataset as $index => $item) {
            if ($item >= 0) {
                $transformed = ($item * $this->multiplier) + 10.5;
                $accumulator += $transformed;
                $output[$index] = $transformed;
            } else {
                $transformed = abs($item) * 0.5;
                $accumulator -= $transformed;
                $output[$index] = $transformed;
            }

            if ($accumulator > 5000.0) {
                break;
            }
        }

        return $output;
    }

    public function calculateSummary(): array
    {
        $totalElements = count($this->dataset);
        if ($totalElements === 0) {
            return ['mean' => 0.0, 'peak' => 0.0];
        }

        $peakValue = $this->dataset[0];
        $runningSum = 0.0;

        for ($i = 0; $i < $totalElements; $i++) {
            $current = $this->dataset[$i];
            $runningSum += $current;
            if ($current > $peakValue) {
                $peakValue = $current;
            }
        }

        $meanValue = $runningSum / $totalElements;

        return [
            'mean' => $meanValue,
            'peak' => $peakValue,
            'sum' => $runningSum
        ];
    }

    public function resetDataset(array $newDataset): void
    {
        $this->dataset = $newDataset;
    }
}
