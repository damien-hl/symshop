<?php

namespace App\Stripe;

use App\Entity\Purchase;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeService
{
    /**
     * @var string
     */
    protected string $secretKey;

    /**
     * @var string
     */
    protected string $publicKey;

    /**
     * StripeService constructor.
     * @param string $secretKey
     * @param string $publicKey
     */
    public function __construct(string $secretKey, string $publicKey)
    {
        $this->secretKey = $secretKey;
        $this->publicKey = $publicKey;
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    /**
     * @param Purchase $purchase
     * @return PaymentIntent
     * @throws ApiErrorException
     */
    public function getPaymentIntent(Purchase $purchase): PaymentIntent
    {
        Stripe::setApiKey($this->secretKey);

        return PaymentIntent::create([
            'amount' => $purchase->getTotal(),
            'currency' => 'eur',
        ]);
    }
}