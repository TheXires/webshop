<?php
  require 'connection.inc.php';

  // prüfen ob eine articelID übergeben wird, wenn nicht direkt abbrechen
  if(!isset($_POST['articleid'])){
    echo 'noarticlenumber';
    exit();
  }

  // setzen der Variablen und schützen vor xss
  $articleID = htmlspecialchars($_POST['articleid'], ENT_QUOTES, 'UTF-8');

  // prüfen ob articelID nur Nummern enthält, um bei fehler direkt abbrechen zu können
  if(!is_numeric($articleID)){
    echo 'iddoesnotexist';
    exit();
  }

  // Bereite sql Abfrage vor
  $sql = $connection->prepare("SELECT user.userID, user.firstname, user.lastname, ratings.rating, ratings.description FROM ratings, user, article
	                             WHERE ratings.userID = user.userID
	                             AND ratings.articleID = article.articleID
	                             AND ratings.articleID = ?");
  if(!$sql){
    // wenn es Fehler gibt, soll auf Startseite weitergeleitet werden und anschlißend script verlassen wern
    echo 'sqlerror';
    exit();
  }

  // füllt und führt Anfrage aus
  $sql->bind_param("i", $articleID);
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
    echo 'nocommentsfound';
    exit();
  }
