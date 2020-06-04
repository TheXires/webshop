<?php
  require 'header.php';
?>
<div class="row justify-content-center">
  <div class="col-10  col-sm-9 col-md-8 col-lg-7 col-xl-6">
    <form action="includes/registration.inc.php" method="post">
      <h1 class="h2 mb-2">Registrierung</h1>

      <?php
        # prueft ob ein error in der URL uebergeben wurde
        if(isset($_GET['error'])){
          # prueft welcher error in URL uebergeben wurde
          if($_GET['error'] == 'usedemail'){ ?>
              <div class="alert alert-danger mb-2" role="alert">
                Diese E-Mail ist bereits registriert!
              </div>
          <?php }else if($_GET['error'] == 'emptyfields'){ ?>
              <div class="alert alert-danger mb-2" role="alert">
                Bitte f&uuml;llen Sie alle Felder aus!
              </div>
          <?php }else if($_GET['error'] == 'invalidemail'){ ?>
              <div class="alert alert-danger mb-2" role="alert">
                Bitte geben Sie eine g&uuml;ltige E-Mail ein!
              </div>
          <?php }else if($_GET['error'] == 'invalidstreet'){ ?>
              <div class="alert alert-danger mb-2" role="alert">
                Bitte geben Sie eine g&uuml;ltige Stra&szlig;e ein!
              </div>
          <?php }
        }
      ?>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="registration_firstname">Vorname</label>
          <input type="text" class="form-control" id="registration_firstname" name="registration_firstname" placeholder="Vorname" required autofocus>
        </div>

        <div class="form-group col-md-6">
          <label for="registration_lastname">Nachname</label>
          <input type="text" class="form-control" id="registration_lastname" name="registration_lastname" placeholder="Nachname" required>
        </div>
      </div>

      <div class="form-group">
        <label for="registration_email">Email</label>
        <input type="email" class="form-control" id="registration_email" name="registration_email" placeholder="Email" required>
      </div>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="registration_password">Passwort</label>
          <input type="password" class="form-control" id="registration_password" name="registration_password" placeholder="Passwort" onfocusout="passwordCheck()" required>
          <div class="invalid-feedback">
            Passw&ouml;rter stimmen nicht &uuml;berein.
          </div>
        </div>

        <div class="form-group col-md-6">
          <label for="registration_password">Passwort wiederholen</label>
          <input type="password" class="form-control" id="registration_password_repeat" name="registration_password_repeat" placeholder="Passwort wiederholen" onfocusout="passwordCheck()" required>
          <div class="invalid-feedback">
            Passw&ouml;rter stimmen nicht &uuml;berein.
          </div>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-10">
          <label for="registration_street">Straße</label>
          <input type="text" class="form-control" id="registration_street" name="registration_street" placeholder="Straße" required>
        </div>

        <div class="form-group col-md-2">
          <label for="registration_houseNumber">Hausnummer</label>
          <input type="number" class="form-control" id="registration_houseNumber" name="registration_houseNumber" placeholder="13" required>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="registration_city">Stadt</label>
          <input type="text" class="form-control" id="registration_city" name="registration_city" name="registration_city" placeholder="Stadt" required>
        </div>

        <div class="form-group col-md-6">
          <label for="registration_zip">Postleitzahl</label>
          <input type="number" class="form-control" id="registration_zip" name="registration_zip" placeholder="PLZ" required>
        </div>
      </div>

      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="agbCheck" name="agbCheck" required>
          <label class="form-check-label" for="agbCheck">
            Ich akzeptiere die <a href="#">AGB</a> und <a href="#">Datenschutzrichtilinien</a>.
          </label>
        </div>
      </div>
      <button type="submit" class="btn btn-success" id="registration_submit" name="registration_submit">Registrieren</button>
    </form>
  </div>
</div>

<script src="js/registration.js" charset="utf-8"></script>

<?php
  require 'footer.html';
?>
