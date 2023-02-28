<?php

namespace App\Controller;

use Twig\Environment;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\twig;
use Symfony\Component\DependencyInjection\Loader\Configurator\session;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session, ProductRepository $productRepository): Response
    {
        $cart = $session->get('cart', []);        
        $total = 0;

                
            $cartWithData=[];
            if (count($cart)!=0 ){
            foreach ($cart as $id => $quantity) {
            $cartWithData[] = [
                'product' => $productRepository->find($id),
                'quantity' => $quantity
            ];
            }
        // $cartWithData = [];

        
         foreach ($cartWithData as $item) {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }
            $session->set('total', $total);
        } else {


        }


       

            return $this->render('cart/index2.html.twig', [
            'items' => $cartWithData,
            'total' => $total,

           


        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add')]
    
    public function add($id, SessionInterface $session, Environment $twig) {
        // $session = $request->getSession();
        $cart = $session ->get('cart', []);

        if(!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

       

        $session->set('cart', $cart);


         $cartCount = array_sum($cart);

            

        // $cartCount = $this->getCartCount($session);

        return $this->redirectToRoute('app_cart', [
            'cart' => $cart,
            'cartCount' => $cartCount,
        ]);

        
    }

    private function getCartCount(SessionInterface $session) {
    $cart = $session->get('cart', []);

    $count = 0;

    foreach ($cart as $item) {
        $count += $item;
    }

    return $count;
}
        

        #[Route('/cart/remove/{id}', name: 'cart_remove')]


    public function remove($id, SessionInterface $session) {
        $cart = $session ->get('cart', []);
        
        if(!empty($cart[$id])) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);
        return $this->redirectToRoute('app_cart');

    }

   
}
