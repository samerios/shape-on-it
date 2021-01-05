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

<!--on load call to 'loadScheduleData' function for load data to page-->
<body onload="loadScheduleData()">
 <!--header-->
<h2 align="center">Lessons Schedule </h2>

<!--"+add a Lesson" button if click at this button go to "newLesson" page-->
<a href="newLesson"><button class="w2ui-btn w2ui-btn-green">+add a lesson</button></a>
<!--"~Sign up for lessons" button if click at this button go to "lessonRegisters" page-->
<a href="lessonRegisters.php"><button class="w2ui-btn w2ui-btn-orange" >~Sign up for lessons</button></a>
<!--"Lessons types" button if click at this button go to "lessonTypeDetails" page-->
<a href="lessonTypeDetails.php"><button class="w2ui-btn w2ui-btn-blue">Lessons types</button></a>
<!--"Rooms" button if click at this button go to "roomsDetails" page-->
<a href="roomsDetails.php"><button class="w2ui-btn w2ui-btn-red">Rooms</button></a>


<div id="grid" style="width: 100%; height: 400px;"></div>

<script type="text/javascript">
 //grid setting 
 
$(function () {
    $('#grid').w2grid({ 
        name: 'grid', 
        show: { 
            toolbar: true,
            footer: true,
           toolbarDelete: true


        },
        multiSearch: true,
        searches: [
            { field: 'lessonNumber', caption: 'lesson Number ', type: 'int' }
        ],
        columns: [
            { field: 'lessonNumber', caption: 'Lesson Number', size: '100px', resizable: true },
            { field: 'LessonType', caption: 'Type', size: '160px', resizable: true },
            { field: 'difficulty', caption: 'Difficulty', size: '80px' },
            { field: 'durationTime', caption: 'DurationTime', size: '100px', resizable: true },
            { field: 'roomNumber', caption: 'Room Number', size: '100px', resizable: true },
            { field: 'roomType', caption: 'Room Type', size: '120px', resizable: true },
            { field: 'startDate', caption: 'start Date', size: '110px', resizable: true },
            { field: 'day', caption: 'Day', size: '80px', resizable: true },
            { field: 'hour', caption: 'Hour', size: '80px', resizable: true },
            { field: 'maxTrainers', caption: 'max Trainers', size: '90px', resizable: true },
            { field: 'registers', caption: 'Registers', size: '100px', resizable: true },
            { field: 'status', caption: 'Status', size: '120px', resizable: true },
            { field: 'see', caption: 'see', size: '120px', resizable: true },


        ],

            onDelete: function (event) {
            var grid = this;
            //if clicked to delete ,save selection lesson number in variable 
            var sel = grid.getSelection();
            var lessonNumber = grid.getCellValue(sel-1, 0); 


         event.onComplete = function () {
          //send js variable in ajax for convert to php variable

                $.ajax({
                          type: 'POST',
                          url: 'Lessons.php',
                          data: {'lessonNumber': lessonNumber},
                        });

                 <?php
//if php find ajax request (js variables) save them in php variables
if (isset($_POST['lessonNumber'])) {
    $lessonNumber = $_POST['lessonNumber'];
    //send lesson number to "deleteLessonsScheduleRow" function for delete lesson details
    deleteLessonsScheduleRow($lessonNumber);
}
?>    
             }    
           
         
     },
    });    
});



//"loadScheduleData" function for load lessons details
        
function loadScheduleData()
{
    try{

    <?php
//get Lessons details by "getLessonsDetails" function
$schedule = getLessonsDetails();
$count = count((array)getLessonsDetails());
?>
    var lenght=<?php echo $count; ?>;
     //check if array lenght is positive
    if(lenght>=1)
    {
      //convert array from php to js array 
      var row = w2ui['grid'].records.length;
      var lessons = [];
      var lessons = <?php echo json_encode($schedule); ?>;
     //get lessons details and show in grid  
   for(var i=0;i<lenght;i++)
   {
         w2ui['grid'].add([
        { recid: row+i+1,
            lessonNumber: lessons[i].lessonNumber,
            LessonType: lessons[i].LessonType.type,
            difficulty: lessons[i].LessonType.difficulty,
            durationTime: lessons[i].LessonType.durationTime,
            roomNumber: lessons[i].Room.roomNumber,
            roomType: lessons[i].Room.roomType,
            startDate: lessons[i].startDate,
            day: lessons[i].day,
            hour: lessons[i].hour,
            maxTrainers: lessons[i].maxTrainers,
            registers: lessons[i].registers,
            status: lessons[i].status,
            //if clicked on button "see" add get request in url (lessonNumber) 
             see: '<a href="usersInLesson.php?lessonNumber='+lessons[i].lessonNumber+'"><button class="w2ui-btn-green" value="green">see</button>' }]);      
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
