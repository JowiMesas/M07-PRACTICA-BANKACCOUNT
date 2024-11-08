<?php namespace ComBank\Support\Traits;

trait ApiTrait {
    //Convert Euros to Dollars 
    function convertBalance(float $euros): float {
    $ch = curl_init();
    $api = "https://manyapis.com/products/currency/eur-to-usd-rate?amount=" . $euros;
    curl_setopt($ch, CURLOPT_URL, $api);
    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => 'sk_210e356d53874580a80ae095976791ad',
        CURLOPT_SSL_VERIFYPEER => false,
    ));
    $result = curl_exec($ch);
    curl_close($ch);
    $convertJson = json_decode($result);
     return $convertJson->convertedAmount;
    }

    function validateEmail(string $email) : bool {

    }
}