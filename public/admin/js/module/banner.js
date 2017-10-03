$('#banner_type').change(function(){
  var type = $(this).val();
  if (type == 0) {
    $('#type1').hide('slow');
    $('#type2').hide('slow');
    $('#type3').hide('slow');
    return;
  }
  if (type == 1) {
    $('#type2').hide('slow');
    $('#type3').hide('slow');
    $('#type1').show('slow');
  } else {
    if (type == 2) {
      $('#type1').hide('slow');
      $('#type3').hide('slow');
      $('#type2').show('slow');
    } else {
      $('#type1').hide('slow');
      $('#type2').hide('slow');
      $('#type3').show('slow');
    }
  }
});