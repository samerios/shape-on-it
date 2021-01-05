<?php
//"Staff" class
//include "User" file to extends 'User' class
require_once ('User.php');
class Staff extends User {
    //class variables
    var $empNumber;
    var $startWork;
    var $endWork;
    var $role;
    var $perHour;
    
    //contructor
    public function __construct($id, $fname, $lname, $gender, $dateOfBirth, $email, $address, $phoneNumber, $username, $password, $empNumber, $startWork, $endWork, $role, $perHour) {
        //send variables to paent class 'User'
        parent::__construct($id, $fname, $lname, $gender, $dateOfBirth, $email, $address, $phoneNumber, $username, $password);
        //use set methods to init object
        $this->setEmpNumber($empNumber);
        $this->setStartWork($startWork);
        $this->setEndWork($endWork);
        $this->setRole($role);
        $this->setPerHour($perHour);
    }
    /////getters & setters
    function getEmpNumber() {
        return $this->empNumber;
    }
    function setEmpNumber($empNumber) {
        $this->empNumber = $empNumber;
    }
    function getStartWork() {
        return $this->startWork;
    }
    function setStartWork($startWork) {
        $this->startWork = $startWork;
    }
    function getEndWork() {
        return $this->endWork;
    }
    function setEndWork($endWork) {
        $this->endWork = $endWork;
    }
    function getRole() {
        return $this->role;
    }
    function setRole($role) {
        $this->role = $role;
    }
    function getPerhour() {
        return $this->perHour;
    }
    function setPerHour($perHour) {
        $this->perHour = $perHour;
    }
}
?>
