<?php
//include all functions from function file 
include "inc/db.php";
include "inc/function.php";
//get inputs and save into varibels
$username = @$_POST['username'];
$password = @$_POST['password'];
$confimpassword = @$_POST['confimpassword'];
$firstname = @$_POST['firstname'];
$lastname = @$_POST['lastname'];
$email = @$_POST['email'];
$gender = @$_POST['gender'];
$phone_number = @$_POST['phone_number'];
$address = @$_POST['address'];
$date_of_birth = @$_POST['date_of_birth'];
$question = @$_POST['security'];
$answer = @$_POST['answer'];
//after all check inputs if clicked "save" button send the inputs data to "register" function to add user as "normal user" to database
if (isset($_POST['save'])) {
    //register function
    register($firstname, $lastname, $gender, $date_of_birth, $email, $phone_number, $address, $username, $password, $question, $answer);
    //success message and return to index page
    echo '<script> w2alert("Thank you for registered you can login now!! good day :)");</script>';
    echo '<meta http-equiv="refresh" content="1; url=\'index.php\'" />';
}
//if clicked "back" button return to 'index' page
if (isset($_POST['back'])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <meta charset="utf-8" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
      <script type="text/javascript" src="css/w2ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/w2ui-1.5.rc1.min"/>
</head> 
<!--Header-->
<h2 align="center"><font font face="verdana" size="5" color="white">Shape On It | Register </h2>

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


<!--Header-->

<div align="center">
        <div>
         <h4>Shape On It System | Register:</h4>
        </div>
</div>

<!--form-->
<div align="center">
 <div id="form" style="width: 450px;">
  <form  action="" method="post" >
    <div class="w2ui-page page-0">
        <div class="w2ui-field" align="left">
            <label>User Name:</label>
            <div>
                <input name="username" type="text"  maxlength="15" minlength=8 size="40"/>
            </div>
        </div>
        <div class="w2ui-field" align="left">
            <label>Password:</label>
            <div>
                <input name="password" type="password"  maxlength="15" minlength=8 size="40"/>
            </div>
        </div>
        <div class="w2ui-field" align="left">
            <label>Confirm Password:</label>
            <div>
                <input name="confimpassword" type="password"  maxlength="15" minlength=8 size="40"/>
            </div>
        </div>
        <div class="w2ui-field" align="left">
            <label>First Name:</label>
            <div>
                <input name="firstname" type="text"  maxlength="15" minlength=2 size="40"/>
            </div>
        </div>
        <div class="w2ui-field" align="left">
            <label>Last Name:</label>
            <div>
                <input name="lastname" type="text"  maxlength="15" minlength=2 size="40"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Address:</label>
            <div>
                <input name="address" type="text"  maxlength="25" minlength=12 size="40" placeholder="city,zip,street"/>
            </div>
        </div>
        
        <div class="w2ui-field" align="left">
            <label>Email:</label>
            <div>
                <input name="email" type="email" maxlength="40" size="40" placeholder="example@example.com"/>
            </div>
            
        </div>
            <div class="w2ui-field" align="left">
            <label>Gender:</label>
            <div>
                <input name="gender" type="radio" value="male"/>Male
                <input name="gender" type="radio" value="female"/>Female
            </div>
        </div>
        
        <div class="w2ui-field" align="left">
            <label>Phone Number:</label>
            <div>
                <input name="phone_number" maxlength="10" minlength=9 size="40" type="int" />
            </div>
        </div>
        
        <div class="w2ui-field" align="left">
            <label>Date Of Birth:</label>
            <div>
                <input name="date_of_birth"  />
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
        
    </div>

    <div class="w2ui-buttons"> 
        <button class="w2ui-btn" name="back">Back</button>      
        <button class="w2ui-btn" name="reset">Reset</button>
        <button class="w2ui-btn w2ui-btn-blue" name="save">Save</button>

    </div>
   </form>
  </div>
</div>


<script type="text/javascript">
//add this security questions to list
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
            { field: 'password', type: 'password', required: true },
            { field: 'confimpassword', type: 'password', required: true },
            { field: 'firstname', type: 'text', required: true },
            { field: 'lastname', type: 'text', required: true },
            { field: 'address', type: 'text', required: true },
            { field: 'email', type: 'email', required: true },
            { field: 'gender', type: 'radio', required: true},
            { field: 'phone_number', type: 'int', required: true},
            { field: 'date_of_birth',type:'Date',required: true},
            { field: 'security', type: 'list',options: {items : secureQuestions}, required: true },
            { field: 'answer', type: 'text', required: true } 

        ],
        actions: {
            reset: function () {
                this.clear();
            },
            
            save: function (e) {
                this.save();
                //send username and email to function "getUsersNamesAndEmails" to check if  username or email are alrealy exsist in system 
                 var isUserExist=0;
                var isEmailExist=0;
                try{
                <?php
                $getUsers = getUsersNamesAndEmails();
                $numberOfUsers = count((array)getUsersNamesAndEmails());
                ?>
                var numberOfUsers=<?php echo $numberOfUsers; ?>;
                if(numberOfUsers>=1)
                {
                  var users = [];
                  var users = <?php echo json_encode($getUsers); ?>;
            
                    for(var i=0;i<numberOfUsers;i++)
                    {
                        if(this.record.username==users[i]['username'])
                         isUserExist=1; 
                        if(this.record.email==users[i]['email'])
                         isEmailExist=1; 
                    }  
                }
            }catch(e1){}
            //check all inputs data is not empty and valid 
                if(this.record.username!="" && this.record.password!="" && this.record.confimpassword!="" && this.record.firstname!="" &&  this.record.lastname!=""  && this.record.address!=""  && this.record.email!=""  && this.record.gender!=""  && this.record.phone_number!=""  && this.record.date_of_birth!="" && this.record.password==this.record.confimpassword &&isUserExist==0 && isEmailExist==0 && this.record.security!="" && this.record.answer!="")
                {}
            //if one or more inputs empty show toasts you need to fill the input   
                    else
                e.preventDefault();
            //check if this inputs are valid and if not valid show Appropriate message
                if(this.record.password!=this.record.confimpassword)
                {
                  w2ui['form'].record['confimpassword'] = ''; 
                        w2ui['form'].refresh();
                }
                if(isUserExist==1)
                {
                    w2ui['form'].record['username'] = ''; 
                    w2ui['form'].refresh();
                    w2alert('username alrealy in use select another one');
                }
                if(isEmailExist==1)
                {
                    w2ui['form'].record['email'] = ''; 
                    w2ui['form'].refresh();
                    w2alert('email alrealy in use select another one');
                }
            }
        }
    });
});
</script>

<div align="center" class="copyRight"><font font face="verdana" size="2" color="white">
            Shape On It  &copy; 2020
        </div>
</body>
</html>
