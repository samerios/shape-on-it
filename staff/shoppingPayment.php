<?php /*include header file*/
include "header.php"; ?>


<?php
//get inputs and save into varibels
$nameoncard = @$_POST['nameoncard'];
$cardnumber = @$_POST['cardnumber'];
$expmonth = @$_POST['expmonth'];
$expyear = @$_POST['expyear'];
$cvv = @$_POST['cvv'];
//if clicked "back" button return to 'Items' page
if (isset($_POST['back'])) {
    header("Location:Items.php");
}
//after all check inputs if clicked "save" button send the inputs data to "updatePaymentDetails" function to update normal user payment details database
if (isset($_POST['save'])) {
    updatePaymentDetails(@$id, @$user, 'staff', $nameoncard, $cardnumber, $expmonth, $expyear, $cvv);
    echo '<script> w2alert("payment details updated successfully you can pay now");</script>';
    echo '<meta http-equiv="refresh" content="2; url=\'cart.php\'" />';
}
?>


  

<!DOCTYPE html>
<html>
<head>
    <title>payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="css/w2ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/w2ui-1.5.rc1.min"/>

  
  <body>

<!--css setting-->


<style>
body {
  font-family: Arial;
  font-size: 17px;
  padding: 8px;
}

* {
  box-sizing: border-box;
}

.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 75%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

.container {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}

input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}




a {
  color: #2196F3;
}

hr {
  border: 1px solid lightgrey;
}


/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
  .row {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}
</style>
</head>
<body>
<!--Header-->


<div align="center">
    <div>
     <h4>'Shape On It System' pay Form:</h4>
    </div>
</div>
  
<!--form-->

<div align="center">
 <div id="form" style="width: 450px;">
  <form  action="" method="post" >
    <div class="w2ui-page page-0">
        <div class="w2ui-field" align="left">

             <h3>Payment</h3>
            <label> <font color="red"> <?php
try {
    if (!empty($type)) {
        echo filter_var($type, FILTER_SANITIZE_NUMBER_INT), "$ To pay";
    }
}
catch(Exception $e) {
}
?> </font></label>
            <label for="fname">Accepted Cards  </label>
            <div class="icon-container">
              <i class="fa fa-cc-visa" style="color:navy;"></i>
              <i class="fa fa-cc-amex" style="color:blue;"></i>
              <i class="fa fa-cc-mastercard" style="color:red;"></i>
              <i class="fa fa-cc-discover" style="color:orange;"></i>
            </div>
        </div>

        <div class="w2ui-field" align="left">
          <label for="fname"><i class="fa fa-user"></i> Name on card</label>
            <div>
                <input name="nameoncard" type="text" maxlength="20" size="40" placeholder="john michael"/>
            </div>
        </div>
    
    <div class="w2ui-field" align="left">
            <label>Card Number:</label>
            <div>
                <input name="cardnumber" type="text" minlenght=20 maxlength="20" size="40" placeholder="xxxx-xxxx-xxxx-xxxx"/>
            </div>
        </div>
    <div class="w2ui-field" align="left">
            <label>Exp month:</label>
            <div>
                <input name="expmonth" type="text" maxlength="10" size="40" placeholder="october"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Exp year:</label>
            <div>
                <input name="expyear" type="text" minlenght=4 maxlength="4" size="40" placeholder="2019"/>
            </div>
        </div>
    
      <div class="w2ui-field" align="left">
            <label>cvv:</label>
            <div>
                <input name="cvv" type="int" minlenght=3 maxlength="3" size="40" placeholder="357"/>
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
        url      : 'server/post',
        fields: [
            { field: 'nameoncard', type: 'text', required: true },
            { field: 'cardnumber', type: 'text', required: true },
            { field: 'expmonth', type: 'text', required: true },
            { field: 'expyear', type: 'int', required: true },
            { field: 'cvv',type:'int',required: true} 

        ],
        actions: {
            reset: function () {
                this.clear();
            },
      
      save: function (e) {
                this.save();
            //check all inputs data is not empty and valid 

                 if(this.record.nameoncard!="" && this.record.cardnumber!="" && this.record.expmonth!="" && this.record.expyear!="" && this.record.cvv!="")
                {}
                          //if one or more inputs empty show toasts you need to fill the input   

                  else
                e.preventDefault();
            }
        }
    });
});
</script>

<?php /*footer header file*/
include "footer.php"; ?>
