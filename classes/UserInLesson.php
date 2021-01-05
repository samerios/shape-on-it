<?php
//"UserInLesson" class
//include "User" file to use User class
require_once ('User.php');
require_once ('Lesson.php');
class UserInLesson {
    //class variables
    var $registertime;
    var $status;
    public $user;
    public $lesson;
    //contructor
    public function __construct($registertime, $status) {
        //use set methods to init object
        $this->setRegisterTime($registertime);
        $this->setStatus($status);
     
        
    }
    /////getters & setters
    function getRegisterTime() {
        return $this->registertime;
    }
    function setRegisterTime($registertime) {
        $this->registertime = $registertime;
    }
    function getStatus() {
        return $this->status;
    }
    function setStatus($status) {
        $this->status = $status;
    }
    public function setLesson($lesson) {
        $this->lesson = $lesson;
    }
    public function getLesson() {
        return $this->lesson;
    }
    public function setUser($user) {
        $this->user = $user;
    }
    public function getUser() {
        return $this->user;
    }
}
?>