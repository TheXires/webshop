<?php
  session_start();

  // prüft ob zulöschende UserID vorhanden ist, um sonst sofort abzubrechen
  if(!isset($_SESSION['userid'])){
    header('location: ../login.php');
    exit();
  }

  require 'connection.inc.php';

  // Bereite sql Abfrage vor
  $sql_deleteuser = $connection->prepare('DELETE FROM user WHERE userID=?;');
  if(!$sql_deleteuser){
		header("location: ../login.php?error=sqlerror");
		exit();
  }

  // führt Anfrage aus und prüft ob diese erfolgreich war
  $sql_deleteuser->bind_param('i', $_SESSION['userid']);
  if($sql_deleteuser->execute()){
    // dann wird Session zerstört, um Nutzer auszuloggen
    session_unset();
    session_destroy();

    header('location: ../index.php');
    exit();

  }else{
    header('location: ../profile.php?error=failedtodelete');
    exit();

  }

  // offene Verbidungen beenden
  $sql_deleteuser->close();
  $connection->close();
