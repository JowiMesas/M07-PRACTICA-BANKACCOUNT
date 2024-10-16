<?php namespace ComBank\Bank;

/**
 * Created by VS Code.
 * User: Joel Mesas
 * Date: 7/27/24
 * Time: 7:25 PM
 */

use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class BankAccount implements BackAccountInterface
{
    private $balance;
    private $status;
    private $overdraft;


    public function __construct($balance, $status, $overdraft) {
        $this->balance = $balance;
        $this->status = $status;
        $this->overdraft = $overdraft;
    }
    public function transaction($BankTransactionInterface) : void {
        $this->balance += $BankTransactionInterface->getAmount();
    }
    public function openAccount() : bool {
        $this->status = true;
        return $this->status;
    }
    public function reopenAccount() : void {
        $this->status = true;

    }
    public function closeAccount() : void {
        $this->status = false;
    }
  
    public function getOverdraft() : OverdraftInterface {

    }
    public function applyOverDraft($OverdraftInterface) : void {

    }
    public function setBalance($float) : void {
        $this->balance = $float;
    }

    /**
     * Get the value of balance
     */ 
    public function getBalance(): float
    {
        return $this->balance;
    }

    }
