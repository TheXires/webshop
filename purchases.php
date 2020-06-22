<?php
  require 'header.php';

  // Wenn Nutzer nicht angemeldet ist, wird er auf die login.php Seite weitergeleitet
  if(!isset($_SESSION['userid'])){
    header('location: login.php');
    exit();
  }
?>
  <!-- Hier findet der Nutzer alle seine bisherigen Käufe -->
  <div class="row justify-content-center">
    <div class="col-10  col-sm-9 col-md-8 col-lg-7 col-xl-6">
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
        <!-- Wird durch JS mit allen Käufen angemeldeten des Nutzers gefüllt -->
      </table>
    </div>
  </div>


<script src="js/purchases.js" charset="utf-8"></script>
<?php
  require 'footer.html';
?>
