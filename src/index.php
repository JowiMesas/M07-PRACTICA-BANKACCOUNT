<?php

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:24 PM
 */

use ComBank\Bank\BankAccount;
use ComBank\OverdraftStrategy\SilverOverdraft;
use ComBank\Transactions\DepositTransaction;
use ComBank\Transactions\WithdrawTransaction;
use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\Bank\InternationalBankAccount;
use ComBank\Bank\NationalBankAccount;
use ComBank\Exceptions\PersonException;
use ComBank\Persons\Person;
require_once 'bootstrap.php';


//---[Bank account 1]---/
// create a new account1 with balance 400
pl('--------- [Start testing bank account #1, No overdraft] --------');
try {
    // show balance account
    $bankAccount1 = new BankAccount(400);
    pl('My balance :' . $bankAccount1->getBalance());
    // close account
    $bankAccount1->closeAccount();
    // reopen account
    $bankAccount1->reopenAccount();


    // deposit +150 
    pl('Doing transaction deposit (+150) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new DepositTransaction(150));

    pl('My new balance after deposit (+150) : ' . $bankAccount1->getBalance());

    // withdrawal -25
    pl('Doing transaction withdrawal (-25) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1-> transaction(new WithdrawTransaction(25));

    pl('My new balance after withdrawal (-25) : ' . $bankAccount1->getBalance());

    // withdrawal -600
    pl('Doing transaction withdrawal (-600) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new WithdrawTransaction(600));
} catch (ZeroAmountException $e) {
    pl($e->getMessage());
} catch (BankAccountException $e) {
    pl($e->getMessage());
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My balance after failed last transaction : ' . $bankAccount1->getBalance());
$bankAccount1->closeAccount();




//---[Bank account 2]---/
pl('--------- [Start testing bank account #2, Silver overdraft (100.0 funds)] --------');
try {
    
    // show balance account
    $bankAccount2 = new BankAccount(200);
    pl(mixed: 'My balance :' . $bankAccount2->getBalance());
    $bankAccount2-> applyOverDraft(new SilverOverdraft);
    // deposit +100
    pl('Doing transaction deposit (+100) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new DepositTransaction(100));
    
    pl('My new balance after deposit (+100) : ' . $bankAccount2->getBalance());

    // withdrawal -300
    pl('Doing transaction withdrawal (-300) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2-> transaction(new WithdrawTransaction(300));
   
    pl('My new balance after withdrawal (-300) : ' . $bankAccount2->getBalance());

    // withdrawal -50
    pl('Doing transaction withdrawal (-50) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(50));
    pl('My new balance after withdrawal (-50) with funds : ' . $bankAccount2->getBalance());

    // withdrawal -120
    pl('Doing transaction withdrawal (-120) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(120));
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My balance after failed last transaction : ' . $bankAccount2->getBalance());

try {
    pl('Doing transaction withdrawal (-20) with current balance : ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(20));
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My new balance after withdrawal (-20) with funds : ' . $bankAccount2->getBalance());

$bankAccount2->closeAccount();
try {
    $bankAccount2->closeAccount();
} catch (BankAccountException $e) {
    pl($e->getMessage());
}
 //---[Bank account 3]---/
pl('--------- [Start testing national account (No conversion)] --------');



$bankAccount3 = new NationalBankAccount(500, "EUR");
pl("My balance: " . number_format($bankAccount3->getBalance(), 1)  . "€ (" . $bankAccount3->getCurrency() . ")");
pl('--------- [Start testing International account (Dollar conversion)] --------');

$bankAccount4 = new InternationalBankAccount(300);
pl("My balance: " . number_format($bankAccount4->getBalance(),1) . "€  (" . $bankAccount4->getCurrency() . ")") ;
pl("My balance converted: " . number_format($bankAccount4->getConvertedBalance(),2) . " $ (" . $bankAccount4->getConvertedCurrency() . ")");

pl('--------- [Start testing Valid Email account] --------');

$person = new Person("John", "123456783459", "john.doe@gmail.com");

$bankAccountPerson = new NationalBankAccount(500, "EUR", $person);

pl('--------- [Start testing Invalid Email account] --------');
$person2 = new Person("Jane", "453675869234", "jane.doe@invalid-com");
$bankAccountPerson2 = new InternationalBankAccount(400, "EUR", $person);

pl('--------- [Start testing Fraud System Deposit Transaction] --------');
$bankAccount5 = new BankAccount(700);
pl("My balance: " . number_format($bankAccount5->getBalance(), 1));
pl('Doing transaction deposit (+23000) with current balance ' . number_format($bankAccount5->getBalance(),1));
try{
    $bankAccount5->transaction(new DepositTransaction(23000));
}catch (FailedTransactionException $e) {
    pl(    $e->getMessage());
}
pl('My balance after failed last transaction : ' . number_format($bankAccount5->getBalance(),1));
pl('Doing transaction deposit (+6000) with current balance ' . number_format($bankAccount5->getBalance(),1));
try{
    $bankAccount5->transaction(new DepositTransaction(6000));
}catch (FailedTransactionException $e) {
    pl(    $e->getMessage());
}
pl('My new balance after deposit (+6000) : ' . number_format($bankAccount5->getBalance(),decimals: 1));

pl('--------- [Start testing Fraud System Withdraw Transaction] --------');
$bankAccount6 = new BankAccount(1000);
pl("My balance: " . number_format($bankAccount6->getBalance(), 1));
pl('Doing transaction withdrawal (-300) with current balance ' . number_format($bankAccount6->getBalance(), 1));
try {
    $bankAccount6->transaction(new WithdrawTransaction(300));
}catch(FailedTransactionException $e) {
    pl($e->getMessage());
}
pl('My new balance after withdrawal (-300) with funds : ' . number_format($bankAccount6->getBalance(), 1));
pl('Doing transaction withdrawal (-6500) with current balance ' . number_format($bankAccount6->getBalance(), 1));
try{
    $bankAccount6->transaction(new WithdrawTransaction(6500));
}catch (FailedTransactionException $e) {
    pl($e->getMessage());
}
pl('My balance after failed last transaction : ' . number_format($bankAccount6->getBalance(),1));

pl('--------- [Start testing IBAN Validation Valid] --------');
$personIBAN = new Person('Joel','12', 'joelmesash@gmail.com', 'ES6000491500051234567892');
$bankAccountPerson3 = new InternationalBankAccount("600", "EUR", $personIBAN);

pl('--------- [Start testing IBAN Validation Invalid] --------'); 
$personIBAN2 = new Person("Victor", "14", "victorlucumi@gmail.com", "ho89370400440me2013000");
$bankAccountPerson4 = new NationalBankAccount("1000", "EUR", $personIBAN2);





