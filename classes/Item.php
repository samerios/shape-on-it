<?php
//"Item" class
//include "Orders" file to use Orders class
require_once ('Orders.php');
class Item {
    //class variables
    var $id;
    var $name;
    var $price;
    var $qty;
    var $img;
    var $description;
    public $order;
    
    //contructor
    public function __construct($id, $name, $price, $qty, $img, $description) {
        //use set methods to init object
        $this->setId($id);
        $this->setName($name);
        $this->setPrice($price);
        $this->setQuantity($qty);
        $this->setImg($img);
        $this->setDescription($description);
    }
    /////getters & setters
    function getId() {
        return $this->id;
    }
    function setId($id) {
        $this->id = $id;
    }
    function getName() {
        return $this->name;
    }
    function setName($name) {
        $this->name = $name;
    }
    function getPrice() {
        return $this->price;
    }
    function setPrice($price) {
        $this->price = $price;
    }
    function getQuantity() {
        return $this->qty;
    }
    function setQuantity($qty) {
        $this->qty = $qty;
    }
    function getImg() {
        return $this->img;
    }
    function setImg($img) {
        $this->img = $img;
    }
    function getDescription() {
        return $this->description;
    }
    function setDescription($description) {
        $this->description = $description;
    }
}
?>
