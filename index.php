<?php
  require 'header.php';
?>

  <div class="grid_container justify-content-center">

      <?php for($i = 0; $i < 4; $i++){
        echo '
        <div class="grid_item product">
          <div class="product_img">
          <img src="img\DSC04578.jpg" alt="">
          </div>
          <div class="product_title">Sony alpha 6000, ganz neu uns im super angebot!!!!</div>
          <div class="product_discription">#Kamera</div>
          <div class="spacer"></div>
          <div class="product_price">399€</div>
        </div>
        ';
      }?>

  </div>

<footer class="fixed-bottom page-footer font-small mt-3">

  <div class="text-center py-3">
    © 2020 Copyright - <a class="text-success" href="http://fotoxires.de/"> Fotoxires.de </a>
  </div>

</footer>
  <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
