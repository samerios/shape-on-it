<?php
//"Exercise" class
//include "Instrument" file to use Instrument class
require_once ('Instrument.php');
//include "WorkPlan" file to use WorkPlan class
require_once ('WorkPlan.php');

class Exercise {
    //class variables
    var $id;
    var $name;
    var $difficulty;
    var $rehearsals; 
    var $sets;
    var $bodyPart;
    var $rest;
    var $speed;
    var $load;
    var $description;
    var $image;
    public $Instrument = array();
    public $WorkPlan;

    //contructor
    public function __construct($id, $name, $difficulty, $rehearsals, $sets, $bodyPart, $rest, $speed, $load, $description, $image) {
        //use set methods to init object
        $this->setId($id);
        $this->setName($name);
        $this->setdifficulty($difficulty);
        $this->setRehearsals($rehearsals);
        $this->setSets($sets);
        $this->setBodyPart($bodyPart);
        $this->setRest($rest);
        $this->setSpeed($speed);
        $this->setLoad($load);
        $this->setDescription($description);
        $this->setImage($image);
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
    function getdifficulty() {
        return $this->name;
    }
    function setdifficulty($difficulty) {
        $this->difficulty = $difficulty;
    }
    function getRehearsals() {
        return $this->rehearsals;
    }
    function setRehearsals($rehearsals) {
        $this->rehearsals = $rehearsals;
    }
    function getSets() {
        return $this->sets;
    }
    function setSets($sets) {
        $this->sets = $sets;
    }
    function getBodyPart() {
        return $this->bodyPart;
    }
    function setBodyPart($bodyPart) {
        $this->bodyPart = $bodyPart;
    }
    function getRest() {
        return $this->rest;
    }
    function setRest($rest) {
        $this->rest = $rest;
    }
    function getSpeed() {
        return $this->speed;
    }
    function setSpeed($speed) {
        $this->speed = $speed;
    }
    function getLoad() {
        return $this->load;
    }
    function setLoad($load) {
        $this->load = $load;
    }
    function getDescription() {
        return $this->description;
    }
    function setDescription($description) {
        $this->description = $description;
    }
    function getImage() {
        return $this->image;
    }
    function setImage($image) {
        $this->image = $image;
    }
  
}
?>
