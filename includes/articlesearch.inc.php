<?php
  require 'connection.inc.php';

  // prüfen ob eine articelID übergeben wird, wenn nicht direkt abbrechen
  if(!isset($_POST['searchParam'])){
    header("location: ../index.php?error=noasearchparameters");
    exit();
  }

  // setzen der Variablen und schützen vor xss
  $likeSearchParam = '%'.htmlspecialchars($_POST['searchParam'], ENT_QUOTES, 'UTF-8').'%';
  $searchParam = htmlspecialchars($_POST['searchParam'], ENT_QUOTES, 'UTF-8');

  // Bereite sql Abfrage vor
  $sql = $connection->prepare("SELECT articleID, brand.name AS brandName, model, conditions.name AS conditionName, size, storage, price, img, stock
                               FROM article, brand, conditions
                               WHERE article.brandID = brand.brandID
                               AND article.conditionID = conditions.conditionID
                               AND ((brand.name LIKE ? OR model LIKE ?) OR ((? LIKE CONCAT('%', brand.name, '%')) OR (? LIKE CONCAT('%', model, '%'))))");
  if(!$sql){
    // wenn es Fehler gibt, soll auf Startseite weitergeleitet werden und anschlißend script verlassen wern
    header('location: ../index.php?error=sqlerror');
    exit();
  }

  // füllt und führt Anfrage aus
  $sql->bind_param("ssss", $likeSearchParam, $likeSearchParam, $searchParam, $searchParam);
  $sql->execute();
  $sql_result = $sql->get_result();

  // wenn es ein ergebnis gibt, werden Variablen gesetzt
  if($sql_result->num_rows > 0){
    // erstellen eines Objektes, in dem das ergibnis der sql Abfrage zu JSON Datei umgewandelt werden kann
    $myObj = new \stdClass();
    // füllen des Objektes mit einzelnen Datensätzen aus der Datenbank
    $myObj = $sql_result->fetch_all(MYSQLI_ASSOC);

    // umkodieren des Objektes in JSON Format
    $myJSON = json_encode($myObj);

    // rückgabe der JSON Datei
    echo $myJSON;

  //sonst wird auf Startseite weitergeleitet
  }else{
    header("location: ../index.php?error=noarticlesfound");
    exit();
  }
