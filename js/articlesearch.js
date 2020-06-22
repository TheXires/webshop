$('#search').click(function(){
  $('#searchresults').empty();

  $.ajax({
    // übertragungs art
    type: 'POST',
    // ziel Datei in der Daten weiterverarbeitet werden
    url: 'includes/articlesearch.inc.php',
    // Sucheingabe, die übermittelt werden soll
    data: {
        'searchParam': $('#searchbar').val()
    },
    success: function(pResults){

      // Rückgabe aus PHP Datei in JS Objekt umwandeln
      var results = JSON.parse(pResults);

      // Für jeden Artikel der in JSON Datei steht wird eine Karte angelegt, die in das Gridsystem eingefgt wird
      results.forEach(function(article) {
        $('#searchresults').append( "" +
          "<div class='grid_item product'>" +
            "<a href='article.php?articleid=" + article.articleID + "'>" +
              "<div class='product_img'>" +
                "<img src='" + article.img + "' alt='Product img'>" +
              "</div>" +
              "<div class='product_title'>" + article.brandName + " " + article.model + "<span class='font-weight-light'> - " + article.conditionName + "</span></div>" +
              "<div class='product_discription'>" + getRating(article.articleID) + "</div>" +
              "<div class='spacer'></div>" +
              "<div class='product_price'>" + article.price + "&euro;</div>" +
            "</a>" +
          "</div>" +
        "");
      });
    }
  });
});

// bekommt eine ArtikelID übergeben und gibt die drchscnhittliche Bewertung dieses Artikels als Sternen in einem String zurück
function getRating(articleID){
  // String wird gesetzt und später angepassst, je nach Anzahl der Sterne
  // Ist es weniger als 1 Stern, wird der String so zurück gegeben
  var starString = 'Keine Bewertungen';

  $.ajax({
    // übertragungs art
    type: 'POST',
    // ajax Funktion soll NICHT parallel laufen, da sonst weiter gegangen wird und das Ergebnis keine Auswirkung mehr hat
    async: false,
    // ziel Datei in der Daten weiterverarbeitet werden
    url: 'includes/getRatings.inc.php',
    // Sucheingabe, die übermittelt werden soll
    data: {
        'articleID': articleID
    },
    success: function(pResults){
      console.log(pResults);

      // voll <i class="fas fa-star">
      // leer <i class="far fa-star">

      // prüft wie viele Stere der Artikel durchschnittlich hat und gibt dementsprechend einen String zurück
      // Sollte es weniger als ein Stern sein, hat der Artikel keine Bewertungen und wird daher nicht bearbeitet
      if(pResults == 5.0){
        console.log("called 5");
        starString = '<span class="text-warning"><i class="fas fa-star"> </i><i class="fas fa-star"> </i><i class="fas fa-star"> </i><i class="fas fa-star"> </i><i class="fas fa-star"> </i></span>';
      }else if(pResults < 5.0 && pResults >= 4.0){
        console.log("called 4");
        starString = '<span class="text-warning"><i class="fas fa-star"> </i><i class="fas fa-star"> </i><i class="fas fa-star"> </i><i class="fas fa-star"> </i></span><span class="text-secondary"><i class="far fa-star"> </i></span>';
      }else if(pResults < 4.0 && pResults >= 3.0){
        console.log("called 3");
        starString = '<span class="text-warning"><i class="fas fa-star"> </i><i class="fas fa-star"> </i><i class="fas fa-star"> </i></span><span class="text-secondary"><i class="far fa-star"> </i><i class="far fa-star"> </i></span>';
      }else if(pResults < 3.0 && pResults >= 2.0){
        console.log("called 2");
        starString = '<span class="text-warning"><i class="fas fa-star"> </i><i class="fas fa-star"> </i></span><span class="text-secondary"><i class="far fa-star"> </i><i class="far fa-star"> </i><i class="far fa-star"> </i></span>';
      }else if(pResults < 2.0 && pResults >= 1.0){
        console.log("called 1");
        starString = '<span class="text-warning"><i class="fas fa-star"> </i></span><span class="text-secondary"><i class="far fa-star"> </i><i class="far fa-star"> </i><i class="far fa-star"> </i><i class="far fa-star"> </i></span>';
      }
    }
  });
  return starString;
}
