<?php
  require 'header.php';
  if(!isset($_SESSION['userid'])){
    header('location: login.php');
    exit();
  }
?>
  <!-- Hier findet der Nutzer alle seine bisherigen Bewertungen -->
  <div class="row justify-content-center">
    <div class="col-10  col-sm-9 col-md-8 col-lg-7 col-xl-6">
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
        <!-- Wird durch JS mit allen Bewertungen des angemeldeten Nutzers gefüllt -->
      </table>
    </div>
  </div>


<script src="js/ratings.js" charset="utf-8"></script>
<?php
  require 'footer.html';
?>
