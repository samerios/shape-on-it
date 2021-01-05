<?php
//"ShapeOnIt" class
//include all classes files to use
require_once('Lesson.php');
require_once('Room.php');
require_once('Orders.php');
require_once('WorkPlan.php');
require_once('User.php');
require_once('supplier.php');
require_once('Admin.php');
require_once('Staff.php');
require_once('Trainer.php');
require_once('Item.php');
require_once('Exercise.php');
require_once('LessonType.php');
require_once('UserInLesson.php');
require_once('Instrument.php');


//connect to database
include "../inc/db.php";

$connect = new mysqli('localhost','shapeonitsystem','H6qvFVRUYAnSLVtP','shapeonit');

if ($connect -> connect_errno) {
  echo "Failed to connect to MySQL: " . $connect -> connect_error;
  exit();
}




class ShapeOnIt {


}
?>
