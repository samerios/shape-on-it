<!DOCTYPE html>
<html>
<head>
    <title>Shape On It</title>
    <meta charset="utf-8" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
      <script type="text/javascript" src="css/w2ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/w2ui-1.5.rc1.min"/>
</head>

<script type="text/javascript">
//get time function
function startTime()
{
var today=new Date();
var h=today.getHours();
var m=today.getMinutes();
var s=today.getSeconds();
// add a zero in front of numbers<10
m=checkTime(m);
s=checkTime(s);
document.getElementById('txt').innerHTML=h+":"+m+":"+s;
t=setTimeout('startTime()',500);
}

function checkTime(i)
{
if (i<10)
  {
  i="0" + i;
  }
return i;
}
</script>


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


<body  class="bg" onload="startTime()">
<font font face="verdana" size="3" color="white"><div id="txt" align=" center"></div>




<div align="center">
		<div>
		 <h1><font font face="verdana" size="5" color="white">Welcome To Shape On It System</font></h1>
		</div>
</div>

<div align="center">
<div>
	<a href="index.php"><img src="img/loginPhoto.jpeg" width="450px" height="150spx"/></a>
</div>
</div>

<div align="center">
 	<form id="loginform" method="post" style="width: 450px" >
    <div class="w2ui-page page-0">
        <div class="w2ui-field">
            <label>Username:</label>
            <div>
                <input name="username" type="text" maxlength="15"  size="40"/>
            </div>
        </div>
        <div class="w2ui-field">
            <label>Password:</label>
            <div>
                <input name="password" type="password" maxlength="15"  size="40"/>
            </div>
        </div>
    </div>

    <div class="w2ui-buttons">
        <button class="w2ui-btn w2ui-btn-green" name="save">Login</button>
        <button class="w2ui-btn w2ui-btn-orange" name="forgetPass" >Forgot Password?</button>
        <button class="w2ui-btn w2ui-btn-blue" name="subscription">Subscribe</button>
		<button class="w2ui-btn w2ui-btn-red" name="register" >Register</button>
    </div>
      </form>
</div>


<script type="text/javascript">
//form setting
$(function () {
    $('#loginform').w2form({
        name  : 'loginform',
        header : 'Shape On It',
        fields: [
            { field: 'username', type: 'text', required: true},
			{ field: 'password', type: 'password', required: true }

        ],
        actions: {
            
			save: function (e) {
				this.save(); 
                if(this.record.username!="" && this.record.password!="")
                {}
                	else
                	//if one or more inputs empty show toasts you need to fill the input                   
                e.preventDefault();

            }
        },

    });


});
</script>





<?php
//include all functions from function file 
include "inc/db.php";
include "inc/function.php";
//get inputs and save into varibels
$user = @$_POST['username'];
$pass = @$_POST['password'];
//after check all inputs if clicked "login" button check if user admin or staff or trainer or normal user and then send the data from inputs to login function for check and if data are correct then go to appropriate "ok" page  with username and userid to start appropriate GUI ("ok" page show Loading message and go to index page depented user type)
if (isset($_POST['save'])) {
    session_start();
    $_SESSION['username'] = $user;
    if (login($user, $pass, 'admin') != 0) {
        $result = login($user, $pass, 'admin');
        $_SESSION['id'] = $result;
        header("Location: admin/ok.php");
    } else if (login($user, $pass, 'user') != 0) {
        $result = login($user, $pass, 'user');
        $_SESSION['id'] = $result;
        header("Location: user/ok.php");
    } else if (login($user, $pass, 'trainer') != 0) {
        //Write to Log File "Login" date and time for control login and logout
        $date = new DateTime("now", new DateTimeZone('Asia/Tel_Aviv'));
        $log = "Login Trainer: " . $_SERVER['REMOTE_ADDR'] . ' - ' . $date->format('Y-m-d H:i:s') . PHP_EOL . "User: " . $user . PHP_EOL . "-------------------------" . PHP_EOL;
        file_put_contents('trainersLoginLogout.log', $log, FILE_APPEND | LOCK_EX);
        $result = login($user, $pass, 'trainer');
        $_SESSION['id'] = $result;
        header("Location: trainer/ok.php");
    } else if (login($user, $pass, 'staff') != 0) {
        $result = login($user, $pass, 'staff');
        $_SESSION['id'] = $result;
        header("Location: staff/ok.php");
    } else
    //if incorrect data send user to subscription page
    header("Location: subscription.php");
}
//if clicked "register" button go to register page
if (isset($_POST['register'])) header("Location: register.php");
//if clicked "subscribe" button go to subscription page
if (isset($_POST['subscription'])) header("Location: subscription.php");
//if clicked "forgot password?" button go to forgotpassword page
if (isset($_POST['forgetPass'])) header("Location: forgotpassword.php");

?>

<div align="center" class="copyRight">
    <font font face="verdana" size="2" color="white">
	Shape On It  &copy; 2020
</div>

</body>
</html>