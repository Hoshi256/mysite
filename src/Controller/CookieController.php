<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CookieController extends AbstractController
{
    #[Route('/cookie', name: 'app_cookie')]
    public function index(Request $request): Response
    {


        $cookie = new Cookie('myCookie', 'contentOfMyCookie', time() + 3600);

        // create a response object
        $response = new Response();

        // add the cookie to the response headers
        $response->headers->setCookie($cookie);
          // get the cookie value from the request object
        $cookieValue = $request->cookies->get('myCookie');

        // add the cookie to the response headers
$response->headers->setCookie($cookie);

// send the response
$response->send();

                // do something with the cookie value


        return $this->render('cookie/index.html.twig', [
            'controller_name' => 'CookieController',
                        'cookieValue' => $cookieValue,

        ]);
    }
}
