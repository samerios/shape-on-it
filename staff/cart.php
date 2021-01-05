<?php /*include header file*/
include "header.php"; ?>


<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  <!-- Css setting-->
    <style>
        @import url('https://fonts.googleapis.com/css?family=Titillium+Web');
        *{
            font-family: 'Titillium Web', sans-serif;
        }
        .product{
            border: 1px solid #eaeaec;
            margin: -1px 19px 3px -1px;
            padding: 10px;
            text-align: center;
            background-color: #efefef;
        }
        table, th, tr{
            text-align: center;
        }
        .title2{
            text-align: center;
            color: #66afe9;
            background-color: #efefef;
            padding: 2%;
        }
        h2{
            text-align: center;
            color: #66afe9;
            background-color: #efefef;
            padding: 2%;
        }
        table th{
            background-color: #efefef;
        }
    </style>
</head>
<body>

   
        <!-- show cart columns headers-->
        <div style="clear: both"></div>
        <h3 class="title2">Shopping Cart Details</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
            <tr>
               <th width="10%">Product Id</th>
                <th width="30%">Product Name</th>
                <th width="10%">Quantity</th>
                <th width="13%">Price Details</th>
                <th width="10%">Total Price</th>
                <th width="17%">Remove Item</th>
            </tr>

            <?php
//set "total" global variable to use it in all place and functions in this page
global $total;
//if the cart not empty
if (!empty($_SESSION["cart"])) {
    $total = 0;
    //get all products from session cart and show them it the table
    foreach ($_SESSION["cart"] as $key => $value) {
?>
                        <tr>
                            <td><?php echo $value["product_id"]; ?></td>
                            <td><?php echo $value["item_name"]; ?></td>
                            <td><?php echo $value["item_quantity"]; ?></td>
                            <td>$ <?php echo $value["product_price"]; ?></td>
                            <!-- show price by multiple selected product quantity in selected product price-->
                            <td> $ <?php echo number_format($value["item_quantity"] * (float)$value["product_price"], 2); ?></td>
                            <!-- if selected "Remove Item" send 'GET' (product id and action=delete) to "items" page to reomve it-->
                            <td><a href="Items.php?action=delete&id=<?php echo $value["product_id"]; ?>"><span
                                        class="text-danger">Remove Item</span></a></td>

                        </tr>
                        <?php
        //save total price in "total" variable
        $total = $total + ($value["item_quantity"] * (float)$value["product_price"]);
    }
?>
                        <tr>
                            <!-- show total price-->
                            <td colspan="3" align="right">Total</td>
                            <th align="right">$ <?php echo number_format($total, 2); ?></th>
                            <td></td>
                        </tr>
                        <?php
}
?>
            </table>
        </div>

    </div>






</script>
<form method="POST">
<!-- if clicked "End shopping" button check if total price not zero (cart not empty) and if yes go to "end shopping" function ,if total price is zero disabled button -->    
<div align="center"><button name="end" class="w2ui-btn w2ui-btn-green" onclick="endShopping()"  <?php if ($total == 0) { ?> disabled <?php
} ?>  >End Shopping</button></div>
</form>



<script type="text/javascript">
    
//"endShopping" function call after "End Shopping" button and show yes no message and if user confirm end shopping send js var in ajax to get it in php to add order to system

function endShopping()
{
<?php $isCard = checkPaymentDetails(@$user, @$id, 'staff'); ?>
 var isCard="<?php echo $isCard; ?>";
   var isCard="<?php echo $isCard; ?>";
    //console.log(isCard);
    if(isCard==1)
    {
         //show confirm message
         if (confirm("Hi <?php echo @$user ?> you going to pay <?php echo $total ?>$  ,End shopping and pay?"))
         {
            $.ajax({
            type: 'POST',
            url: 'cart.php',
            data: {'confirm': confirm},
            });
            //show message after pay
             alert('Thank for pay <?php echo @$user ?> in 14 days you will recived your order with any question you can ask the admins');
    
            }
    }

   
}



</script>




<?php
//if the user confirm "end shopping" check if total price more than zero and if there are 'payment data' for this user
if (isset($_POST['confirm'])) {
    if ($total > 0) {
        //open new order by send "total" price to 'openOrderFromUser' function and get the returned 'order id'
        $order_id = openOrderFromUser($total);
        //get all items in orders and user id and opened order id, send them to "snedOrderFromUser" function for add to database
        foreach ($_SESSION["cart"] as $key => $value) {
            snedOrderFromUser(@$id, $order_id, $value["product_id"], 'staff', $value["item_quantity"], 'user');
        }
        //unset cart (cart not active) and refresh page
        unset($_SESSION['cart']);
        echo '<meta http-equiv="refresh" content="2; url=\'cart.php\'" />';
    }
    //if total price not positive show message
    else if ($total < 0) {
        //if cart is empty show message and return to items page
        echo '<script> w2alert("your cart is empty");</script>';
        echo '<meta http-equiv="refresh" content="1; url=\'Items.php\'" />';
    }
}
//check if user don't have creadit card details by "checkPaymentDetails" function and if no then send him to "shoppingPayment" page to payment
if (isset($_POST['end'])) {
    if (checkPaymentDetails(@$user, @$id, 'staff') == 0) {
        echo '<meta http-equiv="refresh" content="0; url=\'shoppingPayment.php\'" />';
    }
}
?>



</body>
</html>

<?php /*include footer file*/
include "footer.php"; ?>

