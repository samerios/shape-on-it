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
//get menu id from url and save in variable
if (isset($_GET['menuId'])) {
    $menuId = $_GET['menuId'];
}
?>
 <!--if clicked "To Nutrition Menu" button add menu id to url -->
<a href="subsNutritionMenu.php?id=<?php echo $menuId; ?>"><button class="w2ui-btn w2ui-btn-green">~To Nutrition Menu</button></a>
</div>


<?php
//get workplan id from url and save in variable
if (isset($_GET['workPlanIdd'])) {
    $id = $_GET['workPlanIdd'];
}
?>
  <!--workplan id hedear-->

<div align="center">
<p>Work Plan ID: <?php echo $id; ?> 
</div>


<div id="grid" style="width: 100%; height: 1000px;"></div>

<script type="text/javascript">
  //grid details 
$(function () {
    $('#grid').w2grid({ 
        name: 'grid',
        recordHeight: 150,
        show: { 
            toolbar: true,
            footer: true
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


           
        ]
    });    
});


//"loadData" function for load all excercises belongs to selected workplan
function loadData()
{
     try{   
    <?php
//get workplan id from url and save in variable
if (isset($_GET['workPlanIdd']))  $id = $_GET['workPlanIdd'];

//get all excercises belongs to selected workplan by "getExercisesInWorkPlan" function
$exerciseInWorPlan = getExercisesInWorkPlan($id);
//get all excercises by "getExercises" function
$exercises = getExercises();
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
      var exerciseInWorPlanArray = <?php echo json_encode($exerciseInWorPlan); ?>;

      var excercisesArray = [];
      var excercisesArray = <?php echo json_encode($exercises); ?>;


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
            img:  '<img src="../admin/img/exercises/'+excercisesArray[j].image+ '"width="140px" height="70px"/>',
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


</script>

</body>
</html>

<?php /*include footer file*/
include "footer.php"; ?>
