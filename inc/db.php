<?php

$connect = new mysqli('localhost','shapeonitsystem','H6qvFVRUYAnSLVtP','shapeonit');

if ($connect -> connect_errno) {
  echo "Failed to connect to MySQL: " . $connect -> connect_error;
  exit();
}


?>