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
<h2 align="center">Lesson Type Details</h2>


<!--"+Add a New Lesson type" button if click at this button go to "newLessonType" page-->
<a href="newLessonType.php"><button class="w2ui-btn w2ui-btn-green" > +Add a New Lesson type</button></a>

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
            { field: 'type', caption: 'Type', size: '33%',searchable: true  },
            { field: 'difficulty', caption: 'Difficulty', size: '33%',searchable: true  },
            { field: 'durationTime', caption: 'Duration Time', size: '33%' ,searchable: true }
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
        header: 'Edit Lesson Type',
        name: 'form',
        fields: [
            { name: 'type', type: 'text', html: { caption: 'Type', attr: 'size="20" readonly' } },
            { name: 'difficulty', type: 'text', html: { caption: 'Difficulty', attr: 'size="20" maxlength="5"' } },
            { name: 'durationTime', type: 'text',required: true, html: { caption: 'Duration Time', attr: 'size="20"' } }
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

 //if clicked save (edit lesson type details ) save lesson type details in variables
                    var type = this.record.type;
                    var difficulty = this.record.difficulty;
                    var durationTime = this.record.durationTime; 
//send js variables in ajax for convert to php variables
                        $.ajax({
                            type: 'POST',
                            url: 'lessonTypeDetails.php',
                            data: {'type': type,'difficulty':difficulty,'durationTime':durationTime},
                            });

                            <?php
//if php find ajax request (js variables) save them in php variables
if (isset($_POST['type']) && isset($_POST['difficulty']) && isset($_POST['durationTime'])) {
    $type = $_POST['type'];
    $difficulty = $_POST['difficulty'];
    $durationTime = $_POST['durationTime'];
    //send variables to "updateLessonType" function for update lesson type details
    updateLessonType($type, $difficulty, $durationTime);
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


//"loadData" function for load lesson Type details

function loadData()
{
        
    <?php
//get lessons Types details by "getLessonsTypeDetails" function
$lessonType = getLessonsTypeDetails();
$count = count((array)getLessonsTypeDetails());
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive
    if(lenght>=1)
    {
      //convert array from php to js array    
      var row = w2ui['grid'].records.length;
      var typestypesss = [];
      var typess = <?php echo json_encode($lessonType); ?>;
   //get lessons Types details and show in grid   
   for(var i=0;i<lenght;i++)
   {
         w2ui['grid'].add([
        { recid: row+i+1,
            type: typess[i].type,
            difficulty: typess[i].difficulty,          
            durationTime: typess[i].durationTime }]);      
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