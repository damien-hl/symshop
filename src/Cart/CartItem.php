<?php

namespace App\Cart;

use App\Entity\Product;

class CartItem
{
    /**
     * @var Product
     */
    public Product $product;

    /**
     * @var int
     */
    public int $qty;

    /**
     * CartItem constructor.
     * @param Product $product
     * @param int $qty
     */
    public function __construct(Product $product, int $qty)
    {
        $this->product = $product;
        $this->qty = $qty;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->product->getPrice() * $this->qty;
    }
}