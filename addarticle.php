<?php
  require 'header.php';
?>
<div class="row justify-content-center">
  <div class="col-10  col-sm-9 col-md-8 col-lg-7 col-xl-6">
    <form action="includes\addarticle.inc.php" method="post" enctype="multipart/form-data">

      <!-- Eingabe des Marke -->
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="smartphone_brand">Marke</label>
          <input type="text" class="form-control" id="smartphone_brand" name="smartphone_brand" placeholder="Marke" autofocus required>
        </div>

        <!-- Eingabe des Modelnamen -->
        <div class="form-group col-md-8">
          <label for="smartphone_name">Model</label>
          <input type="text" class="form-control" id="smartphone_model" name="smartphone_model" placeholder="Model">
        </div>
      </div>

      <!-- Eingabe der Displaygröße -->
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="smartphone_brand">Gr&ouml;&szlig;e</label>
          <div class="input-group">
            <input type="number" class="form-control" id="smartphone_size" name="smartphone_size" step="0.01" placeholder="6,41" required>
            <div class="input-group-append">
              <span class="input-group-text">Zoll</span>
            </div>
          </div>
        </div>

        <!-- Auswahl des Zustandes -->
        <div class="form-group col-md-4">
          <label for="smartphone_name">Zustand</label>
          <select class="browser-default custom-select" id="smartphone_condition" name="smartphone_condition" required>
            <option selected>Zustand w&auml;hlen...</option>
            <option value="Wie neu">Wie neu</option>
            <option value="Sehr gut">Sehr gut</option>
            <option value="Gut">Gut</option>
            <option value="Stark genutzt">Stark genutzt</option>
          </select>
        </div>

        <!-- Auswahl der Speichergröße -->
        <div class="form-group col-md-4">
          <label for="smartphone_name">Speicher</label>
          <select class="browser-default custom-select" id="smartphone_storage" name="smartphone_storage" required>
            <option selected>Gr&ouml;&szlig;e w&auml;hlen...</option>
            <option value="64">64 GB</option>
            <option value="128">128 GB</option>
            <option value="256">256 GB</option>
            <option value="512">512 GB</option>
          </select>
        </div>
      </div>

      <!-- Bildupload -->
      <div class="form-row">
        <div class="form-group col-md-8">
          <label for="smartphone_img">Bilder</label>
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="smartphone_img" name="smartphone_img" aria-describedby="img_fromats">
            <label class="custom-file-label" for="smartphone_img">Bilder ausw&auml;hlen ...</label>
            <small id="img_fromats" class="form-text text-muted">.jgp .jpeg .png</small>
          </div>
        </div>

        <!-- Eingabe des Preises -->
        <div class="form-group col-md-4">
          <label for="smartphone_brand">Preis</label>
          <div class="input-group">
            <input type="number" class="form-control" id="smartphone_price" name="smartphone_price" aria-describedby="pirce_info" placeholder="299" required>
            <div class="input-group-append">
              <span class="input-group-text">€</span>
            </div>
          </div>
          <small id="pirce_info" class="form-text text-muted">Nur ganze Eurobetr&auml;ge</small>
        </div>
      </div>

      <!-- Button zu senden des Formulares -->
      <button type="submit" class="btn btn-primary" name="smartphone_submit">Hinzuf&uuml;gen</button>
    </form>
  </div>
</div>

<!-- Javascript zur manipulation des Formulares (auch durch Parameter in der URL) -->
<script src="js/addarticle.js" charset="utf-8"></script>
<?php
  require 'footer.html';
?>
