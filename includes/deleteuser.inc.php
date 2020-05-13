<?php
  session_start();
  if(!isset($_SESSION['userid'])){
    header('location: ../login.php');
    exit();
  }

  require 'connection.inc.php';

  $sql_deleteuser = $connection->prepare('DELETE FROM user WHERE ID=?;');
  $sql_deleteuser->bind_param('i', $_SESSION['userid']);
  if($sql_deleteuser->execute()){
    session_unset();
    session_destroy();

    header('location: ../index.php');
    exit();
  }else{
    header('location: ../profile.php?error=failedtodelete');
    exit();
  }
