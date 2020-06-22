<?php
  session_start();
  require 'connection.inc.php';

  // prüft ob zulöschende UserID vorhanden ist, um sonst zum Login weiterzuleiten (Fehler: missingpermissions)
  if($_SESSION['admin'] != 1){
    header('location: ../login.php?error=missingpermissions');
    exit();
  }

  // setzen der Variable und schützen vor xss
  $articleID = htmlspecialchars($_POST['articleid'], ENT_QUOTES, 'UTF-8');

// Beginn für löschen des Artikels
  // Bereite SQL-Abfrage zum Löschen des Artikels vor
  $sql_article = $connection->prepare('DELETE FROM article WHERE articleID=?;');
  if(!$sql_article){
		header("location: ../login.php?error=sqlerror");
		exit();
  }

  // füllt und führt Anfrage aus
  // bei einem Fehler wird auf Artikelseite weitergeleitet (Fehler: failedtodeletearticle)
  $sql_article->bind_param('i', $articleID);
  if(!$sql_article->execute()){
    header('location: ../article.php?error=failedtodeletearticle&articleid='.$articleID);
    exit();
  }

  // beende Verbindung von $sql_article
  $sql_article->close();
// Ende für löschen des Artikels


// Beginn für löschen der zugehörigen Bewertungen
  // Bereite SQL-Anweisung zum Löschen der Bewertungen des Artikels vor
  // wenn es Fehler gibt, soll Fehler übergeben werden und anschlißend Script verlassen werden (Fehler: sqlerror)
  $sql_rating = $connection->prepare('DELETE FROM ratings WHERE articleID=?;');
  if(!$sql_rating){
		header("location: ../login.php?error=sqlerror");
		exit();
  }

  // füllt und führt Anfrage aus
  // bei einem Fehler wird auf Indexseite weitergeleitet (Fehler: failedtodeleteratings)
  $sql_rating->bind_param('i', $articleID);
  if(!$sql_rating->execute()){
    header('location: ../index.php?error=failedtodeleteratings');
    exit();
  }

  // Wenn alles erfolgreich war, wird auf indexseite weitergeleite (Action: success)
  header('location: ../index.php?action=success');
  exit();

  // offene Verbidungen beenden
  $sql_rating->close();
  $connection->close();
