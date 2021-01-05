<?php
//"User" class
//include "Lesson" file to use Lesson class
require_once ('Lesson.php');
//include "WorkPlan" file to use WorkPlan class
require_once ('WorkPlan.php');
//include "Orders" file to use Orders class
require_once ('Orders.php');
//include "ShapeOnIt" file to use ShapeOnIt class
require_once ('ShapeOnIt.php');
class User {
    //class variables
    var $id;
    var $fname;
    var $lname;
    var $gender;
    var $dateOfBirth;
    var $email;
    var $address;
    var $phoneNumber;
    var $username;
    var $password;
    public $Lesson;
    public $WorkPlan;
    public $Orders = array();
    public $ShapeOnIt;
    //contructor
    public function __construct($id, $fname, $lname, $gender, $dateOfBirth, $email, $address, $phoneNumber, $username, $password) {
        //use set methods to init object
        $this->setId($id);
        $this->setFName($fname);
        $this->setLName($lname);
        $this->setGender($gender);
        $this->setdateOfBirth($dateOfBirth);
        $this->setEmail($email);
        $this->setAddress($address);
        $this->setphoneNumber($phoneNumber);
        $this->setUsername($username);
        $this->setPassword($password);
    }
    /////getters & setters
    function getId() {
        return $this->id;
    }
    function setId($id) {
        $this->id = $id;
    }
    function getFName() {
        return $this->fname;
    }
    function setFName($fname) {
        $this->fname = $fname;
    }
    function getLName() {
        return $this->lname;
    }
    function setLName($lname) {
        $this->lname = $lname;
    }
    function getGender() {
        return $this->gender;
    }
    function setGender($gender) {
        $this->gender = $gender;
    }
    function getdateOfBirth() {
        return $this->dateOfBirth;
    }
    function setdateOfBirth($dateOfBirth) {
        $this->dateOfBirth = $dateOfBirth;
    }
    function getEmail() {
        return $this->email;
    }
    function setEmail($email) {
        $this->email = $email;
    }
    function getphoneNumber() {
        return $this->phoneNumber;
    }
    function setphoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }
    function getAddress() {
        return $this->address;
    }
    function setAddress($address) {
        $this->address = $address;
    }
    function getUserName() {
        return $this->username;
    }
    function setUsername($username) {
        $this->username = $username;
    }
    function getPassword() {
        return $this->password;
    }
    function setPassword($password) {
        $this->password = $password;
    }
}
?>
