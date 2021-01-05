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

<!--on load call to 'loadWorkScheduleData' function for load data to page-->
<body onload="loadWorkScheduleData()">

<!--header-->
<h2 align="center">Work Schedule </h2>

<!-- if clicked "+add new row" button go to 'openPopup' function-->
<button class="w2ui-btn w2ui-btn-green" onclick="openPopup()">+add new row</button>

<div id="main" style="width: 100%; height: 450px;"></div>


<script type="text/javascript">

//"staffs" array to save staff names and show in list
         var staffs=[];
         try{
        <?php
//get all staff details by "getStaff" function
$staff = getStaff();
$count = count((array)getStaff());
?>
        var lenght=<?php echo $count; ?>;
        //check if array lenght is positive
        if(lenght>=1)
        {
        //convert array from php to js array    
          var staffName = [];
          var staffName = <?php echo json_encode($staff); ?>;
            staffs.push(" ");
            //add staff details in "itemss" array
           for(var i=0;i<lenght;i++)
           {
               staffs.push(staffName[i].fname+' '+staffName[i].lname);  
           }  

        } 
    }catch(e)
    {

    }

if(lenght>0)
{
//sort staff names
   staffs.sort();
//add array to list
$('input[type=list]').w2field('list', { items: staffs });
}


//grid setting
var config = {
    layout: {
        name: 'layout',
        padding: 4,
        panels: [
            { type: 'left', size: '67%', resizable: true, minSize: 300 },
            { type: 'main', minSize: 300 }
        ]
    },
    grid: { 
        name: 'grid',
        show: {
            toolbar            : true,
            toolbarDelete    : true
        },
        columns: [
                    { field: 'hour', caption: 'Hour', size: '50px' },
                    { field: 'sunday', caption: 'Sunday', size: '90px', resizable: true },
                    { field: 'monday', caption: 'Monday', size: '90px', resizable: true },
                    { field: 'tuesday', caption: 'Tuesday', size: '90px', resizable: true },
                    { field: 'wedensday', caption: 'Wedensday', size: '90px', resizable: true },
                    { field: 'thursday', caption: 'Thursday', size: '90px', resizable: true },
                    { field: 'friday', caption: 'Friday', size: '90px', resizable: true },
                    { field: 'saturday', caption: 'Saturday', size: '90px', resizable: true }
        ],

        onAdd: function (event) {
             w2popup.open(openPopup());
             w2ui['grid'].refresh();

        },


          onDelete: function (event) {
            var grid = this;
            var form = w2ui.form;

            //if clicked to delete save selection row id and hour in variable 
            var sel = grid.getSelection();
            var hour = grid.getCellValue(sel-1, 0); 

         event.onComplete = function () {
          //send js variables in ajax for convert to php variables
                $.ajax({
                          type: 'POST',
                          url: 'workSchedule.php',
                          data: {'hour': hour},
                        });

                 <?php
//if php find ajax request (js variables) save them in php variables
if (isset($_POST['hour'])) {
    $hour = $_POST['hour'];
    //send hour to "deleteWorkPlanRow" function for delete row details
    deleteWorkPlanRow($hour);
}
?>    
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
        header: 'Edit Schedule',
        name: 'form',
        fields: [
             { name: 'hour', type: 'text', html: { caption: 'Hour', attr: 'size="20" maxlength="40" readonly' }},
            { name: 'sunday', type: 'list', options:  { items: staffs },required: true, html: { caption: 'Sunday', attr: 'size="20" maxlength="40"' } },
            { name: 'monday', type: 'list',  options:  { items: staffs },required: true, html: { caption: 'Monday', attr: 'size="20" maxlength="40"' } },
            { name: 'tuesday', type: 'list' , options:  { items: staffs },required: true, html: { caption: 'Thursday', attr: 'size="20" maxlength="40"' } },
            { name: 'wedensday', type: 'list',  options:  { items: staffs },required: true, html: { caption: 'Wedensday', attr: 'size="20" maxlength="40"' } },
            { name: 'thursday', type: 'list',  options:  { items: staffs },required: true, html: { caption: 'Thursday', attr: 'size="20" maxlength="40"' } },
            { name: 'friday', type: 'list', options:  { items: staffs },required: true, html: { caption: 'Friday', attr: 'size="20" maxlength="40"' } },
            { name: 'saturday', type: 'list', options:  { items: staffs }, required: true, html: { caption: 'Saturday', attr: 'size="20" maxlength="40"' } },
        ],
        actions: {
            Reset: function () {
                this.clear();
            },
            Cancel: function () {
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
 //if clicked save (edit row details ) save row details in variables 
                    var scheduleHour = this.record.hour;
                    var sunday = this.record.sunday.text;
                    var monday = this.record.monday.text; 
                    var tuesday = this.record.tuesday.text;
                    var wedensday = this.record.wedensday.text;
                    var thursday = this.record.thursday.text; 
                    var friday = this.record.friday.text;
                    var saturday = this.record.saturday.text;

  //send js variables in ajax for convert to php variables

                        $.ajax({
                            type: 'POST',
                            url: 'workSchedule.php',
                            data: {'scheduleHour': scheduleHour,'sunday':sunday,'monday':monday,'tuesday':tuesday,'wedensday':wedensday,'thursday':thursday,'friday':friday,'saturday':saturday},
                            });

                            <?php
//if php find ajax request (js variables) save them in php variables
if (isset($_POST['scheduleHour']) && isset($_POST['sunday']) && isset($_POST['monday']) && isset($_POST['tuesday']) && isset($_POST['wedensday']) && isset($_POST['thursday']) && isset($_POST['friday']) && isset($_POST['saturday'])) {
    $hour = $_POST['scheduleHour'];
    $sunday = $_POST['sunday'];
    $monday = $_POST['monday'];
    $tuesday = $_POST['tuesday'];
    $wedensday = $_POST['wedensday'];
    $thursday = $_POST['thursday'];
    $friday = $_POST['friday'];
    $saturday = $_POST['saturday'];
    //send variables to "וupdateWorkPlanRow" function for update row details
    וupdateWorkPlanRow($hour, $sunday, $monday, $tuesday, $wedensday, $thursday, $friday, $saturday);
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


 

//"loadWorkScheduleData" function for load rows details (work Schedule)
function loadWorkScheduleData()
{
     
     try{ 
    <?php
//get rows details (work Schedule) by "getWorkScchedule" function
$schedule = getWorkScchedule();
$count = count((array)getWorkScchedule());
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive
    if(lenght>=1)
    {
      //convert array from php to js array   
      var row = w2ui['grid'].records.length;
      var schedule = [];
      var schedule = <?php echo json_encode($schedule); ?>;
   //get rows details (work Schedule) and show in grid   
   for(var i=0;i<lenght;i++)
   {
         w2ui['grid'].add([
        { recid: row+i+1,
            hour: schedule[i].hour,
            sunday: schedule[i].sunday,
            monday: schedule[i].monday,
            tuesday: schedule[i].tuesday,
            wedensday: schedule[i].wedensday,
            thursday: schedule[i].thursday,
            friday: schedule[i].friday,
            saturday: schedule[i].saturday }]);      
   }   

    w2ui['grid'].refresh();
  }
  }catch(e)
  {
    
  }
    
 }

</script>



<script type="text/javascript">

 //"openPopup" function for add row in columm 'hour'
function openPopup () {
//form setting (form in popup)

    if (!w2ui.foo) {
        $().w2form({
            name: 'foo',
            style: 'border: 0px; background-color: transparent;',
            formHTML: 
                '<div class="w2ui-page page-0">'+
                '    <div class="w2ui-field">'+
                '        <label>Hour:</label>'+
                '        <div>'+
                '           <input name="hour" type="text" style="width: 250px"/>'+
                '        </div>'+
                '    </div>'+
                '<div class="w2ui-buttons">'+
                '    <button class="w2ui-btn" name="reset">Reset</button>'+
                '    <button class="w2ui-btn" name="save" >Save</button>'+
                '</div>',
            fields: [
                { field: 'hour', type: 'text', required: true }
            ],

            actions: {
            "save": function () { 
                this.save();
                //check all inputs data is not empty and valid                 
                if(this.record.hour!="" )
                {
                     //if input not empty and valid save in variable
                     var add_hour = this.record.hour;
                     //send js variable in ajax for convert to php variable

                        $.ajax({
                            type: 'POST',
                            url: 'workSchedule.php',
                            data: {'add_hour': add_hour},
                            });

                            <?php
//if php find ajax request (js variables) save them in php variables
if (isset($_POST['add_hour'])) {
    $hour = $_POST['add_hour'];
    //call to "" function forupdate schedule row
    $result = newWorkScheduleRow($hour);
}
?>;
                            //refresh
                       window.location.reload("workSchedule.php");
                    this.clear();
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
        title   : 'Add New Row',
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


</script>


</body>
</html>
 <?php /*include footer file*/
include "footer.php"; ?>