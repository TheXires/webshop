<?php
  if(!isset($_POST['smartphone_submit'])){
    header("location: ../index.php");
    exit();
  }

  require 'connection.inc.php';

// Variablen erstllung aus Inputfeldern
  $smartphone_brand = $_POST['smartphone_brand'];
  $smartphone_model = $_POST['smartphone_model'];
  $smartphone_size = $_POST['smartphone_size'];
  $smartphone_condition = $_POST['smartphone_condition'];
  $smartphone_storage = $_POST['smartphone_storage'];
  $smartphone_price = 100 * $_POST['smartphone_price'];

// prüfen ob alle Felder gesetzt sind
  if(empty($smartphone_brand) || empty($smartphone_model) || empty($smartphone_size) || empty($smartphone_condition) || empty($smartphone_storage) || empty($smartphone_price) || empty($_FILES['smartphone_img'])){
    header('location: ../addarticle.php?error=emptyfields&brand='.$smartphone_brand.'&model='.$smartphone_model.'&size='.$smartphone_size.'&condition='.$smartphone_condition.'&storage='.$smartphone_storage.'&price='.$smartphone_price.'&img='.$_FILES["smartphone_img"]);
    exit();
  }

// File Upload
  $img = $_FILES['smartphone_img'];
  $img_name = $img['name'];
  $img_tmp_name = $img['tmp_name'];
  $img_size = $img['size'];
  $img_error = $img['error'];
  $img_name = $img['name'];

  // Wenn beides in einer Zeile gemacht wird kommt Fehler:
  //    Notice: Only variables should be passed by reference in D:\Programme\xampp\htdocs\webshop\includes\addarticle.inc.php on line 23
  $fileExt_tmp = explode('.', $img_name);
  $fileExt = strtolower(end($fileExt_tmp));

  // Erlaubte Formate
  $allowed = array('jpg', 'jpeg', 'png');

  if(in_array($fileExt, $allowed)){
    if($img_error === 0){
      if($img_size < 10000000){
        $img_name_new = uniqid('', true).'.'.$fileExt; // nennt das Bild um in 'id.zeitInMs.typ'
        $fileDestination = '../uploads/'.$img_name_new; //baut den Speicherort des Bildes zusammen
        move_uploaded_file($img_tmp_name, $fileDestination); // verscheibt das Bild vom Zwischenspeicher zum Speicherort
      }else{
        header('location: ../addarticle.php?error=filetobig');
        exit();
      }
    }else{
      header('location: ../addarticle.php?error=uploadproblem&code='.$img_error);
      exit();
    }
  } else {
    header('location: ../addarticle.php?error=wrongfileformat&format='.$fileExt);
    exit();
  }
// File Upload End

  $sql_article = $connection->prepare("INSERT INTO article (device_brand, device_model, device_size, device_condition, device_storage, device_price, device_img) VALUES (?, ?, ?, ?, ?, ?, ?)");
  if(!$sql_article){
    header('location: ../addarticle.php?error=sqlerror&title='.$article_title.'&description='.$article_description.'&price='.$article_price);
    exit();
  }
  $sql_article->bind_param('ssdssis', $smartphone_brand, $smartphone_model, $smartphone_size, $smartphone_condition, $smartphone_storage, $smartphone_price, substr($fileDestination, 3)); //ltrim entfernt die die er
  $sql_article->execute();
  if($sql_article !== flase){
    header('location: ../article.php?adding=success');
    exit();
  }else{
    header('location: ../addarticle.php?error=failedaddingarticle&brand='.$smartphone_brand.'&model='.$smartphone_model.'&size='.$smartphone_size.'&condition='.$smartphone_condition.'&storage='.$smartphone_storage.'&price='.$smartphone_price.'&img='.$_FILES["smartphone_img"]);
    exit();
  }

  $sql_article->close();
  $connection->close();
