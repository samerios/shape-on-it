<?php /*include header file*/
include "header.php"; ?>

<?php
//Write to Log File "Login" date and time for control login and logout
$date = new DateTime("now", new DateTimeZone('Asia/Tel_Aviv'));
$log = "Logout Trainer: " . $_SERVER['REMOTE_ADDR'] . ' - ' . $date->format('Y-m-d H:i:s') . PHP_EOL . "User: " . $user . PHP_EOL . "-------------------------" . PHP_EOL;
file_put_contents('../trainersLoginLogout.log', $log, FILE_APPEND | LOCK_EX);
//after logout unset all sessions (set not active)
unset($_SESSION['id']);
unset($_SESSION['user']);
unset($_SESSION['workplanid']);
unset($_SESSION['menuid']);
unset($_SESSION['workplanname']);
unset($_SESSION['menuname']);
//  unset($_SESSION['signResult']);
//go to index page to complete logout
header("Location: trainer/ok.php");
header("Location: ../index.php");
?>
 <?php /*include footer file*/
include "footer.php"; ?>
