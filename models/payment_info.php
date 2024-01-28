<?php
class PaymentInfo {
    private $id;
    private $creditCardNo;
    private $cardExpiration;
    private $holderName;
    private $bank;

    function __construct(){}

    //getters
    public function getId() {
        return $this->id;
    }

    public function getCreditCardNo() {
        return $this->creditCardNo;
    }

    public function getCardExpiration() {
        return $this->cardExpiration;
    }

    public function getHolderName() {
        return $this->holderName;
    }

    public function getBank() {
        return $this->bank;
    }



    //setters

    public function setCreditCardNo($creditCardNo) {
        $this->creditCardNo = $creditCardNo;
    }

    public function setCardExpiration($cardExpiration) {
        $this->cardExpiration = $cardExpiration;
    }

    public function setHolderName($holderName) {
        $this->holderName = $holderName;
    }
    
    public function setBank($bank) {
        $this->bank = $bank;
    }


}