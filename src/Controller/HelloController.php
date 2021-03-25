<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{

    /**
     * @Route("/hello/{name}", name="hello", methods={"GET"}, defaults={"name": "World"}, requirements={"name": "[a-zA-Z]+"})
     * @param string $name
     * @return Response
     */
    public function hello(string $name): Response
    {
        return $this->render('hello.html.twig', ['name' => $name]);
    }

    /**
     * @Route("/example", name="example")
     * @return Response
     */
    public function example(): Response
    {
        return $this->render('example.html.twig', ['age' => 33]);
    }
}
