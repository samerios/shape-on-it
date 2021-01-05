<?php /*include header file*/
include "header.php";
//include 'mlAlgorithm' file to use "DecidsionTreeAlgorithm" class
require_once ('../mlAlgorithm.php');


//$calculateResult = new DecidsionTreeAlgorithm();
//$workplanName = $calculateResult->calculateWorkout(175, 75, 15, 'yes', 'no', '3 weeks');
//call to "confirmSubscriptionAndSetWorkOut" function for belong trianer to workplan in database and add in system
 //$calculateResult->updateWeights(91);

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
<h2 align="center">New Subscriptions</h2>

<!--hedaer-->
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
            { field: 'username', caption: 'User Name', size: '33%', sortable: true, searchable: true },
            { field: 'password', caption: 'Password', size: '33%' },
            { field: 'fname', caption: 'First Name', size: '33%', sortable: true, searchable: true },
            { field: 'lname', caption: 'Last Name', size: '33%', sortable: true, searchable: true },
            { field: 'email', caption: 'Email', size: '33%', sortable: true, searchable: true },
            { field: 'address', caption: 'Address', size: '33%', sortable: true, searchable: true },
            { field: 'gender', caption: 'Gender', size: '33%', sortable: true, searchable: true },
            { field: 'phonenumber', caption: 'Phone', size: '33%', sortable: true, searchable: true },
            { field: 'dob', caption: 'Date Of Birth', size: '120px', render: 'date' },
            { field: 'subscriptionType', caption: 'subscription Type', size: '110px', sortable: true, searchable: true},
            { field: 'startDate', caption: 'start Date', size: '100px', sortable: true, searchable: true},
            { field: 'endDate', caption: 'end Date', size: '100px', sortable: true, searchable: true},
            { field: 'ok', caption: 'OK', size: '33%', },
            { field: 'cancel', caption: 'Cancel', size: '33%' }
        ]
    }
};

$(function () {
    // initialization
    $().w2grid(config.grid);

    w2ui.grid.refresh();
    $('#main').w2render('grid');
});


//"loadData" function for load new Subscriptions details
function loadData()
{
    try{

    <?php
//get new Subscriptions details (status 'not active') by "getSubscriptions" function
$newSubscriptions = getSubscriptions("not active");
$count = count((array)getSubscriptions("not active"));
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive
    if(lenght>=1)
    {
    //convert array from php to js array  
      var row = w2ui['grid'].records.length;
      var newSubscribe = [];
      var newSubscribe = <?php echo json_encode($newSubscriptions); ?>;
  //get new Subscriptions details and show in grid
   for(var i=0;i<lenght;i++)
   {
         w2ui['grid'].add([
        { recid: row+i+1,
            id: newSubscribe[i].id,
            fname: newSubscribe[i].fname,
            lname: newSubscribe[i].lname,
            gender: newSubscribe[i].gender,
            dob: newSubscribe[i].dateOfBirth,
            email: newSubscribe[i].email,
            phonenumber: newSubscribe[i].phoneNumber,
            address: newSubscribe[i].address,
            username: newSubscribe[i].username,
            password: newSubscribe[i].password,
            subscriptionType:newSubscribe[i].subscriptionType,
            startDate:newSubscribe[i].subscriptionStartDate,
            endDate:newSubscribe[i].subscriptionEndtDate,
            //if clicked on button "ok" add 'get request' in url (result=1 and subscribe id) 
            ok:'<a href="subsConfirmOrNot.php?id='+newSubscribe[i].id+'&result='+1+ '"><button class="w2ui-btn-green">Yes</button></a>',
            //if clicked on button "cancel" add 'get request' in url (result=0 and subscribe id) 
            cancel:'<a href="subsConfirmOrNot.php?id='+newSubscribe[i].id+'&result='+0+ '"><button class="w2ui-btn-red">No</button></a>'

             }]);      
   }   


    w2ui['grid'].refresh();
  }
}catch(e){}
    
 }


</script>

<?php
try {
    //if php find (get request in url) get url variables (result and subscribe id) and save in variable
    if (isset($_GET['id']) && isset($_GET['result'])) {
        $id = $_GET['id'];
        $result = $_GET['result'];
        //if result is 1 (clicked "ok" button)
        if ($result == 1) {
            //get subscription details object by "getSubsDetails" function
            $trainerDetails = getSubsDetails($id, 'not active');
            if ($trainerDetails != null) {
                //insert object from "DecidsionTreeAlgorithm" class and 'calculate function' (send variables to function) and get the workout result
                $calculateResult = new DecidsionTreeAlgorithm();
                $workplanName = $calculateResult->calculateWorkout($trainerDetails->height, $trainerDetails->weight, $trainerDetails->fat, $trainerDetails->sportHabits, $trainerDetails->medicalProblems, $trainerDetails->subscriptionType);
                //call to "confirmSubscriptionAndSetWorkOut" function for belong trianer to workplan in database and add in system
                confirmSubscriptionAndSetWorkOut($id, $workplanName);
                echo '<meta http-equiv="refresh" content="0; url=\'subsConfirmOrNot.php\'" />';
            }
        }
        //if result is 0 (clicked "cancel" button) call "" function for delete subscribe in system
        if ($result == 0)
        {
         cancelSubscription($id);
         echo '<meta http-equiv="refresh" content="0; url=\'subsConfirmOrNot.php\'" />';

        }
    }
}
catch(Exception $e) {
}
?>

<!--"Back" button if click at this button return to "Subscription" page-->
<br/>
<a href="Subscription.php"><button class="w2ui-btn" name="back">Back</button></a>

</body>
</html>

<?php /*include footer file*/
include "footer.php"; ?>