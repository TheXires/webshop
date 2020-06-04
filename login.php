<?php
  require 'header.php';
?>
<div class="row justify-content-center">
  <div class="col-10  col-sm-9 col-md-8 col-lg-7 col-xl-6">
    <form action="includes/login.inc.php" method="post">
      <h1 class="h3 mb-3 font-weight-normal">Anmeldung</h1>

        <!-- Noch in JS umsetzen und in js/login.js speichern -->
      <?php
        if(isset($_GET['error'])){
          if($_GET['error'] == 'wrongpassword'){ ?>
            <div class="alert alert-danger" role="alert">
              Passwort falsch!
            </div>
          <?php }else if($_GET['error'] == 'nomatch'){ ?>
            <div class="alert alert-danger" role="alert">
              Dieser Nutzer existiert noch nicht!
            </div>
          <?php }
        }
      ?>

      <label for="login_email" class="sr-only">Email address</label>
      <input type="email" id="login_email" name="login_email" class="form-control mb-3" placeholder="Email" required autofocus>
      <label for="login_password" class="sr-only">Password</label>
      <input type="password" id="login_password" name="login_password" class="form-control mb-3" placeholder="Passwort" required>

      <button class="btn btn-lg btn-primary btn-block" name="login_submit" type="submit">Anmelden</button>
    </form>
  </div>
</div>

<script src="js/login.js" charset="utf-8"></script>
<?php
  require 'footer.html';
?>
