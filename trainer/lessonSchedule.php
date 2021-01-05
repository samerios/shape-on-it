<?php /*include header file*/
include "header.php"; ?>
<br/>
<!DOCTYPE html>
<html>
<head>
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
      <script type="text/javascript" src="css/w2ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/w2ui-1.5.rc1.min"/>
</head>
<body>

<!--Header-->
<h1 align="center">'Shape On It' | lessons schedule</h1>

<div id="main" style="width: 100%; height: 350px; margin-bottom: 10px;"></div>

<script type="text/javascript">
//grid setting 
var config = {
    grid: { 
        name: 'grid',
        selectType: 'cell',
        show: { 
            footer: true,
            lineNumbers: false
        },
        onColumnClick: function (event) {
            this.selectNone();
            var column = this.getColumn(event.field, true);
            var sel    = [];
            for (var i = 0; i < this.total; i++) {
                sel.push({ recid: this.records[i].recid, column: column });

            }
            this.select.apply(this, sel);
            event.preventDefault();

        },
        onSelectionExtend: function (event) {
            event.onComplete = function () {
               
            }
        },

         onDelete: function (event) {
            event.force = true;
        }
    }
};

$(function () {
    // initialization
    $().w2grid(config.grid);
    // create columns
    var tmp = ['id','date','hour','sunday', 'monday', 'tuesday', 'wedensday', 'thursday', 'friday', 'saturday'];
    var values     = {};
    for (var i = 0; i < tmp.length; i++) {
        w2ui.grid.columns.push({
            field: tmp[i],
            caption: '<div style="text-align: center">' + tmp[i].toUpperCase() + '</div>',
            size: '15%',
            resizable: true,
            sortable: false,
            editable: false,

            render: function (record, index, col_index) {
                var field     = this.columns[col_index].field;
                var val     = record[field];
                var style     = '';
                if (record.changed && record.changes[field]) val = record.changes[field];
                if (record.style && record.style[col_index]) style = record.style[col_index];
                return '<div style="'+ style +'; padding: 15px 3px; height: '+ this.recordHeight +'px">'+ val +'</div>';
            }
        });
        values[tmp[i]] = '';
    }
    try{

    <?php
//get all Lessons status active by "getLessonsDetails" function
$schedule = getLessonsDetails();
$count = count((array)getLessonsDetails());
?>
    var lenght=<?php echo $count; ?>;
        //check if array lenght is positive

    if(lenght>0)
    {
        //convert array from php to js array
      var lessons = [];
      var lessons = <?php echo json_encode($schedule); ?>;

        for (var i = 0; i < lenght;i++){
        w2ui.grid.records.push($.extend({ recid:i+1 }, values));    
        }
        w2ui.grid.total = w2ui.grid.records.length;
        w2ui.grid.buffered = w2ui.grid.total;
        // init some values
        var rec = w2ui.grid.records;
    //add Lessons details to grid and show them
      var j=0;
   for(var i=0;i<lenght;i++)
   {
       if(lessons[i].status=='active')
       {
        if(lessons[i].day=='Sunday')
        {
          $.extend(rec[j], {id : lessons[i].lessonNumber ,date : lessons[i].startDate, hour : lessons[i].hour,sunday : lessons[i].LessonType.type+'-IN ROOM-'+lessons[i].Room.roomType});
        }
        if(lessons[i].day=='Monday')
        {
          $.extend(rec[j], {id : lessons[i].lessonNumber ,date : lessons[i].startDate, hour : lessons[i].hour,monday : lessons[i].LessonType.type+'-IN ROOM-'+lessons[i].Room.roomType});
        }
        if(lessons[i].day=='Tuesday')
        {
          $.extend(rec[j], {id : lessons[i].lessonNumber ,date : lessons[i].startDate, hour : lessons[i].hour,tuesday : lessons[i].LessonType.type+'-IN ROOM-'+lessons[i].Room.roomType});
        }
        if(lessons[i].day=='Wedensday')
        {
          $.extend(rec[j], {id : lessons[i].lessonNumber ,date : lessons[i].startDate, hour : lessons[i].hour,wedensday : lessons[i].LessonType.type+'-IN ROOM-'+lessons[i].Room.roomType});
        }
        if(lessons[i].day=='Thursday')
        {
          $.extend(rec[j], {id : lessons[i].lessonNumber ,date : lessons[i].startDate, hour : lessons[i].hour,thursday : lessons[i].LessonType.type+'-IN ROOM-'+lessons[i].Room.roomType});
        }
        if(lessons[i].day=='Friday')
        {
          $.extend(rec[j], {id : lessons[i].lessonNumber ,date : lessons[i].startDate, hour : lessons[i].hour,friday : lessons[i].LessonType.type+'-IN ROOM-'+lessons[i].Room.roomType});
        }
         if(lessons[i].day=='Saturday')
        {
          $.extend(rec[j], {id : lessons[i].lessonNumber ,date : lessons[i].startDate, hour : lessons[i].hour,saturday : lessons[i].LessonType.type+'-IN ROOM-'+lessons[i].Room.roomType});
        }
        j++;

       }
   }   

  }


}catch(e){}

    $('#main').w2render('grid');
});


//"check" Function for check click to any cell if the cell is lesson or not lesson and if lesson cell check if the user are alrealy sign for lesson or full lesson
function check()
{
  //js array of grid columns
  var tmp = ['id','date','hour','Sunday', 'Monday', 'Tuesday', 'Wedensday', 'Thursday', 'Friday', 'Saturday'];
//save into variables selected row and columns
var grid = w2ui['grid'];
var sel = grid.getSelection();
var row=sel[0].recid-1;
var col=sel[0].column;
//get lesson number from column id
var lessonNumber=grid.getCellValue(row,0);
//get lesson date from column date 
var date=grid.getCellValue(row,1);
//get lesson hour from column hour 
var hour=grid.getCellValue(row,2);
//get selected cell result from column and row  
var res =grid.getCellValue(row,col);
//get column day
var day=tmp[col];

//send js variables in ajax for convert to php variables
$.ajax({
type: 'POST',
 url: 'lessonSchedule.php',
data: {'lessonNumber':lessonNumber,'date':date,'hour':hour,'row': row,'col':col,'res':res,'day':day},
});
<?php
//if php find ajax request (js variables) save them in php variables
if (isset($_POST['lessonNumber']) && isset($_POST['date']) && isset($_POST['row']) && isset($_POST['col']) && isset($_POST['hour']) && isset($_POST['res']) && isset($_POST['day'])) {
    $lessonNumber = @$_POST['lessonNumber'];
    $date = @$_POST['date'];
    $hour = @$_POST['hour'];
    $row = @$_POST['row'];
    $col = @$_POST['col'];
    $res = @$_POST['res'];
    $day = @$_POST['day'];
}
?>
//if cell result is not lesson show message
  if(res==lessonNumber||res==date||res==hour)
    {
    w2alert('Bad tapping')
    .ok(function () {  });
    }
//if cell result is empty show message
    else if(res==''||res=="")
    {
    w2alert('in day '+tmp[col]+' at hour: '+hour+' Does not exist a lesson')
    .ok(function () {  });
    }
    //if cell result is lesson
    else
    {
      <?php
//get all sign for lessons details ok status
$signsForAllLessons = getSigninForLessonDetails('ok');
$count = count((array)getSigninForLessonDetails('ok'));
?>
      var lenght=<?php echo $count; ?>;
      var isRegister=0;
      var isFullLesson=0;
      //check if array lenght is positive
      if(lenght>=1)
      {
      //convert array from php to js array
      var signsForLessons = [];
      var signsForLessons = <?php echo json_encode($signsForAllLessons); ?>;
      var id=<?php echo json_encode(@$id); ?>;
      
//check if trainer is alrealy sign for selected lesson or the selected lesson is full
     for(var i=0;i<lenght;i++)
     {
      if(signsForLessons[i].user.id==id&&signsForLessons[i].lesson.lessonNumber==lessonNumber)
      {
        isRegister=1;
      }
      if(signsForLessons[i].lesson.lessonNumber==lessonNumber&& signsForLessons[i].lesson.maxTrainers==signsForLessons[i].lesson.registers)
      {
        isFullLesson=1;
      }

     }
    
    }
 

// if trainer is alrealy sign for selected lesson show message 
    if(isRegister==1)
   {
      w2alert("you are already signed this lesson");

   }
   // if selected lesson is full show message 

    if(isFullLesson==1)
   {
          w2alert("Sorry! This Lesson is full");

   }
   // if trainer not sign for selected lesson and selected lesson is not full

   if(isRegister==0&&isFullLesson==0)
   {
     //if trainer confirm sign for selected lesson go to "addTrainerToLesson" function and show meesage
        w2confirm('Are You Sure?')
       .yes(function () { addTrainerToLesson(); w2alert('you have registered to lesson number:'+lessonNumber+"  "+res+' in day: '+tmp[col]+' at hour: '+hour+' your request sent to the admin and you can view the result at the home page Good day :) !!')
        .ok(function () {  }); })
        .no(function () {  });

         //"addTrainerToLesson" function to send js variables in ajax for convert to php variables this function call after trainer confirm selected lesson
        function addTrainerToLesson() {

          var yes=1;
            //send js variables in ajax for convert to php variables
            $.ajax({
            type: 'POST',
            url: 'lessonSchedule.php',
           data: {'lessonNumber':lessonNumber,'yes':yes},
            });
          
            }

        <?php
//check if there are post variables (sent from "addTrainerToLesson" function) and if yes
$lessonId = '';
if (isset($_POST['lessonNumber']) && isset($_POST['yes'])) {
    //get selected lesson id
    $lessonId = $_POST['lessonNumber'];
    //GET DATE AND TIME
    $timeNow = new DateTime("now", new DateTimeZone('Asia/Tel_Aviv'));
    $date = $timeNow->format('Y-m-d H:i:s');
    //send trainer and lesson details with date to "signinForLesson" function to send requet to admin for confirm
    signinForLesson(@$id, $lessonId, $date);
}
?>
   }
  }
}


</script>
<!--if clicked "sign infor lesson" button go to "check" Function   -->

<div align="center"><button class="w2ui-btn-green" value="green" name="sign" onclick="check()">signup for lesson</button></div>




</body>
</html>

<?php /*include footer file*/
include "footer.php"; ?>
