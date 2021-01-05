<?php /*include header file*/
include "header.php";
//this page show product details after click "more details" in items page
//get product id and save it in variable
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = getItems();
    $count = count(getItems());
    for ($i = 0;$i < $count;$i++) {
        if ($result[$i]->id == $id) $item = $result[$i];
    }
}
?>


  <!-- Show item image and description-->
</br>
</br>
<div align="center">
	<div style="width:150px;">
	<h1 ><?php /*show item name*/
echo $item->name; ?></h1>
	</div>

	<div width:150px;>
	<h3 >Price: <?php /*show item price*/
echo $item->price; ?> </h3>
</div>
	<div >
</br>
</br> <!-- Show item image-->
	<img src="<?php echo '../admin/img/proteins/' . $item->img; ?>" width="700px" />
	<br />
	<br />
	<h4><?php /*show item description*/
echo $item->description; ?></h4>
	</div>
</div>


<br/>
  <!--"back" button ro return to items page -->

<a href="items"><button class="w2ui-btn" name="back">Back</button></a>
	
	
<?php include /*include footer file*/
"footer.php"; ?>
