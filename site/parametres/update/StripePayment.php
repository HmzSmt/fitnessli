<?php

namespace App;

use Stripe\Stripe;

class StripePayment
{
    private $clientSecret;

    public function __construct($clientSecret)
    {
        $this->clientSecret = $clientSecret;
        Stripe::setApiKey($this->clientSecret);
        Stripe::setApiVersion('2020-08-27');
    }

    public function startPayment(Cart $cart)
    {
       $line_items = [];
       foreach ($cart->getItems() as $item) {
           $line_items[] = [
               'price_data' => [
                   'currency' => 'eur',
                   'product_data' => [
                       'name' => $item->getName(),
                   ],
                   'unit_amount' => $item->getPrice(),
               ],
               'quantity' => $item->getQuantity(),
           ];
       }

       $session = \Stripe\Checkout\Session::create([
           'payment_method_types' => ['card'],
           'line_items' => $line_items,
           'mode' => 'payment',
           'success_url' => 'https://fitnessli.com/site/recup.php',
           'cancel_url' => 'https://fitnessli.com/site/recup.php',
           'billing_address_collection' => 'required',
           'shipping_address_collection' => [
               'allowed_countries' => ['FR']
           ],
           'metadata' => [
                'cart_id' => $cart->getId()
           ],
       ]);

       return $session->id;
    }
}
