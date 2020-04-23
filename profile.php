<?php
  require 'header.php';
  require 'includes/userinfo.inc.php';
?>

<div class="row justify-content-center">
  <div class="col-10  col-sm-9 col-md-8 col-lg-7 col-xl-6">
    <!-- Hier kommen Fehlermeldungen hin -->
    <?php ?>


    <!-- Erste Reihe -->
    <div class="row">
      <!-- Persoenliche Daten und Passowrt aendern -->
      <div class="col-sm-6 mb-2">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Persönliche Daten</h5>
            <p class="card-text">

              <!-- Persoenliche Daten werden aus Datenbank gelesen und hier eingefuegt -->
              <?php
                echo "<p><span class='font-weight-bold'> Name </span> <br>" . $firstname . " " . $lastname . "</p> <p> <span class='font-weight-bold'> Anschrift </span><br>" . $street . ", " . $housenumber . "<br>" . $zip . ", " . $city . "</p>";
              ?>


              <!-- Button fue Modal -->
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">Bearbeiten</button>

              <!-- Modal -->
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

                      <p>
                        Alle nicht ausgef&uuml;llte Felder bleiben unver&auml;ndert. <span class="badge badge-info">Info</span>
                      </p>
                      <hr>

                      <form action="includes/useredit.inc.php" method="post">
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
                        <button type="submit" class="btn btn-success" name="edit_submit">Speichern</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>



      <!-- Konto Loeschen -->
      <div class="col-sm-6">
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

            <!-- Modal -->
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
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require 'footer.html' ?>
