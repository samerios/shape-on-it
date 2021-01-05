<?php /*include header file*/
include "header.php";
//require_once ('../classes/ShapeOnIt.php');


//call "updateLessonsStatus" function for update lssons status not active if bag tokef
updateLessonsStatus();


?>

<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
<body >



<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>


  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
  </header>


  <!-- show number of new subscription by "getSubscriptions" function-->
  <a href="subsConfirmOrNot.php"><div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>
            <?php
if (getSubscriptions("not active") == null ) echo '0';
else echo count((array)getSubscriptions("not active"));;
?>
          </h3>
        </div>
        <div class="w3-clear"></div>
        <h4>new Subscriptions registers</h4>
      </div>
    </div>
  </a>

  <!-- show number of new Ordes From Users by "getNumberOfNewOrdesFromUsers" function-->
     <a href="UsersOrders.php"><div class="w3-quarter">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-diamond w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>   
            <?php try {
    if (getNumberOfNewOrdesFromUsers() == 0) echo '0';
    else {
        echo getNumberOfNewOrdesFromUsers();
    }
}
catch(Exception $e) {
}
?>
            </h3>
          
        </div>
        <div class="w3-clear"></div>
        <h4>New Users Orders</h4>
      </div>
    </div>
  </a>

  <!-- show number of instrument Need To Check by "instrumentNeedToCheck" function-->
    <a href="Instruments.php"><div class="w3-quarter">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo instrumentNeedToCheck(); ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Instrument need to Check</h4>
      </div>
    </div>
  </a>

  <!-- show number of trainers Sign in For Lesson by "SigninForLessonDetails" function-->
     <a href="lessonRegisters.php"><div class="w3-quarter">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>
            <?php
if ((getSigninForLessonDetails('pending')) == null) echo '0';
else echo count((array)getSigninForLessonDetails('pending'));
?>

          </h3>
        </div>
        <div class="w3-clear"></div>
        <h4>users signs for lessons</h4>
      </div>
    </div>
  </div>
</a>







  <div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">
     
      <div class="w3-twothird">
        <h5>Feeds</h5>
        <table class="w3-table w3-striped w3-white">
          <tr>
            <td><i class="fa fa-user w3-text-blue w3-large"></i></td>
            <td>New record, over 90 views.</td>
            <td><i>10 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-bell w3-text-red w3-large"></i></td>
            <td>Database error.</td>
            <td><i>15 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-users w3-text-yellow w3-large"></i></td>
            <td>New record, over 40 users.</td>
            <td><i>17 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-comment w3-text-red w3-large"></i></td>
            <td>New comments.</td>
            <td><i>25 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-bookmark w3-text-blue w3-large"></i></td>
            <td>Check transactions.</td>
            <td><i>28 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-laptop w3-text-red w3-large"></i></td>
            <td>CPU overload.</td>
            <td><i>35 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-share-alt w3-text-green w3-large"></i></td>
            <td>New shares.</td>
            <td><i>39 mins</i></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <hr>


</body>
</html>



 <?php /*include footer file*/
include "footer.php"; ?>
    