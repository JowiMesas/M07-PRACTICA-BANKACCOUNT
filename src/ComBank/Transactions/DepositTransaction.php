<?php namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 11:30 AM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Support\Traits\ApiTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class DepositTransaction  extends BaseTransaction implements BankTransactionInterface
{
 use ApiTrait;
    public function __construct($amount) {
        parent::validateAmount(amount: $amount);
        $this->amount = $amount;
    }
public function applyTransaction(BackAccountInterface $account) : float {
    if($this->detectFraud($this)) {
        throw new FailedTransactionException("Blocked  by possible fraud");
    }
 parent::validateAmount(amount: $this->amount);
$newBalance = $account->getBalance() + $this->amount; 
return $newBalance;

}
public function getTransactionInfo() : string {
    return "DEPOSIT_TRANSACTION";
}
public function getAmount() : float {
    return $this->amount;
}
}
