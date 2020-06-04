<?php
  require 'header.php';
?>
  <div class="row justify-content-center">
    <div class="col-10  col-sm-9 col-md-8 col-lg-7 col-xl-6">
      <!-- Möglichkeit zur Suche nach Nutzern durch Admin -->
      <h1>Nutzerverwaltung</h1>

      <div class="row">
        <div class="col-8">
          <!-- Eingabefeld für Parameter nach dem gesucht werden soll -->
          <input type="text" class="form-control" name="input_name_to_searche" id="input_name_to_searche" placeholder="Nachname" required>
        </div>
        <div class="col">
          <!-- Button zum ausführen der Suche mit entsprechendem Parameter aus obrigem Eingabefeld -->
          <button type="button" id="button_id2" class="btn btn-primary">Suche</button>
        </div>
      </div>

      <br>

      <div>
        <h2>Suchergebnisse</h2>

        <!-- Tabelle in der alle Nutzer angezeigt werden -->
        <table class="table" id="user">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Vorname</th>
              <th scope="col">Nachname</th>
              <th scope="col">E-Mail</th>
              <th scope="col">Anschrift</th>
            </tr>
          </thead>
          <!-- Wird durch js\usersearch.js nach der Suche gefüllt -->
        </table>
      </div>
    </div>
  </div>


<script src="js\usersearch.js" charset="utf-8"></script>
<?php
  require 'footer.html';
?>
