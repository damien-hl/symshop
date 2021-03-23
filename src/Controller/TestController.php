<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        dd('test');
    }

    /**
     * @Route("/test/{age<\d+>?0}", name="test", methods={"GET", "POST"}, host="127.0.0.1", schemes={"http", "https"})
     *
     * @param int $age
     * @return Response
     */
    public function test(int $age): Response
    {
        return new Response("Vous avez $age ans");
    }
}