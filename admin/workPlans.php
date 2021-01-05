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
<h2 align="center">Work Plans</h2>

<!--"+ Add a work plan" button if click this button go to "newWorkPlan" page -->

<div align="center">
<a href="newWorkPlan.php"><button class="w2ui-btn w2ui-btn-green" >+ Add a work plan</button></a>
</div>

<div id="grid" style="width: 100%; height: 550px;"></div>

<script type="text/javascript">
//grid setting 
$(function () {
    $('#grid').w2grid({ 
        name: 'grid', 
        columns: [                
            { field: 'workPlanId', caption: 'Id', size: '10%' },
            { field: 'name', caption: 'Name', size: '10%' },
            { field: 'about', caption: 'About', size: '10%' },
            { field: 'duration', caption: 'Duration', size: '10%' },
            { field: 'goal', caption: 'Goal', size: '10%' },
            { field: 'requierments', caption: 'Requierments', size: '10%%' },
            { field: 'targetGroup', caption: 'Target Group', size: '10%%' },
            { field: 'menuId', caption: 'Menu Id', size: '10%%' },
            { field: 'see', caption: 'See', size: '10%%' }
        ]
    });    
});


//"loadData" function for load all WorkPlans details

function loadData()
{
       
     try{  
    <?php
    //get all WorkPlans details by "getWorkPlans" function
    $workplans = getWorkPlans();
    $count = count((array)getWorkPlans()); 

    ?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive

    if(lenght>=1)
    {
      var row = w2ui['grid'].records.length;
      var plann = [];
      
      var plann = <?php echo json_encode($workplans);?>;
  //get WorkPlans details and show in grid
   for(var i=0;i<lenght;i++)
   {
         w2ui['grid'].add([
        { recid: row+i+1,
            workPlanId: plann[i].id,
            name: plann[i].name,
            about: plann[i].about,
            duration: plann[i].duration,
            goal: plann[i].goal,
            requierments: plann[i].requierments,
            targetGroup: plann[i].targetGroup,
            menuId: plann[i].Menu.idMenu,
            //if click "see" button send variables (workplan id and menu id) for "workPlanDetails" page with url 
            see: '<a href="workPlanDetails.php?workPlanIdd='+plann[i].id+'&menuId='+plann[i].Menu.idMenu+'"><button class="w2ui-btn-green" value="green">see</button>' }]);      
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