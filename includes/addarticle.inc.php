<?php
  session_start();
  require 'connection.inc.php';

  // prüft ob Nutzer angemeldet und Admin ist
  // Wenn nicht wird auf ../index.php Seite weitergeleitet (Fehler: missingpermissions)
  if(!isset($_SESSION['admin']) || $_SESSION['admin'] != 1){
    header("location: ../index.php?error=missingpermissions");
    exit();
  }

  // Variablen setzen
  $smartphone_add = $_POST['smartphone_add'];
  $smartphone_change = $_POST['smartphone_change'];

  // Prüft von wo diese Datei auferufen wurde und passt dementsprechend die SQL Abfrage und den $filename an
  // ../addarticle.php
  if($smartphone_add){
    $change = false;
    $query = "INSERT INTO article (brandID, model, size, conditionID, storage, price, img, stock) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $filename = 'addarticle.php?';

  // ../article.php
  }else if($smartphone_change){
    $change = true;
    $query = "UPDATE article SET brandID=?, model=?, size=?, conditionID=?, storage=?, price=?, img=?, stock=? WHERE articleID = ?";
    $filename = 'changeArticle.php?';

    if(!isset($_POST['articleid'])){
      header('location: ../index.php?error=missingarticleid');
      exit();
    }

    $articleID = $_POST['articleid'];

  // Ansonsten wird auf Start weitergeleitet (Fehler: unknownsource)
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
  // Wenn nicht, wird auf ../addarticle.php, bzw. ../changeArticle.php weitergeleitet (Fehler: emptyfields)
  // Es werden dabei alle möglichen Varaiblen zum vorausfüllen der Inputfelder wieder mitübergeben
  if(empty($brandName) || empty($model) || empty($size) || empty($condition) || empty($storage) || empty($price)){
    header('location: ../'.$filename.
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

  // Wenn preis geringer ist als 0, wird auf ../addarticle.php, bzw. ../changeArticle.php weitergeleitet (Fehler: negativprice)
  // Es werden dabei alle möglichen Varaiblen zum vorausfüllen der Inputfelder wieder mitübergeben
  if($price < 0){
    header('location: ../'.$filename.
        'error=negativprice'.
        '&brand='.$brandName.
        '&model='.$model.
        '&stock='.$stock.
        '&size='.$size.
        '&condition='.$condition.
        '&storage='.$storage);
    exit();
  }

// File Upload
  // Prüft ob ein Bild vorhanden ist, wenn ja wird dieses zum Artikel hinzugefügt.
  // Wenn nicht wird der upload einfach übersrpungen
  $img = $_FILES['smartphone_img'];
  if(!$img['name'] == ""){

    // um zu entscheiden ob einfügen oder update mit oder ohne Bild
    $withIMG = true;

    $img_name = $img['name'];
    $img_tmp_name = $img['tmp_name'];
    $img_size = $img['size'];
    $img_error = $img['error'];

    // Aufteilen des Dateinamen, um Format auslesen zu können
    // Wenn beides in einer Zeile gemacht wird kommt Fehler:
    $fileExt_tmp = explode('.', $img_name);
    $fileExt = strtolower(end($fileExt_tmp));

    // Erlaubte Formate
    $allowed = array('jpg', 'jpeg', 'png');

    // Prüfen, ob Format erlabt ist
    if(in_array($fileExt, $allowed)){
      if($img_error === 0){
        if($img_size < 10000000){
          // nennt das Bild um in 'id.zeitInMs.typ' und
          // baut den Speicherort des Bildes zusammen, dann
          // Pfad kürtzen, sodass er später auf die richtige Datei auf dem Server und nicht im 'fakepath' verweist,
          // dann das Bild vom Zwischenspeicher zum Speicherort verschieben
          $img_name_new = uniqid('', true).'.'.$fileExt;
          $fileDestination = '../uploads/'.$img_name_new;
          $finalFileDestination = substr($fileDestination, 3);
          move_uploaded_file($img_tmp_name, $fileDestination);
        }else{
          // wenn Bild zu groß ist, wird auf ../addarticle.php, bzw. ../changeArticle.php weitergeleitet (Fehler: filetobig)
          // Es werden dabei alle möglichen Varaiblen zum vorausfüllen der Inputfelder wieder mitübergeben
          header('location: ../'.$filename.
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
        // wenn ein prblem beim upload entsteht, wird auf ../addarticle.php, bzw. ../changeArticle.php weitergeleitet (Fehler: uploadproblem)
        // Es werden dabei alle möglichen Varaiblen zum vorausfüllen der Inputfelder wieder mitübergeben
        header('location: ../'.$filename.
            'error=uploadproblem'.
            '&code='.$img_error.
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
      // wenn das hochgeladene Bild nicht eines der in $allowed angegebenen Formate hat,
      // wird auf ../addarticle.php, bzw. ../changeArticle.php weitergeleitet (Fehler: wrongfileformat)
      // Es werden dabei alle möglichen Varaiblen zum vorausfüllen der Inputfelder wieder mitübergeben
      header('location: ../'.$filename.
          'error=wrongfileformat'.
          '&format='.$fileExt.
          '&brand='.$brandName.
          '&model='.$model.
          '&stock='.$stock.
          '&size='.$size.
          '&condition='.$condition.
          '&storage='.$storage.
          '&price='.$price);
      exit();
    }

  // Wenn kein Bild vorhanden ist, wird $query daran angepasst
  }else{
    if($change){
      $withIMG = false;
      $query = "UPDATE article SET brandID=?, model=?, size=?, conditionID=?, storage=?, price=?, stock=? WHERE articleID = ?";
    }else{
      $finalFileDestination = "";
    }
  }
// File Upload End


// Beginn der Prüfung, ob MarkenID vorhanden ist, bzw. anlegen und anschließdendes Abfragen der MarkenID
  // Bereite sql Abfrage zur Prüfung vor, ob Marke bereits existiert
  // Wenn dabei ein Fehler auftritt, wird auf ../addarticle.php, bzw. ../changeArticle.php weitergeleitet (Fehler: sqlerror)
  // Es werden dabei alle möglichen Varaiblen zum vorausfüllen der Inputfelder wieder mitübergeben
  $sql_brand = $connection->prepare("SELECT brandID FROM brand WHERE name=?");
  if(!$sql_brand){
    header('location: ../'.$filename.
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
  $sql_brand->bind_param('s', $brandName);
  $sql_brand->execute();
  $sql_brand_result = $sql_brand->get_result();

  // Wenn es die Marke schon gibt, speichern der entsprechenden ID in $brandID
  if($row = $sql_brand_result->fetch_assoc()){
    $brandID = $row['brandID'];

  // Wenn noch nicht eingetragen
  }else{
    // Marke in Datenbank eintragen
    $sql_add_brand = $connection->prepare("INSERT INTO brand (name) VALUES (?)");
    $sql_add_brand->bind_param('s', $brandName);
    $sql_add_brand->execute();

    // Prüft, ob Marke erfolgreich hinzugefügt wurde
    // Wenn nicht, wird auf ../addarticle.php, bzw. ../changeArticle.php weitergeleitet (Fehler: failedtoaddbrand)
    // Es werden dabei alle möglichen Varaiblen zum vorausfüllen der Inputfelder wieder mitübergeben
    if($sql_add_brand == false){
      header('location: ../'.$filename.
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


  // Bereite sql Abfrage zum Erstellne oder zum Ändern vor
  // Wenn dabei ein Fehler auftritt, wird auf ../addarticle.php, bzw. ../changeArticle.php weitergeleitet (Fehler: sqlerror)
  // Es werden dabei alle möglichen Varaiblen zum vorausfüllen der Inputfelder wieder mitübergeben
  $sql_article = $connection->prepare($query);
  if(!$sql_article){
    header('location: ../'.$filename.
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

  // füllt SQL Anfrage aus
  // Wenn artikel neu hinzugefügt wird
  if(!$change){
    $sql_article->bind_param('ssdssisi', $brandID, $model, $size, $condition, $storage, $price, $finalFileDestination, $stock);

  // Wenn Aritkelinformationen, einschließlich des Bildes bearbeitet werden sollen
  }else if($change && $withIMG){
    $sql_article->bind_param('ssdssisii', $brandID, $model, $size, $condition, $storage, $price, $finalFileDestination, $stock, $articleID);

  // Wenn Artikelinformationenen, aber nicht das Bild bearbeitet werden sollen
  }else if($change && !$withIMG){
    $sql_article->bind_param('ssdssiii', $brandID, $model, $size, $condition, $storage, $price, $stock, $articleID);

  // Sollte keiner der Punkte zutreffen, wird auf die Startseite weitergeleitet (Fehler: somethingwentwrong)
  }else{
    header('location: ../index.php?error=somethingwentwrong');
    exit();
  }

  // führt SQL Anfrage aus
  $sql_article->execute();

  // prüft ob einfügen ohne Probleme funktioniert hat
  // Wenn nicht, wird auf ../addarticle.php, bzw. ../changeArticle.php weitergeleitet (Fehler: failedaddingarticle)
  // Es werden dabei alle möglichen Varaiblen zum vorausfüllen der Inputfelder wieder mitübergeben
  if($sql_article == false){
    header('location: ../'.$filename.
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
  if(!$change){
    // gibt ID des zuletzt eingefügten Datensatzes zurück (ID des Artikels)
    // um auf richtige Artikel seite zu gelangen
    $articleID = $sql_article->insert_id;
  }
  // Wenn nur bearbeitet wird, ist ArtikelID schon bekannt

  header('location: ../'.$filename.'action=success&articleid='.$articleID);
  exit();

  // offene Verbidungen beenden
  $sql_brand->close();
  $sql_add_brand->close();
  $sql_article->close();
  $connection->close();
