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
<h2 align="center">Nurtion Menu Details</h2>


<?php
//get menu id and save in variable
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
?>

<!--Nurtion Menu Header-->
<div align="center">
<p>Nurtion Menu ID: <?php echo $id; ?> 
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
//get menu id and save in variable
if (isset($_GET['id'])) {
    $id = $_GET['id'];
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
      var id=<?php echo $id; ?>;

 //convert array from php to js array
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

</body>
</html>

<?php /*include footer file*/
include "footer.php"; ?>
