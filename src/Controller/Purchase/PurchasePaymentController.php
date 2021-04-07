<?php

namespace App\Controller\Purchase;

use App\Entity\Purchase;
use App\Repository\PurchaseRepository;
use App\Stripe\StripeService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PurchasePaymentController extends AbstractController
{
    /**
     * @Route("/purchase/pay/{id}", name="purchase_payment_form", requirements={"id":"\d+"})
     * @IsGranted("ROLE_USER")
     * @param int $id
     * @param PurchaseRepository $purchaseRepository
     * @param StripeService $stripeService
     * @return Response
     * @throws ApiErrorException
     */
    public function showCardForm(int $id, PurchaseRepository $purchaseRepository, StripeService $stripeService): Response
    {
        $purchase = $purchaseRepository->find($id);

        if (
            !$purchase ||
            $purchase->getUser() !== $this->getUser() ||
            $purchase->getStatus() === Purchase::STATUS_PAID
        ) {
            return $this->redirectToRoute('cart_show');
        }

        $intent = $stripeService->getPaymentIntent($purchase);

        return $this->render('purchase/payment.html.twig', [
            'clientSecret' => $intent->client_secret,
            'stripePublicKey' => $stripeService->getPublicKey(),
            'purchase' => $purchase
        ]);
    }
}