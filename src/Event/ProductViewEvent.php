<?php

namespace App\Event;

use App\Entity\Product;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class ProductViewEvent
 * @package App\Event
 */
class ProductViewEvent extends Event
{
    /**
     * @var Product
     */
    private Product $product;

    /**
     * ProductViewEvent constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }
}