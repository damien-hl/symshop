<?php

namespace App\Controller\Purchase;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PurchasesListController extends AbstractController
{
    /**
     * @Route("/purchases", name="purchase_index")
     * @IsGranted("ROLE_USER", message="Vous devez être connecté pour accéder à vos commandes")
     *
     * @return Response
     */
    public function index(): Response
    {
        /** @var User $user */
//        $user = $this->security->getUser();
        $user = $this->getUser();

//        if (!$user) {
//            $url = $this->router->generate('homepage');
//            return new RedirectResponse($url);
//            throw new AccessDeniedException("Vous devez être connecté pour accéder à vos commandes");
//        }

//        $html = $this->twig->render('purchase/index.html.twig', [
//            'purchases' => $user->getPurchases()
//        ]);
//
//        return new Response($html);

        return $this->render('purchase/index.html.twig', [
            'purchases' => $user->getPurchases()
        ]);
    }
}
