<?php
  session_start();
  require 'connection.inc.php';

  // Wenn keine Artikelnummer übergeben, wird auf Loginseite weitergeleitet (Fehler: missingsinformation)
  if(!isset($_POST['articleid'])){
    echo $_POST['articleid'];
    header("location: ../login.php?error=missingsinformation");
    exit();
  }

  // enscheidet welche Funktion genutzt werden soll (hasBought oder hasRated)
  // sollte keine der beiden Funktinonen aufgerufen werden, wird Nutzer auf Startseite weitergeleitet (Fehler: somethingwentwrong)
  if($_POST['changeFunction'] == 'hasBought'){
    $userID = htmlspecialchars($_POST['userid'], ENT_QUOTES, 'UTF-8');
    // SQL-Abfrage zum Prüfen, ob ein übergebener Nutzer den übergebenen Artikel gekauft hat
    $query = "SELECT * FROM orders WHERE userID = ? AND articleID = ?";
  }else if($_POST['changeFunction'] == 'hasRated'){
    // Wenn Nutzer nicht angemeldet ist, wird er auf Loginseite weiterleitet
    if(!isset($_SESSION['userid'])){
      header("location: ../login.php");
      exit();
    }
    $userID = htmlspecialchars($_SESSION['userid'], ENT_QUOTES, 'UTF-8');
    // SQL-Abfrage zum Prüfen, ob aktueller Nutzer den übergebenen Artikel bewertet hat
    $query = "SELECT * FROM ratings WHERE userID = ? AND articleID = ?";
  }else{
    header("location: ../login.php?error=somethingwentwrong");
    exit();
  }

  // setzen der Variablen und schützen vor xss
  $articleID = htmlspecialchars($_POST['articleid'], ENT_QUOTES, 'UTF-8');

  // prüfen ob articelID nur Nummern enthält, sonst wird auf Indexseite Weitergeleitet (Fehler: iddoesnotexist)
  if(!is_numeric($articleID)){
    header("location: ../index.php?error=iddoesnotexist");
    exit();
  }

  // Bereite sql Abfrage zur Abfrage, Nutzer artikel gekauft, bzw. bewertet hat vor
  // Wenn dabei ein Fehler auftritt, wird auf Startseite weitergeleitet (Fehler: sqlerror)
  $sql = $connection->prepare($query);
  if(!$sql){
    header("location: ../index.php?error=sqlerror");
    exit();
  }

  // füllt und führt Anfrage aus
  $sql->bind_param("ii", $userID, $articleID);
  $sql->execute();
  $sql_result = $sql->get_result();

  // wenn es ein ergebnis gibt, werden Variablen gesetzt
  // Wenn der übergebene Nutzer das übergeben Produkt mindestens einmal gekauft hat, wird true zurückgegeben
  // sonst wird false zurück gegeben
  if($sql_result->num_rows > 0){
    echo true;
  }else{
    echo false;
  }
