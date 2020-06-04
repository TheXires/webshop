<?php
  require 'header.php';
  require 'includes\article.inc.php';
?>

<div class="alert alert-warning" role="alert">
  This is a warning alert—check it out!
</div>

<div class="container">
  <div class="row">
    <div class="col-6">
      <div class="productpageimg col-6">
        <!-- Bild -->
        <?php
          echo "<img src='".$smartphone_img."' alt='Produktbild'>";
          // echo $smartphone_brand." - ".$smartphone_model." - ".$smartphone_size." - ".$smartphone_condition." - ".$smartphone_storage." - ".$smartphone_price;
        ?>
      </div>
    </div>
    <div class="col-6">
      <!-- Titel (Marke und Modell) -->
      <?php echo $smartphone_brand." - ".$smartphone_model; ?>
      <!-- Preis -->
      <?php  echo $smartphone_price;?>&euro;
    </div>
  </div>
    <table class="table">
      <tr>
        <th>Marke</th>
        <td> <?php echo $smartphone_brand; ?> </td>
      <tr>
        <th>Modell</th>
        <td> <?php echo $smartphone_model; ?> </td>
      </tr>
      <tr>
        <th>Gr&ouml;&szlig;</th>
        <td> <?php echo $smartphone_size; ?> </td>
      </tr>
      <tr>
        <th>Zustand</th>
        <td> <?php echo $smartphone_condition; ?> </td>
      </tr>
      <tr>
        <th>Speicher</th>
        <td> <?php echo $smartphone_storage; ?> </td>
      </tr>
    </table>
</div>

<?php
  require 'footer.html';
?>
