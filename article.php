<?php
  require 'header.php';
?>

  <div class="container">

    <!-- Wird nur angezeigt, wenn angemeldeter Nutzer Admin ist -->
    <!-- Erlaubt es Admin den Artikel zu bearbeiten oder zu löschen-->
    <?php if(isset($_SESSION['admin'])){
      if($_SESSION['admin'] == 1){ ?>
        <div class="alert alert-warning">
          <div class="row justify-content-between">
            <div class="ml-1 mt-1">
              <h4>Artikel oder Verfügbarkeit: </h4>
            </div>
            <!-- hidden...IDs sind Inputfelder für die Formulare, die in JS mit der ArtikelID gefüllt werden,
                 damit mit dieser in PHP weiter gearbeitet werden kann -->
            <div class="ml-auto mr-1">
              <!-- Form zum Bearbeiten des Artikels -->
              <form id="changeForm" method="post">
                <input type="hidden" id="hiddenEditID" name="articleid">
                <button type="submit" class="btn btn-secondary">Anpassen</button>
              </form>
            </div>
            <div class="mr-1">
              <!-- Form zum Löschen des Artikels -->
              <form action="includes/deleteArticle.inc.php" method="post">
                <input type="hidden" id="hiddenDeleteID" name="articleid">
                <button type="submit" class="btn btn-danger">L&ouml;schen</button>
              </form>
            </div>
          </div>
        </div>
      <?php }
    } ?>


    <div class="row">
      <!-- Produktbild, wird durch JS gesetzt -->
      <img class="col-md-6 align-self-center" id="img" alt="Produktbild">

      <!-- Tabelle mit Artikelinformationen wird dynamisch druch JS erzeugt -->
      <div class="col-md-6 align-self-center" id="infos"></div>
    </div>
    <div class="row justify-content-between">
      <div class="col-auto mt-3 mb-3">
        <!-- Anzahl verfügbarer Artikel wird durch JS dynamisch gesetzt -->
        Noch <span class="font-weight-bold" id="inStock">0</span> auf Lager
      </div>
      <form class="form-inline" action="includes/purchaseArticle.inc.php" method="POST">
        <div class="form-group">
          <input type="hidden" id="hiddenPurchaseID" name="articleid">
          <div class="ml-auto mt-3 mb-3">
            <!-- Hier kann der Nutzer eingeben, wie viele Artikel er kaufen möchte
                 Wenn du Verfügbaren Artikel überschritten werden, wird das Feld invalid und der Button disabled-->
            <input id="purchaseQuantity" name="purchaseQuantity" type="number" class="form-control col-auto" value="1">
            <div class="invalid-feedback">
              Nicht gen&uuml;gend Artikel verf&uuml;gbar
            </div>
          </div>
          <!-- sorgen für etwas platz zwischen Input und Button -->
          &nbsp;&nbsp;
          <div class="mt-3 mb-3">
            <!-- Button zum Kaufen des Artikels in der angegebenen Stückzahl -->
            <!-- Es wird sofort gekauft, was eigentlich nicht passiert, da eigentlich
                 erst auf eine Seite weitergeleitet wird, um Zahlungsdaten einzugeben -->
           <button type="submit" id="purchaseButton" class="btn btn-success mr-3"><span class="mr-4 ml-4"><i class="fas fa-credit-card"></i> Kaufen</span></button>
          </div>
        </div>
      </form>
    </div>


    <!-- Wird nur angezeigt, wenn Nutzer angemeldet ist -->
    <!-- Erlaubt es dem Nutzer den Artikel zu bewerten -->
    <!-- Wird nicht mehr angezeigt, wenn der Nutzer diesen Artikel bereits bewertet hat (geregelt durch JS und PHP) -->
    <?php if(isset($_SESSION['userid'])){ ?>
      <div id="ratingDialog" class="alert alert-secondary">
        <h5>Nutzen Sie die Gelegenheit und helfen Sie anderen Nutzern durch ihre Bewertung bei der Kaufentscheidung</h5>
        <!-- Buttons die anzahl der Sterne anzeigen -->
        <div class="form-group">
          <button type="button" class="btn starRating" id="star_1" onclick="changeRating(1)"><i class="fas fa-star"></i></button>
          <button type="button" class="btn starRating" id="star_2" onclick="changeRating(2)"><i class="far fa-star"></i></button>
          <button type="button" class="btn starRating" id="star_3" onclick="changeRating(3)"><i class="far fa-star"></i></button>
          <button type="button" class="btn starRating" id="star_4" onclick="changeRating(4)"><i class="far fa-star"></i></button>
          <button type="button" class="btn starRating" id="star_5" onclick="changeRating(5)"><i class="far fa-star"></i></button>
        </div>
        <!-- Textfeld in dem der Nutzer seine Bewertung frei Formulieren kann -->
        <div class="form-group col-12">
          <label for="ratingDescription">Beschreibung</label>
          <textarea class="form-control" id="ratingDescription" rows="4"></textarea>
        </div>
        <!-- Button zum senden der Bewertung -->
        <button type="button" id="rateButton" class="btn btn-primary mr-1">Bewerten</button>
      </div>
    <?php } ?>


    <!-- Liste wird dynamisch durch JS erstellt -->
    <h3>Bewertungen</h3>
    <div id="ratings"></div>
</div>

<script src="js\article.js" charset="utf-8"></script>
<?php
  require 'footer.html';
?>
