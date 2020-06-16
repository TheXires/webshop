<?php
  session_start();

  require 'connection.inc.php';

  if(!isset($_SESSION['userid']) || !isset($_POST['purchaseQuantity'])){
    header('location: ../login.php');
    exit();
  }

  if(empty($_POST['articleid'])){
    header('location: ../index.php?error=articlenotfound');
    exit();
  }

  // erstellen und teilweises setzen aller benötigten Variablen
  $userID = $_SESSION['userid'];
  $quantity = $_POST['purchaseQuantity'];
  $articleID = $_POST['articleid'];
  $date = date('Y-m-d');
  $stock = null;
  $price = null;
  $brandID = null;
  $model = null;
  $conditionID = null;

  if(!is_numeric($quantity)){
    header('location: ../article.php?articleid='.$articleID);
    exit();
  }

  // vorbereiten der sql Abfrage
  $sql_stock = $connection->prepare("SELECT brandID, model, conditionID, price, stock FROM article WHERE article.articleID=?");
  // prüfung auf fehlerhafte sql Abfragen
  if(!$sql_stock){
    // wenn es Fehler gibt, soll auf Startseite weitergeleitet werden und anschlißend script verlassen wern
    header("location: ../index.php?error=sqlerror");
    exit();
  }
  // sicheres einfügen von nutzereingabe
  $sql_stock->bind_param('i', $articleID);
  $sql_stock->execute();
  $sql_stock_result = $sql_stock->get_result();

  if($row = $sql_stock_result->fetch_assoc()){
    $stock = $row['stock'];
    $price = $row['price'] * $quantity;
    $brandID = $row['brandID'];
    $model = $row['model'];
    $conditionID = $row['conditionID'];
  }

  if($stock == null || $price == null || $brandID == null || $model == null || $conditionID == null){
    header("location: ../index.php?error=sqlerror");
    exit();
  }

  // wenn der Artikel momentan nicht lagernd ist
  if($stock == 0){
    header("location: ../article.php?error=noarticlesavailable&articleid=".$articleID);
    exit();
  }

  // wenn gewünschte Anzahl über der verfügbaeren Artikel liegt
  if($stock < $quantity){
    header("location: ../article.php?error=notenougharticlesavailable&articleid=".$articleID);
    exit();
  }

  // Test Block
  // echo $stock." - ";
  // echo $price." - ";
  // echo $brandID." - ";
  // echo $model." - ";
  // echo $conditionID;

  $sql_add_purchase = $connection->prepare("INSERT INTO orders (userID, quantity, price, date, brandID, model, conditionID, articleID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  if(!$sql_add_purchase){
    header('location: ../article.php?error=sqlerror');
    exit();
  }
  $sql_add_purchase->bind_param('iidsisii', $userID, $quantity, $price, $date, $brandID, $model, $conditionID, $articleID);

  if(!$sql_add_purchase->execute()){
    header('location: ../article.php?error=sqlinserterror&articleid='.$articleID);
    exit();
  }

  $newStock = $stock - $quantity;

  $sql_update_article = $connection->prepare("UPDATE article SET stock = ? WHERE articleID = ?");
  if(!$sql_update_article){
    header('location: ../article.php?error=sqlerror');
    exit();
  }
  $sql_update_article->bind_param('ii', $newStock, $articleID);

  if(!$sql_update_article->execute()){
    header('location: ../article.php?error=sqlupdateerror&articleid='.$articleID);
    exit();
  }

  header('location: ../purchases.php?purchase=success');

  $sql_stock->close();
  $sql_add_purchase->close();
  $sql_update_article->close();
  $connection->close();
