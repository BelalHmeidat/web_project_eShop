<?php

    class User {
        private $id;
        private $name;
        private $identificationNO;
        private $password;
        private $username;
        private $dob;
        private $email;
        private $tel;
        private $houseNO;
        private $street;
        private $city;
        private $country;
        private $payment;

        public function __construct(){ //default constructor
            
         }
        //getters
        public function getId(){
            return $this->id;
        }
        public function getName(){
            return $this->name;
        }
        public function getIdentificationNO(){
            return $this->identificationNO;
        }
        public function getPassword(){
            return $this->password;
        }
        public function getUsername(){
            return $this->username;
        }
        public function getDob(){
            return $this->dob;
        }
        public function getEmail(){
            return $this->email;
        }
        public function getTel(){
            return $this->tel;
        }
        public function getHouseNO(){
            return $this->houseNO;
        }
        public function getStreet(){
            return $this->street;
        }
        public function getCity(){
            return $this->city;
        }
        public function getCountry(){
            return $this->country;
        }
        public function getPayment(){
            return $this->payment;
        }
        //setters
        public function setName($name){
            $this->name = $name;
        }
        public function setIdentificationNO($identificationNO){
            $this->identificationNO = $identificationNO;
        }
        public function setPassword($password){
            $this->password = $password;
        }
        public function setUsername($username){
            $this->username = $username;
        }
        public function setDob($dob){
            $this->dob = $dob;
        }
        public function setEmail($email){
            $this->email = $email;
        }
        public function setTel($tel){
            $this->tel = $tel;
        }
        public function setHouseNO($houseNO){
            $this->houseNO = $houseNO;
        }
        public function setStreet($street){
            $this->street = $street;
        }
        public function setCity($city){
            $this->city = $city;
        }
        public function setCountry($country){
            $this->country = $country;
        }
        public function setPayment($payment){
            $this->payment = $payment;
        }

    }
    ?>