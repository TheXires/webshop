// Füllt das Formular mit allen in der URL uebergebenen parametern aus
  // nimmt URL aus URL Zeile
  url = window.location.search;

  // trennt die Parameter vom 'Naviationsteil'
  urlParams = new URLSearchParams(url);

  // if-Anweisungen prüfen, ob parameter in Parameterliste steht
  // Wenn ja, Parameter für jeweiliges inputfeld suchen und ausfüllen
  if(urlParams.has('articleid')){
    $('#hiddenArticleID').val(urlParams.get('articleid'));
  }

  if(urlParams.has('brand')){
    $('#smartphone_brand').val(urlParams.get('brand'));
  }

  if(urlParams.has('model')){
    $('#smartphone_model').val(urlParams.get('model'));
  }

  if(urlParams.has('stock')){
    $('#smartphone_stock').val(urlParams.get('stock'));
  }

  if(urlParams.has('size')){
    $('#smartphone_size').val(urlParams.get('size'));
  }

  if(urlParams.has('condition')){
    $('#smartphone_condition').val(urlParams.get('condition'));
  }

  if(urlParams.has('storage')){
    $('#smartphone_storage').val(urlParams.get('storage'));
  }

  if(urlParams.has('price')){
    $('#smartphone_price').val(urlParams.get('price'));
  }

// sichtbarer Dateiname in Upload
$('#smartphone_img').on('change',function(){
  // holt den Namen der Datei
  var path = $(this).val();
  // löscht pfad soweit, dass nur noch der Dateiname vorhanden ist
  var fileName = path.replace(/^.*(\\|\/|\:)/, '');
  // ersetzt "Choose a file" label durch den Dateinamen
  $(this).next('.custom-file-label').html(fileName);
});
