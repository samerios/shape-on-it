<?php /*include header file*/
include "header.php";
?>
<br/>

<?php
//after check all inputs if clicked "save"
if (isset($_POST['save'])) {
    //get inputs and save into varibels
    $lessonType = @$_POST['lessonType'];
    $roomType = @$_POST['roomType'];
    $date = @$_POST['startDate'];
    $hour = @$_POST['hour'];
    $maxTrainers = @$_POST['maxTrainers'];
    //get date now
    $date = @$_POST['startDate'];
    $day = date("l", strtotime($date));
    //call "newLesson" function for add lesson in system the function return 1 if lesson not exist (no lesson at selected date and time)
    $result = newLesson($lessonType, $maxTrainers, $date, $day, $hour, $roomType);
    //if no lesson at selected date and time show success message
    if ($result == 1) {
        echo '<script> w2alert("Lesson add succesfully");</script>';
        echo '<meta http-equiv="refresh" content="2; url=\'Lessons.php\'" />';
    }
    //if lesson already exist at selected date and time show message
    else {
        echo '<script> w2alert("Lesson alrealy exist");</script>';
        echo '<meta http-equiv="refresh" content="2; url=\'Lessons.php\'" />';
    }
}
//if clicked "back" button return to 'Lessons' page
if (isset($_POST['back'])) echo '<meta http-equiv="refresh" content="0; url=\'Lessons.php\'" />';
?>
<!DOCTYPE html>
<html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
      <script type="text/javascript" src="css/w2ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/w2ui-1.5.rc1.min"/>
</head>    
<body >

<!--hedaer-->
<h2 align="center">Add A Lesson</h2>

<!--form-->
<div align="center">
 <div id="form" style="width: 600px;">
  <form  action="" method="post" >
    <div class="w2ui-page page-0">
        <div class="w2ui-field" align="left">
            <label>Lesson Type:</label>
            <div>
                <input name="lessonType" type="list" size="48"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Room Type:</label>
            <div>
                <input name="roomType" type="list" size="48"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>start Date:</label>
            <div>
                <input name="startDate" size="48"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Hour:</label>
            <div>
                 <input name="hour"type="text"  minlength=6 maxlength="6" size="48"/>
            </div>
        </div>

        <div class="w2ui-field" align="left">
            <label>Max Trainers:</label>
            <div>
                <input name="maxTrainers" type="int"  minlength=1 maxlength="6" size="48" />
                
            </div>
        </div>
        
    </div>

    <div class="w2ui-buttons">
        <button class="w2ui-btn" name="back">Back</button>
        <button class="w2ui-btn" name="reset">Reset</button>
        <button class="w2ui-btn w2ui-btn-blue" name="save">Save</button>
    </div>
   </form>
  </div>
</div>

<script type="text/javascript">

var roomTypee=[];
 try{
    <?php
//get rooms details by "getRoomsDetails" function
$roomTypee = getRoomsDetails();
$countt = count((array)getRoomsDetails());
?>
    var lenghtt=<?php echo $countt; ?>;
    //check if array lenght is positive
    if(lenghtt>=1)
    {
   //convert array from php to js array  
    var rooms = []; 
    var rooms = <?php echo json_encode($roomTypee); ?>;
    //add rooms details to "roomTypee" list
    for(var i=0;i<lenghtt;i++)
    {
        roomTypee.push(rooms[i].roomType);  
    }  

    } 
}catch(e)
{}

if(lenghtt>0)
{
  //sort "roomTypee" list
roomTypee.sort();
$('input[type=list]').w2field('list', { items: roomTypee });
}


var lessonsType=[];
 try{
    <?php
//get lessons types details by "getLessonsTypeDetails" function
$lessonsType = getLessonsTypeDetails();
$count = count(getLessonsTypeDetails());
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive
    if(lenght>=1)
    {
    //convert array from php to js array    
    var lessonsTypes = []; 
    var lessonsTypes = <?php echo json_encode($lessonsType); ?>;
    //add lessons types details to "lessonsType" list
    for(var i=0;i<lenght;i++)
    {
        lessonsType.push(lessonsTypes[i].type);  
    }  

    } 
}catch(e)
{}

if(lenght>0)
{
    //sort "lessonsType" list
   lessonsType.sort();
$('input[type=list]').w2field('list', { items: lessonsType });
}


$(function () {
  //form setting             
    $('#form').w2form({ 
        name     : 'form',
        fields: [
            { field: 'lessonType', type: 'list',options: {items : lessonsType}, required: true },
            { field: 'roomType', type: 'list', options: {items : roomTypee},required: true },
            { field: 'startDate', type: 'Date', required: true },
            { field: 'hour', type: 'text', required: true },
            { field: 'maxTrainers', type: 'int',required: true}

        ],
        actions: {
            reset: function () {
                this.clear();
            },
            
            save: function (e) {
                this.save();
                //check all inputs data is not empty and valid
                 if(this.record.lessonType!="" && this.record.roomType!="" && this.record.startDate!="" && this.record.hour!="" && this.record.maxTrainers!="")
                {}
                    else
                //if one or more inputs empty show toasts you need to fill the input  
                e.preventDefault();
            }
        }
    });
});
</script>

</body>
</html>

<?php /*include footer file*/
include "footer.php"; ?>