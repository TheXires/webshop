<?php
  session_start();

  // prüft ob zulöschende UserID vorhanden ist, um sonst sofort abzubrechen
  if($_SESSION['admin'] == 0){
    header('location: ../login.php');
    exit();
  }

  require 'connection.inc.php';

  $articleID = htmlspecialchars($_POST['articleid'], ENT_QUOTES, 'UTF-8');

// Beginn für löschen des Artikels
  // Bereite sql Abfrage vor
  $sql_article = $connection->prepare('DELETE FROM article WHERE articleID=?;');
  if(!$sql_article){
		header("location: ../login.php?error=sqlerror");
		exit();
  }

  // führt Anfrage aus und prüft ob diese erfolgreich war
  $sql_article->bind_param('i', $articleID);
  if(!$sql_article->execute()){
    header('location: ../article.php?error=failedtodeletearticle&articleid='.$articleID);
    exit();
  }

  // beende Verbindung von $sql_article
  $sql_article->close();
// Ende für löschen des Artikels

// ***

// Beginn für löschen der zugehörigen Bewertungen
  // Bereite sql Abfrage vor
  $sql_rating = $connection->prepare('DELETE FROM ratings WHERE articleID=?;');
  if(!$sql_rating){
		header("location: ../login.php?error=sqlerror");
		exit();
  }

  // führt Anfrage aus und prüft ob diese erfolgreich war
  $sql_rating->bind_param('i', $articleID);
  if(!$sql_rating->execute()){
    header('location: ../index.php?error=failedtodeleteratings');
    exit();
  }

  header('location: ../index.php?success=deleted');
  exit();

  // offene Verbidungen beenden
  $sql_rating->close();
  $connection->close();
