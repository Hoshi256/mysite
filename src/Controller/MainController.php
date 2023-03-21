<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/change-locale/{locale}', name: 'change-locale')]
    public function changeLocale($locale, Request $request): Response
    {
            // on stocke la la,gue in seesion

            $request->getSession()->set('_locale', $locale);
            $request->setLocale($locale);

            // on revient sur la page precedente 

                return $this->redirect($request->headers->get('referer'));

       
      
    }
}
