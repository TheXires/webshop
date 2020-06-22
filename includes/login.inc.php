<?php
	require 'connection.inc.php';

	// prueft ob ueber das login Formular auf diese Seite zugegriffen wurde
	// Wenn nicht, wird auf Loginsiete weitergeleitet
	if(!isset($_POST['login_submit'])){
		header("location: ../login.php");
		exit();
	}

	// setzen der Variablen und schützen vor xss
	$email = htmlspecialchars($_POST['login_email'], ENT_QUOTES, 'UTF-8');
	$password = $_POST['login_password'];

	// Wenn Email oder Passwort leer sind wir auf Loginseite weitergeleitet (Fehler: emptyfields)
	if(empty($email) || empty($password)){
		header("location: ../login.php?error=emptyfields");
		exit();
	}

	// Bereite SQL-Abfrage zum Einloggen des Nutzers vor
	// Wenn dabei ein Fehler auftritt, wird auf Loginseite weitergeleitet (Fehler: sqlerror)
	$sql_login = $connection->prepare("SELECT userID, email, password, admin FROM user WHERE email=?");
  if(!$sql_login){
		header("location: ../login.php?error=sqlerror");
		exit();
  }

	// füllt und führt Anfrage aus
  $sql_login->bind_param("s", $email);
  $sql_login->execute();
  $sql_login_result = $sql_login->get_result();

	// Wenn ein Nutzer mit diesen Daten existriert, wird das Passwort geprüft
	// Wenn ja, wird das Passwort geprüft
	// Wenn nicht wird Nutzer auf Loginseite weitergeleitet (Fheler: nomatch)
	)
  if($row = $sql_login_result->fetch_assoc()){
		$password_check = password_verify($password, $row['password']);

		// Wenn passwörter übereinstimmen, einloggen des Nutzer durch setzten der Session
				// und weiterleiten auf Indexseite
		// Wenn nicht, wir Nutzer auf Loginseite weitergeleitet (Fehler: wrongpassword
		if($password_check == true){
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
