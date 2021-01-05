<?php include "../inc/function.php";
require_once('../classes/ShapeOnIt.php');

//start session to get "admin" id and username by use the "checkStatus" function to check if the session active
session_start();
if (checkStatus($_SESSION['id'])) {
    //save the username and id in variabels
    @$user = $_SESSION['username'];
    @$id = $_SESSION['id'];
}
//if session not active(user logout) go to index page (system login page)
if (!isset($_SESSION['id'])) header("Location: ../index.php");
?>


<!DOCTYPE html>
<html>
<head>
  <title>Shape On It | Admin</title>
  <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/w2ui-1.5.rc1.min"/>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="../css/w2ui.min.js"></script>




<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
}

.navbar {
  overflow: hidden;
  background-color: #333;
}

.navbar a {
  float: left;
  font-size: 16px;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.dropdown {
  float: left;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 16px;  
  border: none;
  outline: none;
  color: white;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.navbar a:hover, .dropdown:hover .dropbtn {
  background-color: red;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
  background-color: #ddd;
}

.dropdown:hover .dropdown-content {
  display: block;
}
</style>
</head>
<body>


   <!-- Dropdown--> 

<div class="navbar">
  <a href="adminDetails.php">Admins</a>
  <a href="Suppliers.php">Suppliers</a>
  <a href="Subscription.php">Trainers</a>
  <a href="StaffDetails.php">Staff</a>
  <a href="Customers.php">Customers</a>
  <a href="Lessons.php">Lessons & Rooms</a>
  <a href="UsersOrders.php">Users Orders</a>
  <a href="Instruments.php">Instruments</a>
  <a href="workPlans.php">Workplans</a>
  <a href="exerciseDetails.php">Exercises</a>


  <div class="dropdown">
    <button class="dropbtn">More 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="menuDetails.php">Menus</a>
      <a href="workSchedule.php">Work schedule</a>
      <a href="subscriptionTypes.php">Subscription types</a>
      <a href="ordersFromSuppliers.php">Suppliers Orders</a>
      <a href="AdjustingAworkPlanForATrainer.php">Trainers Adjusting</a>
      <a href="Itemss.php">Items</a>


    </div>
  </div> 
   <!-- Logout button--> 
<a href="logout.php">Logout</a>
</div>




<style>
* {
  padding:0;
  margin:0;
}

.post-thumbnail {
    display: block;
    max-height: 450px;
    overflow: hidden;
}
.post-thumbnail img {
    display: block;
    height: auto;
    width: 100%;
}
</style>

</head>
<body>



  <!-- Header Image-->
  <div class="post-thumbnail">
    <a href="index.php"><img src="../img/headerImg.JPG"/></a>
  </div>

    <!-- show welcome message with username -->
  <div><font color="red">Welcome Admin : <?php echo $user; ?></font></div>

  



