<?php

namespace App\Services;

use App\Entity\Command;
use App\Entity\Product;

class StripeService
{
    private $privateKey;

    public function __construct()
    {
        
    
            $this->privateKey = $_ENV['STRIPE_KEY'];
        
    }

    /**
     * @param Product $product
     * @return \Stripe\PaymentIntent
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function paymentIntent(Product $product)
    {
        \Stripe\Stripe::setApiKey($this->privateKey);

        return \Stripe\PaymentIntent::create([
            'amount' => $product->getPrice() * 100,
            'currency' => "usd",
            'payment_method_types' => ['card']
        ]);
    }

    public function paiement(
        $amount,
        $currency,
        $description,
        array $stripeParameter
    )
    {
        \Stripe\Stripe::setApiKey($this->privateKey);
        $payment_intent = null;

        if(isset($stripeParameter['stripeIntentId'])) {
            $payment_intent = \Stripe\PaymentIntent::retrieve($stripeParameter['stripeIntentId']);
        }

        if($stripeParameter['stripeIntentStatus'] === 'succeeded') {
            //TODO
        } else {
            $payment_intent->cancel();
        }

        return $payment_intent;
    }

    /**
     * @param array $stripeParameter
     * @param Product $product
     * @return \Stripe\PaymentIntent|null
     */
    public function stripe(array $stripeParameter, Product $product)
    {
        return $this->paiement(
            $product->getPrice() * 100,
           "usd",
            $product->getPrice(),
            $stripeParameter
        );
    }
}