/*
 * This is fmapp data script
 */

 $( document ).ready(function() {



 });

function addComponent() {
  var chosenComponent = $('#componentInput').val();
  $('#componentInput').val('').attr('placeholder', 'Weitere auswählen');
  alertMessage();
}

/*
 * There are three diferent alert state ba Bootstrap
 * sucess | info | warning | danger
 */
function alertMessage(alertText, alertState) {
  console.log(alertState);
  if(alertState === undefined) {
    alertState = "alert-info";
  }
  // Clean alertState from former message
  if(alertText === undefined) {
    alertText = 'Vorsicht!';
  }
  var alertBoxString =
    '<div id="alertBox" class="alert ' + alertState + ' alert-dismissible" role="alert">\n\t' +
      '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n\t' +
      '<span id="alertBoxText">' + alertText + '</span>\n\t'
    '</div>';
  $('#componentOutput').prepend(alertBoxString);
  $('#alertBox').fadeIn('fast');
}
