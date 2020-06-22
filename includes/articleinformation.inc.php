<?php
  require 'connection.inc.php';

  // prüfen ob eine articelID übergeben wird, wenn nicht direkt abbrechen (Fehler: noarticlenumber)
  if(!isset($_POST['articleid'])){
    echo 'noarticlenumber';
    exit();
  }

  // setzen der Variablen und schützen vor xss
  $articleID = htmlspecialchars($_POST['articleid'], ENT_QUOTES, 'UTF-8');

  // prüfen ob articelID nur Nummern enthält, um bei fehler direkt abbrechen zu können (Fehler: iddoesnotexist)
  if(!is_numeric($articleID)){
    echo 'iddoesnotexist';
    exit();
  }

  // Bereite sql Abfrage für Artikelinformationen vor
  // wenn es Fehler gibt, soll Fehler übergeben werden und anschlißend Script verlassen werden (Fehler: sqlerror)
  $sql = $connection->prepare("SELECT brand.name AS brandName, model, conditions.name AS conditionName, size, storage, price, img, stock, price
                               FROM article, brand, conditions
                               WHERE article.brandID = brand.brandID
                               AND article.conditionID = conditions.conditionID
                               AND articleID=?");
  if(!$sql){
    echo 'sqlerror';
    exit();
  }

  // füllt und führt Anfrage aus
  $sql->bind_param("i", $articleID);
  $sql->execute();
  $sql_result = $sql->get_result();

  // prüfen, ob es genau ein ergebnis gibt
  // Wenn ja, wird ein Objekt erstellt, in dem das Ergibnis der sql Abfrage zu JSON Datei umgewandelt werden kann
  // Wenn nicht, abbrechen (Fehler: iddoesnotexist)
  if($sql_result->num_rows == 1){
    $myObj = new \stdClass();
    $myObj = $sql_result->fetch_all(MYSQLI_ASSOC);t
    $myJSON = json_encode($myObj);
    echo $myJSON;
  }else{
    echo 'iddoesnotexist';
    exit();
  }
