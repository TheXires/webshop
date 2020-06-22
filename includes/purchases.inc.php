<?php
  session_start();
  require 'connection.inc.php';

  // Wenn der Nutzer nicht eingeloggt ist, wird er auf die Loginseite weitergeleitet (Fehler: notloggedin)
  if(!isset($_SESSION['userid'])){
    header('location: ../login.php?error=notloggedin');
    exit();
  }

  // Entscheidet, ob eine JSON Datei mit alle Käufen oder allen Bewertungen zurückgegeben werden soll
  // Wir keine der Funktionen ausgewählt, wird auf die Indexseite weitergeleitet (Fehler: somethingwentwrong)
  if($_POST['changeFunction'] == 'showPurchases'){
    $userID = $_SESSION['userid'];
    // SQL Abfrage für Rückgabe alle Käufe
    $query = "SELECT orders.articleID, brand.name AS brandName, orders.model, conditions.name AS conditionName, orders.quantity, orders.price, orders.date
              FROM conditions, brand, orders
              WHERE brand.brandID = orders.brandID
              AND orders.conditionID = conditions.conditionID
              AND orders.userID = ?
              ORDER BY orders.date DESC, brandName ASC";
  }else if($_POST['changeFunction'] == 'showRatings'){
    $userID = $_SESSION['userid'];
    // SQL Abfrage für Rückgabe alle Bewertungen
    $query = "SELECT article.articleID, brand.name AS brandName, article.model, article.storage, conditions.name AS conditionName, ratings.rating
              FROM conditions, brand, article, ratings
              WHERE brand.brandID = article.brandID
              AND article.conditionID = conditions.conditionID
              AND ratings.articleID = article.articleID
              AND ratings.userID = ?";
  }else{
    header("location: ../index.php?error=somethingwentwrong");
    exit();
  }


  // vorbereiten der SQL-Abfrage
  // wenn es Fehler gibt, wird auf Startseite weitergeleitet (Fehler: sqlerror)
  $sql = $connection->prepare($query);
  if(!$sql){
    header("location: ../login.php?error=sqlerror");
    exit();

  }
  // füllen und ausführen der Abfrage
  $sql->bind_param('i', $userID);
  $sql->execute();
  $sql_result = $sql->get_result();

  // erstellen eines Objektes, in dem das ergibnis der SQL-Abfrage zu JSON Datei umgewandelt werden kann
  // füllen des Objektes mit einzelnen Datensätzen aus der Datenbank
  $myObj = new \stdClass();
  $myObj = $sql_result->fetch_all(MYSQLI_ASSOC);
  $myJSON = json_encode($myObj);
  echo $myJSON;
