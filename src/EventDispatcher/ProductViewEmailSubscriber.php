<?php

namespace App\EventDispatcher;

use App\Event\ProductViewEvent;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

/**
 * Class ProductViewEmailSubscriber
 * @package App\EventDispatcher
 */
class ProductViewEmailSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @var MailerInterface
     */
    protected MailerInterface $mailer;

    /**
     * ProductViewEmailSubscriber constructor.
     * @param LoggerInterface $logger
     * @param MailerInterface $mailer
     */
    public function __construct(LoggerInterface $logger, MailerInterface $mailer)
    {
        $this->logger = $logger;
        $this->mailer = $mailer;
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
//        $email = new TemplatedEmail();
//        $email->from(new Address('contact@mail.com', 'Infos de la boutique'))
//            ->to('admin@mail.com')
//            ->text('Un visiteur est en train de voir la page du produit ' . $productViewEvent->getProduct()->getName())
//            ->htmlTemplate('emails/product_view.html.twig')
//            ->context([
//                'product' => $productViewEvent->getProduct()
//            ])
//            ->subject('Visite du produit ' . $productViewEvent->getProduct()->getName());
//
//        $this->mailer->send($email);

        $this->logger->info("Email envoyé pour le produit " . $productViewEvent->getProduct()->getName());
    }
}