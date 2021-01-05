<!--Only trainers or normal users can update password admin and staff can update password in "Admin Gui" -->

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
      <script type="text/javascript" src="css/w2ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/w2ui-1.5.rc1.min"/>
</head>


<!--Header-->
<h2 align="center"><font font face="verdana" size="5" color="white"> Shape On It | Forgot Password?</h2>

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
<!--Form-->
<div align="center">
 <div id="form" style="width: 550px;">
  <form  action="" method="post" >
    <div class="w2ui-page page-0">

        <div class="w2ui-field" align="left">
            <label>Username:</label>
            <div>
                <input name="username" type="text" maxlength="15" size="48"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Email:</label>
            <div>
                <input name="email" type="text" maxlength="35" size="48"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Security Question:</label>
            <div>
                <input name="security" type="text" maxlength="2" size="48"/>
            </div>
        </div>

         <div class="w2ui-field" align="left">
            <label>Answer:</label>
            <div>
                <input name="answer" type="text" maxlength="30" size="48"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>New Password:</label>
            <div>
                <input name="newPass" type="text" minlength=8 maxlength="15" size="48"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Confirm Password:</label>
            <div>
                <input name="confirmNewPass" type="text" minlength=8 maxlength="15" size="48"/>
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

<body>

<script type="text/javascript">

////save 'security questions' options into "secureQuestions" list
var secureQuestions=[];
 secureQuestions.push('What is the first name of your favourite uncle?'); 
 secureQuestions.push('Where did you meet yout spouse?'); 
 secureQuestions.push('What is your eldest cousins name?'); 
 secureQuestions.push('What is youngest childs nickname?'); 
 secureQuestions.push('What is the first name of your eldest niece?'); 
 secureQuestions.push('What is the first name of your eldest nephew?'); 
 secureQuestions.push('What is the first name of your favourite aunt?'); 
 secureQuestions.push('Where did you spend your honey moon?'); 



//form setting 
$(function () {
    $('#form').w2form({ 
        name     : 'form',
        url      : 'server/post',
        fields: [
            { field: 'username', type: 'text', required: true },
            { field: 'email', type: 'email', required: true },
            { field: 'security', type: 'list',options: {items : secureQuestions}, required: true },
            { field: 'answer', type: 'text', required: true },
            { field: 'newPass', type: 'text', required: true },
            { field: 'confirmNewPass', type: 'text', required: true }

        ],
        actions: {
            reset: function () {
                this.clear();
            },
            
            save: function (e) {
                this.save();
                //check all inputs data is not empty and valid 
                 if(this.record.username!="" && this.record.email!="" && this.record.security!="" 
                    && this.record.answer!="" && this.record.newPass!="" && this.record.confirmNewPass!="")
                {}
                    else
                //if one or more inputs empty show toasts you need to fill the input 
                e.preventDefault();
            }
        }
    });
});
</script>



<?php
//include all functions from function file
include "inc/db.php";
include "inc/function.php";
//after all check inputs if clicked "save" button
if (isset($_POST['save'])) {
    //get inputs and save into varibels
    $username = @$_POST['username'];
    $email = @$_POST['email'];
    $newPassword = @$_POST['newPass'];
    $confirmPassword = @$_POST['confirmNewPass'];
    $question = @$_POST['security'];
    $answer = @$_POST['answer'];
    //check if email and user name exist in system by use 'getUsersNamesAndEmails' function
    $getUsers = getUsersNamesAndEmails();
    $valid = 0;
    for ($i = 0;$i < count((array)getUsersNamesAndEmails());$i++) {
        if ($username == $getUsers[$i]['username'] && $email == $getUsers[$i]['email']) {
            $valid = 1;
        }
    }
    //check if email and username that belong for question and answer in database
    $checkResult = checkForgotPasswordData($username, $email, $question, $answer);
    //if all input data and check input data (email and username and question and answer) are valid and exist in system
    if ($valid && $checkResult) {
        //send inputs data to 'setNewPassword' function to update the new password
        if (setNewPassword($newPassword, $username, $email)) {
            //show success message and return to index page
            echo '<script> w2alert("Your password changed succesfuly");</script>';
            echo '<meta http-equiv="refresh" content="2; url=\'index.php\'" />';
        }
        //if any exception or error in database show system message
        else {
            echo '<script> w2alert("System error try again later!");</script>';
        }
    }
    //if email or username inputs incorrect show message
    else {
        echo '<script> w2alert("incorrect data!");</script>';
    }
}
//if clicked "back" button return to 'index' page
if (isset($_POST['back'])) {
    echo '<meta http-equiv="refresh" content="0; url=\'index.php\'" />';
}
?>

<div align="center" ><font font face="verdana" size="2" color="white">
    Shape On It  &copy; 2020
</div>

</body>
</html>