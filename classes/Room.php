<?php
//"Room" class
//include "Lesson" file to use Lesson class
require_once ('Lesson.php');
//include "ShapeOnIt" file to use ShapeOnIt class
require_once ('ShapeOnIt.php');
class Room {
    //class variables
    var $roomNumber;
    var $maxNumberOfTrainers;
    var $roomType;
    public $Lesson = array();
    public $ShapeOnIt;
    
    //contructor
    public function __construct($roomNumber, $maxNumberOfTrainers, $roomType) {
        //use set methods to init object
        $this->setRoomNumber($roomNumber);
        $this->setMaxNumberOfTrainers($maxNumberOfTrainers);
        $this->setRoomType($roomType);
    }
    /////getters & setters
    function getRoomNumber() {
        return $this->roomNumber;
    }
    function setRoomNumber($roomNumber) {
        $this->roomNumber = $roomNumber;
    }
    function getMaxNumberOfTrainers() {
        return $this->maxNumberOfTrainers;
    }
    function setMaxNumberOfTrainers($maxNumberOfTrainers) {
        $this->maxNumberOfTrainers = $maxNumberOfTrainers;
    }
    function getRoomType() {
        return $this->roomType;
    }
    function setRoomType($roomType) {
        $this->roomType = $roomType;
    }
}
?>
