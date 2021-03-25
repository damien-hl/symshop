<?php

namespace App\Taxes;

class Detector
{
    protected $threshold;

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