<?php 
session_start();
$params = $this->session->userdata('params');
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/hosted/pay",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode([
        'amount' => $amount,
        'customer_email' => $customer_email,
        'currency' => $currency,
        'txref' => $txref,
        'PBFPubKey' => $pubKey,
        'redirect_url' => $redirect_url,
        'params' => $params,
    ]),
    CURLOPT_HTTPHEADER => [
        "content-type: application/json",
        "cache-control: no-cache"
    ],
));

$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
    die('Curl returned error: ' . $err);
}

$transaction = json_decode($response);
if(!$transaction->data && !$transaction->data->link){
    print_r('API returned error: ' . $transaction->message);
}

// Set the params in a cookie
setcookie('payment_params', json_encode($params), time() + 3600, "/");

header('Location: ' . $transaction->data->link);
?>
