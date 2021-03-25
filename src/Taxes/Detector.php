<?php

namespace App\Taxes;

/**
 * Class Detector
 * @package App\Taxes
 */
class Detector
{
    /**
     * @var float
     */
    protected float $threshold;

    /**
     * Detector constructor.
     * @param float $threshold
     */
    public function __construct(float $threshold)
    {
        $this->threshold = $threshold;
    }

    /**
     * @param float $amount
     * @return bool
     */
    public function detect(float $amount): bool
    {
        return $amount > $this->threshold;
    }
}