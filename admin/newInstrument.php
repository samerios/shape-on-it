<?php /*include header file*/
include "header.php";
?>
<br/>
<?php
//after check all inputs if clicked "save"
if (isset($_POST['save'])) {
    //get inputs and save into varibels
    $name = @$_POST['namee'];
    $number = @$_POST['numberr'];
    $buydate = @$_POST['buydate'];
    //get upload image and save in 'img/instruments' directory name of page is name of instrument
    $info = pathinfo($_FILES['image']['name']);
    $ext = $info['extension']; // get the extension of the file
    $img = "$name." . $ext;
    $target = 'img/instruments/' . $img;
    move_uploaded_file($_FILES['image']['tmp_name'], $target);
    //call "newInstrumenet" function for add instrument in system
    newInstrumenet($name, $number, $buydate, $img);
    echo '<meta http-equiv="refresh" content="2; url=\'Instruments.php\'" />';
}
//if clicked "back" button return to 'Instruments' page
if (isset($_POST['back'])) echo '<meta http-equiv="refresh" content="0; url=\'Instruments.php\'" />';
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
<h2 align="center">Add New Instrument</h2>
    
<!--form-->
<div align="center">
 <div id="form" style="width: 450px;">
  <form  action="" method="post" enctype="multipart/form-data" >
    <div class="w2ui-page page-0">

          <div class="w2ui-field" align="left">
            <label>Name:</label>
            <div>
                <input name="namee" type="text" minlength=5 maxlength="50" size="48"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Instrument Number:</label>
            <div>
                <input name="numberr" type="text" minlength=5 maxlength="50" maxlength="15" size="48"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Buy Date:</label>
            <div>
                <input name="buydate" size="48"/>
            </div>
        </div>
        
        <div class="w2ui-field" align="left">
            <label>Image:</label>
            <div>
                <input name="image" type='file' size="48" />
                
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
            { field: 'namee', type: 'text', required: true },
            { field: 'numberr', type: 'text', required: true },
            { field: 'buydate', type: 'date', required: true },
            { field: 'image', required: true}

        ],
        actions: {
            reset: function () {
                this.clear();
            },
            //check all inputs data is not empty and valid
            save: function (e) {
                this.save();
                 if(this.record.numberr!="" && this.record.buydate!="" && this.record.image!=""&& this.record.namee!="" )
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