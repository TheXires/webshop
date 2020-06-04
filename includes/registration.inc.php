<?php
  if(!isset($_POST['registration_submit'])){
    header("location: ../index.php");
    exit();
  }

  require 'connection.inc.php';

  // setzen der Variablen und schützen vor xss
  $firstname = htmlspecialchars($_POST['registration_firstname'], ENT_QUOTES, 'UTF-8');
  $lastname = htmlspecialchars($_POST['registration_lastname'], ENT_QUOTES, 'UTF-8');
  $email = htmlspecialchars($_POST['registration_email'], ENT_QUOTES, 'UTF-8');
  $password = password_hash($_POST['registration_password'], PASSWORD_DEFAULT);
  $street = htmlspecialchars($_POST['registration_street'], ENT_QUOTES, 'UTF-8');
  $housenumber = htmlspecialchars($_POST['registration_houseNumber'], ENT_QUOTES, 'UTF-8');
  $city = htmlspecialchars($_POST['registration_city'], ENT_QUOTES, 'UTF-8');
  $zipcode = htmlspecialchars($_POST['registration_zip'], ENT_QUOTES, 'UTF-8');

  // Prüft, ob eine der Variablen leer ist. Wenn nicht wird der Nutzer gebeten die Eingabe zu ergänzen
  if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($street) || empty($housenumber) || empty($city) || empty($zipcode)){
    header('location: ../registration.php?error=emptyfields&firstname='.$firstname.'&lastname='.$lastname.'&email='.$email.'&street='.$street.'&housenumber='.$housenumber.'&city='.$city.'&zipcode='.$zipcode);
    exit();

  // Prüfung der Emailaddresse -> ist dies eine mögliche Emailaddresse
  } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('location: ../registration.php?error=invalidemail&firstname='.$firstname.'&lastname='.$lastname.'&email=&street='.$street.'&housenumber='.$housenumber.'&city='.$city.'&zipcode='.$zipcode);
    exit();

  // prueft ob die Strasse eine Zahl enthaelt, wenn ja, wird abgebrochen, wenn nicht wird registrierung durchgefuehrt
  } else if(preg_match('/[0-9]/', $street) == 1) {
    header('location: ../registration.php?error=invalidstreet&firstname='.$firstname.'&lastname='.$lastname.'&email='.$email.'&street=&housenumber='.$housenumber.'&city='.$city.'&zipcode='.$zipcode);
    exit();
  }

  // könnte ausgelagert werden -> emailAlreadyExist(); oder so ähnlich
  // Erstellt Datenbankabfrage, um zu prüfen, ob Email bereits registriert ist
  $sql_emailcheck = $connection->prepare("SELECT * FROM user WHERE email = ?");
  if(!$sql_emailcheck){
    header('location: ../registration.php?error=sqlerror');
    exit();
  }

  // füllt und führt Anfrage zur Emailprüfung aus
  $sql_emailcheck->bind_param("s", $email);
  $sql_emailcheck->execute();
  $sql_emailcheck_result = $sql_emailcheck->get_result();

  // Wenn eine kein Eintrag vohanden ist wird der Nutzer registriert
  if($sql_emailcheck_result->num_rows == 0){
    // Erstellt Datenbankabfrage, um Nutzer zur Datenbank hinzuzufügen
    $sql_registration = $connection->prepare("INSERT INTO user (firstname, lastname, email, password, street, housenumber, city, zip, admin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)");
    if(!$sql_registration){
      header('location: ../registration.php?error=sqlerror');
      exit();
    }

    // füllt und führt Anfrage zur Registrierung aus
    $sql_registration->bind_param('sssssisi', $firstname, $lastname, $email, $password, $street, $housenumber, $city, $zipcode);
    $sql_registration->execute();

    // Prüft, ob Konto erfolgreich angelegt wurde
    if($sql_registration !== false){

// Könnte in funktion ausgelagert werden, zusammen mit dem normalen einloggen
      // Erstellt der Datenbankabfrage zum einloggen des Nutzers
      $sql_registration_id = $connection->prepare("SELECT userID FROM user WHERE email=?");
      if(!$sql_registration_id){
        header('location: ../registration.php?error=sqlerror');
        exit();
      }

      // füllt und führt Anfrage zum einloggen aus
      $sql_registration_id->bind_param("s", $email);
	    $sql_registration_id->execute();
	    $sql_registration_id_result = $sql_registration_id->get_result();

	    if($row = $sql_registration_id_result->fetch_assoc()){

        // automtisches einloggen des Nutzers nach erstellen des Kontos, durch setzen der Session
        session_start();
        $_SESSION['userid'] = $row['userID'];
        $_SESSION['useremail'] = $email;
        $_SESSION['username'] = $firstname;
        $_SESSION['admin'] = 0;

        header("location: ../index.php?registration=success");
        exit();
      }
    }
// Ende der möglichen Auslagerung

  // Wenn es bereits einen Eintrag gibt, wird der Nutzer darauf hingewiesen, dass diese Email bereits registriert ist
  }else{
    header('location: ../registration.php?error=usedemail&firstname='.$firstname.'&lastname='.$lastname.'&email=&street='.$street.'&housenumber='.$housenumber.'&city='.$city.'&zipcode='.$zipcode);
    exit();
  }

  // offene Verbidungen beenden
  $sql_emailcheck->close();
  $sql_registration->close();
  $sql_registration_id->close();
  $connection->close();
