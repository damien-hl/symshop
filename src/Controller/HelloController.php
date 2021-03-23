<?php

namespace App\Controller;

use App\Taxes\Calculator;
use Cocur\Slugify\Slugify;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController
{
    /**
     * @Route("/hello/{name}", name="hello", methods={"GET"}, defaults={"name": "World"}, requirements={"name": "[a-zA-Z]+"})
     * @param string $name
     * @param Calculator $calculator
     * @param Slugify $slugify
     * @return Response
     */
    public function hello(string $name, Calculator $calculator, Slugify $slugify): Response
    {
        $slug = $slugify->slugify("Hello World");
        $tva = $calculator->calcul(100);
        return new Response("Hello $name $tva $slug");
    }
}
