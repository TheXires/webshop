<?php
  session_start();
  require 'connection.inc.php';

  if(!isset($_SESSION['userid'])){
    header('location: ../login.php');
    exit();
  }

  // enscheidet welche funktion genutzt werden soll
  if($_POST['changeFunction'] == 'showPurchases'){
    $userID = $_SESSION['userid'];
    // SQL Abfrage für diese Funktion
    $query = "SELECT orders.articleID, brand.name AS brandName, orders.model, conditions.name AS conditionName, orders.quantity, orders.price, orders.date
              FROM conditions, brand, orders
              WHERE brand.brandID = orders.brandID
              AND orders.conditionID = conditions.conditionID
              AND orders.userID = ?
              ORDER BY orders.date DESC, brandName ASC";
  }else if($_POST['changeFunction'] == 'showRatings'){
    $userID = $_SESSION['userid'];
    // SQL Abfrage für diese Funktion
    $query = "SELECT article.articleID, brand.name AS brandName, article.model, article.storage, conditions.name AS conditionName, ratings.rating
              FROM conditions, brand, article, ratings
              WHERE brand.brandID = article.brandID
              AND article.conditionID = conditions.conditionID
              AND ratings.articleID = article.articleID
              AND ratings.userID = ?";
  }else{
    header("location: ../login.php?error=somethingwentwrong");
    exit();
  }


  // vorbereiten der sql Abfrage
  $sql = $connection->prepare($query);
  // prüfung auf fehlerhafte sql Abfragen
  if(!$sql){
    // wenn es Fehler gibt, soll auf Startseite weitergeleitet werden und anschlißend script verlassen wern
    header("location: ../login.php?error=sqlerror");
    exit();
  }
  // sicheres einfügen von nutzereingabe
  $sql->bind_param('i', $userID);
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
