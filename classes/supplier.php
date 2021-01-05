<?php
//"supplier" class
//include "Orders" file to use Orders class
require_once ('Orders.php');
//include "ShapeOnIt" file to use ShapeOnIt class
require_once ('ShapeOnIt.php');
class supplier {
    //class variables
    var $id;
    var $fullname;
    var $email;
    var $phoneNumber;
    public $Orders = array();
    public $ShapeOnIt;
    //contructor
    public function __construct($id, $fullname, $email, $phoneNumber) {
        //use set methods to init object
        $this->setId($id);
        $this->setFullname($fullname);
        $this->setEmail($email);
        $this->setPhoneNumber($phoneNumber);
    }
    /////getters & setters
    function getId() {
        return $this->id;
    }
    function setId($id) {
        $this->id = $id;
    }
    function getFullName() {
        return $this->fullname;
    }
    function setFullname($fullname) {
        $this->fullname = $fullname;
    }
    function getEmail() {
        return $this->email;
    }
    function setEmail($email) {
        $this->email = $email;
    }
    function getPhoneNumber() {
        return $this->phoneNumber;
    }
    function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }
}
?>
