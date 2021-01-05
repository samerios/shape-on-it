<?php
//"Menu" class
//include "WorkPlan" file to use WorkPlan class
require_once ('WorkPlan.php');
class Menu {
    //class variables
    var $idMenu;
    var $name;
    var $adjustment;
    var $firstMeal;
    var $secondMeal;
    var $thirdMeal;
    var $fourthMeal;
    var $fifthMeal;
    var $description;
    public $WorkPlan = array();
    
    //contructor
    public function __construct($idMenu, $name, $adjustment, $firstMeal, $secondMeal, $thirdMeal, $fourthMeal, $fifthMeal, $description) {
        //use set methods to init object
        $this->setMenueId($idMenu);
        $this->setName($name);
        $this->setAdjustment($adjustment);
        $this->setFirstMeal($firstMeal);
        $this->setSecondMeal($secondMeal);
        $this->setThirdMeal($thirdMeal);
        $this->setFourthMeal($fourthMeal);
        $this->setFifthMeal($fifthMeal);
        $this->setDescription($description);
    }
    /////getters & setters
    function getMenueId() {
        return $this->idMenu;
    }
    function setMenueId($idMenu) {
        $this->idMenu = $idMenu;
    }
    function getName() {
        return $this->name;
    }
    function setName($name) {
        $this->name = $name;
    }
    function getAdjustment() {
        return $this->adjustment;
    }
    function setAdjustment($adjustment) {
        $this->adjustment = $adjustment;
    }
    function getFirstMeal() {
        return $this->firstMeal;
    }
    function setFirstMeal($firstMeal) {
        $this->firstMeal = $firstMeal;
    }
    function getSecondMeal() {
        return $this->secondMeal;
    }
    function setSecondMeal($secondMeal) {
        $this->secondMeal = $secondMeal;
    }
    function getThirdMeal() {
        return $this->thirdMeal;
    }
    function setThirdMeal($thirdMeal) {
        $this->thirdMeal = $thirdMeal;
    }
    function getFourthMeal() {
        return $this->fourthMeal;
    }
    function setFourthMeal($fourthMeal) {
        $this->fourthMeal = $fourthMeal;
    }
    function getFifthMeal() {
        return $this->fifthMeal;
    }
    function setFifthMeal($fifthMeal) {
        $this->fifthMeal = $fifthMeal;
    }
    function getDescription() {
        return $this->description;
    }
    function setDescription($description) {
        $this->description = $description;
    }
}
?>
