<?php
  require 'header.php';
  if(!isset($_SESSION['userid'])){
    header('location: login.php');
    exit();
  }
?>
  <div class="row justify-content-center">
    <div class="col-10  col-sm-9 col-md-8 col-lg-7 col-xl-6">
      <!-- Suche nach Nutzern durch Admin -->
      <h1>Bisherige K&auml;ufe</h1>
      <table class="table" id="purchases">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Artikelnummer</th>
            <th scope="col">Marke</th>
            <th scope="col">Modell</th>
            <th scope="col">Zustand</th>
            <th scope="col">Menge</th>
            <th scope="col">Preis</th>
            <th scope="col">Datum</th>
          </tr>
        </thead>
        <!-- Wird durch js\purchases.js gefüllt -->
      </table>
    </div>
  </div>


<script src="js/purchases.js" charset="utf-8"></script>
<?php
  require 'footer.html';
?>
