<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{
    public function index()
    {
        dd('test');
    }

    /**
     * @Route("/test/{age<\d+>?0}", name="test", methods={"GET", "POST"}, host="127.0.0.1", schemes={"http", "https"})
     *
     * @param Request $request
     * @param int $age
     * @return Response
     */
    public function test(Request $request, int $age): Response
    {
//        $age = $request->attributes->get('age', 0);

        return new Response("Vous avez $age ans");
    }
}