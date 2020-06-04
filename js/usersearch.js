$('#button_id2').click(function(){

  // Leert alle Vorhandenen Einträge aus der Liste, um dopplungen zu verhindern
  $('.table_value').remove();

  $.ajax({
    // übertragungs art
    type: 'POST',
    // ziel Datei in der Daten weiterverarbeitet werden
    url: 'includes/usersearch.inc.php',
    // Sucheingabe, die übermittelt werden soll
    data: {
        'name': $('#input_name_to_searche').val()
    },
    success: function(pResults){
      // Rückgabe aus PHP Datei in JS Objekt umwandeln
      var results = JSON.parse(pResults);

      // Geht alle nutzer durch
      results.forEach(function(user) {
        // Ergänzt die Tabelle bei jedem Durchgang mit jeweiligem Nutzerdatensatz
        $('#user thead').append("<tr class='table_value'><td scope='row'>" + user.userID + "</td><td>" + user.firstname + "</td><td>" + user.lastname + "</td><td>" + user.email + "</td><td>" + user.street + ", " + user.housenumber + "<br>" + user.zip + " " + user.city + "</td></tr>");
      });
    }
  });
});
