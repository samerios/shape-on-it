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
<h2 align="center">Users Orders</h2>

<div id="grid" style="width: 100%; height: 400px;"></div>

<script type="text/javascript">
//grid setting 
$(function () {
    $('#grid').w2grid({ 
        name: 'grid', 
        show: { 
            toolbar: true,
            footer: true
        },

         multiSearch: true,
        searches: [
            { field: 'recid', caption: 'ID ', type: 'int' },
            { field: 'orderid', caption: 'Order ID', type: 'text' },
            { field: 'price', caption: 'price', type: 'text' },
            { field: 'statusorder', caption: 'Status', type: 'text'  }
        ],
        columns: [                
            { field: 'orderid', caption: 'Order ID', size: '50px', sortable: true, searchable: 'int', resizable: true },
            { field: 'orderdate', caption: 'Date', size: '140px', sortable: true, searchable: 'text', resizable: true  },
            { field: 'price', caption: 'price', size: '140px', sortable: true, searchable: 'text', resizable: true  },
            { field: 'statusorder', caption: 'Status', size: '140px', sortable: true, searchable: 'text', resizable: true },
            { field: 'openorder', caption: 'Check Order', size: '140px', sortable: true, searchable: 'text', resizable: true }
        ]
    });    
});


//"loadData" function for load Users Orders details
function loadData()
{
   try{

    <?php
//get Users Orders details by "getSigninForLessonDetails" function
$orders = getUsersOrders();
$count = count((array)getUsersOrders());
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive
    if(lenght>=1)
    {
      //convert array from php to js array  
      var row = w2ui['grid'].records.length;
      var jsArray = [];
      var jsArray = <?php echo json_encode($orders); ?>;

  //get Users Orders details details and show in grid
   for(var i=0;i<lenght;i++)
   {
         w2ui['grid'].add([
        { recid: row+i+1,
            orderid: jsArray[i].id,
            orderdate: jsArray[i].dateOpen,
            price: jsArray[i].price,
            statusorder: jsArray[i].status,
            //if clicked "openOrder" button send get variable to "ItemsInOrder" page
            openorder:'<a href="ItemsInOrder.php?orderid='+jsArray[i].id+'&price='+jsArray[i].price+'&dateOpen='+jsArray[i].dateOpen+'&userId='+jsArray[i].User.id+'&fullname='+jsArray[i].User.fname+' '+jsArray[i].User.lname+ '&phonenumber='+jsArray[i].User.phoneNumber+'"><button class="w2ui-btn-green" value="green">openOrder</button></a>' }]);      
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