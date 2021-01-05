<?php
//"Instrument" class
//include "Lesson" file to use Lesson class
require_once ('Lesson.php');
//include "Exercise" file to use Exercise class
require_once ('Exercise.php');
class Instrument {
    //class variables
    var $id;
    var $number;
    var $name;
    var $buyDate;
    var $lastCheckDate;
    var $testDate;
    var $image;
    public $Lesson = array();
    public $Exercise;
    //contructor
    public function __construct($id, $number, $name, $buyDate, $lastCheckDate, $testDate, $image) {
        //use set methods to init object
        $this->setId($id);
        $this->setNumber($number);
        $this->setName($name);
        $this->setBuydate($buyDate);
        $this->setLasCheckDate($lastCheckDate);
        $this->setTestDate($testDate);
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
    function getNumber() {
        return $this->number;
    }
    function setNumber($number) {
        $this->number = $number;
    }
    function getBuydate() {
        return $this->buyDate;
    }
    function setBuydate($buyDate) {
        $this->buyDate = $buyDate;
    }
    function getLastCheckDate() {
        return $this->lastCheckDate;
    }
    function setLasCheckDate($lastCheckDate) {
        $this->lastCheckDate = $lastCheckDate;
    }
    function getTestDate() {
        return $this->testDate;
    }
    function setTestDate($testDate) {
        $this->testDate = $testDate;
    }
    function getImage() {
        return $this->image;
    }
    function setImage($image) {
        $this->image = $image;
    }
}
?>
