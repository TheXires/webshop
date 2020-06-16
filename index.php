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
  <!-- Inhalte die Shop erklären eintragen -->
</div>



<script src="js\articlesearch.js" charset="utf-8"></script>
<?php
  require 'footer.html';
?>
