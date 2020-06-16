<?php
  if(!isset($_POST['smartphone_add']) && !isset($_POST['smartphone_change'])){
    header("location: ../index.php");
    exit();
  }

  require 'connection.inc.php';

  if(isset($_POST['smartphone_add'])){
    $change = false;
    $query = "INSERT INTO article (brandID, model, size, conditionID, storage, price, img, stock) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

  }else if(isset($_POST['smartphone_change'])){
    $change = true;
    $query = "UPDATE article SET brandID=?, model=?, size=?, conditionID=?, storage=?, price=?, img=?, stock=? WHERE articleID = ?";

    if(!isset($_POST['articleid'])){
      header('location: ../index.php?error=missingarticleid');
    }

    $articleID = $_POST['articleid'];

  }else{
    header('location: ../index.php?error=unknownsource');
    exit();

  }

  // Variablen erstllung aus Inputfeldern und schützen vor xss
  $brandName = htmlspecialchars($_POST['smartphone_brand'], ENT_QUOTES, 'UTF-8');
  $model = htmlspecialchars($_POST['smartphone_model'], ENT_QUOTES, 'UTF-8');
  $stock = htmlspecialchars($_POST['smartphone_stock'], ENT_QUOTES, 'UTF-8');
  $size = htmlspecialchars($_POST['smartphone_size'], ENT_QUOTES, 'UTF-8');
  $condition = htmlspecialchars($_POST['smartphone_condition'], ENT_QUOTES, 'UTF-8');
  $storage = htmlspecialchars($_POST['smartphone_storage'], ENT_QUOTES, 'UTF-8');
  $price = htmlspecialchars($_POST['smartphone_price'], ENT_QUOTES, 'UTF-8');

  // prüfen ob alle Felder gesetzt sind
  if(empty($brandName) || empty($model) || empty($size) || empty($condition) || empty($storage) || empty($price)){
    header('location: ../addarticle.php?'.
        'error=emptyfields'.
        '&brand='.$brandName.
        '&model='.$model.
        '&stock='.$stock.
        '&size='.$size.
        '&condition='.$condition.
        '&storage='.$storage.
        '&price='.$price);
    exit();
  }

// File Upload
  // Prüft ob ein Bild vorhanden ist, wenn ja wird dieses zum Artikel hinzugefügt.
  // Wenn nicht wird der upload einfach übersrpungen
  $img = $_FILES['smartphone_img'];
  if(!$img['name'] == ""){

    $withIMG = true;

    $img_name = $img['name'];
    $img_tmp_name = $img['tmp_name'];
    $img_size = $img['size'];
    $img_error = $img['error'];

    // Wenn beides in einer Zeile gemacht wird kommt Fehler:
    $fileExt_tmp = explode('.', $img_name);
    $fileExt = strtolower(end($fileExt_tmp));

    // Erlaubte Formate
    $allowed = array('jpg', 'jpeg', 'png');

    if(in_array($fileExt, $allowed)){
      if($img_error === 0){
        if($img_size < 10000000){
          $img_name_new = uniqid('', true).'.'.$fileExt; // nennt das Bild um in 'id.zeitInMs.typ'
          $fileDestination = '../uploads/'.$img_name_new; //baut den Speicherort des Bildes zusammen
          $finalFileDestination = substr($fileDestination, 3); // kürzt Pfad so, dass er später auf die richtige Datei auf dem Server und nicht im 'fakepath' verweist
          move_uploaded_file($img_tmp_name, $fileDestination); // verscheibt das Bild vom Zwischenspeicher zum Speicherort
        }else{
          // wenn Bild zu groß ist
          header('location: ../addarticle.php?'.
              'error=filetobig'.
              '&brand='.$brandName.
              '&model='.$model.
              '&stock='.$stock.
              '&size='.$size.
              '&condition='.$condition.
              '&storage='.$storage.
              '&price='.$price);
          exit();
        }
      }else{
        // wenn ein prblem beim upload entsteht
        header('location: ../addarticle.php?error=uploadproblem&'.
            'code='.$img_error.
            '&brand='.$brandName.
            '&model='.$model.
            '&stock='.$stock.
            '&size='.$size.
            '&condition='.$condition.
            '&storage='.$storage.
            '&price='.$price);
        exit();
      }
    } else {
      // wenn das hochgeladene Bild nicht eines der in $allowed angegebenen Formate hat
      header('location: ../addarticle.php?'.
          'error=wrongfileformat&'.
          'format='.$fileExt.
          '&brand='.$brandName.
          '&model='.$model.
          '&stock='.$stock.
          '&size='.$size.
          '&condition='.$condition.
          '&storage='.$storage.
          '&price='.$price.
          '&test='.$test
        );
      exit();
    }

  // Wenn kein Bild vorhanden ist
  }else{
    if($change){
      $withIMG = false;
      $query = "UPDATE article SET brandID=?, model=?, size=?, conditionID=?, storage=?, price=?, stock=? WHERE articleID = ?";
    }else{
      $finalFileDestination = "";
    }
  }
// File Upload End


// Beginn der Prüfung, nach MarkenID, bzw. anlegen und anschließdendes Abfragen der MarkenID
  $sql_brand = $connection->prepare("SELECT brandID FROM brand WHERE name=?");
  if(!$sql_brand){
    header('location: ../addarticle.php?'.
        'error=sqlerror'.
        '&brand='.$brandName.
        '&model='.$model.
        '&stock='.$stock.
        '&size='.$size.
        '&condition='.$condition.
        '&storage='.$storage.
        '&price='.$price);
    exit();
  }

  $sql_brand->bind_param('s', $brandName);
  $sql_brand->execute();
  $sql_brand_result = $sql_brand->get_result();

  if($row = $sql_brand_result->fetch_assoc()){
    $brandID = $row['brandID'];
  }else{
    $sql_add_brand = $connection->prepare("INSERT INTO brand (name) VALUES (?)");
    $sql_add_brand->bind_param('s', $brandName);
    $sql_add_brand->execute();

    // Prüft, ob Marke erfolgreich hinzugefügt wurde
    if($sql_add_brand == false){
      header('location: ../addarticle.php?'.
          'error=failedtoaddbrand'.
          '&brand='.$brandName.
          '&model='.$model.
          '&stock='.$stock.
          '&size='.$size.
          '&condition='.$condition.
          '&storage='.$storage.
          '&price='.$price);
      exit();
    }

    // gibt ID des zuletzt eingefügten Datensatzes zurück (ID der Marke)
    $brandID = $sql_add_brand->insert_id;

  }
// Ende der MarkenID Prüfung


  // Bereite sql Abfrage vor
  $sql_article = $connection->prepare($query);
  if(!$sql_article){
    header('location: ../addarticle.php?'.
        'error=sqlerror'.
        '&brand='.$brandName.
        '&model='.$model.
        '&stock='.$stock.
        '&size='.$size.
        '&condition='.$condition.
        '&storage='.$storage.
        '&price='.$price);
    exit();
  }

  // füllt und führt Anfrage aus
  if(!$change){
    $sql_article->bind_param('ssdssisi', $brandID, $model, $size, $condition, $storage, $price, $finalFileDestination, $stock);
  }else if($change && $withIMG){
    $sql_article->bind_param('ssdssisii', $brandID, $model, $size, $condition, $storage, $price, $finalFileDestination, $stock, $articleID);
  }else if($change && !$withIMG){
    $sql_article->bind_param('ssdssiii', $brandID, $model, $size, $condition, $storage, $price, $stock, $articleID);
  }else{
    header('location: ../index.php?error=somethingwentwrong');
    exit();
  }

  $sql_article->execute();

  // prüft ob einfügen ohne Probleme funktioniert hat
  if($sql_article == false){
    header('location: ../addarticle.php?'.
        'error=failedaddingarticle'.
        '&brand='.$brandName.
        '&model='.$model.
        '&stock='.$stock.
        '&size='.$size.
        '&condition='.$condition.
        '&storage='.$storage.
        '&price='.$price);
    exit();
  }

  // Wenn Artikel nicht bearbeitet, sondern hinzugefügt wurde
  if(!changed){
    // gibt ID des zuletzt eingefügten Datensatzes zurück (ID des Artikels)
    // um auf richtige Artikel seite zu gelangen
    $articleID = $sql_article->insert_id;
  }
  // Wenn nur bearbeitet wird, ist ArtikelID schon bekannt

  header('location: ../article.php?action=success&articleid='.$articleID);
  exit();

  // offene Verbidungen beenden
  $sql_brand->close();
  $sql_add_brand->close();
  $sql_article->close();
  $sql_article->close();
  $connection->close();
