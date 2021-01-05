<?php /*include header file*/ include "header.php"; ?>

<?php
//after logout unset all sessions (set not active)
    unset($_SESSION['id']);
    unset($_SESSION['user']);
	header("Location: user/ok.php");
    header("Location: ../index.php");
?>
 <?php /*include footer file*/ include "footer.php"; ?>
