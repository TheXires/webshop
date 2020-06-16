<?php
  session_start();
  require 'connection.inc.php';

  if(!isset($_SESSION['userid'])){
    echo 'notloggedin';
    exit();
  }

  if(empty($_POST['articleid']) || empty($_POST['rating']) || empty($_POST['description'])){
    echo 'needmoreinformation';
    exit();
  }

  // echo $_SESSION['userid'];
  // echo $_POST['articleid'];
  // echo $_POST['rating'];
  // echo $_POST['description'];

  $userID = $_SESSION['userid'];
  $articleID = $_POST['articleid'];
  $rating = $_POST['rating'];
  $description = $_POST['description'];

  $sql = $connection->prepare("INSERT INTO ratings (userID, articleID, rating, description) VALUES (?, ?, ?, ?)");
  if(!$sql){
    echo 'sqlerror';
    exit();
  }
  $sql->bind_param('iiis', $userID, $articleID, $rating, $description);

  if(!$sql->execute()){
    echo 'inserterror';
    exit();
  }

  echo 'success';

  $sql->close();
  $connection->close();
