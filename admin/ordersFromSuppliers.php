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
  <!--header-->
<h2 align="center">Orders from suppliers</h2>

<div align="center">
<!--"Order Instrument" button if click at this button go to "InstrumentOrder" page-->
<a href="InstrumentOrder.php"><button class="w2ui-btn w2ui-btn-red" >Order Instrument</button></a>
<!--"Order Instrument" button if click at this button go to "ProteinsOrder" page-->
<a href="ProteinsOrder.php"><button class="w2ui-btn w2ui-btn-green" >Order proteins</button></a>
</div>

<div id="grid" style="width: 100%; height: 350px;"></div>

<script type="text/javascript">
  //grid setting 
$(function () {
    $('#grid').w2grid({ 
        name: 'grid', 
        columns: [                
            { field: 'orderId', caption: 'Order Id', size: '10%' },
            { field: 'orderDate', caption: 'date', size: '10%' },
            { field: 'supplierName', caption: 'supplier', size: '10%' },
            { field: 'adminName', caption: 'By Admin', size: '10%' },
            { field: 'status', caption: 'Status', size: '10%%' },
            { field: 'orderdetails', caption: 'Order Details', size: '10%%' },

        ]
    });    
});


//"loadData" function for load orders from suppliers details

function loadData()
{
     try{   
    <?php
//get orders from suppliers details by "getOrdersFromSuppliers" function
$orders = getOrdersFromSuppliers();
$count = count((array)getOrdersFromSuppliers());
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive
    if(lenght>=1)
    {
      //convert array from php to js array  
      var row = w2ui['grid'].records.length;
      var ordersSuppliers = [];
      var ordersSuppliers = <?php echo json_encode($orders); ?>;
  //get orders from suppliers details and show in grid
   for(var i=0;i<lenght;i++)
   {
         w2ui['grid'].add([
        { recid: row+i+1,
            orderId: ordersSuppliers[i].id,
            orderDate: ordersSuppliers[i].dateOpen,
            supplierName: ordersSuppliers[i].Supplier.fullname,
            adminName: ordersSuppliers[i].User.fname +' '+ ordersSuppliers[i].User.lname,
            status: ordersSuppliers[i].status,
            //if clicked "opeOrder" button send variable "suporderid" to 'ordersSuppliersDetails' page with url 
            orderdetails: '<a href="ordersSuppliersDetails.php?suporderid='+ordersSuppliers[i].id+'"><button class="w2ui-btn-green" value="green">openOrder</button>' }]);      
   }   

    w2ui['grid'].refresh();
  }
    }catch(e){}
 }

</script>

</body>
</html>
<?php /*include footer file*/
include "footer.php"; ?>