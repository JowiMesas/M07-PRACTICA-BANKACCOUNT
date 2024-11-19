<?php
namespace ComBank\Persons;
use ComBank\Support\Traits\ApiTrait;
class Person {
    use ApiTrait;
    private $name;
    private $idCard;
    private $email;
    public function __construct($name, $idCard, $email){
        $this-> name = $name;
        $this->idCard = $idCard;
        if($this->validateEmail($email)) {
            $this->email = $email;
            pl("validating email: " .$this->getEmail());
            pl("Email is valid");
        } else {
            pl("validating email: " . $email);
            pl(mixed: "Error: Invalid email address: " . $email);
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
  
}