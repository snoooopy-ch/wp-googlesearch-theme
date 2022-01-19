<?php
require_once('vendor/autoload.php');
\Stripe\Stripe::setApiKey('sk_test_51Ion4QFb6lDEOg3VEeKfHVLMI5ZDiPivRe2ubD9v8edloPJuNiSBcfxaC0knDmrkAmJhc9uW8rQbhydkm3Zqjg32000bHJaBTV');
$stripe_id = $_POST['stripe_id'];

$subsc = \Stripe\Subscription::update(
  $stripe_id,
  [
    'cancel_at_period_end' => true,
  ]
);

$url = 'https://quizhub.jp/cancel/?tid='.$subsc->id . '&tname=' . $subsc->plan->id;
header($url); 
echo "<script>window.location.href='" . $url . "';</script>";
echo 'header';
?>