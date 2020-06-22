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

    var condition;

    if(urlParams.get('condition') == "Wie neu"){
      condition = 1;
    }else if(urlParams.get('condition') == "Sehr gut"){
      condition = 2;
    }else if(urlParams.get('condition') == "Gut"){
      condition = 3;
    }else if(urlParams.get('condition') == "Stark genutzt"){
      condition = 4;
    }else{
      condition = 0;
    }

    $('#smartphone_condition').val(condition);
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
