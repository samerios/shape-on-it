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
<h2 align="center">Staff Details</h2>

<!--"+ Add New Staff Member" button if click at this button go to "StaffRegister" page-->
<a href="StaffRegister.php"><button class="w2ui-btn w2ui-btn-green">+ Add New Staff Member</button></a>

<div id="main" style="width: 100%; height: 400px;"></div>

<script type="text/javascript">
//grid setting 
var config = {
    layout: {
        name: 'layout',
        padding: 4,
        panels: [
            { type: 'left', size: '65%', resizable: true, minSize: 300 },
            { type: 'main', minSize: 300 }
        ]
    },
    grid: { 
        name: 'grid',
        show: {
            toolbar : true,
        },
        columns: [

            { field: 'id', caption: 'ID', size: '33%', sortable: true, searchable: true },
            { field: 'number', caption: 'Number', size: '60px', sortable: true, searchable: true },
            { field: 'username', caption: 'User Name', size: '100px' , searchable: true},
            { field: 'password', caption: 'Password', size: '100px' ,render:'password'},
            { field: 'firstname', caption: 'First Name', size: '100px', searchable: true },
            { field: 'lastname', caption: 'Last Name', size: '100px' , searchable: true},
            { field: 'address', caption: 'Address', size: '100px' , searchable: true},
            { field: 'phonenumber', caption: 'Phone Number', size: '100px', searchable: true },
            { field: 'email', caption: 'Email', size: '100px',  searchable: true },
            { field: 'dob', caption: 'Dob', size: '100px', searchable: true },
            { field: 'gender', caption: 'Gender', size: '100px' , searchable: true},
            { field: 'role', caption: 'Role', size: '100px', searchable: true },
            { field: 'startwork', caption: 'Work Start', size: '100px' , searchable: true},
            { field: 'endwork', caption: 'Work End', size: '100px', searchable: true},
            { field: 'perhour', caption: 'Per Hour', size: '100px' , searchable: true}
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
        header: 'Edit Staff Details',
        name: 'form',
        fields: [
            { name: 'recid', type: 'text', html: { caption: '#', attr: 'size="10" readonly' } },
            { name: 'id', type: 'int', html: { caption: 'ID', attr: 'size="10" readonly' } },
            { name: 'number', type: 'text', html: { caption: 'Number', attr: 'size="10" readonly' } },
            { name: 'password', type: 'password', required: true, html: { caption: 'Password', attr: 'size="40" maxlength="40"' } },
            { name: 'address', type: 'text', required: true, html: { caption: 'Address', attr: 'size="40" maxlength="40"' } },
            { name: 'phonenumber', type: 'number', required: true, html: { caption: 'Phone Number', attr: 'size="40" maxlength="40"' } },
            { name: 'email', type: 'email',required: true, html: { caption: 'Email', attr: 'size="40"' } },
            { name: 'perhour', type: 'int',required: true, html: { caption: 'Per Hour', attr: 'size="40"' } }

 
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
                } else {
                    w2ui.grid.set(this.recid, this.record);
                    w2ui.grid.selectNone();

                    //if clicked save (edit staff details ) save staff details in variables 
                    var sel = this.record.recid;
                    var staffId = this.record.id;
                    var password = this.record.password;
                    var address = this.record.address; 
                    var phonenumber = this.record.phonenumber;
                    var email = this.record.email;
                    var perhour = this.record.perhour;

                        //send js variables in ajax for convert to php variables

                        $.ajax({
                            type: 'POST',
                            url: 'staffDetails.php',
                            data: {'staffId': staffId,'password':password,'address':address,'email':email,'phonenumber':phonenumber,'perhour':perhour},
                            });

                            <?php
//if php find ajax request (js variables) save them in php variables
if (isset($_POST['staffId']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['phonenumber']) && isset($_POST['address']) && isset($_POST['perhour'])) {
    $id = $_POST['staffId'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $phonenumber = $_POST['phonenumber'];
    $perhour = $_POST['perhour'];
    //send variables to "updateStaff" function for update staff details
    updateStaff($id, $email, $address, $phonenumber, $password, $perhour);
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



//"loadData" function for load staff details
function loadData()
{
      try{
    <?php
//get staff details by "getStaff" function
$staff = getStaff();
$count = count((array)getStaff());
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive
    if(lenght>=1)
    {
      //convert array from php to js array     
      var row = w2ui['grid'].records.length;
      var staff = [];
      var staff = <?php echo json_encode($staff); ?>;
  //get staff details and show in grid

   for(var i=0;i<lenght;i++)
   {
         w2ui['grid'].add([
        { recid: row+i+1,
            id: staff[i].id,
            number: staff[i].empNumber,
            username: staff[i].username,
            password: staff[i].password,
            firstname: staff[i].fname,
            lastname: staff[i].lname,
            address: staff[i].address,
            phonenumber: staff[i].phoneNumber,
            email: staff[i].email,
            dob: staff[i].dateOfBirth,
            gender: staff[i].gender,
            role: staff[i].role,
            startwork: staff[i].startWork,
            endwork: staff[i].endWork,
            perhour: staff[i].perHour  }]);   
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