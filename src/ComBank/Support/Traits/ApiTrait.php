<?php namespace ComBank\Support\Traits;

use ComBank\Transactions\Contracts\BankTransactionInterface;

trait ApiTrait {
    //Convert Euros to Dollars 
    function convertBalance(float $euros): float {
        $from = "EUR";
        $to = "USD";
    $ch = curl_init();
    $api = "https://api.fxfeed.io/v1/convert?api_key=fxf_4zBcEdJpYJicPlqixcMt&from=$from&to=$to&amount=$euros";
    curl_setopt($ch, CURLOPT_URL, $api);
    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
    ));
    $result = curl_exec(handle: $ch);
    curl_close(handle: $ch);
    $convertJson = json_decode($result, true);
     return $convertJson["result"];
    }

    function validateEmail(string $email) : bool {
            $ch = curl_init();
            $api = "https://api.usercheck.com/email/$email?key=PaHQqILPLJDHrxXAf7Kans589FwvdjF2";
            curl_setopt($ch, CURLOPT_URL, value: $api);
            curl_setopt_array($ch, array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
            ));
            $result = curl_exec(handle: $ch);
            curl_close(handle: $ch);
            $convertJson = json_decode ($result, true);
            if(isset($convertJson['mx']) && isset($convertJson['disposable'])) {
                if ($convertJson['mx']&& !$convertJson['disposable']) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }


    }
    function detectFraud(BankTransactionInterface $transaction): bool {
        $ch = curl_init();
        $api = "https://673789ef4eb22e24fca57b15.mockapi.io/fraudsystem";
        curl_setopt($ch, CURLOPT_URL, value: $api);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
        ));
        $result = curl_exec(handle: $ch);
        curl_close(handle: $ch);
        $convertJson = json_decode ($result, true);
        $giveAmount = $transaction->getAmount();
        $fraud = false;
        foreach ($convertJson as $key => $value) {
            if($convertJson[$key]["movementType"]==$transaction->getTransactionInfo()) {
                if($convertJson[$key]["amount"] >= $giveAmount && $convertJson[$key]["max_amount"] <= $giveAmount) {
                    
                }
            }
        }

    }
}