<?php
require_once '../App/StripePayment.php';
require_once '../App/Cart.php';

$cart = new Cart(); // Vous devez remplir le panier avec les produits que l'utilisateurachète.

$stripePayment = new StripePayment('votre_clé_secrète_stripe');
$sessionId = $stripePayment->startPayment($cart);

echo $sessionId;
?>