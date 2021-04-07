<?php

namespace App\Controller\Purchase;

use App\Cart\CartService;
use App\Entity\Purchase;
use App\Form\CartConfirmationType;
use App\Purchase\PurchasePersister;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseConfirmationController extends AbstractController
{
    /**
     * @var CartService
     */
    protected CartService $cartService;

    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $em;

    /**
     * @var PurchasePersister
     */
    protected PurchasePersister $persister;

    /**
     * PurchaseConfirmationController constructor.
     * @param CartService $cartService
     * @param EntityManagerInterface $em
     * @param PurchasePersister $persister
     */
    public function __construct(CartService $cartService, EntityManagerInterface $em, PurchasePersister $persister)
    {
        $this->cartService = $cartService;
        $this->em = $em;
        $this->persister = $persister;
    }

    /**
     * @Route("/purchase/confirm", name="purchase_confirm")
     * @IsGranted("ROLE_USER", message="Vous devez être connecté pour confirmer une commande")
     * @param Request $request
     * @return RedirectResponse
     */
    public function confirm(Request $request): Response
    {
//        $form = $this->formFactory->create(CartConfirmationType::class);
        $form = $this->createForm(CartConfirmationType::class);

        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
//            $flashBag->add("warning", "Vous devez remplir le formulaire de confirmation");
            $this->addFlash("warning", "Vous devez remplir le formulaire de confirmation");

//            return new RedirectResponse($this->router->generate('cart_show'));
            return $this->redirectToRoute('cart_show');
        }

//        $user = $this->security->getUser();
//        $user = $this->getUser();

//        if (!$user) {
//            throw new AccessDeniedException("Vous devez être connecté pour confirmer une commande");
//        }

        $cartItems = $this->cartService->getDetailedCartItem();

        if (count($cartItems) === 0) {
//            $flashBag->add('warning', "Vous ne pouvez pas passer une commande avec un panier vide");
            $this->addFlash("warning", "Vous ne pouvez pas passer une commande avec un panier vide");

//            return new RedirectResponse($this->router->generate('cart_show'));
            return $this->redirectToRoute('cart_show');
        }

        /** @var Purchase $purchase */
        $purchase = $form->getData();

        $this->persister->storePurchase($purchase);

//        $this->cartService->empty();

//        $flashBag->add('success', "La commande a bien été enregistrée");
//        $this->addFlash("success", "La commande a bien été enregistrée");

//        return new RedirectResponse($this->router->generate('purchase_index'));
//        return $this->redirectToRoute('purchase_index');

        return $this->redirectToRoute("purchase_payment_form", [
            'id' => $purchase->getId()
        ]);
    }
}
