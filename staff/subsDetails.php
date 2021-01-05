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
<h2 align="center">Subscriptions Details</h2>

<div id="main" style="width: 100%; height: 400px;"></div>


<script type="text/javascript">
//grid setting 
var config = {
    grid: { 
        name: 'grid',
        show: { 
            footer    : true,
            toolbar    : true
        },
        columns: [                
            { field: 'id', caption: 'Id', size: '33%', sortable: true, searchable: true },
            { field: 'username', caption: 'User Name', size: '100px', sortable: true, searchable: true },
            { field: 'password', caption: 'Password', size: '100px' ,render:'password'},
            { field: 'fname', caption: 'First Name', size: '100px', sortable: true, searchable: true },
            { field: 'lname', caption: 'Last Name', size: '100px', sortable: true, searchable: true },
            { field: 'email', caption: 'Email', size: '100px', sortable: true, searchable: true },
            { field: 'address', caption: 'Address', size: '120px', sortable: true, searchable: true },
            { field: 'gender', caption: 'Gender', size: '100px', sortable: true, searchable: true },
            { field: 'phonenumber', caption: 'Phone', size: '100px', sortable: true, searchable: true },
            { field: 'dob', caption: 'Date Of Birth', size: '100px', render: 'date' ,sortable: true, searchable: true},
            { field: 'subscriptionType', caption: 'subscription Type', size: '110px', sortable: true, searchable: true},
            { field: 'startDate', caption: 'start Date', size: '100px', sortable: true, searchable: true},
            { field: 'endDate', caption: 'end Date', size: '100px', sortable: true, searchable: true},
            { field: 'status', caption: 'status', size: '100px', sortable: true, searchable: true},
            { field: 'workplan', caption: 'workplan', size: '100px' }
        ],

    }
};

$(function () {
    $().w2grid(config.grid);
    w2ui.grid.refresh();
    $('#main').w2render('grid');



});

//"loadData" function for load all workplan details
function loadData()
{
       try{
    <?php
//get all subscriptions details status active by "getSubscriptions" function
$subscriptions = getSubscriptions("active");
$count = count((array)getSubscriptions("active"));
?>
    var lenght=<?php echo $count; ?>;
//check if array lenght is positive

    if(lenght>=1)
    {
//convert array from php to js array
      var row = w2ui['grid'].records.length;
      var schedule = [];
      var schedule = <?php echo json_encode($subscriptions); ?>;
//add subscriptions details to grid and show them

   for(var i=0;i<lenght;i++)
   {
         w2ui['grid'].add([
        { recid: row+i+1,
            id: schedule[i].id,
            fname: schedule[i].fname,
            lname: schedule[i].lname,
            gender: schedule[i].gender,
            dob: schedule[i].dateOfBirth,
            email: schedule[i].email,
            phonenumber: schedule[i].phoneNumber,
            address: schedule[i].address,
            username: schedule[i].username,
            password: schedule[i].password,
            subscriptionType:schedule[i].subscriptionType,
            startDate:schedule[i].subscriptionStartDate,
            endDate:schedule[i].subscriptionEndtDate,
            status:schedule[i].status,
            //if click "workplan" button send to "subsWorkPlan" url page the work plan id and menuid 
            workplan:'<a href="subsWorkPlan.php?workPlanIdd='+schedule[i].WorkPlan.id+'&menuId='+schedule[i].WorkPlan.Menu.idMenu+'"><button class="w2ui-btn-green" value="green">workplan</button>' }]);      
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
