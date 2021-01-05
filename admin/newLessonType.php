<?php /*include header file*/
include "header.php";
?>
<br/>

<?php
//after check all inputs if clicked "save"
if (isset($_POST['save'])) {
    //get inputs and save into varibels
    $type = @$_POST['type'];
    $difficutly = @$_POST['difficutly'];
    $durationTime = @$_POST['durationTime'];
    //call "newItem" function for add lesson type in system and show message
    newLessonType($type, $difficutly, $durationTime);
    echo '<script> w2alert("Lesson Type add succesfully");</script>';
    echo '<meta http-equiv="refresh" content="2; url=\'lessonTypeDetails.php\'" />';
}
//if clicked "back" button return to 'lessonTypeDetails' page
if (isset($_POST['back'])) echo '<meta http-equiv="refresh" content="2; url=\'lessonTypeDetails.php\'" />';
?>
<!DOCTYPE html>
<html>
<head>
    <title>New Item</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
      <script type="text/javascript" src="css/w2ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/w2ui-1.5.rc1.min"/>
</head>   
<body >

<!--hedaer-->
<h2 align="center">Add New Lesson Type</h2> 

<!--form-->
<div align="center">
 <div id="form" style="width: 450px;">
  <form  action="" method="post" >
    <div class="w2ui-page page-0">

        <div class="w2ui-field" align="left">
            <label>Type:</label>
            <div>
                <input name="type" type="text" minlength=5 maxlength="50" size="48"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Difficulty:</label>
            <div>
                <input name="difficutly" type="text" minlength=4 maxlength="12" size="48"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Duration Time:</label>
            <div>
                <input name="durationTime" type="text" minlength=5 maxlength="6" size="48"/>
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
            { field: 'type', type: 'text', required: true },
            { field: 'difficutly', type: 'text', required: true },
            { field: 'durationTime', type: 'text', required: true }

        ],
        actions: {
            reset: function () {
                this.clear();
            },
            
            save: function (e) {
                this.save();
                //check all inputs data is not empty and valid
                 if(this.record.type!="" && this.record.durationTime!="" && this.record.difficutly!="")
                {}
                //if one or more inputs empty show toasts you need to fill the input  
                    else
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