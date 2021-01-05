<!DOCTYPE html>
<html>
<head>
    <title>payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="css/w2ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/w2ui-1.5.rc1.min"/>
</head>
<body></body>
</html>


<?php
//include all functions from function file
include "inc/db.php";
include "inc/function.php";
//check if is session start (get input data from subscription page to complete subscripe) and if there are exception return to subscription page
try {
    session_start();
    if (isset($_SESSION['firstname'])) $firstname = $_SESSION['firstname'];
    if (isset($_SESSION['lastname'])) $lastname = $_SESSION['lastname'];
    if (isset($_SESSION['gender'])) $gender = $_SESSION['gender'];
    if (isset($_SESSION['dob'])) $dob = $_SESSION['dob'];
    if (isset($_SESSION['address'])) $address = $_SESSION['address'];
    if (isset($_SESSION['email'])) $email = $_SESSION['email'];
    if (isset($_SESSION['phone_number'])) $phone_number = $_SESSION['phone_number'];
    if (isset($_SESSION['type'])) $type = $_SESSION['type'];
    if (isset($_SESSION['username'])) $username = $_SESSION['username'];
    if (isset($_SESSION['password'])) $password = $_SESSION['password'];
    if (isset($_SESSION['subdate'])) $subdate = $_SESSION['subdate'];
    if (isset($_SESSION['height'])) $height = $_SESSION['height'];
    if (isset($_SESSION['weight'])) $weight = $_SESSION['weight'];
    if (isset($_SESSION['fat'])) $fat = $_SESSION['fat'];
    if (isset($_SESSION['sportHabits'])) $sportHabits = $_SESSION['sportHabits'];
    if (isset($_SESSION['medical_problems'])) $medical_problems = $_SESSION['medical_problems'];
    if (isset($_SESSION['security'])) $security = $_SESSION['security'];
    if (isset($_SESSION['answer'])) $answer = $_SESSION['answer'];


//if clicked "back" button return to 'subscription' page
if (isset($_POST['back'])) {
    header("Location: subscription.php");
}
//after all check inputs if clicked "save" button send the inputs data to "subscription" function to add user as "trainer" to database and add payment inputs to database but the trainer status is not active while the admin is confirm the the subscripe request
if (isset($_POST['save'])) {
    $nameoncard = @$_POST['nameoncard'];
    $cardnumber = @$_POST['cardnumber'];
    $expmonth = @$_POST['expmonth'];
    $expyear = @$_POST['expyear'];
    $cvv = @$_POST['cvv'];
    //subscription function
    subscription($firstname, $lastname, $gender, $address, $phone_number, $dob, $email, $username, $password, $type, $subdate, "not active", $weight, $height, $fat, $nameoncard, $cardnumber, $expmonth, $expyear, $cvv, $sportHabits, $medical_problems, $security, $answer);
    //unset (cancel) all sessions
    unset($_SESSION['firstname']);
    unset($_SESSION['lastname']);
    unset($_SESSION['gender']);
    unset($_SESSION['dob']);
    unset($_SESSION['address']);
    unset($_SESSION['email']);
    unset($_SESSION['phone_number']);
    unset($_SESSION['type']);
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['subdate']);
    unset($_SESSION['height']);
    unset($_SESSION['weight']);
    unset($_SESSION['fat']);
    unset($_SESSION['sportHabits']);
    unset($_SESSION['medical_problems']);
    unset($_SESSION['security']);
    unset($_SESSION['answer']);
    //success message and return to index page
    echo '<script> w2alert("Thank you for registered your details are check by admin and in 24 hours you will be registered fixed and you can login");</script>';
    echo '<meta http-equiv="refresh" content="2; url=\'index.php\'" />';
}




}catch(Exception $e) {
    header("Location: subscription.php");
  }
?>


<!DOCTYPE html>
<html>
<head>
    <title>payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="css/w2ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/w2ui-1.5.rc1.min"/>
</head>

<!--Header-->
<h2 align="center"><font font face="verdana" size="5" color="white">Shape On It | Payment</h2>

<style type="text/css">
body, html {
  height: 100%;
}
.bg {
  /* The image used */
  background-image: url("img/headdd.jpg");

  /* Full height */
  height: 100%;

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}
</style>


<body  class="bg" >

<!--css setting-->

<style>
body {
  font-family: Arial;
  font-size: 17px;
  padding: 8px;
}

* {
  box-sizing: border-box;
}

.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 75%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

.container {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}

input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

a {
  color: #2196F3;
}

hr {
  border: 1px solid lightgrey;
}


/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
  .row {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}
</style>


<!--Header-->
<div align="center">
    <div>
     <h4>'Shape On It System' | subscription payment Form:</h4>
    </div>
</div>
  
<!--Form-->
<div align="center">
 <div id="form" style="width: 450px;">
  <form  action="" method="post" >
    <div class="w2ui-page page-0">
        <div class="w2ui-field" align="left">

             <h3>Payment</h3>
            <label> <font color="red"> <?php
try {
    //check if selected type from subscription page is not empty to get the price
    if (!empty($type)) {
        //get price from 'getSubscriptionTypePrice' function by send type variable (1 week,1 month..etc)
        //and print in the form
        $price = getSubscriptionTypePrice($type);
        echo filter_var($price, FILTER_SANITIZE_NUMBER_INT), "$ To pay";
    }
}
catch(Exception $e) {
}
?> </font></label>
            <label for="fname">Accepted Cards  </label>
            <div class="icon-container">
              <i class="fa fa-cc-visa" style="color:navy;"></i>
              <i class="fa fa-cc-amex" style="color:blue;"></i>
              <i class="fa fa-cc-mastercard" style="color:red;"></i>
              <i class="fa fa-cc-discover" style="color:orange;"></i>
            </div>
        </div>

        <div class="w2ui-field" align="left">
          <label for="fname"><i class="fa fa-user"></i> Name on card</label>
            <div>
                <input name="nameoncard" type="text" maxlength="20" size="40" placeholder="john michael"/>
            </div>
        </div>
    
    <div class="w2ui-field" align="left">
            <label>Card Number:</label>
            <div>
                <input name="cardnumber" type="text" maxlength="20" size="20" placeholder="xxxx-xxxx-xxxx-xxxx"/>
            </div>
        </div>
    <div class="w2ui-field" align="left">
            <label>Exp month:</label>
            <div>
                <input name="expmonth" type="text" maxlength="10" size="40" placeholder="october"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Exp year:</label>
            <div>
                <input name="expyear" type="text" maxlength="4" size="40" placeholder="2019"/>
            </div>
        </div>
    
      <div class="w2ui-field" align="left">
            <label>cvv:</label>
            <div>
                <input name="cvv" type="int" maxlength="3" size="40" placeholder="357"/>
            </div>
      
        </div>
     
    
    </div>

    <div class="w2ui-buttons"> 
        <button class="w2ui-btn" name="back">Back</button>      
        <button class="w2ui-btn" name="reset">Reset</button>
        <button class="w2ui-btn w2ui-btn-blue" name="save">Save</button>

    </div>
   </form>
  </div>
</div>

</head>
<body>

<script type="text/javascript">
//form setting  
$(function () {
    $('#form').w2form({ 
        name     : 'form',
        url      : 'server/post',
        fields: [
            { field: 'nameoncard', type: 'text', required: true },
            { field: 'cardnumber', type: 'text', required: true },
            { field: 'expmonth', type: 'text', required: true },
            { field: 'expyear', type: 'int', required: true },
            { field: 'cvv',type:'int',required: true} 

        ],
        actions: {
            reset: function () {
                this.clear();
            },
      
          save: function (e) {
                this.save();
            //check all inputs data is not empty and valid 
                if(this.record.nameoncard!="" && this.record.cardnumber!="" && this.record.expmonth!="" && this.record.expyear!="" &&  this.record.cvv!="" )
                {
                }
                //if one or more inputs empty show toasts you need to fill the input   
                else
                {
                  e.preventDefault();
                }

            }
        }
    });
});
</script>

<div align="center" class="copyRight"><font font face="verdana" size="2" color="white">
      Shape On It  &copy; 2020
    </div>
