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

  // erstellen und teilweises setzen aller benötigten Variablen und schützen vor xss
  $userID = $_SESSION['userid'];
  $quantity = htmlspecialchars($_POST['purchaseQuantity'], ENT_QUOTES, 'UTF-8');
  $articleID = htmlspecialchars($_POST['articleid'], ENT_QUOTES, 'UTF-8');
  $date = date('Y-m-d');
  $stock = null;
  $price = null;
  $brandID = null;
  $model = null;
  $conditionID = null;

  // Wenn Anazhl keine Ziffer ist, wird abgebrochen (Fehler: notnumeric)
  if(!is_numeric($quantity)){
    header('location: ../article.php?error=notnumeric&articleid='.$articleID);
    exit();
  }

  // vorbereiten der sql Abfrage für Werte, die in der Bestellung gespeicher werden sollen
  // Sollte dabei ein Fehler auftreten wird abgebrochen (Fehler: sqlerror)
  $sql_stock = $connection->prepare("SELECT brandID, model, conditionID, price, stock FROM article WHERE article.articleID=?");
  if(!$sql_stock){
    header("location: ../index.php?error=sqlerror");
    exit();
  }

  // füllt und führt Anfrage aus
  $sql_stock->bind_param('i', $articleID);
  $sql_stock->execute();
  $sql_stock_result = $sql_stock->get_result();

  // Wenn es mindestens ein Ergebnis gibt, werden die übrigen Varaiable gesetzt
  if($row = $sql_stock_result->fetch_assoc()){
    $stock = $row['stock'];
    $price = $row['price'] * $quantity;
    $brandID = $row['brandID'];
    $model = $row['model'];
    $conditionID = $row['conditionID'];
  }

  // wenn nicht alle Variablen gefüllt wurden, wird auf die Startseite weitergeleitet (Fehler: sqlerror)
  if($stock == null || $price == null || $brandID == null || $model == null || $conditionID == null){
    header("location: ../index.php?error=sqlerror");
    exit();
  }

  // wenn der Artikel momentan nicht lagernd ist,
  // wird auf Artikelseite weitergeleitet (Fehler: noarticlesavailable)
  if($stock == 0){
    header("location: ../article.php?error=noarticlesavailable&articleid=".$articleID);
    exit();
  }

  // wenn gewünschte Anzahl über der verfügbaeren Artikel liegt,
  // wird auf Artikelseite weitergeleitet (Fehler: notenougharticlesavailable)
  if($stock < $quantity || $quantity <= 0 ){
    header("location: ../article.php?error=notenougharticlesavailable&articleid=".$articleID);
    exit();
  }

  // Vorbereiten des SQL Befehls zum einfügen eines Kaufes
  // Sollte dabei ein Fehler auftreten wird abgebrochen (Fehler: sqlerror)
  $sql_add_purchase = $connection->prepare("INSERT INTO orders (userID, quantity, price, date, brandID, model, conditionID, articleID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  if(!$sql_add_purchase){
    header('location: ../article.php?error=sqlerror');
    exit();
  }

  // füllt und führt Anfrage aus
  // wenn beim ausführen ein Fehler auftritt, wird abgebrochen (Fehler: inserterror)
  $sql_add_purchase->bind_param('iidsisii', $userID, $quantity, $price, $date, $brandID, $model, $conditionID, $articleID);
  if(!$sql_add_purchase->execute()){
    header('location: ../article.php?error=sqlinserterror&articleid='.$articleID);
    exit();
  }

  // berechnen der neuen Lagernden Artikel
  $newStock = $stock - $quantity;

  // Vorbereiten des SQL Befehls zum updaten der noch verfügbaren Artikel
  // Sollte dabei ein Fehler auftreten wird abgebrochen (Fehler: sqlerror)
  $sql_update_article = $connection->prepare("UPDATE article SET stock = ? WHERE articleID = ?");
  if(!$sql_update_article){
    header('location: ../article.php?error=sqlerror');
    exit();
  }

  // füllt und führt Anfrage aus
  // wenn beim ausführen ein Fehler auftritt, wird abgebrochen (Fehler: sqlupdateerror)
  $sql_update_article->bind_param('ii', $newStock, $articleID);
  if(!$sql_update_article->execute()){
    header('location: ../article.php?error=sqlupdateerror&articleid='.$articleID);
    exit();
  }

  // Wenn alles funktioniert hat, weiterleiten auf Kaufübersicht
  header('location: ../purchases.php?purchase=success');

  // offene Verbindungen beenden
  $sql_stock->close();
  $sql_add_purchase->close();
  $sql_update_article->close();
  $connection->close();
