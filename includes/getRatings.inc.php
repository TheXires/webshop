<?php
  require 'connection.inc.php';

  // prüfen ob eine articelID übergeben wird, wenn nicht direkt abbrechen
  if(!isset($_POST['articleID'])){
    header("location: ../index.php?error=noarticleid");
    exit();
  }

  // setzen der Variablen und schützen vor xss
  $articleID = $_POST['articleID'];

  // Bereite sql Abfrage vor
  $sql = $connection->prepare("SELECT AVG(ratings.rating) AS rating FROM ratings WHERE ratings.articleID = ?");
  if(!$sql){
    // wenn es Fehler gibt, soll auf Startseite weitergeleitet werden und anschlißend script verlassen wern
    header('location: ../index.php?error=sqlerror');
    exit();
  }

  // füllt und führt Anfrage aus
  $sql->bind_param("i", $articleID);
  $sql->execute();
  $sql_result = $sql->get_result();

  // wenn es ein ergebnis gibt, werden Variablen gesetzt
  if($row = $sql_result->fetch_assoc()){
    if($row['rating'] == null){
      echo 0;
    }else{
      echo $row['rating'];
    }


  //sonst wird auf Startseite weitergeleitet
  }else{
    header("location: ../index.php?error=noratingsfound");
    exit();
  }
