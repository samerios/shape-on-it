<?php 
//include all functions from "function" file and the classes will be use in user GUI
include "../inc/function.php";
require_once('../classes/Item.php');
require_once('../classes/Orders.php');
//start session to get "userid" id and username by use the "checkStatus" function to check if the session active

    session_start();
    if(checkStatus($_SESSION['id']))
    {
                //save the username and id in variabels

       @$user =$_SESSION['username'];
       @$id =$_SESSION['id'];
    }
        //if session not active(user logout) go to index page (system login page)

    if(!isset($_SESSION['id']))  
      header("Location: ../index.php");
 ?>


<!DOCTYPE html>
<html>
<head>
	<title>Shape On It</title>
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
  <a href="Items.php">Products</a>
  <a href="staffWorkSchedule.php">Watch work schedule</a>
  <a href="subsDetails.php">Subscriptions Details</a>
  <a href="cart.php"><i class="fa" style="font-size:24px">&#xf07a;</i>
  <span class='badge badge-warning' id='lblCartCount'> 
  <?php if(isset($_SESSION["cart"])) echo count($_SESSION["cart"]); else echo 0;?> </span></a>
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

  <!-- Css settings-->

  <style type="text/css">
    
    a {
  position: relative;
  text-decoration: none;
  color: green;
}
  </style>
  <!-- show welcome message with username-->

	<div>Welcome :<?php echo $user; ?>
   </div>

   <!-- css cart icon-->
<style type="text/css">
  .badge {
  padding-left: 9px;
  padding-right: 9px;
  -webkit-border-radius: 9px;
  -moz-border-radius: 9px;
  border-radius: 9px;
}

.label-warning[href],
.badge-warning[href] {
  background-color: #c67605;
}
#lblCartCount {
    font-size: 12px;
    background: #ff0000;
    color: #fff;
    padding: 0 5px;
    vertical-align: top;
    margin-left: -10px; 
}
</style>




