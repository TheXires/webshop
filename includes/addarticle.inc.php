<?php
  if(!isset($_POST['addarticle_submit'])){
    header("location: ../index.php");
    exit();
  }

  require 'connection.inc.php';

  $article_title = $_POST['artciel_title'];
  $article_description = $_POST['artcile_description'];
  $article_price = 100 * $_POST['article_price'];

// File Upload
  $img = $_FILES['article_img'];
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
        $img_name_new = uniqid('', true).'.'.$fileExt;
        $fileDestination = '../uploads/'.$img_name_new;
        $test = move_uploaded_file($img_tmp_name, $fileDestination);
      }else{
        header('location: ../addarticle.php?error=filetobig');
        exit();
      }
    }else{
      header('location: ../addarticle.php?error=uploadproblem&code='.$img_error);
      exit();
    }
  } else {
    header('location: ../addarticle.php?error=wrongfileformat');
    exit();
  }
// File Upload End

  // if(empty($article_title) || empty($article_description) || empty($article_price)){
  //   header('location: ../addarticle.php?error=emptyfields&title='.$article_title.'&description='.$article_description.'&price='.$article_price);
  //   exit();
  // }
  //
  // $sql_article = $connection->prepare("INSERT INTO article (title, description, price) VALUES (?, ?, ?)");
  // if(!$sql_article){
  //   header('location: ../addarticle.php?error=sqlerror&title='.$article_title.'&description='.$article_description.'&price='.$article_price);
  //   exit();
  // }
  // $sql_article->bind_param('ssi', $article_title, $article_description, $article_price);
  // $sql_article->execute();
  // if($sql_article !== flase){
  //   header('location: ../article.php?adding=success');
  //   exit();
  // }else{
  //   header('location: ../addarticle.php?error=failedaddingarticle&title='.$article_title.'&description='.$article_description.'&price='.$article_price);
  //   exit();
  // }
  //
  // $sql_article->close();
  // $connection->close();
?>
