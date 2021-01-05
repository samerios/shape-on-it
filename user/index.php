<?php  /*include header file*/ include "header.php" ?>

 <br>
<ul align="center" >
	<script>
		//on load index page show some gym images by use "Image" function 
		var i = 0; var path = new Array();
		path[0] = "../img/gym5.jpg";
		path[1] = "../img/gym2.jpg";
		path[2] = "../img/gym3.jpg";
		path[3] = "../img/gym4.png";
		path[4] = "../img/gym5.jpg";
				
		function Image()
		{ 
			document.slide.src = path[i];
			if(i < path.length - 1)
				i++;
			else
				i = 0; 
			setTimeout("Image()",1500);
		}
		//on load page call "Image" function
		window.onload=Image;
	</script>
	<img height="300" name="slide" width="500" />

</ul>

 <?php /*include footer file*/ include "footer.php" ?>
		