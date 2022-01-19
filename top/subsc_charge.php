<?php
require_once('vendor/autoload.php');
\Stripe\Stripe::setApiKey('sk_test_51Ion4QFb6lDEOg3VEeKfHVLMI5ZDiPivRe2ubD9v8edloPJuNiSBcfxaC0knDmrkAmJhc9uW8rQbhydkm3Zqjg32000bHJaBTV');

$name = $_POST['name'];
$email = $_POST['email'];
$token = $_POST['stripeToken'];
$item = $_POST['item'];

// Create Customer In Stripe
$customer = \Stripe\Customer::create(array(
  "name" => $name,
  "email" => $email,
  "source" => $token
));

$subsc = \Stripe\Subscription::create([
  "customer" => $customer->id,
  'items' => [['price' => $item]],
]);

// Customer Data
$customerData = [
  'id' => $subsc->customer,
  'name' => $name,
  'email' => $email
];

// Transaction Data
$transactionData = [
  'id' => $subsc->id,
  'customer_id' => $subsc->customer,
  'product' => $subsc->description,
  'status' => $subsc->status,
];
  
$url = 'https://quizhub.jp/thanks/?tid='.$subsc->id . '&tname=' . $subsc->plan->id . '&price='. $subsc->plan->amount;
header($url); 
echo "<script>window.location.href='" . $url . "';</script>";
echo 'header';
?>