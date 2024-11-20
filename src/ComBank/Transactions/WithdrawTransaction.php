<?php namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:22 PM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Support\Traits\ApiTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class WithdrawTransaction extends BaseTransaction implements BankTransactionInterface
{
    use ApiTrait;
    public function __construct($amount) {
        parent::validateAmount(amount: $amount);
        $this->amount = $amount;
    }
    public function applyTransaction(BackAccountInterface $account) : float {
        parent::validateAmount(amount:$this->amount);
        if($this->detectFraud($this)) {
            throw new FailedTransactionException(message: "Blocked  by possible fraud");
        }
        $newBalance = $account->getBalance() - $this->amount; 
        $overdraft = $account-> getOverdraft()->isGrantOverdraftFunds($newBalance);
        if($newBalance < 0) {
            if($overdraft) {
                return $newBalance;
            } else {
                throw new InvalidOverdraftFundsException("Insuffcient balance to complete the withdrawal");
            }
        } else {
            return $newBalance;
        }
        
    }
    public function getTransactionInfo() : string {
        return "WITHDRAW_TRANSACTION";
    }
    public function getAmount() : float {
        return $this->amount;

    }
   
}
