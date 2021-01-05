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
<h2 align="center">Suppliers Details</h2>
<!--"+ Add New Supplier" button if click at this button go to "newsupplier" page-->
<a href="newsupplier.php"><button class="w2ui-btn w2ui-btn-green">+ Add New Supplier</button></a>

<div id="main" style="width: 100%; height: 400px;"></div>

<script type="text/javascript">
//grid setting 
var config = {
    layout: {
        name: 'layout',
        padding: 4,
        panels: [
            { type: 'left', size: '50%', resizable: true, minSize: 300 },
            { type: 'main', minSize: 300 }
        ]
    },
    grid: { 
        name: 'grid',
        show: {
            toolbar          : true,
            toolbarDelete    : true
        },
        columns: [
            { field: 'id', caption: 'Supplier Id', size: '33%', sortable: true, searchable: true },
            { field: 'fullname', caption: 'Full Name', size: '33%', sortable: true, searchable: true },
            { field: 'email', caption: 'Email', size: '33%' ,searchable: true},
            { field: 'phonenumber', caption: 'Phone Number', size: '120px',searchable: true }
        ],
       
      onDelete: function (event) {
            var grid = this;
            var form = w2ui.form;
            //if clicked to delete save selection supplier id in variable 
            var sel = grid.getSelection();
            var supplierId = grid.getCellValue(sel-1, 0); 


         event.onComplete = function () {
          //send js variables in ajax for convert to php variables
                $.ajax({
                          type: 'POST',
                          url: 'Suppliers.php',
                          data: {'id': supplierId},
                        });

                 <?php
//if php find ajax request (js variables) save them in php variables
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    //send supplier id to "deleteSupplier" function for delete supplier details
    deleteSupplier($id);
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
        header: 'Edit Supplier Details',
        name: 'form',
        fields: [
            { name: 'recid', type: 'text', html: { caption: '#', attr: 'size="30" readonly' } },
            { name: 'id', type: 'int', html: { caption: 'Supplier id', attr: 'size="30" maxlength="40" readonly'  } },
            { name: 'fullname', type: 'text', required: true, html: { caption: 'Full Name', attr: 'size="30" maxlength="40"' } },
            { name: 'email', type: 'email',required: true, html: { caption: 'Email', attr: 'size="30"' } },
            { name: 'phonenumber', type: 'int',required: true, html: { caption: 'Phone Number', attr: 'size="30"' } }
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
 //if clicked save (edit supplier details ) save supplier details in variables 
                        var sel = this.record.recid;
                        var supid = this.record.id;
                        var fullname = this.record.fullname;
                        var email = this.record.email;
                        var phonenumber = this.record.phonenumber;
                          //send js variables in ajax for convert to php variables
                        $.ajax({
                            type: 'POST',
                            url: 'Suppliers.php',
                            data: {'supid': supid,'fullname':fullname,'email':email,'phonenumber':phonenumber},
                            });
//if php find ajax request (js variables) save them in php variables
                            <?php
if (isset($_POST['supid']) && isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['phonenumber'])) {
    $id = $_POST['supid'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];
    //send variables to "updateSupplier" function for update supplier details
    updateSupplier($id, $fullname, $email, $phonenumber);
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



//"loadData" function for load Suppliers details
    function loadData()
     {
   //get Suppliers details by "getSuppliers" function
     
    <?php
$supp = getSuppliers();
$count = count((array)getSuppliers());
?>
    var lenght=<?php echo $count; ?>;
     //check if array lenght is positive
    if(lenght>=1)
    {
     //convert array from php to js array  
      var row = w2ui['grid'].records.length;
      var suppliers = [];
      var suppliers = <?php echo json_encode($supp); ?>;
  //get Suppliers details and show in grid
   for(var i=0;i<lenght;i++)
   {
         w2ui['grid'].add([
        { recid: row+i+1, id: suppliers[i].id, fullname: suppliers[i].fullname, email: suppliers[i].email, phonenumber: suppliers[i].phoneNumber}]);    
   }   
 

    w2ui['grid'].refresh();
    }
    

    }


</script>

</body>
</html>
<?php /*include footer file*/
include "footer.php"; ?>