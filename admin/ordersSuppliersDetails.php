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
//get order from supplier id from url
if (isset($_GET['suporderid'])) $id = $_GET['suporderid'];
?>

<!--header-->
<div align="center">
<p>Order ID: <?php echo $id; ?></p>

<!--convert php variable to js variable for send order id to js function-->
<script type="text/javascript"> var orderId=<?php echo $id ?></script>

<!--"Confirm order" button if click at this button go to "confirrmOrder" function for change order status to "sent"-->
<button class="w2ui-btn w2ui-btn-blue" name="confirm order" onclick="confirrmOrder()">confirm received order</button>
</div>

<div id="main" style="width: 100%; height: 400px;"></div>

<script type="text/javascript">
//grid setting 
var config = {
    grid: { 
        name: 'grid',
        recordHeight: 70,
        show: { 
            footer    : true,
            toolbar    : true
        },
        columns: [                
            { field: 'itemid', caption: 'Item ID', size: '80px', sortable: true, searchable: 'int', resizable: true },
            { field: 'itemname', caption: 'Item Name', size: '140px', sortable: true, searchable: 'text', resizable: true  },
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


//"loadData" function for load items in supplier order details

function loadData()
{
        
     try{
    <?php
//get all orders (from suppliers) details by "getAllSuppliersOrdersdetails" function
$itemsInOrder = getAllSuppliersOrdersdetails();
$count = count((array)getAllSuppliersOrdersdetails());
//get sent supplier order id from url
$id = $_GET['suporderid'];
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive
    if(lenght>=1)
    {
      //convert array from php to js array  
      var row = w2ui['grid'].records.length;
      var orderType = [];
      var orderType = <?php echo json_encode($itemsInOrder); ?>;
      var id= <?php echo $id; ?>;
      var type='';
      //get the type of order (protein or instrument)
     for(var i=0;i<lenght;i++)
      {
        if(orderType[i].orderid==id)
        {
           if(orderType[i].itemtype=='protein')
          {
             type='protein';
          }
          else  if(orderType[i].itemtype=='instrument')
            type='instrument';
          else type='';
        }    
      }

      //if type of order is 'protein'
      if(type=='protein')
      {
            <?php
//get items details (proteins) by "getItems" function
$itemsInOrderr = getItems();
$count1 = count((array)getItems());
?>
            //convert array from php to js array  
             var lenght1=<?php echo $count1; ?>;
             var items = [];
             var items = <?php echo json_encode($itemsInOrderr); ?>;

          //get items in order details (belong to order) and show in grid
         for(var i=0;i<lenght;i++)
          {
            if(orderType[i].orderid==id)
            {
               if(orderType[i].itemtype=='protein')
                {
                   for(var j=0;j<lenght1;j++)
                     {
                        if(orderType[i].itemid==items[j].id)
                        {
                          var name=items[j].name;
                          var img=items[j].img;

                           w2ui['grid'].add([
                          { recid: row+i+1,
                          itemid: orderType[i].itemid,
                          itemname: name,
                          quantity: orderType[i].quantity,
                          //get protein image from 'img/proteins' folder
                          img:  '<img src="img/proteins/'+img+ '"width="90px" height="70px"/>'
                          }]);
                          }
                      }
                }    
             }
              w2ui['grid'].refresh();

         }

      }

      //if type of order is 'instrument'
      if(type=='instrument')
      {
            <?php
//get instruments details by "getInstrumentsDetails" function
$itemsInOrderr = getInstrumentsDetails();
$count1 = count((array)getInstrumentsDetails());
?>
            var lenght1=<?php echo $count1; ?>;
            //convert array from php to js array  
            var instruments = [];
            var instruments = <?php echo json_encode($itemsInOrderr); ?>;
        //get instruments in order details (belong to order) and show in grid
         for(var i=0;i<lenght;i++)
          {
            if(orderType[i].orderid==id)
            {
               if(orderType[i].itemtype=='instrument')
                {
                   for(var j=0;j<lenght1;j++)
                     {
                        if(orderType[i].itemid==instruments[j].number)
                        {
                          var name=instruments[j].name;
                          var img=instruments[j].image;

                           w2ui['grid'].add([
                          { recid: row+i+1,
                          itemid: orderType[i].itemid,
                          itemname: name,
                          quantity: orderType[i].quantity,
                          //get instrument image from 'img/instruments' folder
                         img:  '<img src="img/instruments/'+img+ '"width="90px" height="70px"/>'
                          }]);
                          }
                      }
                }    
             }
              w2ui['grid'].refresh();

         }

      }


    
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
  url: 'ordersSuppliersDetails.php',
  data: {'yes':yes,'ordrId':ordrId},
  });
}

<?php
//if php find ajax request (js variables) save them in php variables
if (isset($_POST['yes']) && isset($_POST['ordrId'])) {
    $id = $_POST['ordrId'];
    //update order status from 'pending' to 'sent' by "updateUserOrderStatus" (belong to supplier) function
    updateUserOrderStatus($id);
}
?>
</script>


<!--"Back" button if click at this button return to "ordersFromSuppliers" page-->
<br/>
<a href="ordersFromSuppliers"><button class="w2ui-btn" name="back">Back</button></a>

</body>
</html>

<?php /*include footer file*/
include "footer.php"; ?>