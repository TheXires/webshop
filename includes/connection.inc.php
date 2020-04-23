<?php
  $dbServername = "localhost";
  $dbUser = "root";
  $dbPassword = "";
  $db = "webshopdb";

  $connection = new mysqli($dbServername, $dbUser, $dbPassword, $db);

  if($connection->connect_error){
    die($connection->connect_error);
  }
 ?>
