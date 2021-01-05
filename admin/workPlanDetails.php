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
<h2 align="center">Work plan Details</h2>


<div>
<?php 
//get menu id from url
    if(isset($_GET['menuId'])) $menuId=$_GET['menuId'];
?>

<!--"~To Nutrition Menu" button if click this button go to "nutritionMenu" page -->
<a href="nutritionMenu.php?id=<?php echo $menuId; ?>"><button class="w2ui-btn w2ui-btn-green">~To Nutrition Menu</button></a>
</div>




<?php 
//get workPlanId from url
if(isset($_GET['workPlanIdd'])) 
  {
    $wid=$_GET['workPlanIdd'];

  //  session_start();
    $_SESSION['planId'] = $wid;
  }
?>

<!--header "Work Plan ID"-->
<div align="center">
<p>Work Plan ID: <?php echo $wid;?> 
</div>


<!-- if clicked "add Exercise To work plan" button go to 'openPopup' function-->
<button class="w2ui-btn-orange" onclick="openPopup()">add Exercise To work plan</button>



<div id="grid" style="width: 100%; height: 1000px;"></div>

<script type="text/javascript">
//grid setting 
$(function () {
    $('#grid').w2grid({ 
        name: 'grid',
        recordHeight: 150,
        show: { 
            toolbar: true,
            footer: true,
            toolbarDelete: true,
        },
        multiSearch: true,
        searches: [
            { field: 'exercisename', caption: 'Exercise Name', type: 'text' },
            { field: 'week', caption: 'Week', type: 'text' },
            { field: 'day', caption: 'Day', type: 'list', options: { items: ['Sunday', 'Monday', 'Tuesday']} }
        ],
        columns: [
            { field: 'week', caption: 'Week', size: '80px' },
            { field: 'day', caption: 'Day', size: '80px' },
            { field: 'exerciseid', caption: 'ID', size: '50px' },
            { field: 'exercisename', caption: 'Exercise Name', size: '120px' },
            { field: 'difficulty', caption: 'Difficulty', size: '65px' },
            { field: 'img', caption: 'Image', size: '150px' },
            { field: 'description', caption: 'description', size: '300px', resizable: true  },            
            { field: 'rehearsals', caption: 'Rehearsals', size: '100px' },
            { field: 'sets', caption: 'Sets', size: '50px'  },
            { field: 'bodyPart', caption: 'Body Part', size: '100px' },
            { field: 'rest', caption: 'Rest', size: '50px' },
            { field: 'speed', caption: 'Speed', size: '50px'  },
            { field: 'load', caption: 'Load', size: '50px'  }
        ],
        onAdd: function (event) {
             w2popup.open(openPopup());
        },
         onDelete: function (event) {
            var grid = this;
            var form = w2ui.form;

            //if clicked to delete save selection excercise day and week id in variable 
            var sel = grid.getSelection();
            var exerciseid = grid.getCellValue(sel-1, 2);
            var week = grid.getCellValue(sel-1, 0);
            var day = grid.getCellValue(sel-1, 1);

            //get workplan id save in js variable
            <?php 
            $wid=0;
            if (isset($_SESSION['planId'])) $wid = $_SESSION['planId'];
            ?>
            var planId = <?php echo $wid ?>;




         event.onComplete = function () {
        //send js variables in ajax for convert to php variables
                $.ajax({
                          type: 'POST',
                          url: 'workPlanDetails.php',
                          data: {'exerciseid': exerciseid,'week': week,'day': day,'planId': planId},
                        });

                 <?php
//if php find ajax request (js variables) save them in php variables
if (isset($_POST['exerciseid']) && isset($_POST['week']) && isset($_POST['day'])  && isset($_POST['planId'])) {

    $exerciseid = $_POST['exerciseid'];
    $week = $_POST['week'];
    $day = $_POST['day'];
    $planId = $_POST['planId'];


    //send excercise worplan id day and week to "deleteExcerciseFromWorkplan" function for delete exercise from workplan
    deleteExcerciseFromWorkplan($planId,$exerciseid,$day,$week);
}
?>    
             }    
           
     },


    });    
});




//"loadData" function for load all excercises belongs to selected workplan
function loadData()
{
     try{   
    <?php
    //get workplan id from url and save in variable
    if(isset($_GET['workPlanIdd']))  $id=$_GET['workPlanIdd'];
      
//get all excercises belongs to selected workplan by "getExercisesInWorkPlan" function
    $exerciseInWorPlan = getExercisesInWorkPlan($id);
  //get all excercises by "getExercises" function
    $exercises=getExercises();

    $count1 = count((array)getExercisesInWorkPlan($id)); 
    $count2 = count((array)getExercises()); 
    ?>
    var lenght1=<?php echo $count1; ?>;
    var lenght2=<?php echo $count2; ?>;
    //check if two array lenght are positive
    if(lenght1>=1 && lenght2>=1)
    {
       //convert arrays from php to js arrays 
      var row = w2ui['grid'].records.length;
      var exerciseInWorPlanArray = [];
      var exerciseInWorPlanArray = <?php echo json_encode($exerciseInWorPlan);?>;

      var excercisesArray = [];
      var excercisesArray = <?php echo json_encode($exercises);?>;


//add in grid
   for(var i=0;i<lenght1;i++)
   {

     for(var j=0;j<lenght2;j++)
     {
      if(exerciseInWorPlanArray[i].exerciseid==excercisesArray[j].id)
      {

         w2ui['grid'].add([
        { recid: row+i+1,
            week: exerciseInWorPlanArray[i].week,
            day: exerciseInWorPlanArray[i].day,
            exerciseid: excercisesArray[j].id,
            exercisename: excercisesArray[j].name,
            difficulty: excercisesArray[j].difficulty,
           //get excercise image from folder
            img:  '<img src="img/exercises/'+excercisesArray[j].image+ '"width="140px" height="70px"/>',
            description: '<textarea readonly style="width: 290px; height: 180px; resize: none">'+excercisesArray[j].description+'</textarea>',
            rehearsals: excercisesArray[j].rehearsals,
            sets: excercisesArray[j].sets,
            bodyPart: excercisesArray[j].bodyPart,
            rest: excercisesArray[j].rest,
            speed: excercisesArray[j].speed,
            load: excercisesArray[j].load}]);    

      }

     }
          
   }   

    w2ui['grid'].refresh();
  }
}catch(e){}
    
 }






//"openPopup" function for load excercises details and add to list and open popup for show how excercise want to add in workplan (week and day)
function openPopup () {

//"itemss" array to save excercises names and show in list
  
var itemss=[];
 try{
    <?php
//get all excercises details by "getExercises" function
$itemss = getExercises();
$count = count((array)getExercises());
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive
    if(lenght>=1)
    {
    //convert array from php to js array          
    var excercises = []; 
    var excercises = <?php echo json_encode($itemss); ?>;
    //add excercises details for show in "itemss" list

    for(var i=0;i<lenght;i++)
    {
        itemss.push(excercises[i].name);  
    }  

    } 
}catch(e)
{}
itemss.sort();
//sort excercises names
$('list').w2field('list', {
    items: itemss
});


//"days" array for add to  list 
var days = ['Sunday', 'Monday', 'Tuesday', 'Wedensday', 'Thursday', 'Friday', 'Saturday'];
$('input[type=list]').w2field('list', { items: days });

//"weeks" array for add to  list 
var weeks=[] ;
for(var i=1;i<=52;i++)
       weeks.push('week'+' '+i);  
$('input[type=list]').w2field('list', { items: days });

//form setting (form in popup)
    if (!w2ui.foo) {
        $().w2form({
            name: 'foo',
            style: 'border: 0px; background-color: transparent;',
            formHTML: 
                '<div class="w2ui-page page-0">'+
                '    <div class="w2ui-field">'+
                '        <label>Exercise:</label>'+
                '        <div>'+
                '           <input name="item" style="width: 250px"/>'+
                '        </div>'+
                '    </div>'+ 
                '    <div class="w2ui-field">'+
                '        <label>week:</label>'+
                '        <div>'+
                '           <input name="week"  style="width: 250px"/>'+
                '        </div>'+
                '    </div>'+

                '    <div class="w2ui-field">'+
                '        <label>Day of week:</label>'+
                '        <div>'+
                '            <input name="day" style="width: 250px"/>'+
                '        </div>'+
                '    </div>'+
                '<div class="w2ui-buttons">'+
                '    <button class="w2ui-btn" name="reset">Reset</button>'+
                '    <button class="w2ui-btn" name="save" >Save</button>'+
                '</div>',
            fields: [
                 { field: 'week', type: 'list',options: {items: weeks}, required: true },
                { field: 'day', type: 'list',options: {items: days}, required: true },
                { field: 'item', type: 'list',options: {items: itemss}, required: true },

            ],

            actions: {
            "save": function (e) { 
                this.save();
                 //check all inputs data is not empty and valid                 
                  if(this.record.item!="" && this.record.week!="" && this.record.day!="")
                {
                    //if input not empty and valid go to "addnewEscerciseToGrid"
                    addnewEscerciseToGrid();
                }
                    else
                //if one or more inputs empty show toasts you need to fill the input       
                e.preventDefault(); 
            },
            "reset": function () { this.clear(); }
            }
        });


    }
//popup setting
    $().w2popup('open', {
        title   : 'Add New Exercise to Work Plan',
        body    : '<div id="form" style="width: 100%; height: 100%;"></div>',
        style   : 'padding: 15px 0px 0px 0px',
        width   : 500,
        height  : 300, 
        showMax : true,
        onToggle: function (event) {
            $(w2ui.foo.box).hide();
            event.onComplete = function () {
                $(w2ui.foo.box).show();
                w2ui.foo.resize();
            }
        },
        onOpen: function (event) {
            event.onComplete = function () {
                $('#w2ui-popup #form').w2render('foo');

            }
        }
    });


}

//"addnewEscerciseToGrid" function for add excercise to grid after select exercise and click "save" in popup 

function addnewEscerciseToGrid()
{
     //get selected 'exercise' 'week' and 'day' and save in variables

     var exerciseName= $('#item').w2field().get().text;
     var week= $('#week').w2field().get().text;
     var day= $('#day').w2field().get().text;


        //send js variables in ajax for convert to php variables
$.ajax({
            type: 'POST',
         url: 'workPlanDetails.php',
            data: {'exerciseName': exerciseName,'week':week, 'day':day},
             });

//if php find ajax request (js variables) save them in php variables
<?php
if (isset($_POST['exerciseName']) && isset($_POST['week']) && isset($_POST['day']) ) {    

    //get sent varibles from ajax
    $exerciseName = $_POST['exerciseName'];
    $exercWeek = $_POST['week'];
    $exercDay = $_POST['day'];

    //call "getExerciseId" function send exercise name and get exercise id
    $exerciseId = getExerciseId($exerciseName);
    


  //get workplanid
    session_start();
    if (isset($_SESSION['planId'])) $wid = $_SESSION['planId'];

    //"addExerciseToWorkPlan" function for send excercise id day and week belong to workplan id 
    addExerciseToWorkPlan($exercWeek, $exercDay,$exerciseId,$wid);
   
        }

  ?>; 



    <?php
  //get all excercises by "getExercises" function
    $exercises=getExercises();

    $count = count((array)getExercises()); 
    ?>
    var lenght=<?php echo $count; ?>;
    //check if two array lenght are positive
    if(lenght>=1)
    {
       //convert arrays from php to js arrays 
      var row = w2ui['grid'].records.length;

      var excercisesArray = [];
      var excercisesArray = <?php echo json_encode($exercises);?>;
      var obj = [];
      var obj=null;


//find excercise object and save in 'obj' array
   for(var j=0;j<lenght;j++)
   {

      if(excercisesArray[j].name==exerciseName)
      {

      obj=excercisesArray[j];
   }   

  }
}
    

    //show excercise 'obj' detials to grid
     var row = w2ui['grid'].records.length;
     w2ui['grid'].add([
    { recid: row+1,
     exercisename : exerciseName,
     week : week,
     day : day,
     exerciseid :  obj.id,
     exercisename: obj.name,
      difficulty: obj.difficulty,
           //get excercise image from folder
            img:  '<img src="img/exercises/'+obj.image+ '"width="140px" height="70px"/>',
            description: '<textarea readonly style="width: 290px; height: 180px; resize: none">'+obj.description+'</textarea>',
            rehearsals: obj.rehearsals,
            sets: obj.sets,
            bodyPart: obj.bodyPart,
            rest: obj.rest,
            speed: obj.speed,
            load: obj.load


   }]);
    w2ui['grid'].refresh();
}









</script>

</body>
</html>

<?php /*include footer file*/
include "footer.php"; ?>