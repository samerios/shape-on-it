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
<h2 align="center">Rooms Details</h2>
<!--"+Add a New Room details" button if click at this button go to "newRoom" page-->
<a href="newRoom.php"><button class="w2ui-btn w2ui-btn-green" > +Add a New Room Details</button></a>

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
            { field: 'roomNumber', caption: 'Room Number', size: '33%',searchable: true  },
            { field: 'roomType', caption: 'Room Type', size: '33%',searchable: true  },
            { field: 'maxNumberOfTrainers', caption: 'max Number Of Trainers', size: '33%',searchable: true  }
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
    form: { 
        //form setting
        header: 'Edit Room Details',
        name: 'form',
        fields: [
            { name: 'roomNumber', type: 'text', html: { caption: 'Room Number', attr: 'size="20" readonly' } },
            { name: 'roomType', type: 'text', html: { caption: 'Room Type', attr: 'size="20" readonly' } },
            { name: 'maxNumberOfTrainers', type: 'text', html: { caption: 'max Number Of Trainers', attr: 'size="20" maxlength="5"' } }
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
                    //if clicked save (edit room details ) save room details in variables 
                    var roomNumber = this.record.roomNumber;
                    var roomType = this.record.roomType;
                    var maxNumberOfTrainers = this.record.maxNumberOfTrainers; 

                        //send js variables in ajax for convert to php variables
                        $.ajax({
                            type: 'POST',
                            url: 'roomsDetails.php',
                            data: {'roomNumber': roomNumber,'roomType':roomType,'maxNumberOfTrainers':maxNumberOfTrainers},
                            });

                            <?php
//if php find ajax request (js variables) save them in php variables
if (isset($_POST['roomNumber']) && isset($_POST['roomType']) && isset($_POST['maxNumberOfTrainers'])) {
    $roomNumber = $_POST['roomNumber'];
    $roomType = $_POST['roomType'];
    $maxNumberOfTrainers = $_POST['maxNumberOfTrainers'];
    //send variables to "updateRoomDetails" function for update room details
    updateRoomDetails($roomNumber, $roomType, $maxNumberOfTrainers);
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


//"loadData" function for load rooms details
function loadData()
{
        
    <?php
//get rooms details by "getRoomsDetails" function
$room = getRoomsDetails();
$count = count((array)getRoomsDetails());
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive
    if(lenght>=1)
    {
      //convert array from php to js array     
      var row = w2ui['grid'].records.length;
      var rooms = [];
      var rooms = <?php echo json_encode($room); ?>;
  //get rooms details and show in grid
   for(var i=0;i<lenght;i++)
   {
         w2ui['grid'].add([
        { recid: row+i+1,
            roomNumber: rooms[i].roomNumber,
            roomType: rooms[i].roomType,          
            maxNumberOfTrainers: rooms[i].maxNumberOfTrainers }]);      
   }   

    w2ui['grid'].refresh();
  }
    
 }

</script>

<!--"Back" button if click at this button return to "lessons" page-->
</br>
<a href="lessons.php"><button class="w2ui-btn" >Back</button></a>


</body>
</html>
<?php /*include footer file*/
include "footer.php"; ?>