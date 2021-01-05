<?php
//"WorkPlan" class
//include "Menu" file to use Menu class
require_once ('Menu.php');
//include "User" file to use User class
require_once ('User.php');
//include "ShapeOnIt" file to use ShapeOnIt class
require_once ('ShapeOnIt.php');
//include "Exercise" file to use Exercise class
require_once ('Exercise.php');
class WorkPlan {
    //class variables
    var $id;
    var $name;
    var $about;
    var $duration;
    var $goal;
    var $requierments;
    var $targetGroup;
    public $Menu;
    public $User = array();
    public $ShapeOnIt;
    public $Exercise = array();
    //contructor
    public function __construct($id, $name, $about, $duration, $goal, $requierments, $targetGroup) {
        //use set methods to init object
        $this->setId($id);
        $this->setName($name);
        $this->setAbout($about);
        $this->setDuration($duration);
        $this->setGoal($goal);
        $this->setRequierments($requierments);
        $this->setTargetGroup($targetGroup);
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
    function getAbout() {
        return $this->about;
    }
    function setAbout($about) {
        $this->about = $about;
    }
    function getDuration() {
        return $this->duration;
    }
    function setDuration($duration) {
        $this->duration = $duration;
    }
    function getGoal() {
        return $this->goal;
    }
    function setGoal($goal) {
        $this->goal = $goal;
    }
    function getRequierments() {
        return $this->requierments;
    }
    function setRequierments($requierments) {
        $this->requierments = $requierments;
    }
    function getTargetGroup() {
        return $this->targetGroup;
    }
    function setTargetGroup($targetGroup) {
        $this->targetGroup = $targetGroup;
    }
}
?>
