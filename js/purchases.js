$(document).ready(function(){
  // Leert alle Vorhandenen Einträge aus der Liste, um dopplungen zu verhindern
  $('.table_value').remove();

  $.ajax({
    // übertragungs art
    type: 'POST',
    // ziel Datei in der Daten weiterverarbeitet werden
    url: 'includes/purchases.inc.php',
    data: {
        'changeFunction': 'showPurchases'
    },
    success: function(pResults){
      // Rückgabe aus PHP Datei in JS Objekt umwandeln
      var results = JSON.parse(pResults);

      // Geht alle Artikel durch
      results.forEach(function(purchase) {
        // Ergänzt die Tabelle bei jedem Durchgang mit jeweiligem Artikeldatensatz
        $('#purchases thead').append("" +
          "<tr class='table_value'>" +
            "<td>" + purchase.articleID + "</td>" +
            "<td>" + purchase.brandName + "</td>" +
            "<td>" + purchase.model + "</td>" +
            "<td>" + purchase.conditionName + "</td>" +
            "<td>" + purchase.quantity + "</td>" +
            "<td>" + purchase.price + "&euro;</td>" +
            "<td>" + purchase.date + "</td>" +
            "</tr>" +
          "");
      });
    }
  });
});
