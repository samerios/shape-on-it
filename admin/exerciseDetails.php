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
<!--hedaer-->
<h2 align="center">Exercises Details</h2>

<!--"+Add New Exercise" button if click at this button go to "newExercise" page-->

<a href="newExercise.php"><button class="w2ui-btn w2ui-btn-green" > +Add New Exercise</button></a>
<div id="main" style="width: 100%; height: 400px; "></div>

<script type="text/javascript">

//grid setting 

var config = {
    layout: {
        name: 'layout',
        padding: 4,
        panels: [
            { type: 'left', size: '70%', resizable: true, minSize: 500 },
            { type: 'main', minSize: 300 },
        ]
    },
    grid: { 
        name: 'grid',
        recordHeight: 70,


        show: {
            toolbar            : true,
            toolbarDelete    : true
        },
        columns: [
            { field: 'id', caption: 'Id', size: '33%',searchable: true  },
            { field: 'name', caption: 'Name', size: '100px',searchable: true  },
            { field: 'difficulty', caption: 'Difficulty', size: '100px' ,searchable: true },
            { field: 'rehearsals', caption: 'Rehearsals', size: '100px',searchable: true  },
            { field: 'sets', caption: 'Sets', size: '55%', sortable: true, searchable: true },
             { field: 'bodyPart', caption: 'Body Part', size: '55%', sortable: true, searchable: true },
              { field: 'rest', caption: 'Rest', size: '55%', sortable: true, searchable: true },
               { field: 'speed', caption: 'Speed', size: '55%', sortable: true, searchable: true },
                { field: 'load', caption: 'Load', size: '55%', sortable: true, searchable: true },
                 { field: 'description', caption: 'Description', size: '100px', sortable: true, searchable: true },
                 
            { field: 'img', caption: 'image', size: '55%'}


        ],

 
 
          onDelete: function (event) {
            var grid = this;
           event.onComplete = function () {
    
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
        header: 'Edit Exercise',
        name: 'form',
        fields: [
            { name: 'recid', type: 'text', html: { caption: 'ID', attr: 'size="10" readonly' } },
            { name: 'id', type: 'int', required: true, html: { caption: 'Exercise id', attr: 'size="30" maxlength="40" readonly'  } },
            { name: 'name', type: 'text', html: { caption: 'Exercise name', attr: 'size="30" maxlength="40" readonly' } },
            { name: 'description', type: 'textarea',required: true, html: { caption: 'Description', attr:' style="width: 200px; height: 80px; resize: none"' } }
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
                 //if clicked save (edit excercise details ) save excercise details in variables 


                    var exercise_id = this.record.id;
                    var description = this.record.description;
    
                        $.ajax({
                            type: 'POST',
                            url: 'exerciseDetails.php',
                            data: {'exercise_id': exercise_id,'description':description},
                            });
  //send js variables in ajax for convert to php variables

                            <?php
//if php find ajax request (js variables) save them in php variables
if (isset($_POST['exercise_id']) && isset($_POST['description'])) {
    $exercise_id = $_POST['exercise_id'];
    $description = $_POST['description'];
    //send variables to "updateExercise" function for update exercise details
    updateExercise($exercise_id, $description);
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


//"loadData" function for load Exercises details
function loadData()
{
    try{
    <?php
//get all Exercises details by "getExercises" function
$Exercises = getExercises();
$count = count((array)getExercises());
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive

    if(lenght>=1)
    {
      //convert array from php to js array  
      var row = w2ui['grid'].records.length;
      var exercisess = [];
      var exercisess = <?php echo json_encode($Exercises); ?>;
  //get Exercises details and show in grid

   for(var i=0;i<lenght;i++)
   {
         w2ui['grid'].add([
        { recid: row+i+1,
            id: exercisess[i].id,
            name: exercisess[i].name,
            difficulty: exercisess[i].difficulty,
            rehearsals: exercisess[i].rehearsals,
            sets: exercisess[i].sets,
            bodyPart: exercisess[i].bodyPart,
            rest: exercisess[i].rest,
            speed: exercisess[i].speed,
            load: exercisess[i].load,
            description: exercisess[i].description,
            //take the excercise image from the img folder
            img:  '<img src="img/exercises/'+exercisess[i].image+ '"width="70px" height="70px"/>' }]);      
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

