<?php /*include header file*/
include "header.php";
//This page show products to sale and the user can buy
//if clicked one of product "Add to cart" button
if (isset($_POST["add"])) {
    //get selected product id and selected quantity and save them into variables
    $id = $_GET["id"];
    $qty = $_POST["quantity"];
    //get all items (products) by "getItems" function and get the selected product quantity to check if the selected quantity exist in system
    $result = getItems();
    $count = count(getItems());
    for ($i = 0;$i < $count;$i++) {
        if ($result[$i]->id == $id) $item = $result[$i];
    }
    //if  selected product quantity not exist in system show message
    if ($item->qty < $qty) {
        echo '<script>w2alert("We Dont have this quantity in stock")</script>';
        echo '<meta http-equiv="refresh" content="1; url="Items.php"" />';
        return;
    }
    //if alrealy exists cart (saved cart) in system
    if (isset($_SESSION["cart"])) {
        //get this cart and save cart variables in array For the system know which products already exist in the shopping cart
        $item_array_id = array_column($_SESSION["cart"], "product_id");
        //if selected product not exist in saved cart save it into array and add to saved cart
        if (!in_array($_GET["id"], $item_array_id)) {
            $count = count($_SESSION["cart"]);
            $item_array = array('product_id' => $_GET["id"], 'item_name' => $_POST["hidden_name"], 'product_price' => $_POST["hidden_price"], 'item_quantity' => $_POST["quantity"],);
            //updade saved cart and go to cart page to show current saved cart
            $_SESSION["cart"][$count] = $item_array;
            echo '<script>window.location="cart.php"</script>';
            //if selected product exist in saved cart show message
            
        } else {
            echo '<script>w2alert("Product is already Added to Cart")</script>';
            echo '<meta http-equiv="refresh" content="1; url="Items.php"" />';
        }
    } else {
        //if not exists cart (saved cart) in system save selected product into array and add to new cart
        $item_array = array('product_id' => $_GET["id"], 'item_name' => $_POST["hidden_name"], 'product_price' => $_POST["hidden_price"], 'item_quantity' => $_POST["quantity"],);
        //add array to new art
        $_SESSION["cart"][0] = $item_array;
    }
            echo '<meta http-equiv="refresh" content="0; url="cart.php"" />';

}
//if clicked to "delete" work (in cart page) to remove any item from cart
if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        //get item id and delete item from cart session and return from cart page to this page
        foreach ($_SESSION["cart"] as $keys => $value) {
            if ($value["product_id"] == $_GET["id"]) {
                unset($_SESSION["cart"][$keys]);
                echo '<script>w2alert("Product has been Removed...!")</script>';
                echo '<meta http-equiv="refresh" content="1; url="cart.php"" />';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
      <script type="text/javascript" src="css/w2ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/w2ui-1.5.rc1.min"/>

  <!-- Css setting-->
    <style>
        @import url('https://fonts.googleapis.com/css?family=Titillium+Web');
        *{
            font-family: 'Titillium Web', sans-serif;
        }
        .product{
            border: 10px solid #eaeaec;
            margin: -1px 20px 3px -1px;
            padding: 1px;
            text-align: center;
            background-color: #efefef;
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


       
    </style>
</head>
<body>

    <div style="width: 100%">
        <h2>Products</h2>
        <?php
//get all items (products) by "getItems" function to show all products
$result = getItems();
$count = count(getItems());
//if exist one ore more products
if ($count > 0) {
    $i = 0;
    //show all products (product name quantity image price )
    while ($count > $i) {
?>
                    <div class="col-md-3">
                    <!-- Form-->

                        <form method="post" action="Items.php?action=add&id=<?php echo $result[$i]->id; ?>">

                            <div class="product">
                               <img src="<?php echo '../admin/img/proteins/' . $result[$i]->img; ?>" height="200" width="200" class="responsive" >
                                <h2 class="text-info"><?php echo $result[$i]->name; ?></h2>

                                <!-- If clicked product "more Details" go to 'itemDetails' page  -->
                                <h2 class="text-danger"><?php echo $result[$i]->price; ?></h2>
                                 <a href="itemDetails.php?id=<?php echo $result[$i]->id; ?>"><input type="hidden" name="hidden_price"> more Details</a>

                                <input type="text" name="quantity" class="form-control" value="1">
                                <input type="hidden" name="hidden_name" value="<?php echo $result[$i]->name; ?>">

                                <input type="hidden" name="hidden_price" value="<?php echo $result[$i]->price; ?>">
                                <input type="submit" name="add" style="margin-top: 5px;" class="btn btn-success"
                                       value="Add to Cart">
                            </div>
                        </form>
                    </div>
                    <?php
        $i++;
    }
}
?>
</br>

</body>
</html>
<?php /*footer header file*/
include "footer.php"; ?>