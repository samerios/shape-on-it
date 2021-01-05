<?php /*include header file*/
include "header.php";
//include 'mlAlgorithm' file to use "DecidsionTreeAlgorithm" class
require_once ('../mlAlgorithm.php');
?>


       
<?php

//after check all inputs if clicked "save"
if (isset($_POST['save'])) {
    //get inputs and save into varibels

    $menuName = @$_POST['menuss'];
    $workPlanName = @$_POST['workPlanName'];
    $about = @$_POST['about'];
    $duration = @$_POST['duration'];
    $goal = @$_POST['goal'];
    $requierments = @$_POST['requierments'];
    $targetGroup = @$_POST['targetGroup'];
    $height = @$_POST['height'];
    $weight = @$_POST['weight'];
    $fat = @$_POST['fat'];
    $sport = @$_POST['sport'];
    $medical_problems = @$_POST['medical_problems'];
    //call "getMenuId" function send menu name to get menu id
    $menu_id = getMenuId($menuName);
    //call "newWorkPlann" function send variables and get returned "workplan id"
     newWorkPlann($workPlanName, $about, $duration, $goal, $requierments, $targetGroup, $menu_id);

    //insert "DecidsionTreeAlgorithm" object
    $addToCsvFile = new DecidsionTreeAlgorithm();
    //call "addNewWorkplan" object function send variables to add in csv file
    $addToCsvFile->addNewWorkplan($workPlanName, $height, $weight, $fat, $sport, $medical_problems, $duration);

    
    echo '<script> w2alert("wokplan added");</script>';
    echo '<meta http-equiv="refresh" content="2; url=\'workPlans.php\'" />';    



}
?>

<br/>

<!DOCTYPE html>
<html>
<head>
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
      <script type="text/javascript" src="css/w2ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/w2ui-1.5.rc1.min"/>
</head>
<body>

<!--hedaer-->
<h2 align="center">Create a new Work plan</h2>




<script type="text/javascript">


//"types" array to save Susbcription types details and show in list
         var types=[];
         try{
        <?php
//get Susbcription types details by "getSusbcriptionTypDetails" function
$types = getSusbcriptionTypDetails();
$count = count((array)getSusbcriptionTypDetails());
?>
        var lenght=<?php echo $count; ?>;
      //check if array lenght is positive       
        if(lenght>=1)
        {
          //convert array from php to js array    
          var typess = [];
          var typess = <?php echo json_encode($types); ?>;
      //add Susbcription types details and show for show in "types" list
           
           for(var i=0;i<lenght;i++)
           {
               types.push(typess[i].name);  
           }  

        } 
    }catch(e)
    {

    }

if(lenght>0)
{
  //sort Susbcription types
   types.sort();
$('input[type=list]').w2field('list', { items: types });
}





//save 'yes and no' options into "yesNo" list
var yesNo=[];
yesNo.push('yes'); 
yesNo.push('no'); 

//"menus" array to save menus names and show in list
var menus=[];
 try{
    <?php
//get menus details by "getMenus" function
$menus = getMenus();
$count = count((array)getMenus());
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive
    if(lenght>=1)
    {
    //convert array from php to js array          
    var menuu = []; 
    var menuu = <?php echo json_encode($menus); ?>;
    //add menus details for show in "menus" list    
    for(var i=0;i<lenght;i++)
    {
        menus.push(menuu[i].name);  
    }  

    } 
}catch(e)
{}
//sort menus names
menus.sort();
//add to "menus" list

$('#list').w2field('list', {
    items: menus
});



//form setting
$(function () {
    $('#loginform').w2form({
        name  : 'loginform',
        header : 'save work plan Form',
        fields: [
            { field: 'workPlanName', type: 'text', required: true},
            { field: 'about', type: 'text', required: true },
            { field: 'duration',  type: 'list',  options: {items : types}, required: true },
            { field: 'goal', type: 'text', required: true },
            { field: 'menuss', type: 'list', options: {items : menus}, required: true },
            { field: 'requierments', type: 'text', required: true },
            { field: 'targetGroup', type: 'text', required: true  },
            { field: 'height', type: 'text', required: true },
            { field: 'weight', type: 'text', required: true  },
            { field: 'fat', type: 'text', required: true },
            { field: 'sport', type: 'list',  options: {items : yesNo}, required: true  },
            { field: 'medical_problems', type: 'list',  options: {items : yesNo}, required: true  },


        ],
        actions: {
            reset: function () {
                this.clear();
               
            },
      save: function (e) {
        this.save();  
              //check all inputs data is not empty and valid 
                if(this.record.workPlanName!="" && this.record.about!="" && this.record.duration!="" && this.record.goal!="" && this.record.requierments!="" && this.record.targetGroup!="" && this.record.menuss!="" && this.record.height!="" && this.record.weight!="" && this.record.fat!="" && this.record.sport!="" && this.record.medical_problems!="" && (this.record.weight>=50&&this.record.weight<=350) &&(this.record.height>=140&&this.record.height<=220) && (this.record.fat>=5&&this.record.fat<=80))
                {
                  
                  

                }
                  else
                  {
                       //if one or more inputs empty show toasts you need to fill the input       
                       e.preventDefault();

                       if(!(this.record.weight>=50&&this.record.weight<=350))
                       {
                        w2ui['loginform'].record['weight'] = ''; 
                        w2ui['loginform'].refresh();
                       }
                        if(!(this.record.height>=140&&this.record.height<=220))
                       {
                        w2ui['loginform'].record['height'] = ''; 
                        w2ui['loginform'].refresh();
                       }
                       if(!(this.record.fat>=5&&this.record.fat<=80))
                       {
                        w2ui['loginform'].record['fat'] = ''; 
                        w2ui['loginform'].refresh();
                       }
                  }
                  

            }
        },

    });

});




</script>


<!--form-->
<div align="center">
<form id="loginform" method="post" style="width: 550px" >
    <div class="w2ui-page page-0">
 
   <div class="w2ui-field">
       <label>work Plan Name:</label>
        <div>
            <input name="workPlanName" type="text" minlength="5" maxlength="50"size="40"/>
        </div>
    </div>

    <div class="w2ui-field">
       <label>About</label>
        <div>
            <textarea name="about" type="text" minlength="12" maxlength="2048" style="width: 250px; height: 80px; resize: none"></textarea>
        </div>
    </div>


     <div class="w2ui-field">
       <label>Duration:</label>
        <div>
            <input name="duration" type="text" minlength="4" maxlength="12" size="40"/>
        </div>
    </div>

     <div class="w2ui-field">
       <label>Goal:</label>
        <div>
            <input name="goal" type="text" minlength="6" maxlength="50" size="40"/>
        </div>
    </div>

     <div class="w2ui-field">
       <label>Requierments:</label>
        <div>
            <input name="requierments" type="text" minlength="5" maxlength="50" size="40"/>
        </div>
    </div>

     <div class="w2ui-field">
       <label>Target Group:</label>
        <div>
            <input name="targetGroup" type="text" minlength="5" maxlength="50" size="40"/>
        </div>
    </div>



    <div class="w2ui-field">
        <label>Menu:</label>
      <div>
          <input  name="menuss" size="40"/>
      </div>
   </div>

   <div class="w2ui-field">
        <label>adjusting Height: </label>
      <div>
          <input  name="height" type="text" minlength="3" maxlength="3" size="40" />
      </div>
   </div>

   <div class="w2ui-field">
        <label>adjusting weight:</label>
      <div>
          <input  name="weight" type="text" minlength="2" maxlength="3" size="40" />
      </div>
   </div>

    <div class="w2ui-field">
        <label>adjusting Fat:</label>
      <div>
          <input  name="fat" type="text" minlength="1" maxlength="2" size="40" />
      </div>
   </div>



   <div class="w2ui-field">
        <label>sport habits:</label>
      <div>
          <input  name="sport" size="40" />
      </div>
   </div>

    <div class="w2ui-field">
        <label>medical problems:</label>
      <div>
          <input  name="medical_problems" size="40" />
      </div>
   </div>


  </div>

    <div class="w2ui-buttons">
       <button name="reset" class="w2ui-btn" >Reset</button>
       <button name="save" class="w2ui-btn" >Save </button>

    </div>

  </form>
</div>




<!-- if clicked "Back" button return to 'workPlans' page-->
<a href="workPlans.php"><button class="w2ui-btn" >Back</button></a>

</body>
</html>
 <?php /*include footer file*/
include "footer.php"; ?>