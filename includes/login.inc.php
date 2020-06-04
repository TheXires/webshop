<?php
	// prueft ob ueber das login Formular (../login.php) auf diese Seite zugegriffen wurde
	if(!isset($_POST['login_submit'])){
		header("location: ../index.php");
		exit();
	}
  require 'connection.inc.php';

	// setzen der Variablen und schützen vor xss
	$email = htmlspecialchars($_POST['login_email'], ENT_QUOTES, 'UTF-8');
	$password = $_POST['login_password'];

	if(empty($email) || empty($password)){
		header("location: ../login.php?error=emptyfields");
		exit();
	}

	// Bereite sql Abfrage vor
	$sql_login = $connection->prepare("SELECT userID, email, password, admin FROM user WHERE email=?");
  if(!$sql_login){
		header("location: ../login.php?error=sqlerror");
		exit();
  }

	// füllt und führt Anfrage aus
  $sql_login->bind_param("s", $email);
  $sql_login->execute();
  $sql_login_result = $sql_login->get_result();

	// Wertet Ergebnis aus
  if($row = $sql_login_result->fetch_assoc()){

		// Prüfen ob Passwort korrekt
		$password_check = password_verify($password, $row['password']);
		if($password_check == true){
			// Einloggen des Nutzer durch setzten der Session
			session_start();
			$_SESSION['userid'] = $row['userID'];
			$_SESSION['useremail'] = $row['email'];
			$_SESSION['username'] = $row['firstname'];
			$_SESSION['admin'] = $row['admin'];

			header('location: ../index.php?login=success&test1='.$row['admin'].'&test2='.$_SESSION['admin']);
			exit();

		}else{
			header('location: ../login.php?error=wrongpassword&email='.$email);
			exit();
		}

  }else{
    header('location: ../login.php?error=nomatch');
		exit();

  }

	// offene Verbidungen beenden
	$sql_login->close();
	$connection->close();
