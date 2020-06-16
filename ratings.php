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
      <h1>Meine Bewertungen</h1>
      <table class="table" id="ratings">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Artikelnummer</th>
            <th scope="col">Marke</th>
            <th scope="col">Modell</th>
            <th scope="col">Speicher</th>
            <th scope="col">Zustand</th>
            <th scope="col">Bewertung</th>
          </tr>
        </thead>
        <!-- Wird durch js\purchases.js gefüllt -->
      </table>
    </div>
  </div>


<script src="js/ratings.js" charset="utf-8"></script>
<?php
  require 'footer.html';
?>
