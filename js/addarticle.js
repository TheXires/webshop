$('#smartphone_img').on('change',function(){
  //get the file name
  var path = $(this).val();
  // löscht pfad soweit, dass nur noch der Dateiname vorhanden ist
  var fileName = path.replace(/^.*(\\|\/|\:)/, '');
  // ersetzt "Choose a file" label durch den Dateinamen
  $(this).next('.custom-file-label').html(fileName);
});
