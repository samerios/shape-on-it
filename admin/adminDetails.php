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
<h2 align="center">Admin Details</h2>
<!--"+ Add New Admin" button if click at this button go to "addNewAdmin" page-->
<a href="addNewAdmin.php"><button class="w2ui-btn w2ui-btn-green" value="green" >+ Add New Admin</button></a>

<div id="main" style="width: 100%; height: 400px;"></div>

<script type="text/javascript">
//grid setting 
var config = {
    layout: {
        name: 'layout',
        padding: 4,
        panels: [
            { type: 'left', size: '67%', resizable: true, minSize: 500 },
            { type: 'main', minSize: 250 }
        ]
    },
    grid: { 
        name: 'grid',
        show: {
            toolbar          : true,
            toolbarDelete    : true
        },
        columns: [

            { field: 'id', caption: 'ID', size: '33%', sortable: true, searchable: true },
            { field: 'number', caption: 'Number', size: '60px', sortable: true, searchable: true },
            { field: 'username', caption: 'User Name', size: '70px' ,searchable: true },
            { field: 'password', caption: 'Password', size: '70px' ,render:'password', searchable: true},
            { field: 'firstname', caption: 'First Name', size: '70px',searchable: true},
            { field: 'lastname', caption: 'Last Name', size: '70px',searchable: true},
            { field: 'gender', caption: 'Gender', size: '50px', searchable: true},
            { field: 'dob', caption: 'Dob', size: '50px', render: 'Date',searchable: true},
            { field: 'email', caption: 'Email', size: '100px' ,searchable: true},
            { field: 'phonenumber', caption: 'Phone Number', size: '50px',searchable: true},
            { field: 'address', caption: 'Address', size: '110px', searchable: true},
            { field: 'seniority', caption: 'Seniority', size: '70px', searchable: true},
            { field: 'startwork', caption: 'Work Start', size: '70px', render: 'Date', searchable: true}

        ],

         onDelete: function (event) {
            var grid = this;
            var form = w2ui.form;
            //if clicked to delete save selection admin id in variable 
            var sel = grid.getSelection();
            var adminid = grid.getCellValue(sel-1, 0); 


         event.onComplete = function () {
        //send js variables in ajax for convert to php variables
                $.ajax({
                          type: 'POST',
                          url: 'adminDetails.php',
                          data: {'adminid': adminid},
                        });

                 <?php
//if php find ajax request (js variables) save them in php variables
if (isset($_POST['adminid'])) {
    $adminid = $_POST['adminid'];
    //send admin id to "deleteAdmin" function for delete admin details
    deleteAdmin($adminid);
}
?>    
             }    
           
     },
        
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
        header: 'Edit Admin Details',
        name: 'form',
        fields: [
            { name: 'recid', type: 'text', html: { caption: '#', attr: 'size="10" readonly' } },
            { name: 'id', type: 'int', html: { caption: 'ID', attr: 'size="40" readonly' } },
            { name: 'number', type: 'int', html: { caption: 'Number', attr: 'size="40" readonly' } },
            { name: 'password', type: 'password', required: true, html: { caption: 'Password', attr: 'size="40" maxlength="40"' } },
            { name: 'address', type: 'text', required: true, html: { caption: 'Address', attr: 'size="40" maxlength="40"' } },
            { name: 'phonenumber', type: 'int', required: true, html: { caption: 'Phone Number', attr: 'size="40" maxlength="40"' } },
            { name: 'email', type: 'email', required: true,html: { caption: 'Email', attr: 'size="40"' } },

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
 //if clicked save (edit admin details ) save admin details in variables 
                    var sel = this.record.recid;
                    var adminId = this.record.id;
                    var password = this.record.password;
                    var address = this.record.address; 
                    var phonenumber = this.record.phonenumber;
                    var email = this.record.email;
                    
  //send js variables in ajax for convert to php variables
                        $.ajax({
                            type: 'POST',
                            url: 'adminDetails.php',
                            data: {'adminId': adminId,'password':password,'address':address,'email':email,'phonenumber':phonenumber},
                            });
//if php find ajax request (js variables) save them in php variables
                            <?php
if (isset($_POST['adminId']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['phonenumber']) && isset($_POST['address'])) {
    $id = $_POST['adminId'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $phonenumber = $_POST['phonenumber'];
    //send variables to "updateAdmin" function for update admin details
    updateAdmin($id, $email, $address, $phonenumber, $password);
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


//"loadData" function for load admin details
function loadData()
{
        
<?php
//get all admins details by "getAdmins" function
$admins = getAdmins();
$count = count((array)getAdmins());
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive
    if(lenght>=1)
    {
     //convert array from php to js array  
      var row = w2ui['grid'].records.length;
      var admins = [];
      var admins = <?php echo json_encode($admins); ?>;
  //get admins details and show in grid
   for(var i=0;i<lenght;i++)
   {
         w2ui['grid'].add([
        { recid: row+i+1,
            id: admins[i].id,
            number: admins[i].adminNumber,
            firstname: admins[i].fname,
            lastname: admins[i].lname,
            gender: admins[i].gender,
            dob: admins[i].dateOfBirth,
            email: admins[i].email,
            phonenumber: admins[i].phoneNumber,
            address: admins[i].address,
            seniority: admins[i].seniority,
            startwork: admins[i].startDate,
            username: admins[i].username,
            password: admins[i].password }]);      
   }   

    w2ui['grid'].refresh();
  }
    
 }


</script>

</body>
</html>
<?php /*include footer file*/
include "footer.php"; ?>

