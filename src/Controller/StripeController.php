<?php
 
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Stripe;
 
class StripeController extends AbstractController
{
    #[Route('/stripe', name: 'app_stripe')]
    public function index(): Response
    {
        return $this->render('stripe/index.html.twig', [
            'stripe_key' => $_ENV["STRIPE_KEY"],
        ]);
    }
 

    
 
    #[Route('/stripe/create-charge', name: 'app_stripe_charge', methods: ['POST'])]

    
    public function createCharge(Request $request)


    {
        $session = $request->getSession();
        Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
    $user = $this->getUser();

    

        $total = $session->get('total');
        Stripe\Charge::create ([
                "amount" => $total * 100,
                "currency" => "usd",
                "source" => $request->request->get('stripeToken'),
                "description" => "rascol Payment Test"
        ]);
        $this->addFlash(
            'success',
            'Payment Successful!'
        );


        return $this->redirectToRoute('app_save_booking', [], Response::HTTP_SEE_OTHER);
    }
}