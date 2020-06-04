// nimmt URL aus URL Zeile
url = window.location.search;

// trennt die Parameter vom 'Naviationsteil'
urlParams = new URLSearchParams(url);

// pueft ob parameter in Parameterliste steht
if(urlParams.has('email')){

  // sucht zum Parameter passendes inputfeld und fuellt inputfeld mit parameter
  $('#login_email').val(urlParams.get('email'));
}
