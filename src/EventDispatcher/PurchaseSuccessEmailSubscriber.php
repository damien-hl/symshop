<?php

namespace App\EventDispatcher;

use App\Event\PurchaseSuccessEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PurchaseSuccessEmailSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private  LoggerInterface $logger;

    /**
     * PurchaseSuccessEmailSubscriber constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'purchase.success' => 'sendSuccessEmail'
        ];
    }

    /**
     * @param PurchaseSuccessEvent $purchaseSuccessEvent
     */
    public function sendSuccessEmail(PurchaseSuccessEvent $purchaseSuccessEvent)
    {
        $this->logger->info("Email envoyé pour la commande n°" . $purchaseSuccessEvent->getPurchase()->getId());
    }
}