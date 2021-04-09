<?php

namespace App\EventDispatcher;

use App\Entity\User;
use App\Event\PurchaseSuccessEvent;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Security\Core\Security;

/**
 * Class PurchaseSuccessEmailSubscriber
 * @package App\EventDispatcher
 */
class PurchaseSuccessEmailSubscriber implements EventSubscriberInterface
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
     * @var Security
     */
    protected Security $security;

    /**
     * PurchaseSuccessEmailSubscriber constructor.
     * @param LoggerInterface $logger
     * @param Security $security
     * @param MailerInterface $mailer
     */
    public function __construct(LoggerInterface $logger, Security $security, MailerInterface $mailer)
    {
        $this->logger = $logger;
        $this->mailer = $mailer;
        $this->security = $security;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'purchase.success' => 'sendSuccessEmail'
        ];
    }

    /**
     * @param PurchaseSuccessEvent $purchaseSuccessEvent
     * @throws TransportExceptionInterface
     */
    public function sendSuccessEmail(PurchaseSuccessEvent $purchaseSuccessEvent)
    {
        /** @var User $currentUser */
        $currentUser = $this->security->getUser();

        $purchase = $purchaseSuccessEvent->getPurchase();

        $email = new TemplatedEmail();
        $email->to(new Address($currentUser->getEmail(), $currentUser->getFullName()))
            ->from("contact@mail.com")
            ->subject("Bravo votre commande ({$purchase->getId()}) a bien été confirmée")
            ->htmlTemplate('emails/purchase_success.html.twig')
            ->context([
                'purchase' => $purchase,
                'user' => $currentUser
            ]);

        $this->logger->info("Email envoyé pour la commande n°" . $purchaseSuccessEvent->getPurchase()->getId());

        $this->mailer->send($email);
    }
}