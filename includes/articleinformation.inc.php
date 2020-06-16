<?php
  require 'connection.inc.php';

  // prüfen ob eine articelID übergeben wird, wenn nicht direkt abbrechen
  if(!isset($_POST['articleid'])){
    echo 'noarticlenumber';
    exit();
  }

  // setzen der Variablen und schützen vor xss
  $articleID = htmlspecialchars($_POST['articleid'], ENT_QUOTES, 'UTF-8');

  // prüfen ob articelID nur Nummern enthält, um bei fehler direkt abbrechen zu können
  if(!is_numeric($articleID)){
    echo 'iddoesnotexist';
    exit();
  }

  // Bereite sql Abfrage vor
  $sql = $connection->prepare("SELECT brand.name AS brandName, model, conditions.name AS conditionName, size, storage, price, img, stock, price
                               FROM article, brand, conditions
                               WHERE article.brandID = brand.brandID
                               AND article.conditionID = conditions.conditionID
                               AND articleID=?");
  if(!$sql){
    // wenn es Fehler gibt, soll Fehler übergeben werden und anschlißend script verlassen wern
    echo 'sqlerror';
    exit();
  }

  // füllt und führt Anfrage aus
  $sql->bind_param("i", $articleID);
  $sql->execute();
  $sql_result = $sql->get_result();

  // wenn es ein ergebnis gibt, werden Variablen gesetzt
  if($sql_result->num_rows == 1){
    // erstellen eines Objektes, in dem das ergibnis der sql Abfrage zu JSON Datei umgewandelt werden kann
    $myObj = new \stdClass();
    // füllen des Objektes mit einzelnen Datensätzen aus der Datenbank
    $myObj = $sql_result->fetch_all(MYSQLI_ASSOC);

    // umkodieren des Objektes in JSON Format
    $myJSON = json_encode($myObj);

    // rückgabe der JSON Datei
    echo $myJSON;


  }else{
    echo 'iddoesnotexist';
    exit();
  }
