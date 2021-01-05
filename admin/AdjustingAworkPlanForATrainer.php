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

<!--hedaers-->
<h2 align="center">Adjusting </h2>
<h6 align="center">NOTE: Don't edit workplan "Only in exceptional condition"!!</h6>

<div id="main" style="width: 100%; height: 400px;"></div>

<script type="text/javascript">
//get all workplans by "getWorkPlans" function
        var plans=[];
         try{
        <?php
$plans = getWorkPlans();
$count = count((array)getWorkPlans());
?>
        var lenght=<?php echo $count; ?>;
        //check if array lenght is positive
        if(lenght>=1)
        {
          //convert array from php to js array
          var workplans = [];
          var workplans = <?php echo json_encode($plans); ?>;
           //add all workplans array to "plan" list 
           for(var i=0;i<lenght;i++)
           {
               plans.push(workplans[i].name);  
           }  

        } 
    }catch(e)
    {

    }
//sort plans list 
if(lenght>0)
{
   plans.sort();
$('input[type=list]').w2field('list', { items: plans });
}

//grid setting 
var config = {
    layout: {
        name: 'layout',
        padding: 4,
        panels: [
            { type: 'left', size: '67%', resizable: true, minSize: 800 },
            { type: 'main', minSize: 350 }
        ]
    },
    grid: { 
        name: 'grid',
        show: {
            toolbar            : true,
            toolbarDelete    : false
        },
        columns: [

            { field: 'id', caption: 'Id', size: '20%', sortable: true, searchable: true },
            { field: 'height', caption: 'Height', size: '100px', sortable: true, searchable: true },
            { field: 'weight', caption: 'Weight', size: '100px' , sortable: true, searchable: true},
            { field: 'fat', caption: 'Fat %', size: '60px' , sortable: true, searchable: true},
            { field: 'issport', caption: 'Sport habits', size: '100px' , sortable: true, searchable: true},
            { field: 'isMedical', caption: 'Medical Problems', size: '100px' , sortable: true, searchable: true},
            { field: 'type', caption: 'Type', size: '70px' , sortable: true, searchable: true},
            { field: 'workPlan', caption: 'Workplan', size: '200px' , sortable: true, searchable: true },
            { field: 'feedback', caption: 'Workplan', size: '80px' },
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
        header: 'Edit workplan',
        name: 'form',
        fields: [
            { name: 'id', type: 'text', html: { caption: 'Id', attr: 'size="10" readonly' } },
            { name: 'height', type: 'text',required: true, html: { caption: 'Height', attr: 'size="40" readonly' } },
            { name: 'weight', type: 'text', required: true, html: { caption: 'Weight', attr: 'size="40" maxlength="40" readonly' } },
            { name: 'fat', type: 'text', required: true, html: { caption: 'Fat', attr: 'size="40" maxlength="40" readonly' } },
            { name: 'issport', type: 'text', required: true, html: { caption: 'Sport habits', attr: 'size="40" maxlength="40" readonly' } },
            { name: 'isMedical', type: 'text', required: true, html: { caption: 'Medical Problems', attr: 'size="40" maxlength="40" readonly' } },
            { name: 'type', type: 'text', required: true, html: { caption: 'Type', attr: 'size="40" maxlength="40" readonly' } },
            { name: 'workPlan', type: 'list',  options: {items : plans}, required: true, html: { caption: 'WorkPlan', attr: 'size="40" maxlength="40"' } },

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
                    //if clicked save (edit work plan ) save work plan name and tainer in variables 
                    var workplanName = this.record.workPlan.text;
                    var trainerId = this.record.id;
                    //send js variables in ajax for convert to php variables
                        $.ajax({
                            type: 'POST',
                            url: 'AdjustingAworkPlanForATrainer.php',
                            data: {'workplanName': workplanName,'trainerId': trainerId},
                            });
                            //if php find ajax request (js variables) save them in php variables
                            <?php
if (isset($_POST['workplanName']) && isset($_POST['trainerId'])) {
    $workplanName = $_POST['workplanName'];
    $trainerId = $_POST['trainerId'];
    //send variables to "setNewWorkplanForTrainer" function for update workplan to trainer
    setNewWorkplanForTrainer($trainerId, $workplanName);
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

//"loadData" function for load Subscriptions details
function loadData()
{
       try{
    <?php
//get all Subscriptions details status active by "getSubscriptions" function
$subscriptions = getSubscriptions("active");
$count = count((array)getSubscriptions("active"));
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive

    if(lenght>=1)
    {
     //convert array from php to js array
      var row = w2ui['grid'].records.length;
      var subcribes = [];
      var subcribes = <?php echo json_encode($subscriptions); ?>;
  //show Subscriptions details and show in grid
   for(var i=0;i<lenght;i++)
   {
         w2ui['grid'].add([
        { recid: row+i+1,
            id: subcribes[i].id,
            height: subcribes[i].height,
            weight: subcribes[i].weight,
            fat: subcribes[i].fat,
            issport: subcribes[i].sportHabits,
            isMedical:subcribes[i].medicalProblems,
            workPlan: subcribes[i].WorkPlan.name,
            type:subcribes[i].subscriptionType,
            //send if clicked "feedback" button send work plan name in url to "feedsBi" page
            feedback:'<a href="feedsBi.php?workPlan='+subcribes[i].WorkPlan.id+'"><button class="w2ui-btn-green" value="green">feedback</button>'
             }]);      
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
