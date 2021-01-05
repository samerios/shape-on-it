<?php /*include header file*/
include "header.php";
?>
<br/>
<?php
//after check all inputs if clicked "save"
if (isset($_POST['save'])) {
    //get inputs and save into varibels
    $name = @$_POST['name'];
    $duration = @$_POST['duration'];
    $price = @$_POST['price'];
    $description = @$_POST['description'];
    //call "newSusbcriptionType" function for add Susbcription Type in system and show message
    newSusbcriptionType($name, $price, $duration, $description);
    echo '<script> w2alert("susbcription type add successfully");</script>';
    echo '<meta http-equiv="refresh" content="2; url=\'subscriptionTypes.php\'" />';
}
//if clicked "back" button return to 'subscriptionTypes' page
if (isset($_POST['back'])) echo '<meta http-equiv="refresh" content="0; url=\'subscriptionTypes.php\'" />';
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
<h2 align="center">Add New Lesson Type</h2>
    
<!--form-->
<div align="center">
 <div id="form" style="width: 450px;">
  <form  action="" method="post" >
    <div class="w2ui-page page-0">

        <div class="w2ui-field" align="left">
            <label>Name:</label>
            <div>
                <input name="name" type="text" minlength=5 maxlength="15" size="48"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Price:</label>
            <div>
                <input name="price" type="int" minlength=1 maxlength="6" size="48"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Duration (Days):</label>
            <div>
                <input name="duration" type="text" minlength=1 maxlength="5" size="48"/>
            </div>
        </div>
        <div class="w2ui-field" align="left">
            <label>Description:</label>
            <div>
                <textarea name="description" type="text" minlength=10 maxlength="255" style="width: 290px; height: 80px; resize: none"></textarea>
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
            { field: 'name', type: 'text', required: true },
            { field: 'duration', type: 'int', required: true },
            { field: 'description', type: 'text', required: true },
            { field: 'price', type: 'int', required: true }

        ],
        actions: {
            reset: function () {
                this.clear();
            },
            
            save: function (e) {
                this.save();
                 //check all inputs data is not empty and valid
                 if(this.record.name!=""  && this.record.duration!="" && this.record.price!="" && this.record.description!="")
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