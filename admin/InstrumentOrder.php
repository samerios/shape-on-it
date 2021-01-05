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
<h2 align="center">Order Instruments from supplier</h2>
<br/>

<!-- "chosse supplier" header-->
<div align="center">
choose supllier and send order:
<div style="height: 20px"></div>

<!-- suppliers list-->
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

<!-- if clicked "+ add new Instrument" button go to 'openPopup' function-->
<button class="w2ui-btn-orange" onclick="openPopup()">+ add new Instrument</button>
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
            { field: 'itemName', caption: 'Instrument Name', size: '150px', sortable: true, attr: 'align=center' },
            { field: 'itemQuantity', caption: 'Item Quantity', size: '10%', sortable: true }
        ],
        onAdd: function (event) {
             w2popup.open(openPopup());
        },
        onDelete: function (event) {
        }
    });    
});


</script>


<script type="text/javascript">

//"openPopup" function for load instruments details and add to list and open popup for show how instrument want to order and qnd quantity needed
function openPopup () {
//"itemss" array to save instruments names and show in list
var itemss=[];
 try{
    <?php
//get all instruments details by "getInstrumentsDetails" function
$itemss = getInstrumentsDetails();
$count = count((array)getInstrumentsDetails());
?>
    var lenght=<?php echo $count; ?>;
    //check if array lenght is positive
    if(lenght>=1)
    {
    //convert array from php to js array    
    var instruments = []; 
    var instruments = <?php echo json_encode($itemss); ?>;
    //add instruments details in "itemss" array
    for(var i=0;i<lenght;i++)
    {
        itemss.push(instruments[i].name);  
    }  

    } 
}catch(e)
{}
//sort instruments names
itemss.sort();
//add array to list
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
                  //go to "addNewIntrumentToGrid" function
                    addNewIntrumentToGrid();
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
        title   : 'Add New Instrument',
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

//"addNewIntrument" function for add instrument to grid (after clicked "save" in popup)
function addNewIntrumentToGrid()
{
     //get selected 'intrument name' and 'quantity' and save in variables
     var name= $('#item').w2field().get().text;
     var qty= w2ui['foo'].record['quantity'];

     //add 'instrument name' and 'quantity' to grid 
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
        //if selected supplier get numbers of grid rows (instruments)
        var grid = w2ui['grid'];
        var count = w2ui['grid'].records.length;
        //if no find intruments show message
        if(count==0)
        {
             w2alert('your order is empty')
            .ok(function () { return; });
        }
        else
        {
          //if selected supplier and find selected one or more instrument
          //send supplier name js variable in ajax for convert to php variable
            $.ajax({
                          type: 'POST',
                          url: 'InstrumentOrder.php',
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
   // session_start();
    $_SESSION['supplierorderid'] = $orderId;
}
?>
              //add all intruments to order
             for(var i=0;i<count;i++)
              {
                  //get selected intrument name and quantity and save in variables as place in grid
                  var intrument = grid.getCellValue(i, 0); 
                  var qty=grid.getCellValue(i, 1);
                 //send js variable in ajax for convert to php variable
                 $.ajax({
                       type: 'POST',
                          url: 'InstrumentOrder.php',
                        data: {'intrument': intrument,'qty':qty},
                        });

                <?php
            //if php find ajax request (js variables) save them in php variables
            if (isset($_POST['intrument']) && isset($_POST['qty'])) {
                //get session "supplierorderid" for get order id
                 session_start();
            if (isset($_SESSION['supplierorderid'])) $orderr = $_SESSION['supplierorderid'];
                 //get sent varibles from ajax
                 $intrument = $_POST['intrument'];
                 $qty = $_POST['qty'];
        //call"addInstrumentsToSupplierOrder" function for send intrument quantity user id and belong to order id (opened order)
               addInstrumentsToSupplierOrder($intrument, $orderr, @$id, $qty);
}
?>; 
            }
          //show succesful message
         w2alert('The order is sent')
       .ok(function () { window.location.reload("InstrumentOrder.php"); return; });
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
