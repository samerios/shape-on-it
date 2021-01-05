<?php /*include header file*/
include "header.php";
?>
<br/>
<?php
//after check all inputs if clicked "save"
if (isset($_POST['save'])) {
    //get inputs and save into varibels
    $number = @$_POST['number'];
    $fnamme = @$_POST['firstname'];
    $lname = @$_POST['lastname'];
    $dob = @$_POST['dob'];
    $gender = @$_POST['gender'];
    $address = @$_POST['address'];
    $email = @$_POST['email'];
    $phone_number = @$_POST['phonenumber'];
    $username = @$_POST['username'];
    $password = @$_POST['password'];
    $confimpassword = @$_POST['confimpassword'];
    //get date now
    $d = $mydate = getdate(date("U"));
    $startDate = "$mydate[year]-$mydate[mon]-$mydate[mday]";
    //call "newAdmin" function for add admin in system
    newAdmin($number, $fnamme, $lname, $gender, $dob, $email, $phone_number, $address, $username, $password, $startDate);
    //refresh
    echo '<meta http-equiv="refresh" content="2; url=\'index.php\'" />';
}
//if clicked "back" button return to 'adminDetails' page
if (isset($_POST['back']))  header("Location: adminDetails.php");

?>
<!DOCTYPE html>
<html>
<head>
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
      <script type="text/javascript" src="css/w2ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/w2ui-1.5.rc1.min"/>
<body >


<!--hedaer-->
<h2 align="center">Admin Register</h2>

<!--form-->
<div align="center">
 <div id="form" style="width: 450px;">
  <form  action="" method="post" >
    <div class="w2ui-page page-0">

        <div class="w2ui-field" align="left">
            <label>Admin Number:</label>
            <div>
                <input name="number" type="text" minlength=5 maxlength="15" size="40"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>User Name:</label>
            <div>
                <input name="username" type="text" minlength=8 maxlength="15" size="40"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Password:</label>
            <div>
                <input name="password" type="password" minlength=8 maxlength="15" size="40"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Confim Password:</label>
            <div>
                <input name="confimpassword" type="password" minlength=8 maxlength="15" size="40"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>First Name:</label>
            <div>
                <input name="firstname" type="text" minlength=2 maxlength="20" size="40"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Last Name:</label>
            <div>
                <input name="lastname" type="text" minlength=2 maxlength="20" size="40"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Address:</label>
            <div>
                <input name="address" type="text" minlength=8 maxlength="20" size="40"/>
            </div>
        </div>

         <div class="w2ui-field" align="left">
            <label>Phone Number:</label>
            <div>
                <input name="phonenumber"  minlength=10 maxlength="10" size="40"/>
            </div>
        </div>
      
        <div class="w2ui-field" align="left">
            <label>Email:</label>
            <div>
                <input name="email" type="email" maxlength="35" size="40"/>
            </div>
        </div>

         <div class="w2ui-field" align="left">
            <label>Dob:</label>
            <div>
                <input name="dob" size="40"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Gender:</label>
             <div>
                <input name="gender" type="radio" value="male"/>Male
                <input name="gender" type="radio" value="female"/>Female
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
        fields: [
            { field: 'number', type: 'text', required: true },
            { field: 'username', type: 'text', required: true },
            { field: 'password', type: 'password', required: true },
            { field: 'confimpassword', type: 'password', required: true },
            { field: 'firstname', type: 'text', required: true },
            { field: 'lastname', type: 'text', required: true },
            { field: 'address', type: 'text', required: true },
            { field: 'phonenumber', type: 'int', required: true},
            { field: 'email', type: 'email', required: true },
            { field: 'dob', type: 'date', required: true},
            { field: 'gender', type: 'radio', required: true}

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
                if( this.record.number && this.record.username!="" && this.record.password!="" && this.record.confimpassword!="" && this.record.firstname!="" &&  this.record.lastname!=""  && this.record.address!=""  && this.record.email!=""  && this.record.gender!=""  && this.record.phone_number!=""  && this.record.dob!="" && this.record.password==this.record.confimpassword &&isUserExist==0 && isEmailExist==0)
                {}
                //if one or more inputs empty show toasts you need to fill the input   
                    else
                    {
                         e.preventDefault();
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
        }
    });
});
</script>

</body>
</html>

 <?php /*include footer file*/
include "footer.php"; ?>
