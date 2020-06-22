<?php
  // Muss immer includet werden, wenn eine Verbindung zur Datenbank aufgebauet werden soll

  // Setzt Variablen für Datenbankverbindung
  $dbServername = "localhost";
  $dbUser = "root";
  $dbPassword = "";
  $db = "test";

  // verbindet sich mit der Datenbank
  $connection = new mysqli($dbServername, $dbUser, $dbPassword, $db);

  // Wenn es zu einem Fehler kam, wird die Verbindung beendet
  if($connection->connect_error){
    die($connection->connect_error);
  }
