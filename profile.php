<?php
  require 'header.php';
  require 'includes/userinfo.inc.php';
?>

<div class="row justify-content-center">
  <div class="col-10  col-sm-9 col-md-8">
    <!-- col-xl-6 -->

    <center><h2>Konto</h2></center>
    <br>

    <!-- Anfang erste Zeile -->
    <div class="row">
      <!-- Persoenliche Daten und Passowrt aendern -->
      <div class="col-sm-4 mb-2">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Persönliche Daten</h5>
            <p class="card-text">
              <!-- Sollte vielleicht eher mit JS und dann ajax gelöst werden, aber habe ich erst später gelernt, daher später noch überarbeiten -->
              <!-- Persoenliche Daten werden aus Datenbank gelesen und hier eingefuegt -->
              <?php
                echo "<p><span class='font-weight-bold'> Name </span> <br>" . $firstname . " " . $lastname . "</p><p><span class='font-weight-bold'> Anschrift </span><br>" . $street . ", " . $housenumber . "<br>" . $zip . ", " . $city . "</p>";
              ?>
              <!-- Button für Modal -->
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">Bearbeiten</button>
          </div>
        </div>
      </div>


      <!-- Bisherige Kaufe -->
      <div class="col-sm-4 mb-2">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Bisherige K&auml;ufe</h5>
            <p class="card-text">
                Hier finden Sie alle bisherigen K&auml;ufe, die Sie mit diesem Konto getätigt haben.
            </p>
            <a class="btn btn-primary text-white" href="purchases.php">K&auml;ufe anzeigen</a>
          </div>
        </div>
      </div>

      <!-- Bisherige Kaufe -->
      <div class="col-sm-4 mb-2">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Meine Bewertungen</h5>
            <p class="card-text">
                Hier finden Sie alle bisherigen Bewertungen, die Sie mit diesem Konto getätigt haben.
            </p>
            <a class="btn btn-primary text-white" href="ratings.php">Bewertungen anzeigen</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Ende erste Zeiele  -->

    <hr>

    <!-- *** Nur für Admin sichtbar *** -->
    <?php if(isset($_SESSION['admin'])){
      if($_SESSION['admin'] == 1){ ?>

        <center><h2>Admin</h2></center>
        <br>

        <!-- Anfang dritte Zeile -->
        <div class="row">
          <!-- Nutzerübersicht -->
          <div class="col-sm-4 mb-2">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Nutzer&uuml;bersicht</h5>
                <p class="card-text">
                    Hier k&ouml;nnen alle Nutzer des Webshops angezeigt und durchsucht werden.
                </p>
                <a class="btn btn-primary text-white" href="usersearch.php">Nutzer&uuml;bersicht</a>
              </div>
            </div>
          </div>

          <!-- weiter "Adminonly"-Funktionen hier einfügen -->
        </div>
        <hr>
      <?php }
    } ?>
    <!-- *** Ende des Adminbereiches *** -->


    <div class="row">
      <!-- Konto Loeschen -->
      <div class="col-sm-4 mt-2 mb-2">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Konto L&ouml;schen</h5>
            <p class="card-text">
              <p>
                Sind Sie unzufrieden mit uns oder haben keine Verwendung mehr f&uuml;r Ihr Konto? <br>
                Dann k&ouml;nnen Sie es hier einfach l&ouml;schen. <br>
              </p>
              <p>
                Einmal gel&ouml;schte Daten k&ouml;nnen allerdings nicht wiederhergestellt werden!
              </p>
            </p>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Konto L&ouml;schen</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal zur Bearbeitung des Profils -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalTitle">Profil bearbeiten</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <p> Alle nicht ausgef&uuml;llte Felder bleiben unver&auml;ndert. <span class="badge badge-info">Info</span> </p>
        <hr>

        <!-- Form führt sendet Daten noch nicht richtig weiter, müsste noch implemenitert werden -->
        <form action="includes/#.inc.php" method="post">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="edit_firstname">Vorname</label>
              <input type="text" class="form-control" id="edit_firstname" name="edit_firstname" placeholder="Vorname" autofocus>
            </div>

            <div class="form-group col-md-6">
              <label for="edit_lastname">Nachname</label>
              <input type="text" class="form-control" id="edit_lastname" iname="edit_lastname" placeholder="Nachname">
            </div>
          </div>

          <div class="form-group">
            <label for="edit_email">Email</label>
            <input type="email" class="form-control" id="edit_email" name="edit_email" placeholder="Email">
          </div>

          <div class="form-row">
            <div class="form-group col-md-9">
              <label for="edit_street">Straße</label>
              <input type="text" class="form-control" id="edit_street" name="edit_street" placeholder="Straße">
            </div>

            <div class="form-group col-md-3">
              <label for="edit_houseNumber">Hausnummer</label>
              <input type="number" class="form-control" id="edit_houseNumber" name="edit_houseNumber" placeholder="13">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="edit_city">Stadt</label>
              <input type="text" class="form-control" id="edit_city" name="edit_city" name="registration_city" placeholder="Stadt">
            </div>

            <div class="form-group col-md-6">
              <label for="edit_zip">Postleitzahl</label>
              <input type="number" class="form-control" id="edit_zip" name="edit_zip" placeholder="PLZ">
            </div>
          </div>

      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Abbrechen</button>
          <button type="submit" class="btn btn-success disabled" name="edit_submit" disabled>Speichern</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal zum löschen des Kontos -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalTitle">Konto L&ouml;schen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Sind Sie sich sicher, dass Sie Ihr Konto entg&uuml;ltig l&ouml;schen wollen?</p>
        <p class="text-danger">Der L&ouml;schvorgang kann <span class="font-weight-bold">nicht</span> r&uuml;ckg&auml;ngig gemacht werden!</p>
      </div>
      <div class="modal-footer">
        <form action="includes/deleteuser.inc.php" method="post">
          <button type="submit" class="btn btn-danger mr-2" name="delete_submit">Konto L&ouml;schen</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require 'footer.html' ?>
