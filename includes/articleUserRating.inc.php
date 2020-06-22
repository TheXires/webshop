<?php
  require 'connection.inc.php';

  // prüfen ob eine articelID übergeben wird, wenn nicht direkt abbrechen (Fehler: noarticlenumber)
  if(!isset($_POST['articleid'])){
    echo 'noarticlenumber';
    exit();
  }

  // setzen der Variable und schützen vor xss
  $articleID = htmlspecialchars($_POST['articleid'], ENT_QUOTES, 'UTF-8');

  // prüfen ob articelID nur Nummern enthält, um bei Fehler direkt abbrechen zu können (Fehler: iddoesnotexist)
  if(!is_numeric($articleID)){
    echo 'iddoesnotexist';
    exit();
  }

  // Bereite sql Abfrage für Nutzerbewertungen vor
  $sql = $connection->prepare("SELECT user.userID, user.firstname, user.lastname, ratings.rating, ratings.description
                               FROM ratings, user, article
	                             WHERE ratings.userID = user.userID
	                             AND ratings.articleID = article.articleID
	                             AND ratings.articleID = ?");
  if(!$sql){
    // wenn es Fehler gibt, soll auf Startseite weitergeleitet werden und anschlißend script verlassen werden (Fehler: sqlerror)
    echo 'sqlerror';
    exit();
  }

  // füllt und führt Anfrage aus
  $sql->bind_param("i", $articleID);
  $sql->execute();
  $sql_result = $sql->get_result();

  // prüfen, ob es mindestens ein ergebnis gibt
  // Wenn ja, wird ein Objekt erstellt, in dem das Ergibnis der sql Abfrage zu JSON Datei umgewandelt werden kann
  // Wenn nicht, abbrechen (Fehler: nocommentsfound)
  if($sql_result->num_rows > 0){
    $myObj = new \stdClass();
    $myObj = $sql_result->fetch_all(MYSQLI_ASSOC);
    $myJSON = json_encode($myObj);
    echo $myJSON;
  }else{
    echo 'nocommentsfound';
    exit();
  }
