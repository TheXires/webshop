<?php
  require 'header.php';
?>

<div class="row justify-content-center">
  <!-- Suche -->
  <div class="col-6">
    <input type="text" class="form-control" id="searchbar" placeholder="Suche">
  </div>
  <div class="col-1">
    <button type="button" id="search" class="btn btn-primary"><span class="mr-1 ml-1"><i class="fas fa-search"></i></span></button>
  </div>
</div>

<!-- Grid wird dynamisch durch serach.js erst geleert und dann gefüllt, nachdem auf "Suchen"-Butten geklickt wurde -->
<div id="searchresults" class='grid_container justify-content-center'>
  <!-- Inhalte die Shop erklären eintragen mit Bild -->
</div>

<!-- Infokarten, "Warum gebraucht kaufen?" - Werden durch JS entfernt sobald gesucht wird -->
<div id="buyUsedAdvantages" class="row justify-content-center mt-5">
  <div class="col-10 col-sm-9 col-md-8 col-lg-7 col-xl-6 mt-5">
    <h2>Warum gebraucht kaufen?</h2>
    <div class="card-deck mt-3">

      <!-- Umweltschutzkarte -->
      <div class="card">
        <div class="card-body justify-content-center">
          <center>
            <h5 class="card-title text-success">Umweltschutz</h5>
            &nbsp;&nbsp;
            <p class="card-text"><i class="fas fa-seedling fa-9x text-success"></i></p>
          </center>
        </div>
      </div>

      <!-- Sparenkarte -->
      <div class="card">
        <div class="card-body">
          <center>
            <h5 class="card-title text-danger">Sparen</h5>
            &nbsp;&nbsp;
            <p class="card-text"><i class="fas fa-piggy-bank fa-9x text-danger"></i></p>
          </center>
        </div>
      </div>

      <!-- Recycnlnkarte -->
      <div class="card">
        <div class="card-body">
          <center>
            <h5 class="card-title text-primary">Recyceln</h5>
            &nbsp;&nbsp;
            <p class="card-text"><i class="fas fa-recycle fa-9x text-primary"></i></p>
          </center>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="js\articlesearch.js" charset="utf-8"></script>
<?php
  require 'footer.html';
?>
