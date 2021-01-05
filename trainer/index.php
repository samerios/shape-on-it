<?php /*include header file*/
include "header.php"; 

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
</head>
<body >


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>


  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
  </header>

  <!-- Contrainer to show left days to end trainer subscribe -->
  <a href="index.php"><div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
         <!-- get left days to end trainer subscribe from "getLeftDays" function-->
          <h3><?php echo $days=getLeftDays(@$id); ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Days left to end subscribe</h4>
      </div>
    </div>
  </a>



  <div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">
     

  <hr>


</body>
</html>

 <?php  /*include footer file*/ include "footer.php"; ?>
    