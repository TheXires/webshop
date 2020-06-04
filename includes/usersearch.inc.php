<?php
  require 'connection.inc.php';

  if(!isset($_POST['name'])){
    echo 'Error';
  }

  // erweitern der sucheingabe, um 'Like' in sql nutzen zu können
  $toSearch = '%'.$_POST['name'].'%';

  // vorbereiten der sql Abfrage
  $sql = $connection->prepare("SELECT userID, firstname, lastname, email, street, housenumber, city, zip FROM user WHERE lastname LIKE ?");
  // prüfung auf fehlerhafte sql Abfragen
  if(!$sql){
    // wenn es Fehler gibt, soll auf Startseite weitergeleitet werden und anschlißend script verlassen wern
    header("location: ../login.php?error=sqlerror");
    exit();
  }
  // sicheres einfügen von nutzereingabe
  $sql->bind_param('s', $toSearch);
  $sql->execute();
  $sql_result = $sql->get_result();

  // erstellen eines Objektes, in dem das ergibnis der sql Abfrage zu JSON Datei umgewandelt werden kann
  $myObj = new \stdClass();
  // füllen des Objektes mit einzelnen Datensätzen aus der Datenbank
  $myObj = $sql_result->fetch_all(MYSQLI_ASSOC);

  // umkodieren des Objektes in JSON Format
  $myJSON = json_encode($myObj);

  // rückgabe der JSON Datei
  echo $myJSON;
