<?php /*include header file*/
include "header.php";
?>
<br/>
<?php
//after check all inputs if clicked "save"
if (isset($_POST['save'])) {
    //get inputs and save into varibels
    $name = @$_POST['itemName'];
    $price = @$_POST['price'];
    $quantity = @$_POST['quantity'];
    $description = @$_POST['description'];
    //get upload image and save in 'img/proteins' directory name of page is name of protein
    $info = pathinfo($_FILES['image']['name']);
    $ext = $info['extension']; // get the extension of the file
    $img = "$name." . $ext;
    $target = 'img/proteins/' . $img;
    move_uploaded_file($_FILES['image']['tmp_name'], $target);
    //call "newItem" function for add protein in system
    newItem($name, $price, $quantity, $img, $description);
    echo '<meta http-equiv="refresh" content="2; url=\'Itemss.php\'" />';
}
//if clicked "back" button return to 'Itemss' page
if (isset($_POST['back'])) echo '<meta http-equiv="refresh" content="0; url=\'Itemss.php\'" />';
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
<h2 align="center">Add New Item</h2>

    
<!--form-->
<div align="center">
 <div id="form" style="width: 450px;">
  <form  action="" method="post" enctype="multipart/form-data" >
    <div class="w2ui-page page-0">
        <div class="w2ui-field" align="left">
            <label>Item Name:</label>
            <div>
                <input name="itemName" type="text" minlength=5 maxlength="50" size="48"/>
            </div>
        </div>
        <div class="w2ui-field" align="left">
            <label>Price:</label>
            <div>
                <input name="price" type="text" minlength=1 maxlength="6" size="48"/>
            </div>
        </div>
        <div class="w2ui-field" align="left">
            <label>Quantity:</label>
            <div>
                <input name="quantity" type="text" minlength=1 maxlength="6" size="48"/>
            </div>
        </div>
        <div class="w2ui-field" align="left">
            <label>Description:</label>
            <div>
                <textarea name="description" type="text" minlength=10 maxlength="512" style="width: 290px; height: 80px; resize: none"></textarea>
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
        url      : 'server/post',
        fields: [
            { field: 'itemName', type: 'text', required: true },
            { field: 'price', type: 'text', required: true },
            { field: 'quantity', type: 'text', required: true },
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
                 if(this.record.itemName!="" && this.record.price!="" && this.record.quantity!="" && this.record.description!="" && this.record.image!="")
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