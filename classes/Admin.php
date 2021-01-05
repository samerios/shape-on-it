<?php
//"Admin" class
//include "User" file to extends 'User' class
require_once ('User.php');
class Admin extends User {
    //class variables
    var $adminNumber;
    var $seniority;
    var $startDate;
    //contructor
    public function __construct($id, $fname, $lname, $gender, $dateOfBirth, $email, $address, $phoneNumber, $username, $password, $adminNumber, $seniority, $startDate) {
        //send variables to paent class 'User'
        parent::__construct($id, $fname, $lname, $gender, $dateOfBirth, $email, $address, $phoneNumber, $username, $password);
        //use set methods to init object
        $this->setAdminNumber($adminNumber);
        $this->setSeniority($seniority);
        $this->setStartDate($startDate);
    }
    /////getters & setters
    function getAdminNumber() {
        return $this->adminNumber;
    }
    function setAdminNumber($adminNumber) {
        $this->adminNumber = $adminNumber;
    }
    function getSeniority() {
        return $this->seniority;
    }
    function setSeniority($seniority) {
        $this->seniority = $seniority;
    }
    function getStartdate() {
        return $this->startDate;
    }
    function setStartDate($startDate) {
        $this->startDate = $startDate;
    }

}
?>
