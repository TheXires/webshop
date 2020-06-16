rating = 1;

$(document).ready(function(){

  url = window.location.search;

  // trennt die Parameter vom 'Naviationsteil'
  urlParams = new URLSearchParams(url);

  // Setzen der unsichtbaren Inputs, um articleID aus der URL zum editieren oder löschen zu übergeben
  $('#hiddenEditID').val(urlParams.get('articleid'));
  $('#hiddenDeleteID').val(urlParams.get('articleid'));
  $('#hiddenPurchaseID').val(urlParams.get('articleid'));

  // ruft Funktion um Tabelle mit Artikel Informationen zu erstellen
  creatArtikelinformation(urlParams);

  if(hasRated()){
    $('#ratingDialog').remove();
  }

  // ruft Funktion um Liste mit Bewertungen zu erstellen
  createUserRating(urlParams);
});

// Prüft, ob die gewünschte Anzahl an Artikeln auch verfügbat ist und disabled wenn nicht den kaufen-Button
$('#purchaseQuantity').change(function(){
  checkAvailability();
});

$('#rateButton').click(function(){
  $.ajax({
    // übertragungs art
    type: 'POST',
    // ziel Datei in der Daten weiterverarbeitet werden
    url: 'includes/rate.inc.php',
    // Sucheingabe, die übermittelt werden soll
    data: {
        'articleid': urlParams.get('articleid'),
        'rating': rating,
        'description': $('#ratingDescription').val()
    },
    success: function(pResult){
      // PHP Funktion antwortet mit 1, wenn alles funktioniert hat. Sonst mit 0.
      console.log(pResult);
      if(pResult == 'success'){
        console.log('called');
        $('#ratingDialog').remove();
        createUserRating(urlParams);
      }
    }
  });
});

// ------------ Funktionen ------------
function checkAvailability() {
  if($('#purchaseQuantity').val().length === 0 || $('#purchaseQuantity').val() == 0){
    $('#purchaseButton').attr("disabled", true);
    $('#purchaseButton').addClass("mb-4");
    $('#purchaseQuantity').addClass("is-invalid");
  }else if($('#purchaseQuantity').val() > $('#inStock').html()){
    $('#purchaseButton').attr("disabled", true);
    $('#purchaseButton').addClass("mb-4");
    $('#purchaseQuantity').addClass("is-invalid");
  }else{
    $('#purchaseButton').attr("disabled", false);
    $('#purchaseButton').removeClass("mb-4");
    $('#purchaseQuantity').removeClass("is-invalid");
  }
}

function changeRating(button){

  // voll <i class="fas fa-star">
  // leer <i class="far fa-star">

  // prüft, welcher Button geklicked wurde und passt sternen Anzah darauf an
  if(button == 1){
    $('#star_1').html('<i class="fas fa-star">');
    $('#star_2').html('<i class="far fa-star">');
    $('#star_3').html('<i class="far fa-star">');
    $('#star_4').html('<i class="far fa-star">');
    $('#star_5').html('<i class="far fa-star">');
    rating = 1;
  }else if(button == 2){
    $('#star_1').html('<i class="fas fa-star">');
    $('#star_2').html('<i class="fas fa-star">');
    $('#star_3').html('<i class="far fa-star">');
    $('#star_4').html('<i class="far fa-star">');
    $('#star_5').html('<i class="far fa-star">');
    rating = 2;
  }else if(button == 3){
    $('#star_1').html('<i class="fas fa-star">');
    $('#star_2').html('<i class="fas fa-star">');
    $('#star_3').html('<i class="fas fa-star">');
    $('#star_4').html('<i class="far fa-star">');
    $('#star_5').html('<i class="far fa-star">');
    rating = 3;
  }else if(button == 4){
    $('#star_1').html('<i class="fas fa-star">');
    $('#star_2').html('<i class="fas fa-star">');
    $('#star_3').html('<i class="fas fa-star">');
    $('#star_4').html('<i class="fas fa-star">');
    $('#star_5').html('<i class="far fa-star">');
    rating = 4;
  }else if(button == 5){
    $('#star_1').html('<i class="fas fa-star">');
    $('#star_2').html('<i class="fas fa-star">');
    $('#star_3').html('<i class="fas fa-star">');
    $('#star_4').html('<i class="fas fa-star">');
    $('#star_5').html('<i class="fas fa-star">');
    rating = 5;
  }
}

function setRating(){
  // rating = ratings.rating
}

function creatArtikelinformation(urlParams){
  // prueft ob parameter in Parameterliste steht
  if(urlParams.has('articleid')){
    $.ajax({
      // übertragungs art
      type: 'POST',
      // ziel Datei in der Daten weiterverarbeitet werden
      url: 'includes/articleinformation.inc.php',
      // Sucheingabe, die übermittelt werden soll
      data: {
          'articleid': urlParams.get('articleid')
      },
      success: function(pResults){
        if(pResults == 'noarticlenumber'){
          console.log(pResults);
          return;
        }
        if(pResults == 'iddoesnotexist'){
          console.log(pResults);
          return;
        }
        if(pResults == 'sqlerror'){
          console.log(pResults);
          return;
        }

        // Rückgabe aus PHP Datei in JS Objekt umwandeln
        var results = JSON.parse(pResults);

        results.forEach(function(device) {

          $('#img').attr('src', device.img);

          $('#infos').html('<table class="table">' +
              '<tr>'+
                '<th>Marke</th>' +
                '<td>' + device.brandName + '</td>' +
              '</tr><tr>' +
                '<th>Modell</th>' +
                '<td>' + device.model + '</td>' +
              '</tr><tr>' +
                '<th>Zustand</th>' +
                '<td>' + device.conditionName + '</td>' +
              '</tr><tr>' +
                '<th>Gr&ouml;&szlig;e</th>' +
                '<td>' + device.size + '&quot;</td>' +
              '</tr><tr>' +
                '<th>Speicher</th>' +
                '<td>' + device.storage + '</td>' +
              '</tr><tr>' +
                '<th>Preis</th>' +
                '<td>' + device.price + '&euro;</td>' +
              '</tr>' +
            '</table>'
          );

          $('#inStock').html(device.stock);
          $('#changeForm').attr('action', 'changeArticle.php?articleid=' +
            urlParams.get('articleid') +
            '&brand=' + device.brandName +
            '&model=' + device.model +
            '&stock=' + device.stock +
            '&size=' + device.size +
            '&condition=' + device.conditionName +
            '&storage=' + device.storage +
            '&price=' + device.price
          );
        });

        // prüft ob genügend Artikel zur verfügung stehen
        checkAvailability();
      }
    });
  }
}


function createUserRating(urlParams){
  // prueft ob parameter in Parameterliste steht
  if(urlParams.has('articleid')){
    $.ajax({
      // übertragungs art
      type: 'POST',
      // ziel Datei in der Daten weiterverarbeitet werden
      url: 'includes/articleUserRating.inc.php',
      // Sucheingabe, die übermittelt werden soll
      data: {
          'articleid': urlParams.get('articleid')
      },
      success: function(pResults){

        //  Hier könnte noch genauer auf die Fehler eingegangen werden
        //  und spezielle Fehlerbehandlung betrieben werden
        if(pResults == 'noarticlenumber'){
          console.log(pResults);
          return;
        }
        if(pResults == 'iddoesnotexist'){
          console.log(pResults);
          return;
        }
        if(pResults == 'sqlerror'){
          console.log(pResults);
          return;
        }
        if(pResults == 'nocommentsfound'){
          console.log(pResults);
          return;
        }

        // Rückgabe aus PHP Datei in JS Objekt umwandeln
        var results = JSON.parse(pResults);

        var ratingsList = '<ul class="list-group list-group-flush">';
        results.forEach(function(rating) {
          ratingsList += '' +
            '<div class="list-group-item">' +
              '<div class="row">' +
                '<div class="col-6">';

                    // Vor- und Nachname des Nutzers eanzeigen, der die Bewertung abgegeben hat
                ratingsList += '<span class="font-weight-bold">' + rating.firstname + ' ' + rating.lastname + '</span> ';

                // prüft ob nutzer Artikel gekauft hat
                if(hasBought(rating.userID) == 1){
                  // Wenn ja, wir die Bewertung mit einem Badge versehen
                  ratingsList += '<span class="badge badge-info">gekauft</span>';
                }

          ratingsList += '' +
                '</div>' +
              '</div>' +
              '<div class="row">' +
                '<div class="col-6">';

                  // Anzahl der Sterne
                  if(rating.rating == 1){
                    ratingsList += '<span class="text-warning"><i class="fas fa-star"> </i></span><span class="text-secondary"><i class="far fa-star"> </i><i class="far fa-star"> </i><i class="far fa-star"> </i><i class="far fa-star"> </i></span>';
                  }else if(rating.rating == 2){
                    ratingsList += '<span class="text-warning"><i class="fas fa-star"> </i><i class="fas fa-star"> </i></span><span class="text-secondary"><i class="far fa-star"> </i><i class="far fa-star"> </i><i class="far fa-star"> </i></span>';
                  }else if(rating.rating == 3){
                    ratingsList += '<span class="text-warning"><i class="fas fa-star"> </i><i class="fas fa-star"> </i><i class="fas fa-star"> </i></span><span class="text-secondary"><i class="far fa-star"> </i><i class="far fa-star"> </i></span>';
                  }else if(rating.rating == 4){
                    ratingsList += '<span class="text-warning"><i class="fas fa-star"> </i><i class="fas fa-star"> </i><i class="fas fa-star"> </i><i class="fas fa-star"> </i></span><span class="text-secondary"><i class="far fa-star"> </i></span>';
                  }else if(rating.rating == 5){
                    ratingsList += '<span class="text-warning"><i class="fas fa-star"> </i><i class="fas fa-star"> </i><i class="fas fa-star"> </i><i class="fas fa-star"> </i><i class="fas fa-star"> </i></span>';
                  }

          ratingsList += '' +
                  '<br>' +
                '</div>' +
              '</div>' +
              '<div class="row">' +
                '<div class="col-12 mt-2">';

                   // Bewertungs Text
                   ratingsList += rating.description;

          ratingsList += '' +
                '</div>' +
              '</div>' +
            '</div>';
        });

        ratingsList += '</ul>';
        $('#ratings').append(ratingsList);

      }
    });
  }
}


function hasBought(userID){
  var result = false;

  $.ajax({
    // übertragungs art
    type: 'POST',
    // ajax Funktion soll NICHT parallel laufen, da sonst weiter gegangen wird und das Ergebnis keine Auswirkung mehr hat
    async: false,
    // ziel Datei in der Daten weiterverarbeitet werden
    url: 'includes/has.inc.php',
    // Sucheingabe, die übermittelt werden soll
    data: {
        'articleid': urlParams.get('articleid'),
        'userid': userID,
        'changeFunction': 'hasBought'
    },
    success: function(pResults){
      result = pResults;
    }
  });
  return result;
}

function hasRated(){
  var result = false;

  $.ajax({
    // übertragungs art
    type: 'POST',
    // ajax Funktion soll NICHT parallel laufen, da sonst weiter gegangen wird und das Ergebnis keine Auswirkung mehr hat
    async: false,
    // ziel Datei in der Daten weiterverarbeitet werden
    url: 'includes/has.inc.php',
    // Sucheingabe, die übermittelt werden soll
    data: {
        'articleid': urlParams.get('articleid'),
        'changeFunction': 'hasRated'
    },
    success: function(pResults){
      result = pResults;
    }
  });
  return result;
}
