<?php
  require 'connection.inc.php';

  // Wenn keine AritkelID übergeben, wird auf Startseite weitergeleitet (Fehler: noarticleid)
  if(!isset($_POST['articleID'])){
    header("location: ../index.php?error=noarticleid");
    exit();
  }

  // setzen der Variablen
  $articleID = $_POST['articleID'];

  // Bereitet SQL-Abfrage zum Erhalten der durchschnittliche Bewertung eines Artikels vor
  // wenn es Fehler gibt, wird auf Startseite weitergeleitet (Fehler: sqlerror)
  $sql = $connection->prepare("SELECT AVG(ratings.rating) AS rating FROM ratings WHERE ratings.articleID = ?");
  if(!$sql){
    header('location: ../index.php?error=sqlerror');
    exit();
  }

  // füllt und führt Anfrage aus
  $sql->bind_param("i", $articleID);
  $sql->execute();
  $sql_result = $sql->get_result();

  // wenn es ein ergebnis gibt, werden Variablen mit der jeweiligen Bewertung gesetzt
  // sonst wird auf Startseite weitergeleitet (Fehler: noratingsfound)
  if($row = $sql_result->fetch_assoc()){
    if($row['rating'] == null){
      echo 0;
    }else{
      echo $row['rating'];
    }
  }else{
    header("location: ../index.php?error=noratingsfound");
    exit();
  }
