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
<body onload=" loadData();">
<!--header-->
<h2 align="center">Intruments Managment</h2>
<!--" +Add New Instrument" button if click at this button go to "newInstrument" page-->
<a href="newInstrument.php"><button class="w2ui-btn w2ui-btn-green" > +Add New Instrument</button></a>


<div id="main" style="width: 100%; height: 400px;"></div>

<script type="text/javascript">
//grid setting 

var config = {
    layout: {
        name: 'layout',
        padding: 4,
        panels: [
            { type: 'left', size: '67%', resizable: true, minSize: 400 },
            { type: 'main', minSize: 300 }
        ]
    },
    grid: { 
        name: 'grid',
        recordHeight: 90,
        show: {
            toolbar            : true,
            toolbarDelete    : true
        },
        columns: [
            { field: 'id', caption: 'ID', size: '50px', sortable: true, searchable: 'int', resizable: true },
            { field: 'number', caption: 'Instrument Number', size: '80px', sortable: true, searchable: 'int', resizable: true },
            { field: 'name', caption: 'Instrument Name', size: '140px', sortable: true, searchable: 'int', resizable: true },
            { field: 'lastcheck', caption: 'Last Check', size: '140px', sortable: true, searchable: 'Date', resizable: true },
            { field: 'buydate', caption: 'Buy Date', size: '140px', sortable: true, searchable: 'Date', resizable: true },
            { field: 'testdate', caption: 'Test Date', size: '140px', sortable: true, searchable: 'Date', resizable: true },
            { field: 'image', caption: 'Image',size: '55%'},

        ],


         onDelete: function (event) {
            var grid = this;
            var form = w2ui.form;
            //if clicked to delete ,save selection intrument id in variable 

            var sel = grid.getSelection();
            var Instrument_id = grid.getCellValue(sel-1, 0); 


         event.onComplete = function () {
  //send js variable in ajax for convert to php variables
                $.ajax({
                          type: 'POST',
                          url: 'Instruments.php',
                          data: {'Instrument_id': Instrument_id},
                        });

                 <?php
//if php find ajax request (js variables) save them in php variables
if (isset($_POST['Instrument_id'])) {
    $Instrument_id = $_POST['Instrument_id'];
    //send Instrument id to "deleteInstrument" function for delete Instrument details
    deleteInstrument($Instrument_id);
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
        header: 'Edit Instrument',
        name: 'form',
        fields: [
            { name: 'recid', type: 'text', html: { caption: 'ID', attr: 'size="10" readonly' } },
            { name: 'name', type: 'text', html: { caption: 'Instrument Name', attr: 'size="20" maxlength="40" readonly' } },
            { name: 'number', type: 'text', html: { caption: 'Instrument Number', attr: 'size="20" maxlength="40" readonly' } },
            { name: 'lastcheck', type: 'Date', required: true, html: { caption: 'Last Check', attr: 'size="20" maxlength="40"' } },
            { name: 'testdate', type: 'Date', required: true, html: { caption: 'Test Date', attr: 'size="20" maxlength="40"' } }
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
                     //if clicked save (edit Instrument details ) save Instrument details in variables 
                    var instr_id = this.record.id;
                    var lastcheck = this.record.lastcheck;
                    var testdate = this.record.testdate;
                    
  //send js variables in ajax for convert to php variables
                        $.ajax({
                            type: 'POST',
                            url: 'Instruments.php',
                            data: {'instr_id': instr_id,'lastcheck':lastcheck,'testdate':testdate},
                            });
                 //if php find ajax request (js variables) save them in php variables
                            <?php
if (isset($_POST['instr_id']) && isset($_POST['lastcheck']) && isset($_POST['testdate'])) {
    $instr_id = $_POST['instr_id'];
    $lastcheck = $_POST['lastcheck'];
    $testdate = $_POST['testdate'];
    //send variables to "updateInstrumentDetails" function for update Instrument details
    updateInstrumentDetails($instr_id, $lastcheck, $testdate);
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




//"loadData" function for load Instruments details
function loadData()
{
     try{  
    <?php
//get all Instruments details by "getInstrumentsDetails" function
$intruments = getInstrumentsDetails();
$count = count((array)getInstrumentsDetails());
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive
    if(lenght>=1)
    {
    //convert array from php to js array  
      var row = w2ui['grid'].records.length;
      var instrumentss = [];
      var instrumentss = <?php echo json_encode($intruments); ?>;
  //get instruments details and show in grid
   for(var i=0;i<lenght;i++)
   {
         w2ui['grid'].add([
        { recid: row+i+1,
            id: instrumentss[i].id,
            number: instrumentss[i].number,
            name: instrumentss[i].name,
            buydate: instrumentss[i].buyDate,
            lastcheck: instrumentss[i].lastCheckDate,
            testdate: instrumentss[i].testDate,
            //get instrument image from "instruments" folder
            image:  '<img src="img/instruments/'+instrumentss[i].image+ '"width="90px" height="90px"/>',
            
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
