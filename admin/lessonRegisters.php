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
<h2 align="center">Sign up for lessons</h2>

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
            { field: 'lessonNumber', caption: 'lesson Number', size: '33%', sortable: true, searchable: true },
            { field: 'lessonType', caption: 'lesson Type', size: '33%', sortable: true, searchable: true },
            { field: 'roomType', caption: 'room Type', size: '33%', sortable: true, searchable: true },
            { field: 'userid', caption: 'Trainer Id', size: '33%', sortable: true, searchable: true },
            { field: 'fname', caption: 'First Name', size: '33%', sortable: true, searchable: true },
            { field: 'lname', caption: 'Last Name', size: '33%', sortable: true, searchable: true },
            { field: 'registertime', caption: 'register Time', size: '33%', sortable: true, searchable: true },
            { field: 'ok', caption: 'OK', size: '33%', },
            { field: 'cancel', caption: 'Cancel', size: '33%' },


        ]
    }
};

$(function () {
    // initialization
    $().w2grid(config.grid);
    // generate data
 
    
    w2ui.grid.refresh();
    $('#main').w2render('grid');
});


//"loadData" function for load sign up for lessons details status "pending"

function loadData()
{
    try{

    <?php
//get sign up for lessons details status "pending" details by "getSigninForLessonDetails" function
$signinforlesson = getSigninForLessonDetails('pending');
$count = count((array)getSigninForLessonDetails('pending'));
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive

    if(lenght>=1)
    {
       //convert array from php to js array
      var row = w2ui['grid'].records.length;
      var trainerSignForLesson = [];
      var trainerSignForLesson = <?php echo json_encode($signinforlesson); ?>;
   //get sign up for lessons details status "pending" details and show in grid 
   for(var i=0;i<lenght;i++)
   {
         w2ui['grid'].add([
        { recid: row+i+1,
            lessonNumber: trainerSignForLesson[i].lesson.lessonNumber,
            lessonType: trainerSignForLesson[i].lesson.LessonType.type,
            roomType: trainerSignForLesson[i].lesson.Room.roomType,
            userid: trainerSignForLesson[i].user.id,
            fname: trainerSignForLesson[i].user.fname,
            lname: trainerSignForLesson[i].user.lname,
            registertime: trainerSignForLesson[i].registertime,
            //if clicked on button "ok" add get request in url (result=1 and lesson id) 
            ok:'<a href="lessonRegisters.php?id='+trainerSignForLesson[i].user.id+'&result='+1+ '&lessonid='+trainerSignForLesson[i].lesson.lessonNumber+'"><button class="w2ui-btn-green">Yes</button></a>',
            //if clicked on button "cancel" add get request in url (result=0 and lesson id) 
            cancel:'<a href="lessonRegisters.php?id='+trainerSignForLesson[i].user.id+'&result='+0+ '&lessonid='+trainerSignForLesson[i].lesson.lessonNumber+'"><button class="w2ui-btn-red">No</button></a>'}]);      
   }   

    w2ui['grid'].refresh();
  }

}catch(e){}

 }

</script>


<?php
//if php find (get request in url) get url variables (result and lesson id) and save in variable
if (isset($_GET['id']) && isset($_GET['lessonid']) && isset($_GET['result'])) {
    $userid = @$_GET['id'];
    $lessonid = @$_GET['lessonid'];
    $result = @$_GET['result'];
    //if result is 1 (clicked "ok" button)
    if ($result) {
        //send lesson id and userid to "updateLessonRegisterStatus" with 'ok' status
        $isSign = updateLessonRegisterStatus($userid, $lessonid, "ok");
        //if function returned 1 change request status to ok (add trainer to lesson lesson not full)
        if ($isSign == 1) {
            echo '<script> w2alert("Trainer added");</script>';
            echo '<meta http-equiv="refresh" content="2; url=\'lessonRegisters.php\'" />';
        } else
        //if function returned 0 change request status to cancel (lesson not full)
        {
            echo '<script> w2alert("opps! lesson full trainer not added to lesson");</script>';
            echo '<meta http-equiv="refresh" content="2; url=\'lessonRegisters.php\'" />';
        }
    }
    //if result is 0 (clicked "cancel" button)
    else {
        //send lesson id and userid to "updateLessonRegisterStatus" with 'cancel' status
        updateLessonRegisterStatus($userid, $lessonid, "cancel");
        echo '<script> w2alert("Trainer cancelled");</script>';
        echo '<meta http-equiv="refresh" content="2; url=\'lessonRegisters.php\'" />';
    }
}
?>

<!--"Back" button if click at this button return to "lessons" page-->
<br/>
<a href="lessons.php"><button class="w2ui-btn" name="back">Back</button></a>

</body>
</html>

<?php /*include footer file*/
include "footer.php"; ?>