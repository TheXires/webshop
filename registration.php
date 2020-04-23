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
          if($_GET['error'] == 'usedemail'){
            echo '
              <div class="alert alert-danger mb-2" role="alert">
                Diese E-Mail ist bereits registriert!
              </div>
            ';
          }else if($_GET['error'] == 'emptyfields'){
            echo '
              <div class="alert alert-danger mb-2" role="alert">
                Bitte f&uuml;llen Sie alle Felder aus!
              </div>
            ';
          }else if($_GET['error'] == 'invalidemail'){
            echo '
              <div class="alert alert-danger mb-2" role="alert">
                Bitte geben Sie eine g&uuml;ltige E-Mail ein!
              </div>
            ';
          }else if($_GET['error'] == 'invalidstreet'){
            echo '
              <div class="alert alert-danger mb-2" role="alert">
                Bitte geben Sie eine g&uuml;ltige Stra&szlig;e ein!
              </div>
            ';
          }
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

<script type="text/javascript">
// Füllt das Formular mit allen in der URL uebergebenen parametern aus
    url = window.location.search; // nimmt URL aus URL Zeile
    urlParams = new URLSearchParams(url); // trennt die Parameter vom 'Naviationsteil'
    if(urlParams.has('firstname')){ // pueft ob parameter in Parameterliste steht
      input_firstname = document.getElementById('registration_firstname'); // sucht zum Parameter passendes inputfeld
      input_firstname.value = urlParams.get('firstname'); // fuellt inputfeld mit parameter
    }
    if(urlParams.has('lastname')){ // pueft ob parameter in Parameterliste steht
      input_lastname = document.getElementById('registration_lastname'); // sucht zum Parameter passendes inputfeld
      input_lastname.value = urlParams.get('lastname'); // fuellt inputfeld mit parameter
    }
    if(urlParams.has('email')){ // pueft ob parameter in Parameterliste steht
      input_email = document.getElementById('registration_email'); // sucht zum Parameter passendes inputfeld
      input_email.value = urlParams.get('email'); // fuellt inputfeld mit parameter
    }
    if(urlParams.has('street')){ // pueft ob parameter in Parameterliste steht
      input_street = document.getElementById('registration_street'); // sucht zum Parameter passendes inputfeld
      input_street.value = urlParams.get('street'); // fuellt inputfeld mit parameter
    }
    if(urlParams.has('housenumber')){ // pueft ob parameter in Parameterliste steht
      input_housenumber = document.getElementById('registration_houseNumber'); // sucht zum Parameter passendes inputfeld
      input_housenumber.value = urlParams.get('housenumber'); // fuellt inputfeld mit parameter
    }
    if(urlParams.has('city')){ // pueft ob parameter in Parameterliste steht
      input_city = document.getElementById('registration_city'); // sucht zum Parameter passendes inputfeld
      input_city.value = urlParams.get('city'); // fuellt inputfeld mit parameter
    }
    if(urlParams.has('zipcode')){ // pueft ob parameter in Parameterliste steht
      input_zipcode = document.getElementById('registration_zip'); // sucht zum Parameter passendes inputfeld
      input_zipcode.value = urlParams.get('zipcode'); // fuellt inputfeld mit parameter
    }

    function passwordCheck(){
      var password = document.getElementById('registration_password').value;
      var password_repeat = document.getElementById('registration_password_repeat').value;

      if(password != password_repeat){
        if(password && password_repeat){
          $('#registration_password').addClass("is-invalid");
          $('#registration_password_repeat').addClass("is-invalid");
          $('#registration_submit').prop('disabled', true);
        }
      }else{
        $('#registration_password').removeClass("is-invalid");
        $('#registration_password_repeat').removeClass("is-invalid");
        $('#registration_submit').prop('disabled', false);
      }
      if(!password || !password_repeat){ // sorgt dafuer, dass Felder nicht invalid sind, wenn eins der Fleder Leer ist
        $('#registration_password').removeClass("is-invalid");
        $('#registration_password_repeat').removeClass("is-invalid");
        $('#registration_submit').prop('disabled', false);
      }
    }
</script>

<?php
  require 'footer.html';
?>
