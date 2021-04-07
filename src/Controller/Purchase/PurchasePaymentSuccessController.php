<?php

namespace App\Controller\Purchase;

use App\Cart\CartService;
use App\Entity\Purchase;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PurchasePaymentSuccessController extends AbstractController
{
    /**
     * @Route("/purchase/terminate/{id}", name="purchase_payment_success", requirements={"id":"\d+"})
     * @IsGranted("ROLE_USER")
     * @param int $id
     * @param PurchaseRepository $purchaseRepository
     * @param EntityManagerInterface $em
     * @param CartService $cartService
     * @return Response
     */
    public function success(int $id, PurchaseRepository $purchaseRepository, EntityManagerInterface $em, CartService $cartService): Response
    {
        $purchase = $purchaseRepository->find($id);

        if (
            !$purchase ||
            $purchase->getUser() !== $this->getUser() ||
            $purchase->getStatus() === Purchase::STATUS_PAID
        ) {
            $this->addFlash('warning', "La commande n'existe pas");

            return $this->redirectToRoute("purchase_index");
        }

        $purchase->setStatus(Purchase::STATUS_PAID);

        $em->flush();

        $cartService->empty();

        $this->addFlash('success', "La commande a été payée et confirmée");

        return $this->redirectToRoute("purchase_index");
    }
}