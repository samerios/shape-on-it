<?php /*include header file*/
include "header.php";
?>
<?php
//after check all inputs if clicked "save"
if (isset($_POST['save'])) {
    $roomtype = @$_POST['roomtype'];
    $maxnumoftrainers = @$_POST['maxnumoftrainers'];
    //call "newRoom" function for add room details in system and show message
    newRoom($roomtype, $maxnumoftrainers);
    echo '<script> w2alert("room Type add succesfully");</script>';
    echo '<meta http-equiv="refresh" content="2; url=\'roomsDetails.php\'" />';
}
//if clicked "back" button return to 'roomsDetails' page
if (isset($_POST['back'])) echo '<meta http-equiv="refresh" content="0; url=\'roomsDetails.php\'" />';
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
<h2 align="center">Add New Room</h2>

    
<!--form-->
<div align="center">
 <div id="form" style="width: 550px;">
  <form  action="" method="post" >
    <div class="w2ui-page page-0">

        <div class="w2ui-field" align="left">
            <label>Room Type:</label>
            <div>
                <input name="roomtype" type="text" minlength=2 maxlength="20" size="48"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Max Trainers:</label>
            <div>
                <input name="maxnumoftrainers" type="text" minlength=1 maxlength="6" size="48"/>
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
        fields: [
            { field: 'roomtype', type: 'text', required: true },
            { field: 'maxnumoftrainers', type: 'int', required: true }

        ],
        actions: {
            reset: function () {
                this.clear();
            },
            
            save: function (e) {
                this.save();
                 //check all inputs data is not empty and valid
                 if(this.record.roomtype!="" && this.record.maxnumoftrainers!="" )
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