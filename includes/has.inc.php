<?php
  session_start();
  require 'connection.inc.php';

  // prüfen ob eine articelID übergeben wird, wenn nicht direkt abbrechen
  if(!isset($_POST['articleid'])){
    echo $_POST['articleid'];
    header("location: ../login.php?error=missingsinformation");
    exit();
  }

  // enscheidet welche funktion genutzt werden soll
  if($_POST['changeFunction'] == 'hasBought'){
    // userID wird immer auf die gesetzt, die hinter dem Kommentar steht
    $userID = htmlspecialchars($_POST['userid'], ENT_QUOTES, 'UTF-8');
    // SQL Abfrage für diese Funktion
    $query = "SELECT * FROM orders WHERE userID = ? AND articleID = ?";
  }else if($_POST['changeFunction'] == 'hasRated'){
    // Wenn eine Nutzer angemeldet ist, wird die userID auf diesen User gesetzt
    if(isset($_SESSION['userid'])){
      $userID = htmlspecialchars($_SESSION['userid'], ENT_QUOTES, 'UTF-8');
    }
    // SQL Abfrage für diese Funktion
    $query = "SELECT * FROM ratings WHERE userID = ? AND articleID = ?";
  }else{
    header("location: ../login.php?error=somethingwentwrong");
    exit();
  }

  // setzen der Variablen und schützen vor xss
  $articleID = htmlspecialchars($_POST['articleid'], ENT_QUOTES, 'UTF-8');

  // prüfen ob articelID nur Nummern enthält, um bei fehler direkt abbrechen zu können
  if(!is_numeric($articleID)){
    header("location: ../login.php?error=iddoesnotexist");
    exit();
  }

  // Bereite sql Abfrage vor
  $sql = $connection->prepare($query);
  if(!$sql){
    // wenn es Fehler gibt, soll auf Startseite weitergeleitet werden und anschlißend script verlassen wern
    header("location: ../login.php?error=sqlerror");
    exit();
  }

  // füllt und führt Anfrage aus
  $sql->bind_param("ii", $userID, $articleID);
  $sql->execute();
  $sql_result = $sql->get_result();

  // wenn es ein ergebnis gibt, werden Variablen gesetzt
  if($sql_result->num_rows > 0){
    // gibt true zurück, wenn der übergebene Nutzer das übergeben Produkt mindestens einmal gekauft hat
    echo true;

  //sonst wird auf Startseite weitergeleitet
  }else{
    echo false;
  }
