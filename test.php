<?php
  require 'header.php';
  require 'includes/connection.inc.php';

  $sql_articles = $connection->prepare("SELECT * FROM article");
  if(!$sql_articles){
    header("location: login.php?error=sqlerror");
    exit();
  }
  $sql_articles->execute();
  $sql_articles_result = $sql_articles->get_result();
  echo "<div class='grid_container justify-content-center'>";
  while($row = mysqli_fetch_assoc($sql_articles_result)){
    // echo $row['device_brand'].' - '.$row['device_model'].'<br />';
    // echo "<img src='".$row['device_img']."' alt='Bild' width='250px' height='350'>";
    echo"
    <div class='grid_item product'>
      <div class='product_img'>
      <img src='".$row['device_img']."' alt=''>
      </div>
      <div class='product_title'>".$row['device_brand']." - ".$row['device_model']."</div>
      <div class='product_discription'>".$row['device_condition']."</div>
      <div class='spacer'></div>
      <div class='product_price'>".$row['device_price']."</div>
    </div>
    ";
  }
  echo '</div>';

  require 'footer.html';
?>
