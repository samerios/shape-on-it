<?php
//"LessonType" class
//include "Lesson" file to use Lesson class
require_once ('Lesson.php');
class LessonType {
    //class variables
    var $type;
    var $difficulty;
    var $durationTime;
    public $Lesson = array();
    //contructor
    public function __construct($type, $difficulty, $durationTime) {
        //use set methods to init object
        $this->setType($type);
        $this->setDifficulty($difficulty);
        $this->setDuratinTime($durationTime);
    }
    /////getters & setters
    function getType() {
        return $this->type;
    }
    function setType($type) {
        $this->type = $type;
    }
    function getDifficulty() {
        return $this->difficulty;
    }
    function setDifficulty($difficulty) {
        $this->difficulty = $difficulty;
    }
    function getDurationTime() {
        return $this->durationTime;
    }
    function setDuratinTime($durationTime) {
        $this->durationTime = $durationTime;
    }
}
?>
