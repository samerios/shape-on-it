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
$address = @$_POST['address'];
$gender = @$_POST['gender'];
$phone_number = @$_POST['phone_number'];
$dob = @$_POST['date_of_birth'];
$weight = @$_POST['weight'];
$height = @$_POST['height'];
$fat = @$_POST['fat'];
$type = @$_POST['type'];
$sportHabits = @$_POST['sportHabits'];
$medical_problems = @$_POST['medical_problems'];
$question = @$_POST['security'];
$answer = @$_POST['answer'];
$dateNow = getdate(date("U"));
$subdate = "$dateNow[year]-$dateNow[mon]-$dateNow[mday]";
//after all check inputs if clicked "next" button start session for get them in the next page (Payment) to complete the subscribe
if (isset($_POST['next'])) {
    //start session and save all inputs data in variabels
    session_start();
    $_SESSION['firstname'] = $firstname;
    $_SESSION['lastname'] = $lastname;
    $_SESSION['gender'] = $gender;
    $_SESSION['dob'] = $dob;
    $_SESSION['address'] = $address;
    $_SESSION['email'] = $email;
    $_SESSION['phone_number'] = $phone_number;
    $_SESSION['type'] = $type;
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    $_SESSION['subdate'] = $subdate;
    $_SESSION['height'] = $height;
    $_SESSION['weight'] = $weight;
    $_SESSION['fat'] = $fat;
    $_SESSION['sportHabits'] = $sportHabits;
    $_SESSION['medical_problems'] = $medical_problems;
    $_SESSION['security'] = $question;
    $_SESSION['answer'] = $answer;
    //go to payment page to complete the subscribe
    header("Location: payment.php");
}
//if clicked "back" button return to 'index' page
if (isset($_POST['back'])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Shape On It</title>
    <meta charset="utf-8" />
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
      <script type="text/javascript" src="css/w2ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/w2ui-1.5.rc1.min"/>
</head>

    
<!--Header-->
<h2 align="center"><font font face="verdana" size="5" color="white">Shape On It | Subscribtion</h2>

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
<script type="text/javascript">

    //get all subscription types (3 weeks,6 weeks,1 month..etc) from "getSusbcriptionTypDetails" function
         var types=[];
         try{
        <?php
        //get all Susbcription Type Details details by "getSusbcriptionTypDetails" function
$types = getSusbcriptionTypDetails();
$count = count((array)getSusbcriptionTypDetails());
?>
        var lenght=<?php echo $count; ?>;
        //check if array lenght is positive
        if(lenght>=1)
        {
           //convet data from php to javascript and save them into "types" list with sort
          var subscribstions = [];
          var subscribstions = <?php echo json_encode($types); ?>;
           //add to "types" list
           for(var i=0;i<lenght;i++)
           {
               types.push(subscribstions[i].name);  
           }  

        } 
    }catch(e)
    {

    }

if(lenght>0)
{
   types.sort();
$('input[type=list]').w2field('list', { items: types });
}


//save 'yes and no' options into "yesNo" list
var yesNo=[];
yesNo.push('yes'); 
yesNo.push('no'); 


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
        header : 'subscription Form',
        fields: [
            { field: 'username', type: 'text', required: true },
            { field: 'password', type: 'password', required: true, },
            { field: 'confimpassword', type: 'password', required: true },
            { field: 'firstname', type: 'text', required: true },
            { field: 'lastname', type: 'text', required: true },
            { field: 'email', type: 'email', required: true },
            { field: 'gender', type: 'radio', required: true},
            { field: 'address', type: 'text', required: true },
            { field: 'phone_number', type: 'int', required: true},
            { field: 'date_of_birth', type: 'date', required: true},
            { field: 'security', type: 'list',options: {items : secureQuestions}, required: true },
            { field: 'answer', type: 'text', required: true }, 
            { field: 'weight', type: 'float', required: true},
            { field: 'height', type: 'float', required: true},
            { field: 'fat', type: 'float', required: true},
            { field: 'type', type: 'list',  options: {items : types}, required: true},
            { field: 'sportHabits', type: 'list',  options: {items : yesNo}, required: true},
            { field: 'medical_problems', type: 'list',  options: {items : yesNo}, required: true}
        ],

        actions: {
            reset: function () {
                this.clear();
            },
              next: function (e) {
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
                if(this.record.username!="" && this.record.password!="" && this.record.confimpassword!="" && this.record.firstname!="" &&  this.record.lastname!=""  && this.record.email!=""  && this.record.gender!=""  && this.record.address!=""  && this.record.phone_number!=""  && this.record.date_of_birth!=""  && this.record.weight!=""  && this.record.height!=""  && this.record.fat!=""  && this.record.type!="" && this.record.password==this.record.confimpassword && (this.record.weight>=50&&this.record.weight<=350) &&(this.record.height>=140&&this.record.height<=220) && (this.record.fat>=5&&this.record.fat<=80) &&isUserExist==0 && isEmailExist==0 && record.this.sportHabits!="" && record.this.medical_problems!="" && this.record.security!="" 
                    && this.record.answer!="")
                {

                }
                    //if one or more inputs empty show toasts you need to fill the input 
                    else
                    {
                       e.preventDefault();
                       if(this.record.password!=this.record.confimpassword)
                       {
                        w2ui['form'].record['confimpassword'] = ''; 
                        w2ui['form'].refresh();
                       }
                       if(!(this.record.weight>=50&&this.record.weight<=350))
                       {
                        w2ui['form'].record['weight'] = ''; 
                        w2ui['form'].refresh();
                       }
                        if(!(this.record.height>=140&&this.record.height<=220))
                       {
                        w2ui['form'].record['height'] = ''; 
                        w2ui['form'].refresh();
                       }
                       if(!(this.record.fat>=5&&this.record.fat<=80))
                       {
                        w2ui['form'].record['fat'] = ''; 
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
            

        }
    });

});

</script>



    
<!--form-->
<div align="center">
 <form id="form" method="post" style="width: 450px;">
    <div class="w2ui-page page-0">
        <div class="w2ui-field" align="left">
            <label>User Name:</label>
            <div>
                <input name="username" type="text" maxlength="15" minlength=8 size="40"/>
            </div>
        </div>
        <div class="w2ui-field" align="left">
            <label>Password:</label>
            <div>
                <input name="password" type="password" maxlength="15" minlength=8 size="40"/>
            </div>
        </div>
        <div class="w2ui-field" align="left">
            <label>Confirm Password:</label>
            <div>
                <input name="confimpassword" type="password" maxlength="15" minlength=8 size="40"/>
            </div>
        </div>
        <div class="w2ui-field" align="left">
            <label>First Name:</label>
            <div>
                <input name="firstname" type="text" maxlength="20" minlength=2 size="40"/>
            </div>
        </div>
        <div class="w2ui-field" align="left">
            <label>Last Name:</label>
            <div>
                <input name="lastname" type="text" maxlength="20" minlength=2 size="40"/>
            </div>
        </div>
        
        <div class="w2ui-field" align="left">
            <label>Email:</label>
            <div>
                <input name="email" type="email" maxlength="35" size="40" placeholder="example@example.com"/>
            </div>
            
        </div>

        <div class="w2ui-field" align="left">
            <label>Address:</label>
            <div>
                <input name="address" type="text" maxlength="35" minlength=12 size="40" placeholder="city,zip,street"/>
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
                <input name="phone_number" type= "text" maxlength="10" minlength=10 size="40"/>
            </div>
        </div>
        
        <div class="w2ui-field" align="left">
            <label>Date Of Birth:</label>
            <div>
                <input name="date_of_birth"/>
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


        <div class="w2ui-field" align="left"   size="40">
            <label>Weight(kg):</label>
            <div>
                <input name="weight" type= "double" maxlength="3" minlength=2 placeholder="100"/>
            </div>
        </div>
        <div class="w2ui-field" align="left" >
            <label>Height(cm):</label>
            <div>
                <input name="height" type= "double" maxlength="3" minlength=3 size="40" placeholder="165"/>
            </div>
        </div>
        <div class="w2ui-field" align="left" >
            <label>Fat (%):</label>
            <div>
                <input name="fat" type= "double" maxlength="2" minlength=1 size="40" placeholder="15"/>
            </div>
        </div>

        <div class="w2ui-field" align="left" >
            <label>sport Habits?:</label>
            <div>
                <input name="sportHabits" size="40" />
            </div>
        </div>

        <div class="w2ui-field" align="left" >
            <label>medical problems?:</label>
            <div>
                <input name="medical_problems" size="40" />
            </div>
        </div>

        <div class="w2ui-field" align="left" type= "double" size="40">
            <label>Subscription Tpye:</label>
            <div>
                <input name="type" />
            </div>
        </div>

        

    </div>

    <div class="w2ui-buttons">
        <button class="w2ui-btn" name="back">Back</button>
        <button class="w2ui-btn" name="reset">Reset</button>
        <button class="w2ui-btn" name="next">Next</button>

    </div>
  </form>
</div>

<div align="center" class="copyRight"><font font face="verdana" size="2" color="white">
        Shape On It  &copy; 2020
</div>

</body>
</html>
