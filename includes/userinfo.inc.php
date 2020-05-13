<?php

  if(!isset($_SESSION['userid'])){
    header('location: ../index.php');
    exit();
  }

  require 'connection.inc.php';

  $sql_userinfo = $connection->prepare("SELECT firstname, lastname, email, street, housenumber, city, zip FROM user WHERE ID=?");
  if(!$sql_userinfo){
    header("location: ../login.php?error=sqlerror");
    exit();
  }else{
    $sql_userinfo->bind_param("i", $_SESSION['userid']);
    $sql_userinfo->execute();
    $sql_userinfo_result = $sql_userinfo->get_result();
    if($row = $sql_userinfo_result->fetch_assoc()){
      $firstname = $row['firstname'];
      $lastname = $row['lastname'];
      $email = $row['email'];
      $street = $row['street'];
      $housenumber = $row['housenumber'];
      $city = $row['city'];
      $zip = $row['zip'];
    }else{
      $firstname = 'fehler';
    }
  }
