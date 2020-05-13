<?php
  if(!isset($_POST['registration_submit'])){
    header("location: ../index.php");
    exit();
  }

  require 'connection.inc.php';

  $firstname = $_POST['registration_firstname'];
  $lastname = $_POST['registration_lastname'];
  $email = $_POST['registration_email'];
  $password = password_hash($_POST['registration_password'], PASSWORD_DEFAULT);
  $street = $_POST['registration_street'];
  $housenumber = $_POST['registration_houseNumber'];
  $city = $_POST['registration_city'];
  $zipcode = $_POST['registration_zip'];

  if(empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($street) || empty($housenumber) || empty($city) || empty($zipcode)){
    header('location: ../registration.php?error=emptyfields&firstname='.$firstname.'&lastname='.$lastname.'&email='.$email.'&street='.$street.'&housenumber='.$housenumber.'&city='.$city.'&zipcode='.$zipcode);
    exit();
  }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    header('location: ../registration.php?error=invalidemail&firstname='.$firstname.'&lastname='.$lastname.'&email=&street='.$street.'&housenumber='.$housenumber.'&city='.$city.'&zipcode='.$zipcode);
    exit();
  }else if(preg_match('/[0-9]/', $street) == 1){ # prueft ob die Strasse eine Zahl enthaelt, wenn ja, wird abgebrochen, wenn nicht wird registrierung durchgefuehrt
    header('location: ../registration.php?error=invalidstreet&firstname='.$firstname.'&lastname='.$lastname.'&email='.$email.'&street=&housenumber='.$housenumber.'&city='.$city.'&zipcode='.$zipcode);
    exit();
  }

  $sql_emailcheck = $connection->prepare("SELECT * FROM user WHERE email = ?");
  $sql_emailcheck->bind_param("s", $_POST['registration_email']);
  $sql_emailcheck->execute();
  $sql_emailcheck_result = $sql_emailcheck->get_result();

  if($sql_emailcheck_result->num_rows == 0){
    $sql_registration = $connection->prepare("INSERT INTO user (firstname, lastname, email, password, street, housenumber, city, zip) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if(!$sql_registration){
      header('location: ../registration.php?error=sqlerror');
      exit();
    }
    $sql_registration->bind_param('sssssisi', $firstname, $lastname, $email, $password, $street, $housenumber, $city, $zipcode);
    $sql_registration->execute();
    if($sql_registration !== false){
      $sql_registration_id = $connection->prepare("SELECT ID FROM user WHERE email=?");
      if(!$sql_registration_id){
        header('location: ../registration.php?error=sqlerror');
        exit();
      }
      $sql_registration_id->bind_param("s", $email);
	    $sql_registration_id->execute();
	    $sql_registration_id_result = $sql_registration_id->get_result();
	    if($row = $sql_registration_id_result->fetch_assoc()){
        session_start();
        $_SESSION['userid'] = $row['ID'];
        $_SESSION['useremail'] = $email;
        $_SESSION['username'] = $firstname;

        header("location: ../index.php?registration=success");
        exit();
      }
    }
  }else{
    header('location: ../registration.php?error=usedemail&firstname='.$firstname.'&lastname='.$lastname.'&email=&street='.$street.'&housenumber='.$housenumber.'&city='.$city.'&zipcode='.$zipcode);
    exit();
  }
  $sql_emailcheck->close();
  $sql_registration->close();
  $sql_registration_id->close();
  $connection->close();
