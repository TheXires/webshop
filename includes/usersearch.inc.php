<?php
  session_start();
  require 'connection.inc.php';

  if(!isset($_POST['name'])){
    echo 'Error';
  }

  // prüfen, ob ein Nutzer eingeloggt ist, wenn nicht direkt abbrechen (Fehler: notloggedin)
  if(!isset($_SESSION['userid'])){
    echo 'notloggedin';
    exit();
  }

  // erweitern der sucheingabe, um 'Like' in der SQL-Abfrage nutzen zu können
  $toSearch = $_POST['name'];
  $likeToSearch = '%'.$toSearch.'%';

  // vorbereiten der sql Abfrage für die Nutzersuche
  // Sollte es zu einem Fehler kommen, wird der Nutzer auf die usersearch weitergeleitet (Fehler: sqlerror)
  $sql = $connection->prepare("SELECT userID, firstname, lastname, email, street, housenumber, city, zip
                               FROM user
                               WHERE ((lastname LIKE ? OR firstname LIKE ?) OR (? LIKE CONCAT('%', lastname, '%') OR (? LIKE CONCAT('%', firstname, '%'))))");
  if(!$sql){
    header("location: ../usersearch.php?error=sqlerror");
    exit();
  }

  // füllt und führt Anfrage aus
  $sql->bind_param('ssss', $likeToSearch, $likeToSearch, $toSearch, $toSearch);
  $sql->execute();
  $sql_result = $sql->get_result();

  // Es wird ein Objekt erstellt, in dem das Ergibnis der SQL Abfrage zu einer JSON Datei umgewandelt werden kann
  $myObj = new \stdClass();
  $myObj = $sql_result->fetch_all(MYSQLI_ASSOC);
  $myJSON = json_encode($myObj);

  // rückgabe der JSON Datei
  echo $myJSON;
