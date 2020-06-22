<?php
  session_start();
  require 'connection.inc.php';

  // Wenn der Nutzer nicht eingeloggt ist, wird er auf die Loginseite weitergeleitet (Fehler: notloggedin)
  if(!isset($_SESSION['userid'])){
    header('location: ../login.php?error=notloggedin');
    exit();
  }

  // setzen der Variablen
  $userID = $_SESSION['userid'];

// Beginn für löschen der Bestellungen des zu löschenden Nutzers
  // Bereite SQL-Anweisung zum Löschen der Bestellungen vor
  // wenn es Fehler gibt, soll Fehler übergeben werden und anschlißend Script verlassen werden (Fehler: sqlerror)
  $sql_orders = $connection->prepare('DELETE FROM orders WHERE userID=?;');
  if(!$sql_orders){
		header("location: ../index.php?error=sqlerror");
		exit();
  }

  // führt Anweisung aus und prüft ob diese erfolgreich war
  // Wenn nicht, wird Nutzer auf sein Profil weitergeleitet (Fehler: failedtodeleteorders)
  $sql_orders->bind_param('i', $userID);
  if(!$sql_orders->execute()){
    header('location: ../profile.php?error=failedtodeleteorders');
    exit();
  }

  // beende Verbindung von $sql_orders
  $sql_orders->close();
// Ende für löschen der Bestellungen



// Beginn für löschen der Bewertungen des zu löschenden Nutzers
  // Bereite SQL-Anweisung zum Löschen der Bestellungen vor
  // Wenn nicht, wird Nutzer auf sein Profil weitergeleitet (Fehler: sqlerror)
  $sql_ratings = $connection->prepare('DELETE FROM ratings WHERE userID=?;');
  if(!$sql_ratings){
		header("location: ../index.php?error=sqlerror");
		exit();
  }

  // führt Anweisung aus und prüft ob diese erfolgreich war
  // Wenn nicht, wird Nutzer auf sein Profil weitergeleitet (Fehler: failedtodeleteratings)
  $sql_ratings->bind_param('i', $userID);
  if(!$sql_ratings->execute()){
    header('location: ../profile.php?error=failedtodeleteratings');
    exit();
  }

  // beende Verbindung von $sql_ratings
  $sql_ratings->close();
// Ende für löschen der Bestellungen


// Beginn für löschen des Nutzers
  // Bereite SQL-Anweisung zum Löschen des Nutzers vor
  // Wenn nicht, wird Nutzer auf sein Profil weitergeleitet (Fehler: failedtodeleteratings)
  $sql_deleteuser = $connection->prepare('DELETE FROM user WHERE userID=?;');
  if(!$sql_deleteuser){
		header("location: ../login.php?error=sqlerror");
		exit();
  }

  // führt Anfrage aus und prüft ob diese erfolgreich war
  // Wenn ja, wird Session zerstört, um Nutzer auszuloggen und der Nutzer auf index.php weitergeleitet
  // Wenn nicht, wird Nutzer auf sein Profil weitergeleitet (Fehler: failedtodeleteuser)
  $sql_deleteuser->bind_param('i', $userID);
  if($sql_deleteuser->execute()){
    session_unset();
    session_destroy();
    header('location: ../index.php?action=success');
    exit();
  }else{
    header('location: ../profile.php?error=failedtodeleteuser');
    exit();
  }
// Ende für löschen des Nutzers

  // offene Verbidungen beenden
  $sql_deleteuser->close();
  $connection->close();
