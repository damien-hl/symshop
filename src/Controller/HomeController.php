<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function homepage(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findBy([], [], 3);

        return $this->render('home.html.twig', [
            'products' => $products
        ]);
    }
}