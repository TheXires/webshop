<?php session_start(); ?>
<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/grid.css">
    <link rel="stylesheet" href="css/product.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>WebShop</title>
  </head>
  <body>
    <head>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
        <a class="navbar-brand" href="index.php">WebShop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li>
          </ul>

          <?php if(isset($_SESSION['userid'])){ ?>
              <form class="form-inline" action="includes/logout.inc.php" method="post">
              <button type="submit" class="btn btn-outline-danger mr-2" name="logout_submit">Abmelden</button>
              <a class="btn btn-primary mr-2" href="profile.php">Mein Profil</a>
          <?php }else{ ?>
              <form class="form-inline">
              <a class="btn btn-outline-success mr-2" href="registration.php">Registrieren</a>
              <a class="btn btn-primary mr-2" href="login.php">Anmelden</a>
          <?php } ?>
          </form>
        </div>
      </nav>
    </head>
