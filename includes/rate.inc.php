<?php
  session_start();
  require 'connection.inc.php';

  // prüfen, ob ein Nutzer eingeloggt ist, wenn nicht direkt abbrechen (Fehler: notloggedin)
  if(!isset($_SESSION['userid'])){
    echo 'notloggedin';
    exit();
  }

  // prüfen ob alle Felder gesetzt sind, wenn nicht direkt abbrechen (Fehler: needmoreinformation)
  if(empty($_POST['articleid']) || empty($_POST['rating']) || empty($_POST['description'])){
    echo 'needmoreinformation';
    exit();
  }

  // Variablen Erstllung aus Inputfeldern und schützen vor xss
  $userID = $_SESSION['userid'];
  $articleID = htmlspecialchars($_POST['articleid'], ENT_QUOTES, 'UTF-8');
  $rating = htmlspecialchars($_POST['rating'], ENT_QUOTES, 'UTF-8');
  $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');

  // Vorbereiten des SQL Befehls zum einfügen einer Nutzerbewertung
  // Sollte dabei ein Fehler auftreten wird abgebrochen (Fehler: sqlerror)
  $sql = $connection->prepare("INSERT INTO ratings (userID, articleID, rating, description) VALUES (?, ?, ?, ?)");
  if(!$sql){
    echo 'sqlerror';
    exit();
  }

  // füllt und führt Anfrage aus
  // wenn beim ausführen ein Fehler auftritt, wird abgebrochen (Fehler: inserterror)
  $sql->bind_param('iiis', $userID, $articleID, $rating, $description);
  if(!$sql->execute()){
    echo 'inserterror';
    exit();
  }

  // Wenn alles funktioniert hat, wird 'success' zurückgegeben
  echo 'success';

  // offene Verbidungen beenden
  $sql->close();
  $connection->close();
