<?php

namespace App\Service;

use Stripe\Charge;
use Stripe\Stripe;

class StripeService
{
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        Stripe::setApiKey($apiKey);
    }

    public function createCharge(int $amount, string $currency, string $source)
    {
        $charge = Charge::create([
            'amount' => $amount,
            'currency' => $currency,
            'source' => $source,
        ]);

        return $charge;
    }
}
?>