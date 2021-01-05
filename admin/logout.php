<?php /*include header file*/
include "header.php"; ?>
<?php
//after logout unset all sessions (set not active)
	  unset($_SESSION['id']);
      unset($_SESSION['user']);
   	  //go to index page to complete logout
      echo '<meta http-equiv="refresh" content="0; url=\'../index.php\'" />';
?>
 <?php /*include footer file*/
include "footer.php"; ?>

