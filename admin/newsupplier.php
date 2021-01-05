<?php /*include header file*/
include "header.php";
?>
<br/>
<?php
//after check all inputs if clicked "save"
if (isset($_POST['save'])) {
    //get inputs and save into varibels
    $fullname = @$_POST['fullname'];
    $email = @$_POST['email'];
    $phonenumber = @$_POST['phonenumber'];
    //call "newSupplier" function for add Supplier in system and show message
    newSupplier($fullname, $email, $phonenumber);
    echo '<meta http-equiv="refresh" content="1; url=\'Suppliers.php\'" />';
}
//if clicked "back" button return to 'Suppliers' page
if (isset($_POST['back'])) echo '<meta http-equiv="refresh" content="0; url=\'Suppliers.php\'" />';
?>
<!DOCTYPE html>
<html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
      <script type="text/javascript" src="css/w2ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/w2ui-1.5.rc1.min"/>
</head> 
<body >

<!--hedaer-->
<h2 align="center">Add New Supplier</h2>

    
<!--form-->
<div align="center">
 <div id="form" style="width: 450px;">
  <form  action="" method="post" >
    <div class="w2ui-page page-0">
        <div class="w2ui-field" align="left">
            <label>Full Name:</label>
            <div>
                <input name="fullname" type="text" minlength=4 maxlength="30" size="48"/>
            </div>
        </div>
        <div class="w2ui-field" align="left">
            <label>Email:</label>
            <div>
                <input name="email" name="email" type="email" minlength=10 maxlength="255" size="48" placeholder="example@example.com"/>
            </div>
        </div>
        <div class="w2ui-field" align="left">
            <label>Phone Number:</label>
            <div>
                <input name="phonenumber" type="text" minlength=8 maxlength="10" size="48"/>
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
//form setting                     
$(function () {
    $('#form').w2form({ 
        name     : 'form',
        url      : 'server/post',
        fields: [
            { field: 'fullname', type: 'text', required: true },
            { field: 'email', type: 'email', required: true },
            { field: 'phonenumber', type: 'text', required: true }

        ],
        actions: {
            reset: function () {
                this.clear();
            },
            
            save: function (e) {
                this.save();
                 //check all inputs data is not empty and valid                
                if(this.record.fullname!="" && this.record.email!="" && this.record.phonenumber!="" )
                {}
                    else
            //if one or more inputs empty show toasts you need to fill the input                                               
                e.preventDefault();
            }
        }
    });
});
</script>

</body>
</html>


<?php /*include footer file*/
include "footer.php"; ?>