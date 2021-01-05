<?php /*include header file*/
include "header.php";
?>
<br/>

<?php
//after check all inputs if clicked "save"
if (isset($_POST['save'])) {
    //get inputs and save into varibels
    $name = @$_POST['name'];
    $difficulty = @$_POST['difficulty'];
    $rehearsals = @$_POST['rehearsals'];
    $sets = @$_POST['sets'];
    $bodyPart = @$_POST['bodyPart'];
    $rest = @$_POST['rest'];
    $speed = @$_POST['speed'];
    $load = @$_POST['load'];
    $description = @$_POST['description'];
    //get upload image and save in 'img/exercises' directory name of page is name of item
    $info = pathinfo($_FILES['image']['name']);
    $ext = $info['extension']; // get the extension of the file
    $img = "$name." . $ext;
    $target = 'img/exercises/' . $img;
    move_uploaded_file($_FILES['image']['tmp_name'], $target);
    //call "newExercise" function for add exercise in system
    newExercise($name, $difficulty, $rehearsals, $sets, $bodyPart, $rest, $speed, $load, $description, $img);
    //refresh
    echo '<meta http-equiv="refresh" content="2; url=\'exerciseDetails.php\'" />';
}
//if clicked "back" button return to 'exerciseDetails' page
if (isset($_POST['back'])) echo '<meta http-equiv="refresh" content="0; url=\'exerciseDetails.php\'" />';
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
<h2 align="center">Add New Exercise</h2>

    
<!--form-->
<div align="center">
 <div id="form" style="width: 450px;">
  <form  action="" method="post" enctype="multipart/form-data" >
    <div class="w2ui-page page-0">
        <div class="w2ui-field" align="left">
            <label>Exercise Name:</label>
            <div>
                <input name="name" type="text" minlength=5 maxlength="50" size="48"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Difficulty:</label>
            <div>
                <input name="difficulty" type="text" minlength=5 maxlength="15" size="48"/>
            </div>
        </div>
        <div class="w2ui-field" align="left">
            <label>Rehearsals:</label>
            <div>
                <input name="rehearsals" type="text" minlength=3 maxlength="15" size="48"/>
            </div>
        </div>
        
        <div class="w2ui-field" align="left">
            <label>Sets:</label>
            <div>
                <input name="sets" type="text" minlength=1 maxlength="2" size="48" />
                
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Body Part:</label>
            <div>
                <input name="bodyPart"  type="text" minlength=3 maxlength="20" size="48" />
                
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Rest:</label>
            <div>
                <input name="rest" type="text" minlength=3 maxlength="20" size="48" />
                
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Speed:</label>
            <div>
                <input name="speed" type="text" minlength=3 maxlength="20" size="48" />
                
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Load:</label>
            <div>
                <input name="load" type="text" minlength=3 maxlength="20" size="48" />
                
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Image:</label>
            <div>
                <input name="image" type='file' size="48" />
                
            </div>
        </div>
        
            
       <div class="w2ui-field" align="left">
            <label>Description:</label>
            <div>
                <textarea name="description" type="text" style="width: 290px; height: 80px; resize: none"></textarea>
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
            { field: 'name', type: 'text', required: true },
            { field: 'difficulty', type: 'text', required: true },
            { field: 'rehearsals', type: 'text', required: true },
            { field: 'sets', type: 'text', required: true },
            { field: 'bodyPart', type: 'text', required: true },
            { field: 'rest', type: 'text', required: true },
            { field: 'speed', type: 'text', required: true },
            { field: 'load', type: 'text', required: true },
            { field: 'description', type: 'text', required: true },
            { field: 'image', required: true}

        ],
        actions: {
            reset: function () {
                this.clear();
            },
            
            save: function (e) {
                this.save();
                 //check all inputs data is not empty and valid
                 if(this.record.name!="" && this.record.difficulty!="" && this.record.rehearsals!="" && this.record.sets!="" && this.record.bodyPart!="" && this.record.rest!="" && this.record.speed!="" && this.record.load!="" && this.record.description!="" && this.record.image!="")
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