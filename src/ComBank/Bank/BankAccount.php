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

class BankAccount extends BankAccountException implements BackAccountInterface 
{
    use AmountValidationTrait;
    private $balance;
    private $status;
    private $overdraft;


    public function __construct($balance) {
        $this->balance = $balance;
        $this->status = BackAccountInterface::STATUS_OPEN;
        $this-> overdraft = new NoOverdraft();
    }
    public function transaction(BankTransactionInterface $transaction) : void {
      if($this->status == BackAccountInterface::STATUS_OPEN) {
        try {
            $this->balance = $transaction->applyTransaction($this);
        } catch(BankAccountException $e) {
            throw new BankAccountException($e->getMessage(), $e->getCode());
        } catch(InvalidOverdraftFundsException $e) {
            throw new FailedTransactionException($e->getMessage(), $e->getCode());

        }
      } else {
        throw new BankAccountException("The account is already closed");
      }
    }
    public function openAccount() : bool {
        if($this->status == BackAccountInterface::STATUS_OPEN) {
            return true;
        } else {
            return false;
        }
    }
    public function reopenAccount() : void {
        if($this-> status == BackAccountInterface::STATUS_OPEN) {
            throw new BankAccountException("The account is already opened");
        } else {
            $this->status = BackAccountInterface :: STATUS_OPEN;
            echo " <br> My account is now reopened <br> ";
        }

    }
    public function closeAccount() : void {
        if($this->openAccount()) {
            $this->status = BackAccountInterface :: STATUS_CLOSED;
            echo " <br> My account is now closed <br>";
        } 
    }
  
    public function getOverdraft() : OverdraftInterface {
        return $this->overdraft;
    }
    public function applyOverDraft(OverdraftInterface $overdraft) : void {
        $this->overdraft = $overdraft;
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
