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
<h2 align="center">Subscription Type Details</h2>

<!--"+Add a New Subscription Type" button if click at this button go to "newSubscriptionType" page-->
<a href="newSubscriptionType.php"><button class="w2ui-btn w2ui-btn-green" > +Add a New Subscription Type</button></a>

<div id="main" style="width: 100%; height: 300px; "></div>

<script type="text/javascript">
//grid setting 
var config = {
    layout: {
        name: 'layout',
        padding: 4,
        panels: [
            { type: 'left', size: '67%', resizable: true, minSize: 500 },
            { type: 'main', minSize: 300 },
        ]
    },
    grid: { 
        name: 'grid',

        show: {
            toolbar: true
        },
        columns: [
            { field: 'id', caption: 'Id', size: '33%',searchable: true  },
            { field: 'name', caption: 'Name', size: '33%',searchable: true  },
            { field: 'duration', caption: 'Duration', size: '33%' ,searchable: true },
            { field: 'price', caption: 'Price', size: '33%' ,searchable: true },
            { field: 'description', caption: 'Description', size: '33%' ,searchable: true }
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
        header: 'Edit Subscription Type',
        name: 'form',
        fields: [
            { name: 'id', type: 'text', html: { caption: 'Id', attr: 'size="20" readonly' } },
            { name: 'name', type: 'text',required: true, html: { caption: 'Name', attr: 'size="20" maxlength="5"' } },
            { name: 'description', type: 'text',required: true, html: { caption: 'description', attr: 'size="20"' } }
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
 //if clicked save (edit subscription types details ) save subscription types  details in variables 
                    var id = this.record.id;
                    var name = this.record.name;
                    var description = this.record.description;
//send js variables in ajax for convert to php variables
                        $.ajax({
                            type: 'POST',
                            url: 'subscriptionTypes.php',
                            data: {'id': id,'name':name,'description':description},
                            });
//if php find ajax request (js variables) save them in php variables
                            <?php
if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['description'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    //send variables to "updateSusbcriptionTypeDetails" function for update subscription types details
    updateSusbcriptionTypeDetails($id, $name, $description);
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


//"loadData" function for load subscription types details
function loadData()
{
       try{
    <?php
//get subscription types details by "getSusbcriptionTypDetails" function
$Type = getSusbcriptionTypDetails();
$count = count((array)getSusbcriptionTypDetails());
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive
    if(lenght>=1)
    {
    //convert array from php to js array  
      var row = w2ui['grid'].records.length;
      var jsArray = [];
      var jsArray = <?php echo json_encode($Type); ?>;
  //get subscription types details and show in grid

   for(var i=0;i<lenght;i++)
   {
         w2ui['grid'].add([
        { recid: row+i+1,
            id: jsArray[i].id,
            name: jsArray[i].name, 
            description: jsArray[i].description,          
            duration: jsArray[i].duration,          
            price: jsArray[i].price }]);      
   }   

    w2ui['grid'].refresh();
  }
}catch(e){}
    
}
</script>

<!--"Back" button if click at this button return to "lessons" page-->
</br>
<a href="lessons.php"><button class="w2ui-btn" >Back</button></a>



</body>
</html>
<?php /*include footer file*/
include "footer.php"; ?>
