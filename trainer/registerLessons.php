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

<body onload="loadScheduleData()">
<h2 align="center">Lessons Register</h2>

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
        ]
    });    
});

//"loadData" function for load lesson details that the user are sign and the status of leason is active and the admin accept the request 

function loadScheduleData()
{
    try{


    <?php
//get all Signin For Lessons Details accept from admin  by "getSigninForLessonDetails" function
$schedule = getSigninForLessonDetails('ok');
$count = count((array)getSigninForLessonDetails('ok'));
?>
    var lenght=<?php echo $count; ?>;
        //check if array lenght is positive

    if(lenght>=1)
    {
      var row = w2ui['grid'].records.length;
            //convert array from php to js array

      var lesson = [];
      var lesson = <?php echo json_encode($schedule); ?>;
      var id=<?php echo json_encode(@$id); ?>;
  //show lessons details the trainer are sign for and status is active and show in grid

   for(var i=0;i<lenght;i++)
   {
      if(lesson[i].user.id==id&&lesson[i].lesson.status=='active')
      {
         w2ui['grid'].add([
        { recid: row+i+1,
            lessonNumber: lesson[i].lesson.lessonNumber,
            LessonType: lesson[i].lesson.LessonType.type,
            difficulty: lesson[i].lesson.LessonType.difficulty,
            durationTime: lesson[i].lesson.LessonType.durationTime,
            roomNumber: lesson[i].lesson.Room.roomNumber,
            roomType: lesson[i].lesson.Room.roomType,
            startDate: lesson[i].lesson.startDate,
            day: lesson[i].lesson.day,
            hour: lesson[i].lesson.hour,
            maxTrainers: lesson[i].lesson.maxTrainers,
            registers: lesson[i].lesson.registers,
            status: lesson[i].lesson.status,
       }]);
     }

   }   

    w2ui['grid'].refresh();
  }

}catch(e)
{

}
    
 }

</script>


</body>
</html>

<?php /*include footer file*/ include "footer.php"; ?>
