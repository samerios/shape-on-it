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
<!--"New Subscriptions sigin up" button if click at this button go to "subsConfirmOrNot" page-->
<a href="subsConfirmOrNot.php"><button class="w2ui-btn w2ui-btn-green" >New Subscriptions sigin up</button></a>

<div id="main" style="width: 100%; height: 400px;"></div>

<script type="text/javascript">
//grid setting 
var config = {
    layout: {
        name: 'layout',
        padding: 4,
        panels: [
            { type: 'left', size: '67%', resizable: true, minSize: 800 },
            { type: 'main', minSize: 250 }
        ]
    },
    grid: { 
        name: 'grid',
        show: {
            toolbar            : true,
            toolbarDelete    : false
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
            { field: 'workplan', caption: 'Workplan', size: '100px' }
        ],
       
        onClick: function(event) {
            var grid = this;
            var form = w2ui.form;
            console.log(event);
            event.onComplete = function () {
                var sel = grid.getSelection();
                console.log(sel);
                if (sel.length == 1) {
                    form.recid  = sel[0];
                    form.record = $.extend(true, {}, grid.get(sel[0]));
                    form.refresh();
                } else {
                    form.clear();
                }
            }
        }
    },
    //form setting
    form: { 
        header: 'Edit Subscription',
        name: 'form',
        fields: [
            { name: 'id', type: 'text', html: { caption: 'Id', attr: 'size="10" readonly' } },
            { name: 'email', type: 'email',required: true, html: { caption: 'Email', attr: 'size="40"' } },
            { name: 'address', type: 'text', required: true, html: { caption: 'Address', attr: 'size="40" maxlength="40"' } },
            { name: 'status', type: 'text',required: true, html: { caption: 'Status', attr: 'size="40"' } },
            { name: 'phonenumber', type: 'text', required: true, html: { caption: 'Phone Number', attr: 'size="40" maxlength="40"' } },

             ],
        actions: {
            Reset: function () {
                this.clear();
            },
            Save: function () {
                var errors = this.validate();
                if (errors.length > 0) return;
                if (this.recid == 0) {
                    w2ui.grid.add($.extend(true,  this.record,{ recid: w2ui.grid.records.length + 2 }));
                    w2ui.grid.selectNone();
                    this.clear();
                } else {
                    w2ui.grid.set(this.recid, this.record);
                    w2ui.grid.selectNone();

                    //if clicked save (edit subscribe details ) save subscribe details in variables 
                    var sel = this.record.recid;
                    var subscribeId = this.record.id;
                    var address = this.record.address; 
                    var phonenumber = this.record.phonenumber;
                    var email = this.record.email;
                    var status = this.record.status;


                    
  //send js variables in ajax for convert to php variables
                        $.ajax({
                            type: 'POST',
                            url: 'Subscription.php',
                            data: {'subscribeId': subscribeId,'status':status,'address':address,'email':email,'phonenumber':phonenumber},
                            });
//if php find ajax request (js variables) save them in php variables
                            <?php
if (isset($_POST['subscribeId']) && isset($_POST['status']) && isset($_POST['email']) && isset($_POST['phonenumber']) && isset($_POST['address'])) {
    $subscribeId = $_POST['subscribeId'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    $address = $_POST['address'];
    $phonenumber = $_POST['phonenumber'];
    //send variables to "updateSubscripeDetails" function for update subscribe details
    updateSubscripeDetails($subscribeId, $email, $address, $phonenumber, $status);
}
?>;


                    this.clear();
                }
            }
        }
    }
};

$(function () {
    // initialization
    $('#main').w2layout(config.layout);
    w2ui.layout.content('left', $().w2grid(config.grid));
    w2ui.layout.content('main', $().w2form(config.form));
});

//"loadData" function for load Subscriptions details
function loadData()
{
       try{
    <?php
//get all Subscriptions details (status active) by "getSubscriptions" function
$subscriptions = getSubscriptions('active');
$count = count((array)getSubscriptions('active'));
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive    
    if(lenght>=1)
    {
      //convert array from php to js array   
      var row = w2ui['grid'].records.length;
      var subscriptionss = [];
      var subscriptionss = <?php echo json_encode($subscriptions); ?>;
  //get  Subscriptions details (status active) and show in grid
   for(var i=0;i<lenght;i++)
   {
         w2ui['grid'].add([
        { recid: row+i+1,
            id: subscriptionss[i].id,
            fname: subscriptionss[i].fname,
            lname: subscriptionss[i].lname,
            gender: subscriptionss[i].gender,
            dob: subscriptionss[i].dateOfBirth,
            email: subscriptionss[i].email,
            phonenumber: subscriptionss[i].phoneNumber,
            address: subscriptionss[i].address,
            username: subscriptionss[i].username,
            password: subscriptionss[i].password,
            subscriptionType:subscriptionss[i].subscriptionType,
            startDate:subscriptionss[i].subscriptionStartDate,
            endDate:subscriptionss[i].subscriptionEndtDate,
            status:subscriptionss[i].status,
            //if click 'workplan' button send workplanid and belong menu id for "workPlanDetails" page 
            workplan:'<a href="workPlanDetails.php?workPlanIdd='+subscriptionss[i].WorkPlan.id+'&menuId='+subscriptionss[i].WorkPlan.Menu.idMenu+'"><button class="w2ui-btn-green" value="green">workplan</button>' }]);      
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