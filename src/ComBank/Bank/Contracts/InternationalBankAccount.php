<?php

use ComBank\Bank\BankAccount;
use ComBank\Support\Traits\ApiTrait;
class InternationalBankAccount extends BankAccount {

function getConvertedBalance(): float {

      return parent::convertBalance($this-> balance);
}
function getConvertedCurrency() : string {

    return 'USD';
}
}