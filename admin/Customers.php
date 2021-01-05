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
<!--hedaer-->
<h2 align="center">Customers Details</h2>

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
            { field: 'customerid', caption: 'Customer Id', type: 'text' },
            { field: 'fname', caption: 'First Name', type: 'text' },
            { field: 'email', caption: 'Email', type: 'list', options: { items: ['peter@gmail.com', 'jim@gmail.com', 'jdoe@gmail.com']} }
        ],
        columns: [

            { field: 'customerid', caption: 'ID', size: '50px', sortable: true, searchable: 'int', resizable: true },
            { field: 'username', caption: 'User Name', size: '140px', sortable: true, searchable: 'text', resizable: true },
            { field: 'password', caption: 'Password', size: '140px', sortable: true, searchable: 'text', resizable: true },
            { field: 'email', caption: 'Email', size: '100%', resizable: true, sortable: true },
            { field: 'firstname', caption: 'First Name', size: '140px', sortable: true, searchable: 'text', resizable: true },
            { field: 'lastname', caption: 'Last Name', size: '140px', sortable: true, searchable: 'text', resizable: true },
            { field: 'address', caption: 'Address', size: '140px', sortable: true, searchable: 'text', resizable: true },
            { field: 'gender', caption: 'Gender', size: '140px', sortable: true, searchable: 'text', resizable: true },
            { field: 'phonenumber', caption: 'Phone Number', size: '120px', resizable: true, sortable: true },
            { field: 'date', caption: 'Date Of Birth', size: '120px', resizable: true, sortable: true, render: 'date' }

        ]
    });    
});



//"loadData" function for load Customers details

function loadData()
{
        
    <?php
//get all Customers details by "getCustomers" function
$Customers = getCustomers();
$count = count((array)getCustomers());
?>
    var lenght=<?php echo $count; ?>;
        //check if array lenght is positive

    if(lenght>=1)
    {
      //convert array from php to js array  

      var row = w2ui['grid'].records.length;
      var customers = [];
      var customers = <?php echo json_encode($Customers); ?>;
  //show Customers details and show in grid

   for(var i=0;i<lenght;i++)
   {
         w2ui['grid'].add([
        { recid: row+i+1,
            customerid: customers[i].id,
            firstname: customers[i].fname,
            lastname: customers[i].lname,
            gender: customers[i].gender,
            date: customers[i].dateOfBirth,
            email: customers[i].email,
            phonenumber: customers[i].phoneNumber,
            address: customers[i].address,
            username: customers[i].username,
            password: customers[i].password }]);      
   }   

    w2ui['grid'].refresh();
  }
    
 }


</script>

</body>
</html>

<?php /*include footer file*/
include "footer.php"; ?>
