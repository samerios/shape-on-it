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
<h2 align="center">Menu Details</h2>
<!--"+Add New Menu" button if click at this button go to "newMenu" page-->
<a href="newMenu.php"><button class="w2ui-btn w2ui-btn-green" > +Add New Menu</button></a>

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
            toolbarDelete    : false
        },
        columns: [
            { field: 'id', caption: 'Id', size: '33%',searchable: true  },
            { field: 'name', caption: 'Name', size: '100px',searchable: true  },
            { field: 'adjustment', caption: 'Adjustment', size: '100px' ,searchable: true },
            { field: 'firstMeal', caption: 'first Meal', size: '100px',searchable: true  },
            { field: 'secondMeal', caption: 'Second tMeal', size: '55%', sortable: true, searchable: true },
            { field: 'thirdMeal', caption: 'Third Meal', size: '55%', sortable: true, searchable: true },
            { field: 'fourthMeal', caption: 'Fourth Meal', size: '55%', sortable: true, searchable: true },
            { field: 'fifthMeal', caption: 'Fifth Meal', size: '55%', sortable: true, searchable: true },
            { field: 'description', caption: 'Description', size: '100px', sortable: true, searchable: true }
        ],

          onDelete: function (event) {
            var grid = this;

            var sel = grid.getSelection();
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
        header: 'Edit Menu',
        name: 'form',
        fields: [
            { name: 'recid', type: 'text', html: { caption: 'ID', attr: 'size="10" readonly' } },
            { name: 'id', type: 'int', required: true, html: { caption: 'Menu id', attr: 'size="30" maxlength="40" readonly'  } },
            { name: 'name', type: 'text', html: { caption: 'Menu name', attr: 'size="30" maxlength="40" readonly' } },
             { name: 'adjustment', type: 'text',required: true, html: { caption: 'Adjustment', attr:'size="30" maxlength="50"' } },
            { name: 'firstMeal', type: 'textarea',required: true, html: { caption: 'First Meal', attr:' style="width: 200px; height: 80px; resize: none"' } },
            { name: 'secondMeal', type: 'textarea',required: true, html: { caption: 'Second Meal', attr:' style="width: 200px; height: 80px; resize: none"' } },
            { name: 'thirdMeal', type: 'textarea',required: true, html: { caption: 'Third Meal', attr:' style="width: 200px; height: 80px; resize: none"' } },
            { name: 'fourthMeal', type: 'textarea',required: true, html: { caption: 'Fourth Meal', attr:' style="width: 200px; height: 80px; resize: none"' } },
            { name: 'fifthMeal', type: 'textarea',required: true, html: { caption: 'Fifth Meal', attr:' style="width: 200px; height: 80px; resize: none"' } },
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

 //if clicked save (edit menu details ) save menu details in variables 
                    var menu_id = this.record.id;
                    var adjustment = this.record.adjustment;
                    var firstMeal = this.record.firstMeal;
                    var secondMeal = this.record.secondMeal;
                    var thirdMeal = this.record.thirdMeal;
                    var fourthMeal = this.record.fourthMeal;
                    var fifthMeal = this.record.fifthMeal;
                    var description = this.record.description;
      //send js variables in ajax for convert to php variables
                        $.ajax({
                            type: 'POST',
                            url: 'menuDetails.php',
                            data: {'menu_id': menu_id,'adjustment':adjustment,'firstMeal':firstMeal,'secondMeal':secondMeal, 'thirdMeal':thirdMeal, 'fourthMeal':fourthMeal ,'fifthMeal':fifthMeal,'description':description},
                            });

                            <?php
//if php find ajax request (js variables) save them in php variables
if (isset($_POST['menu_id']) && isset($_POST['adjustment']) && isset($_POST['firstMeal']) && isset($_POST['secondMeal']) && isset($_POST['thirdMeal']) && isset($_POST['fourthMeal']) && isset($_POST['fifthMeal']) && isset($_POST['description'])) {
    $menu_id = $_POST['menu_id'];
    $adjustment = $_POST['adjustment'];
    $firstMeal = $_POST['firstMeal'];
    $secondMeal = $_POST['secondMeal'];
    $thirdMeal = $_POST['thirdMeal'];
    $fourthMeal = $_POST['fourthMeal'];
    $fifthMeal = $_POST['fifthMeal'];
    $description = $_POST['description'];
    //send variables to "updateMenu" function for update menu details
    updateMenu($menu_id, $adjustment, $firstMeal, $secondMeal, $thirdMeal, $fourthMeal, $fifthMeal, $description);
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


//"loadData" function for load menu details
function loadData()
{
    try{
    <?php
//get all menu details by "getMenus" function
$Menus = getMenus();
$count = count((array)getMenus());
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive
    if(lenght>=1)
    {
    //convert array from php to js array  
      var row = w2ui['grid'].records.length;
      var menu = [];
      var menu = <?php echo json_encode($Menus); ?>;
     //get menus details and show in grid  
   for(var i=0;i<lenght;i++)
   {
         w2ui['grid'].add([
        { recid: row+i+1,
            id: menu[i].idMenu,
            name: menu[i].name,
            adjustment: menu[i].adjustment,
            firstMeal: menu[i].firstMeal,
            secondMeal: menu[i].secondMeal,
            thirdMeal: menu[i].thirdMeal,
            fourthMeal: menu[i].fourthMeal,
            fifthMeal: menu[i].fifthMeal,
            description: menu[i].description,
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