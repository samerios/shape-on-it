<?php /*include header file*/
include "header.php";
?>
<br/>
<!DOCTYPE html>
<html>
<head>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
      <script type="text/javascript" src="css/w2ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/w2ui-1.5.rc1.min"/>
</head>
<!--on load call to 'loadData' function for load data to page-->
<body onload="loadData()">

<?php
//get sent variable from url (sent by "UsersOrders" page) and save in variable
if (isset($_GET['orderid'])) $id = $_GET['orderid'];
if (isset($_GET['dateOpen'])) $dateOpen = $_GET['dateOpen'];
if (isset($_GET['price'])) $price = $_GET['price'];
if (isset($_GET['userId'])) $userId = $_GET['userId'];
if (isset($_GET['fullname'])) $fullname = $_GET['fullname'];
if (isset($_GET['phonenumber'])) $phonenumber = $_GET['phonenumber'];
?>

<!--convert php variable to js variable for send order id to js function-->
<script type="text/javascript"> var orderId=<?php echo $id ?></script>

<!--header-->
<div align="center">
<p>Order ID: <?php echo $id; ?> | Order Open Date: <?php echo $dateOpen; ?> | Order Total Price: <?php echo $price; ?>$</p>
<br>
<p>User Details | user id : <?php echo $userId; ?> | fullname: <?php echo $fullname; ?> | phonenumber : <?php echo $phonenumber; ?></p>

<!--"Confirm order" button if click at this button go to "confirrmOrder" function for change order status to "sent"-->
<button class="w2ui-btn w2ui-btn-blue" name="confirm order" onclick="confirrmOrder()">Confirm order</button>
</div>

<div id="main" style="width: 100%; height: 400px;"></div>

<script type="text/javascript">
//grid setting 
var config = {
    grid: { 
        name: 'grid',
        recordHeight: 100,
        show: { 
            footer    : true,
            toolbar    : true
        },
        columns: [                
            { field: 'itemid', caption: 'Item ID', size: '80px', sortable: true, searchable: 'int', resizable: true },
            { field: 'itemname', caption: 'Item Name', size: '140px', sortable: true, searchable: 'text', resizable: true  },
            { field: 'price', caption: 'Price', size: '140px', sortable: true, searchable: 'text', resizable: true },
            { field: 'quantity', caption: 'Quantity', size: '140px', sortable: true, searchable: 'text', resizable: true },
            { field: 'img', caption: 'Image', size: '200px' }

        ]
    }
};

$(function () {
    // initialization
    $().w2grid(config.grid);

    w2ui.grid.refresh();
    $('#main').w2render('grid');



});


//"loadData" function for load items in order details

function loadData()
{
        
        try{
    <?php
//get all orders (from users) details by "getUsersOrders" function
$itemsInOrder = getUsersOrders();
$count = count((array)getUsersOrders());
//get sent order id from url
$id = $_GET['orderid'];
?>
    var lenght=<?php echo $count; ?>;
     //check if array lenght is positive
    if(lenght>=1)
    {
      //convert array from php to js array  
      var row = w2ui['grid'].records.length;
      var orderss = [];
      var orderss = <?php echo json_encode($itemsInOrder); ?>;
      var id= <?php echo $id; ?> ;
      //obj variable for save order object 
      var obj;

      //check if order id equal sent order id to get the object 
      for(var i=0;i<lenght;i++)
      {
         if(orderss[i].id==id)
         {
            obj=orderss[i];
         }
     }

  //get items in order details and show in grid

   for(var j=0;j<obj.items.length;j++)
   {

  w2ui['grid'].add([
        { recid: row+i+1,
            itemid: obj.items[j].id,
            itemname: obj.items[j].name,
            price: obj.items[j].price*obj.items[j].qty,
            quantity: obj.items[j].qty,
            //get items image from "proteins" folder
           img:  '<img src="img/proteins/'+obj.items[j].img+ '"width="70px" height="90px"/>',
 }]);
}

    w2ui['grid'].refresh();
  }
}catch(e){}
    
 }

 


//"confirrmOrder" function for show confirm (yes no) message
 function confirrmOrder()
 {
    
  //if admin confirm order go to "updateOrderStatus" function and show meesage
        w2confirm('Are You Sure?')
       .yes(function () { updateOrderStatus(orderId); w2alert("The order Has been confirmed")
        .ok(function () {  }); })
        .no(function () {  });
           
 }

//"updateOrderStatus" function for send js variables in ajax for convert to php variables

function updateOrderStatus(ordrId)
{

  var yes=1;
  //send js variables in ajax for convert to php variables
  $.ajax({
  type: 'POST',
  url: 'ItemsInOrder.php',
  data: {'yes':yes,'ordrId':ordrId},
  });
}


<?php
//if php find ajax request (js variables) save them in php variables
if (isset($_POST['yes']) && isset($_POST['ordrId'])) {
    $id = $_POST['ordrId'];
    //update order status from 'pending' to 'sent' by "updateUserOrderStatus" function
    updateUserOrderStatus($id);
}
?>
</script>


<!--"Back" button if click at this button return to "UsersOrders" page-->
<br/>
<a href="UsersOrders"><button class="w2ui-btn" name="back">Back</button></a>

</body>
</html>

<?php /*include footer file*/
include "footer.php"; ?>

