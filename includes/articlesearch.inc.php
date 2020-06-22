<?php
  require 'connection.inc.php';

  // prüfen ob eine articelID übergeben wird, wenn nicht direkt abbrechen (Fehler: nosearchparameters)
  if(!isset($_POST['searchParam'])){
    header("location: ../index.php?error=nosearchparameters");
    exit();
  }

  // setzen der Variablen und schützen vor xss
  $likeSearchParam = '%'.htmlspecialchars($_POST['searchParam'], ENT_QUOTES, 'UTF-8').'%';
  $searchParam = htmlspecialchars($_POST['searchParam'], ENT_QUOTES, 'UTF-8');

  // Bereitet sql Abfrage für die Arikelsuche vor
  $sql = $connection->prepare("SELECT articleID, brand.name AS brandName, model, conditions.name AS conditionName, size, storage, price, img, stock
                               FROM article, brand, conditions
                               WHERE article.brandID = brand.brandID
                               AND article.conditionID = conditions.conditionID
                               AND ((brand.name LIKE ? OR model LIKE ?) OR ((? LIKE CONCAT('%', brand.name, '%')) OR (? LIKE CONCAT('%', model, '%'))))");
  if(!$sql){
    // wenn es Fehler gibt, soll auf Startseite weitergeleitet werden und anschlißend script verlassen werden (Fehler: sqlerror)
    header('location: ../index.php?error=sqlerror');
    exit();
  }

  // füllt und führt Anfrage aus
  $sql->bind_param("ssss", $likeSearchParam, $likeSearchParam, $searchParam, $searchParam);
  $sql->execute();
  $sql_result = $sql->get_result();

  // prüfen, ob es mindestens ein ergebnis gibt
  // Wenn ja, wird ein Objekt erstellt, in dem das Ergibnis der sql Abfrage zu JSON Datei umgewandelt werden kann
  // Wenn nicht, abbrechen und weiterleiten (Fehler: noarticlesfound)
  if($sql_result->num_rows > 0){
    $myObj = new \stdClass();
    $myObj = $sql_result->fetch_all(MYSQLI_ASSOC);
    $myJSON = json_encode($myObj);
    echo $myJSON;
  }else{
    header("location: ../index.php?error=noarticlesfound");
    exit();
  }
