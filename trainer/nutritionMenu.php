<?php /*include header file*/
include "header.php";
//check if is get in url thad sent from workplan page if yes get them and in variables to show them
if (isset($_GET['id'])) {
    $menuid = $_GET['id'];
}
if (isset($_GET['name'])) {
    $menuname = $_GET['name'];
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

<!--on load call to 'loadData' function for load data to page-->
<body onload="loadData()">
<!--header-->
<h2 align="center">Nurtion Menu Details</h2>



<!-- show Nurtion Menu name-->
<div align="center">
<p style="color:red;">Nurtion Menu: <?php echo $menuname; ?> 
</div>


<div id="grid" style="width: 100%; height: 500px;"></div>

<script type="text/javascript">

//grid setting
$(function () {
    $('#grid').w2grid({ 
        name: 'grid',
        recordHeight: 500,
        show: { 
            toolbar: true,
            footer: true
        },
      
        columns: [
            { field: 'name', caption: 'Menu Name', size: '100px' },
            { field: 'firstMeal', caption: 'Firs tMeal', size: '300px' },
            { field: 'secondMeal', caption: 'Second Meal', size: '300px' },
            { field: 'thirdMeal', caption: 'Third Meal', size: '300px' },
            { field: 'fourthMeal', caption: 'Fourth Meal', size: '300px' },
            { field: 'fifthMeal', caption: 'Fifth Meal', size: '300px' },
            { field: 'description', caption: 'Description', size: '300px', resizable: true  }                
        ]
    });    
});



//"loadData" function for load nutrition menu details

function loadData()
{
     try{   
    <?php
//check if is get in url that sent from workplan page if yes get id (nutrition menu id )
if (isset($_GET['id'])) {
    $menuid = $_GET['id'];
}
?>;

 <?php
//get all menus by "getMenus" function
$menus = getMenus();
$count = count((array)getMenus());
?>;

    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive

    if(lenght>=1)
    {
      //convert array from php to js array
      var row = w2ui['grid'].records.length;
      var menus = [];
      var menus = <?php echo json_encode($menus); ?>;
      var id=<?php echo $menuid; ?>;

  //show menu details and show in grid
   for(var i=0;i<lenght;i++)
   {
      if(menus[i].idMenu==id)
      {

         w2ui['grid'].add([
        { recid: row+i+1,
            name: menus[i].name,
            firstMeal: '<textarea readonly style="width: 290px; height: 500px; resize: none">'+menus[i].firstMeal+'</textarea>',            
            secondMeal: '<textarea readonly style="width: 290px; height: 500px; resize: none">'+menus[i].secondMeal+'</textarea>',
            thirdMeal: '<textarea readonly style="width: 290px; height: 500px; resize: none">'+menus[i].thirdMeal+'</textarea>',
            fourthMeal: '<textarea readonly style="width: 290px; height: 500px; resize: none">'+menus[i].fourthMeal+'</textarea>',
            fifthMeal: '<textarea readonly style="width: 290px; height: 500px; resize: none">'+menus[i].fifthMeal+'</textarea>',
            description: '<textarea readonly style="width: 290px; height: 500px; resize: none">'+menus[i].description+'</textarea>'}]);    
     }
          
   }   

    w2ui['grid'].refresh();
  }
}catch(e){}
    
 }


</script>


<!-- after clicked "back" button if trainer not sent feedback the system will show popup form -->

<script type="text/javascript">
  //"openPopup" function to show feedbak form 
function openPopup () {

  //save 'yes and no' options into "itemss" list
        var itemss=[];    
        itemss.push("yes"); 
        itemss.push("no");  
$('list').w2field('list', {
    items: itemss
});

//form in popup setting
    if (!w2ui.foo) {
        $().w2form({
            name: 'foo',
            style: 'border: 0px; background-color: transparent;',
            formHTML: 
            
                '<div class="w2ui-page page-0">'+
                '    <div class="w2ui-field">'+
                '        <label>Are You Satisfed? :</label>'+
                '        <div>'+
                '           <input name="item" style="width: 250px"/>'+
                '        </div>'+
                '    </div>'+
                '<div class="w2ui-buttons">'+
                '    <button class="w2ui-btn" name="save" >Save</button>'+
                '</div>',
            fields: [
                { field: 'item', type: 'list',options: {items: itemss}, required: true }
            ],

            actions: {
            "save": function (e) { 
                this.save();
                //if answer the feedback
                  if(this.record.item!="")
                {
                  //go to "sendFeedback" js function in this page 
                    sendFeedback();
                    //after "sendFeedback" function end (add feedback to database) show message 

                      w2alert('Thank You For Your Feedback :)')
                    .ok(function () { return; });



                }
                 //if not answer the feedback do nothing
                    else
                e.preventDefault(); 
            },
            }
        });


    }
//popup setting
    $().w2popup('open', {
        title   : 'Feedback',
        body    : '<div id="form" style="width: 100%; height: 100%;"></div>'+
        '<div class="w2ui-centered" style="line-height: 1.8">'+
                  'Please help us to improve our system  <br> <br><br>'+
                  '</div>',
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


//"sendFeedback" function for add feedback to database (use function from "function file") 
function sendFeedback()
{
     //get the feedback answer        
     var answer= $('#item').w2field().get().text;
      //send 'answer' js variable in ajax to get it in php
                 $.ajax({
                       type: 'POST',
                          url: 'nutritionMenu.php',
                        data: {'answer': answer},
                        });
                 //get answer js variable
                <?php
if (isset($_POST['answer'])) {
    $answer = $_POST['answer'];
    //get work plan is that the trainer is belong to by "getSubsDetails" function
    $trainers = getSubsDetails(@$id,'active');
    $workplanid = $trainers->WorkPlan->id;
    //update feedbacks table by "updateFeedback" function in addition the function update the trainer alrealy sent feedback
    updateFeedback(@$id, $workplanid, $answer);
}
?>; 
}
      

</script>


<?php
//if clicked "back" button
if (isset($_POST['back'])) {
    //check if trainer alrealy sent feedback or no and if no
    if (isTrainerAnswerForFeedback(@$id) == 0) {
        //open the popup (form) feedback answer
        echo '<script type="text/javascript">', 'openPopup();', '</script>';
    } else
    // if trainer alrealy sent feedback go to "workPlanDetails" page
    echo '<meta http-equiv="refresh" content="0; url=\'workPlanDetails.php\'" />';
}
?>

<form name="form" method="post">
  <br/>
<button class="w2ui-btn" name="back" >Back</button>
</form>


</body>
</html>

<?php /*include footer file*/ include "footer.php"; ?>
