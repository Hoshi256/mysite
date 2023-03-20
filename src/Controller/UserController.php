<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('user/account.html.twig', [
            
        ]);
    }

    #[Route('/user/preferences', name: 'app_user_preferences')]
    public function preferences(Request $request, SessionInterface $session): Response
    {
        // get the user's preferred language from the session (if it exists)
        $language = $session->get('language');

        // check if the form was submitted
        if ($request->isMethod('POST')) {
            // get the user's preferred language from the form data
            $language = $request->request->get('language');

            // store the user's preferred language in the session
            $session->set('language', $language);

            // create a new cookie to store the user's preferred language
            $cookie = new Cookie('language', $language, time() + (365 * 24 * 60 * 60));

            // create a new response object
            $response = new Response();

            // add the cookie to the response headers
            $response->headers->setCookie($cookie);

            // redirect the user back to the preferences page
            return $this->redirectToRoute('app_user_preferences');
        }

        // get the user's preferred language from the cookie (if it exists)
        $cookieLanguage = $request->cookies->get('language');

        if ($cookieLanguage) {
            $language = $cookieLanguage;
        }

        // render the preferences template and pass in the user's preferred language
        return $this->render('user/preferences.html.twig', [
            'language' => $language,
        ]);
    }
     #
}
