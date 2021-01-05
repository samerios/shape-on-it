<?php
//"Trainer" class
//include "User" file to extends 'User' class
require_once ('User.php');
class Trainer extends User {
    //class variables
    var $subscriptionType;
    var $subscriptionStartDate;
    var $subscriptionEndtDate;
    var $status;
    var $height;
    var $weight;
    var $fat;
    var $sportHabits;
    var $medicalProblems;
    //contructor
    public function __construct($id, $fname, $lname, $gender, $dateOfBirth, $email, $address, $phoneNumber, $username, $password, $subscriptionType, $subscriptionStartDate, $subscriptionEndtDate, $status, $height, $weight, $fat, $sportHabits, $medicalProblems) {
        //send variables to paent class 'User'
        parent::__construct($id, $fname, $lname, $gender, $dateOfBirth, $email, $address, $phoneNumber, $username, $password);
        //use set methods to init object
        $this->setSubscriptionType($subscriptionType);
        $this->setSubscriptionStartDate($subscriptionStartDate);
        $this->setSubscriptionEndtDate($subscriptionEndtDate);
        $this->setStatus($status);
        $this->setHeight($height);
        $this->setWeight($weight);
        $this->setFat($fat);
        $this->setSportHabits($sportHabits);
        $this->setMedicalProblems($medicalProblems);
    }
    /////getters & setters
    function getSubscriptionType() {
        return $this->subscriptionType;
    }
    function setSubscriptionType($subscriptionType) {
        $this->subscriptionType = $subscriptionType;
    }
    function getSubscriptionStartDate() {
        return $this->subscriptionStartDate;
    }
    function setSubscriptionStartDate($subscriptionStartDate) {
        $this->subscriptionStartDate = $subscriptionStartDate;
    }
    function getSubscriptionEndtDate() {
        return $this->subscriptionEndtDate;
    }
    function setSubscriptionEndtDate($subscriptionEndtDate) {
        $this->subscriptionEndtDate = $subscriptionEndtDate;
    }
    function getStatus() {
        return $this->status;
    }
    function setStatus($status) {
        $this->status = $status;
    }
    function getHeight() {
        return $this->height;
    }
    function setHeight($height) {
        $this->height = $height;
    }
    function getWeight() {
        return $this->weight;
    }
    function setWeight($weight) {
        $this->weight = $weight;
    }
    function getFat() {
        return $this->fat;
    }
    function setFat($fat) {
        $this->fat = $fat;
    }
    function getSportHabits() {
        return $this->sportHabits;
    }
    function setSportHabits($sportHabits) {
        $this->sportHabits = $sportHabits;
    }
    function getMedicalProblems() {
        return $this->medicalProblems;
    }
    function setMedicalProblems($medicalProblems) {
        $this->medicalProblems = $medicalProblems;
    }

    
}
?>
