<?php
//"Lesson" class
//include "LessonType" file to use LessonType class
require_once ('LessonType.php');
//include "User" file to use User class
require_once ('User.php');
//include "Room" file to use Room class
require_once ('Room.php');
//include "ShapeOnIt" file to use ShapeOnIt class
require_once ('ShapeOnIt.php');
//include "Instrument" file to use Instrument class
require_once ('Instrument.php');

class Lesson {
    //class variables
    var $lessonNumber;
    var $maxTrainers;
    var $startDate;
    var $day;
    var $hour;
    var $registers;
    var $status;
    public $LessonType;
    public $User;
    public $Room;
    public $ShapeOnIt;
    public $Instrument = array();

    //contructor
    public function __construct($lessonNumber, $maxTrainers, $startDate, $day, $hour, $registers, $status) {
        //use set methods to init object
        $this->setLessonNumber($lessonNumber);
        $this->setMaxTrainers($maxTrainers);
        $this->setStartDate($startDate);
        $this->setDay($day);
        $this->setHour($hour);
        $this->setRegisters($registers);
        $this->setStatus($status);
    }
    /////getters & setters
    function getLessonNumber() {
        return $this->lessonNumber;
    }
    function setLessonNumber($lessonNumber) {
        $this->lessonNumber = $lessonNumber;
    }
    function getMaxTrainers() {
        return $this->maxTrainers;
    }
    function setMaxTrainers($maxTrainers) {
        $this->maxTrainers = $maxTrainers;
    }
    function getStartDate() {
        return $this->startDate;
    }
    function setStartDate($startDate) {
        $this->startDate = $startDate;
    }
    function getDay() {
        return $this->day;
    }
    function setDay($day) {
        $this->day = $day;
    }
    function getHour() {
        return $this->hour;
    }
    function setHour($hour) {
        $this->hour = $hour;
    }
    function getRegisters() {
        return $this->registers;
    }
    function setRegisters($registers) {
        $this->registers = $registers;
    }
    function getStatus() {
        return $this->status;
    }
    function setStatus($status) {
        $this->status = $status;
    }
}
?>
