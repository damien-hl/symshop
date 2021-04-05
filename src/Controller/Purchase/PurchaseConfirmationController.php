<?php

namespace App\Controller\Purchase;

use App\Cart\CartService;
use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use App\Entity\User;
use App\Form\CartConfirmationType;
use DateTime;
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
     * PurchaseConfirmationController constructor.
     * @param CartService $cartService
     * @param EntityManagerInterface $em
     */
    public function __construct(CartService $cartService, EntityManagerInterface $em)
    {
        $this->cartService = $cartService;
        $this->em = $em;
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

        /** @var User $user */
//        $user = $this->security->getUser();
        $user = $this->getUser();

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

        $purchase->setUser($user)
            ->setPurchasedAt(new DateTime())
            ->setTotal($this->cartService->getTotal());

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

        $this->cartService->empty();

//        $flashBag->add('success', "La commande a bien été enregistrée");
        $this->addFlash("success", "La commande a bien été enregistrée");

//        return new RedirectResponse($this->router->generate('purchase_index'));
        return $this->redirectToRoute('purchase_index');
    }
}
