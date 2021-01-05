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
<h2 align="center">Users In Lesson</h2>


<?php
//get lesson number from url
if (isset($_GET['lessonNumber'])) $id = $_GET['lessonNumber'];
?>
<!--header "Lesson Number"-->

<div align="center">
<p>Lesson Number: <?php echo $id; ?> 
</div>


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
            { field: 'userId', caption: 'User Id', size: '50px' },
            { field: 'userName', caption: 'User Name', size: '65px' },
            { field: 'fullname', caption: 'first Name', size: '150px' },
            { field: 'gender', caption: 'Gender', size: '150px' },
            { field: 'email', caption: 'Email', size: '150px' },
            { field: 'PhoneNumber', caption: 'Phone Number', size: '150px' },
        ]
    });    
});


//"loadData" function for load usersInLesson details
function loadData()
{
     try{   
    <?php
//get lesson number from url
if (isset($_GET['lessonNumber'])) $id = $_GET['lessonNumber'];
//get Signin For Lesson Details status 'ok' by "getSigninForLessonDetails" function
$usersInLesson = getSigninForLessonDetails('ok');
$count = count((array)getSigninForLessonDetails('ok'));
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive
    if(lenght>=1)
    {
      //convert array from php to js array  
      var row = w2ui['grid'].records.length;
      var userinLesson = [];
      var userinLesson = <?php echo json_encode($usersInLesson); ?>;
      var lessonNumber=<?php echo $id ?>;
      
  //get Signin For Lesson status 'ok' details and show in grid
   for(var i=0;i<lenght;i++)
   {

      if(userinLesson[i].lesson.lessonNumber==lessonNumber)
      {
         w2ui['grid'].add([
        { recid: row+i+1,
            userId: userinLesson[i].user.id,
            userName: userinLesson[i].user.username,
            fullname: userinLesson[i].user.fname+' '+userinLesson[i].user.lname,
            gender: userinLesson[i].user.gender,
            email: userinLesson[i].user.email,
            PhoneNumber: userinLesson[i].user.phoneNumber}]);    
      }
          
   }   

    w2ui['grid'].refresh();
  }
}catch(e){}
    
 }

</script>

<!--"Back" button if click at this button return to "Lessons" page-->
</br>
<a href="Lessons.php"><button class="w2ui-btn" >Back</button></a>

</body>
</html>

<?php /*include footer file*/
include "footer.php"; ?>
