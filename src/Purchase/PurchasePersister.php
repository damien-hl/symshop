<?php

namespace App\Purchase;

use App\Cart\CartService;
use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class PurchasePersister
{
    /**
     * @var Security
     */
    protected Security $security;

    /**
     * @var CartService
     */
    protected CartService $cartService;

    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $em;

    /**
     * PurchasePersister constructor.
     * @param Security $security
     * @param CartService $cartService
     * @param EntityManagerInterface $em
     */
    public function __construct(Security $security, CartService $cartService, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->cartService = $cartService;
        $this->em = $em;
    }

    public function storePurchase(Purchase $purchase)
    {
        /** @var User $user */
        $user = $this->security->getUser();

        $purchase->setUser($user);
//            ->setPurchasedAt(new DateTime())
//            ->setTotal($this->cartService->getTotal());

        $this->em->persist($purchase);

        foreach ($this->cartService->getDetailedCartItem() as $cartItem) {
            $purchaseItem = new PurchaseItem();
            $purchaseItem->setPurchase($purchase)
                ->setProduct($cartItem->product)
                ->setProductName($cartItem->product->getName())
                ->setQuantity($cartItem->qty)
                ->setTotal($cartItem->getTotal())
                ->setProductPrice($cartItem->product->getPrice());

            $this->em->persist($purchaseItem);
        }

        $this->em->flush();
    }
}