<?php

namespace App\Taxes;

use Psr\Log\LoggerInterface;

class Calculator
{
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @var float
     */
    protected float $tva;

    /**
     * Calculator constructor.
     * @param LoggerInterface $logger
     * @param float $tva
     */
    public function __construct(LoggerInterface $logger, float $tva)
    {
        $this->logger = $logger;
        $this->tva = $tva;
    }

    /**
     * @param float $prix
     * @return float
     */
    public function calcul(float $prix): float
    {
        $this->logger->info(' aa a aCoucou calculator');
        return $prix * ($this->tva / 100);
    }
}
