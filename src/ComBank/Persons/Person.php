<?php
namespace ComBank\Persons;
use ComBank\Support\Traits\ApiTrait;
class Person {
    use ApiTrait;
    private $name;
    private $idCard;
    private $email;
    private $iban;
    private $bankName;
    public function __construct($name, $idCard, $email, $iban = null){
        $this-> name = $name;
        $this->idCard = $idCard;
        $validateIban = $this->validateIban($iban);
        if($this->validateEmail($email)) {
            $this->email = $email;
            pl("validating email: " .$this->getEmail());
            pl("Email is valid");
        } else {
            pl("validating email: " . $email);
            pl(mixed: "Error: Invalid email address: " . $email);
    }
    if ($iban !== null) {
        $validateIban = $this->validateIban($iban);
        if ($validateIban['valid']) {
            $this->iban = $iban;
            $this->bankName = $validateIban['bank_name'];
            pl("IBAN is valid!!: " . $this->getIban());
            pl("Name of Bank: " . $this->getBankName());
        } else {
            pl("Invalid IBAN !!! ");
            pl("IBAN incorrect:  " . $iban);
        }
    } else {
        $this->iban = null;
        $this->bankName = null;
        pl("No IBAN provided.");
    }
}
    public function getEmail()
    {
        return $this->email;
    }

    public function getIdCard()
    {
        return $this->idCard;
    }
  
    public function getName()
    {
        return $this->name;
    }
  

    /**
     * Get the value of iban
     */ 
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * Get the value of bankName
     */ 
    public function getBankName()
    {
        return $this->bankName;
    }
}