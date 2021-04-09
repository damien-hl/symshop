<?php

namespace App\EventDispatcher;

use App\Event\ProductViewEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ProductViewEmailSubscriber
 * @package App\EventDispatcher
 */
class ProductViewEmailSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'product.view' => 'sendProductEmail'
        ];
    }

    /**
     * @param ProductViewEvent $productViewEvent
     */
    public function sendProductEmail(ProductViewEvent $productViewEvent)
    {
        $this->logger->info("Email envoyé pour le produit " . $productViewEvent->getProduct()->getName());
    }
}