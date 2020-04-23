<?php
	#prueft ob ueber das login Formular (../login.php) auf diese Seite zugegriffen wurde
	if(!isset($_POST['login_submit'])){
		header("location: ../index.php");
		exit();
	}
  require 'connection.inc.php';

	$email = $_POST['login_email'];
	$password = $_POST['login_password'];

	if(empty($email) || empty($password)){
		header("location: ../login.php?error=emptyfields");
		exit();
	}else{
		$sql_login = $connection->prepare("SELECT ID, email, password FROM user WHERE email=?");
	  if(!$sql_login){
			header("location: ../login.php?error=sqlerror");
			exit();
	  }
    $sql_login->bind_param("s", $email);
    $sql_login->execute();
    $sql_login_result = $sql_login->get_result();
    if($row = $sql_login_result->fetch_assoc()){
			$password_check = password_verify($password, $row['password']);
			if($password_check == true){
				session_start();
				$_SESSION['userid'] = $row['ID'];
				$_SESSION['useremail'] = $row['email'];
				$_SESSION['username'] = $row['firstname'];

				header('location: ../index.php?login=success');
				exit();
			}else{
				header('location: ../login.php?error=wrongpassword&email='.$email);
				exit();
			}
    }else{
      header('location: ../login.php?error=nomatch');
			exit();
    }

  $sql_login->close();
	$connection->close();
  }
?>
