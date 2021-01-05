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

<!--on load call to 'loadSuppliers' function for load data to page-->
<body onload="loadSuppliers()">
<!--headerr-->
<h2 align="center">Order Proteins</h2>
<br/>

<!-- "chosse supplier" header-->
<div align="center">
choose supllier and send order:
<div style="height: 20px"></div>
    <div class="w2ui-page page-0">
    <div class="w2ui-field">
    Supplier : <input id="list" name="supp" style="width: 300px;">
    </div>
</div>

<br/>
<!-- if clicked "send order" button go to 'sendd' function-->
<button name="send" onclick="sendd()" class="w2ui-btn-green" >send order </button>
</div>
<br/>

<!-- if clicked "+ add new item" button go to 'openPopup' function-->
<button class="w2ui-btn-orange" onclick="openPopup()">add new item</button>
<br/>

<div id="grid" style="width: 100%; height: 300px;"></div>
<script type="text/javascript">
//grid setting
$(function () {    
    $('#grid').w2grid({ 
        name: 'grid', 
        show: { 
            toolbar: true,
            footer: true,
            toolbarDelete: true,
      
        },
        searches: [                
            { field: 'itemName', caption: 'Item Name', type: 'text' },
            { field: 'itemQuantity', caption: 'Item Quantity', type: 'int' },
        ],
        columns: [
            { field: 'itemName', caption: 'Item Name', size: '150px', sortable: true, attr: 'align=center' },
            { field: 'itemQuantity', caption: 'Item Quantity', size: '10%', sortable: true }
        ],
        onAdd: function (event) {
             w2popup.open(openPopup());
        },
        onDelete: function (event) {
            console.log('delete has default behavior');
        }
    });    
});


</script>


<script type="text/javascript">
//"openPopup" function for load proteins details and add to list and open popup for show how proteins want to order and and quantity needed 
function openPopup () {
  //"itemss" array to save proteins names and show in list
  var itemss=[];
 try{
    <?php
//get all proteins details by "getItems" function
$itemss = getItems();
$count = count((array)getItems());
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive
    if(lenght>=1)
    {
    //convert array from php to js array    
    var proteins = []; 
    var proteins = <?php echo json_encode($itemss); ?>;
    //add proteins details for show in "itemss" list
    for(var i=0;i<lenght;i++)
    {
        itemss.push(proteins[i].name);  
    }  

    } 
}catch(e)
{}

//sort instruments names
itemss.sort();
//add to "itemss" list
$('list').w2field('list', {
    items: itemss
});

//form setting (form in popup)
    if (!w2ui.foo) {
        $().w2form({
            name: 'foo',
            style: 'border: 0px; background-color: transparent;',
            formHTML: 
                '<div class="w2ui-page page-0">'+
                '    <div class="w2ui-field">'+
                '        <label>Item:</label>'+
                '        <div>'+
                '           <input name="item" style="width: 250px"/>'+
                '        </div>'+
                '    </div>'+
                '    <div class="w2ui-field">'+
                '        <label>Quantity:</label>'+
                '        <div>'+
                '            <input name="quantity" type="int" maxlength="100" style="width: 250px"/>'+
                '        </div>'+
                '    </div>'+
                '<div class="w2ui-buttons">'+
                '    <button class="w2ui-btn" name="reset">Reset</button>'+
                '    <button class="w2ui-btn" name="save" >Save</button>'+
                '</div>',
            fields: [
                { field: 'item', type: 'list',options: {items: itemss}, required: true },
                { field: 'quantity', type: 'int', required: true },
            ],

            actions: {
            "save": function (e) { 
                this.save();
                //check all inputs data is not empty and valid 
                  if(this.record.item!="" && this.record.quantity!="")
                {
                  //if all inputs data is not empty and valid 
                  //go to "addnewProtein" function
                    addnewProtein();
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
        title   : 'Add New Item',
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


<script type="text/javascript">

//"loadSuppliers" function for load suppliers names to list
function loadSuppliers()
{
    //"suppliers" array to save suppliers names and show in list
    var suppliers=[];
 try{
    <?php
//get all suppliers details by "getSuppliers" function
$suppliers = getSuppliers();
$count = count((array)getSuppliers());
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive
    if(lenght>=1)
    {
    //convert array from php to js array   
    var supplierss = []; 
    var supplierss = <?php echo json_encode($suppliers); ?>;
        //add suppliers to array

    for(var i=0;i<lenght;i++)
    {
        suppliers.push(supplierss[i].fullname);  
    }  

    } 
}catch(e)
{}
//add array to "suppliers" list
$('#list').w2field('list', {
    items: suppliers
});

}

//"addnewProtein" function for add Proteins to grid (after clicked "save" in popup)

function addnewProtein()
{
     //get selected 'protein name' and 'quantity' and save in variables
     var name= $('#item').w2field().get().text;
     var qty= w2ui['foo'].record['quantity'];

     //add 'protein name' and 'quantity' to grid 

     w2ui['foo'].refresh();
     var row = w2ui['grid'].records.length;

     w2ui['grid'].add([
    { recid: row+1,
     itemName: name ,
     itemQuantity : qty}]);
    w2ui['grid'].refresh();
}

//"sendd" function for send save order (after clicked "send order" button)
function sendd()
{

    //get selected supplier name and save in variable
    var name= $('#list').w2field().get().text;
    //if not selected supplier show message
    if(!name)
    {
        w2alert('Please choose a Supplier')
       .ok(function () { return; });
    }
    else
    {
        //if selected supplier get numbers of grid rows (proteins)
         var grid = w2ui['grid'];
        var count = w2ui['grid'].records.length;
       //if no find proteins show message
        if(count==0)
        {
             w2alert('your order is empty')
            .ok(function () { return; });
        }
        else
        {
          //if selected supplier and find selected one or more proteins
          //send supplier name js variable in ajax for convert to php variable
            $.ajax({
                          type: 'POST',
                          url: 'proteinsOrder.php',
                          data: {'name': name},
                        });
                 <?php
$orderId = "";
//if php find ajax request (js variables) save them in php variables
if (isset($_POST['name'])) {
    $name = $_POST['name'];
    //get supplier name and send by "getSupplierId" function for get supplier id
    $supplierId = getSupplierId($name);
    //get date now
    $d = $mydate = getdate(date("U"));
    $date = "$mydate[year]-$mydate[mon]-$mydate[mday]";
    //open supplier order by "openOrderFromSupplier" and get returned order id
    $orderId = openOrderFromSupplier($date, @$id, $supplierId);
    //start session "supplierorderid" for get order id in continued code
    //session_start();
    $_SESSION['supplierorderid'] = $orderId;
}
?>

            //add all proteins to order
             for(var i=0;i<count;i++)
              {
                //get selected protein name and quantity and save in variables as place in grid
                  var item = grid.getCellValue(i, 0); 
                  var qty=grid.getCellValue(i, 1);
                  //send js variable in ajax for convert to php variable
                 $.ajax({
                       type: 'POST',
                          url: 'proteinsOrder.php',
                        data: {'item': item,'qty':qty},
                        });

                <?php
//if php find ajax request (js variables) save them in php variables
if (isset($_POST['item']) && isset($_POST['qty'])) {
    //get session "supplierorderid" for get order id
    session_start();
    if (isset($_SESSION['supplierorderid'])) $orderr = $_SESSION['supplierorderid'];
    //get sent varibles from ajax
    $item = $_POST['item'];
    $qty = $_POST['qty'];
    //call"addItemsToSupplierOrder" function for send protein quantity user id and belong to order id (opened order)
    addItemsToSupplierOrder($item, $orderr, @$id, $qty);
}
?>; 

            }
          //show succesful message
         w2alert('the order is sent')
       .ok(function () { return; });
       unset($_SESSION['supplierorderid']);
  
        }
        
    }

}

</script>

<!-- if clicked "Back" button return to 'ordersFromSuppliers' page-->

</br>
<a href="ordersFromSuppliers.php"><button class="w2ui-btn" >Back</button></a>
</body>
</html>
 <?php /*include footer file*/
include "footer.php"; ?>