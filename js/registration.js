// Füllt das Formular mit allen in der URL uebergebenen parametern aus
  // nimmt URL aus URL Zeile
  url = window.location.search;

  // trennt die Parameter vom 'Naviationsteil'
  urlParams = new URLSearchParams(url);

  // prueft ob parameter in Parameterliste steht
  if(urlParams.has('firstname')){
    // sucht zum Parameter passendes inputfeld und fuellt inputfeld mit parameter
    $('#registration_firstname').val(urlParams.get('firstname'));
  }

  if(urlParams.has('lastname')){
    $('#registration_lastname').val(urlParams.get('lastname'));
  }

  if(urlParams.has('email')){
    $('#registration_email').val(urlParams.get('email'));
  }

  if(urlParams.has('street')){
    $('#registration_street').val(urlParams.get('street'));
  }

  if(urlParams.has('housenumber')){
    $('#registration_houseNumber').val(urlParams.get('housenumber'));
  }

  if(urlParams.has('city')){
    $('#registration_city').val(urlParams.get('city'));
  }

  if(urlParams.has('zipcode')){
    $('#registration_zip').val(urlParams.get('zipcode'));
  }


  // prüft ob beide Passwörter gleich sind
  function passwordCheck(){
    var password = $('#registration_password').val();
    var password_repeat = $('#registration_password_repeat').val();

    if(password != password_repeat){
      if(password && password_repeat){
        $('#registration_password').addClass("is-invalid");
        $('#registration_password_repeat').addClass("is-invalid");
        $('#registration_submit').prop('disabled', true);
      }
    }else{
      $('#registration_password').removeClass("is-invalid");
      $('#registration_password_repeat').removeClass("is-invalid");
      $('#registration_submit').prop('disabled', false);
    }

    // sorgt dafuer, dass Felder nicht invalid sind, wenn eins der Fleder Leer ist
    if(!password || !password_repeat){
      $('#registration_password').removeClass("is-invalid");
      $('#registration_password_repeat').removeClass("is-invalid");
      $('#registration_submit').prop('disabled', false);
    }
  }
