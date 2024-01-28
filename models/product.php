<?php
class Product {
    private $id;
    private $name;
    private $description;
    private $price;
    private $amount;
    private $category;
    private $remarks;
    private $photos;

    public function __construct(){ //default constructor
        
     }

    //getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getRemarks() {
        return $this->remarks;
    }

    public function getPhotos() {
        return $this->photos;
    }

    //setters

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function setRemarks($remarks) {
        $this->remarks = $remarks;
    }

    public function setPhotos($photos) {
        $this->photos = $photos;
    }
}