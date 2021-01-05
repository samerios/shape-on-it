<?php /*include header file*/
include "header.php";
?>
<br/>
<?php
//after check all inputs if clicked "save"
if (isset($_POST['save'])) {
    //get inputs and save into varibels
    $name = @$_POST['name'];
    $adjustment = @$_POST['adjustment'];
    $firstMeal = @$_POST['firstMeal'];
    $secondMeal = @$_POST['secondMeal'];
    $thirdMeal = @$_POST['thirdMeal'];
    $fourthMeal = @$_POST['fourthMeal'];
    $fifthMeal = @$_POST['fifthMeal'];
    $description = @$_POST['description'];
    //call "newMenu" function for add menu in system and show message
    newMenu($name, $adjustment, $firstMeal, $secondMeal, $thirdMeal, $fourthMeal, $fifthMeal, $description);
    echo '<meta http-equiv="refresh" content="2; url=\'menuDetails.php\'" />';
}
//if clicked "back" button return to 'menuDetails' page
if (isset($_POST['back'])) echo '<meta http-equiv="refresh" content="0; url=\'menuDetails.php\'" />';
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
<h2 align="center">Add New Menu</h2>
    
<!--form-->
<div align="center">
 <div id="form" style="width: 450px;">
  <form  action="" method="post" enctype="multipart/form-data" >
    <div class="w2ui-page page-0">
        <div class="w2ui-field" align="left">
            <label>Menu Name:</label>
            <div>
                <input name="name" type="text" minlength=15 maxlength="255" size="48"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Adjustment:</label>
            <div>
                 <input name="adjustment" type="text" minlength=8 maxlength="20" size="48"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>First Meal:</label>
            <div>
               <textarea name="firstMeal" type="text" minlength=15 maxlength="255" style="width: 290px; height: 80px; resize: none"></textarea>
            </div>
        </div>
        
        <div class="w2ui-field" align="left">
            <label>Second Meal:</label>
            <div>
               <textarea name="secondMeal" type="text" minlength=15 maxlength="255" style="width: 290px; height: 80px; resize: none"></textarea>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Third Meal:</label>
            <div>
               <textarea name="thirdMeal" type="text" minlength=15 maxlength="255" style="width: 290px; height: 80px; resize: none"></textarea>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Fourth Meal:</label>
            <div>
               <textarea name="fourthMeal" type="text" minlength=15 maxlength="255" style="width: 290px; height: 80px; resize: none"></textarea>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Fifth Meal:</label>
            <div>
               <textarea name="fifthMeal" type="text" minlength=15 maxlength="255" style="width: 290px; height: 80px; resize: none"></textarea>
            </div>
        </div>
        
            
       <div class="w2ui-field" align="left">
            <label>Description:</label>
            <div>
                <textarea name="description" type="text" minlength=15 maxlength="255" style="width: 290px; height: 80px; resize: none"></textarea>
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
            { field: 'adjustment', type: 'text', required: true },
            { field: 'firstMeal', type: 'text', required: true },
            { field: 'secondMeal', type: 'text', required: true },
            { field: 'thirdMeal', type: 'text', required: true },
            { field: 'fourthMeal', type: 'text' },
            { field: 'fifthMeal', type: 'text' },
            { field: 'description', type: 'text',required: true }

        ],
        actions: {
            reset: function () {
                this.clear();
            },
            
            save: function (e) {
                this.save();
                 //check all inputs data is not empty and valid
                 if(this.record.name!="" && this.record.adjustment!="" && this.record.firstMeal!="" && this.record.secondMeal!="" && this.record.thirdMeal!=""
                 && this.record.description!="" )
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