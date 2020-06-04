$(document).ready(function(){
  // Leert alle Vorhandenen Einträge aus der Liste, um dopplungen zu verhindern
  $('.table_value').remove();

  $.ajax({
    // übertragungs art
    type: 'POST',
    // ziel Datei in der Daten weiterverarbeitet werden
    url: 'includes/purchases.inc.php',
    success: function(pResults){
      // Rückgabe aus PHP Datei in JS Objekt umwandeln
      var results = JSON.parse(pResults);

      // Geht alle Artikel durch
      results.forEach(function(article) {
        // Ergänzt die Tabelle bei jedem Durchgang mit jeweiligem Artikeldatensatz
        $('#purchases thead').append("<tr class='table_value'><td scope='row'>" + "user.ID" + "</td><td>" + "user.firstname" + "</td><td>" + "user.lastname" + "</td><td>" + "user.email" + "</td><td>" + "user.street" + "</td></tr>");
      });
    }
  });
});
