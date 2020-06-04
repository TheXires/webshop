<?php
  require 'connection.inc.php';

  // prüfen ob eine articelID übergeben wird, wenn nicht direkt abbrechen
  if(!isset($_GET['articleid'])){
    header('location ../index.php?error=iddoesnotexist');
    exit();
  }

  // setzen der Variablen und schützen vor xss
  $articleID = htmlspecialchars($_GET['articleid'], ENT_QUOTES, 'UTF-8');

  // prüfen ob articelID nur Nummern enthält, um bei fehler direkt abbrechen zu können
  if(!is_numeric($articleID)){
    header('location ../index.php?error=iddoesnotexist');
    exit();
  }

  // Bereite sql Abfrage vor
  $sql = $connection->prepare("SELECT device_brand, device_model, device_size, device_condition, device_storage, device_price, device_img FROM article WHERE articleID=?");
  if(!$sql){
    header("location: ../login.php?error=sqlerror");
    exit();
  }

  // füllt und führt Anfrage aus
  $sql->bind_param("i", $articleID);
  $sql->execute();
  $sql_result = $sql->get_result();

  // Ergebnis auswerten
  if($row = mysqli_fetch_assoc($sql_result)){
    // Variablen zur Ausgabe eines Smartphones in ../article.php setzen
    $smartphone_brand = $row['device_brand'];
    $smartphone_model = $row['device_model'];
    $smartphone_size = $row['device_size'];
    $smartphone_condition = $row['device_condition'];
    $smartphone_storage = $row['device_storage'];
    $smartphone_price = $row['device_price'];
    $smartphone_img = $row['device_img'];
  }

  // offene Verbidungen beenden
  $sql->close();
  $connection->close();
