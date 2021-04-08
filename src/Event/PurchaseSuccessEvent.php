<?php

namespace App\Event;

use App\Entity\Purchase;
use Symfony\Contracts\EventDispatcher\Event;

class PurchaseSuccessEvent extends Event
{
    /**
     * @var Purchase
     */
    private Purchase $purchase;

    /**
     * PurchaseSuccessEvent constructor.
     * @param $purchase
     */
    public function __construct(Purchase $purchase)
    {
        $this->purchase = $purchase;
    }

    /**
     * @return Purchase
     */
    public function getPurchase(): Purchase
    {
        return $this->purchase;
    }
}