$(document).ready(function(){
  // Leert alle Vorhandenen Einträge aus der Liste, um dopplungen zu verhindern
  $('.table_value').remove();

  $.ajax({
    // übertragungs art
    type: 'POST',
    // ziel Datei in der Daten weiterverarbeitet werden
    url: 'includes/purchases.inc.php',
    data: {
        'changeFunction': 'showRatings'
    },
    success: function(pResults){
      // Rückgabe aus PHP Datei in JS Objekt umwandeln
      var results = JSON.parse(pResults);

      // Geht alle Artikel durch
      results.forEach(function(purchase) {
        // Ergänzt die Tabelle bei jedem Durchgang mit jeweiligem Artikeldatensatz
        $('#ratings thead').append("" +
          "<tr class='table_value'>" +
            "<td>" + purchase.articleID + "</td>" +
            "<td>" + purchase.brandName + "</td>" +
            "<td>" + purchase.model + "</td>" +
            "<td>" + purchase.storage + "</td>" +
            "<td>" + purchase.conditionName + "</td>" +
            "<td>" + ratingInStars(purchase.rating) + "</td>" +
            "</tr>" +
          "");
      });
    }
  });
});

function ratingInStars(rating){
  if(rating == 1){
    return '<span class="text-warning"><i class="fas fa-star"> </i></span><span class="text-secondary"><i class="far fa-star"> </i><i class="far fa-star"> </i><i class="far fa-star"> </i><i class="far fa-star"> </i></span>';
  }else if(rating == 2){
    return '<span class="text-warning"><i class="fas fa-star"> </i><i class="fas fa-star"> </i></span><span class="text-secondary"><i class="far fa-star"> </i><i class="far fa-star"> </i><i class="far fa-star"> </i></span>';
  }else if(rating == 3){
    return '<span class="text-warning"><i class="fas fa-star"> </i><i class="fas fa-star"> </i><i class="fas fa-star"> </i></span><span class="text-secondary"><i class="far fa-star"> </i><i class="far fa-star"> </i></span>';
  }else if(rating == 4){
    return '<span class="text-warning"><i class="fas fa-star"> </i><i class="fas fa-star"> </i><i class="fas fa-star"> </i><i class="fas fa-star"> </i></span><span class="text-secondary"><i class="far fa-star"> </i></span>';
  }else if(rating == 5){
    return '<span class="text-warning"><i class="fas fa-star"> </i><i class="fas fa-star"> </i><i class="fas fa-star"> </i><i class="fas fa-star"> </i><i class="fas fa-star"> </i></span>';
  }
}
