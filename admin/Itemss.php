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
<h2 align="center">Items Details</h2>

<!--" +Add New Item" button if click at this button go to "newItem" page-->
<a href="newItem.php"><button class="w2ui-btn w2ui-btn-green" > +Add New Item</button></a>

<div id="main" style="width: 100%; height: 400px; "></div>
<script type="text/javascript">

//grid setting 
var config = {
    layout: {
        name: 'layout',
        padding: 4,
        panels: [
            { type: 'left', size: '67%', resizable: true, minSize: 200 },
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
            { field: 'id', caption: 'Item Id', size: '33%',searchable: true  },
            { field: 'name', caption: 'Item Name', size: '33%',searchable: true  },
            { field: 'quantity', caption: 'Quantity', size: '33%' ,searchable: true },
            { field: 'price', caption: 'Price', size: '120px',searchable: true  },
            { field: 'desc', caption: 'Description', size: '55%', sortable: true, searchable: true },
            { field: 'img', caption: 'image', size: '35%'}


        ],


          onDelete: function (event) {
            var grid = this;
            var form = w2ui.form;

           //if clicked to delete ,save selection item id in variable 
            var sel = grid.getSelection();
            var itemId = grid.getCellValue(sel-1, 0); 


         event.onComplete = function () {
          //send js variable in ajax for convert to php variable

                $.ajax({
                          type: 'POST',
                          url: 'itemss.php',
                          data: {'itemId': itemId},
                        });

                 <?php
//if php find ajax request (js variables) save them in php variables
if (isset($_POST['itemId'])) {
    $id = $_POST['itemId'];
    //send item id to "deleteItem" function for delete item details
    deleteItem($id);
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
        header: 'Edit Item',
        name: 'form',
        fields: [
            { name: 'recid', type: 'text', html: { caption: 'ID', attr: 'size="40" readonly' } },
            { name: 'id', type: 'int', required: true, html: { caption: 'Item id', attr: 'size="40" maxlength="40" readonly'  } },
            { name: 'name', type: 'text', html: { caption: 'Item name', attr: 'size="40" maxlength="40" readonly' } },
            { name: 'quantity', type: 'text',required: true, html: { caption: 'Quantity', attr: 'size="40"' } },
            { name: 'price', type: 'text',required: true, html: { caption: 'Price', attr: 'size="40"' } }
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
                    //if clicked save (edit item details ) save item details in variables 

                    var item_id = this.record.id;
                    var price = this.record.price;
                    var qty = this.record.quantity; 
                
                  //send js variables in ajax for convert to php variables

                        $.ajax({
                            type: 'POST',
                            url: 'itemss.php',
                            data: {'item_id': item_id,'price':price,'qty':qty},
                            });

                            <?php
//if php find ajax request (js variables) save them in php variables
if (isset($_POST['item_id']) && isset($_POST['price']) && isset($_POST['qty'])) {
    $id = $_POST['item_id'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    //send variables to "updateItem" function for update item details
    updateItem($id, $qty, $price);
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


//"loadData" function for load items details
function loadData()
{
     try{   
    <?php
//get all items details by "getItems" function
$items = getItems();
$count = count((array)getItems());
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive
    if(lenght>=1)
    {
      //convert array from php to js array  
      var row = w2ui['grid'].records.length;
      var items = [];
      var items = <?php echo json_encode($items); ?>;
    //get items details and show in grid
   for(var i=0;i<lenght;i++)
   {
         w2ui['grid'].add([
        { recid: row+i+1,
            id: items[i].id,
            name: items[i].name,
            quantity: items[i].qty,
            price: items[i].price,
            img:  '<img src="img/proteins/'+items[i].img+ '"width="70px" height="70px/>',
            desc: items[i].description }]);      
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
