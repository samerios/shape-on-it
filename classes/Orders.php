<?php
//"Orders" class
//include "User" file to use User class
require_once ('User.php');
//include "ShapeOnIt" file to use ShapeOnIt class
require_once ('ShapeOnIt.php');
//include "Item" file to use Item class
require_once ('Item.php');
//include "supplier" file to use supplier class
require_once ('supplier.php');

class Orders {
    //class variables
    var $id;
    var $dateOpen;
    var $status;
    var $price;
    var $type; //That means user || supplier
    public $User;
    public $Supplier;
    public $ShapeOnIt;
    public $items = array();
    
    //contructor
    public function __construct($id, $dateOpen, $price, $status, $type) {
        //use set methods to init object
        $this->setId($id);
        $this->setOpenDate($dateOpen);
        $this->setPrice($price);
        $this->setStatus($status);
        $this->setType($type);
    }
    /////getters & setters
    function getId() {
        return $this->id;
    }
    function setId($id) {
        $this->id = $id;
    }
    function getOpenDate() {
        return $this->dateOpen;
    }
    function setOpenDate($dateOpen) {
        $this->dateOpen = $dateOpen;
    }
    function getPrice() {
        return $this->price;
    }
    function setPrice($price) {
        $this->price = $price;
    }
    function getStatus() {
        return $this->status;
    }
    function setStatus($status) {
        $this->status = $status;
    }
    function getType() {
        return $this->type;
    }
    function setType($type) {
        $this->type = $type;
    }
}
?>
