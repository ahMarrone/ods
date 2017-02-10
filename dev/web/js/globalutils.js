
function showSimpleModal(modalID, messageType, message){
    var icon = "";
    var fullMessage = "";
    var modalObject = $('#'+ modalID);
    var modalBody = modalObject.find('.modal-body');
    switch(messageType){
      case 'success':  icon = '<i class="fa fa-check" style="color: green"></i>';
                       break;
      case 'error' :   icon = '<i class="fa fa-times" style="color: red"></i>';
    }
    var fullMessage = icon + "  " + message;
    modalBody.html(fullMessage);
    modalObject.modal('show');
}

function appendSpinner(domElement){
    domElement.append('<i id="refreshSpinner" class="fa fa-refresh fa-spin fa-fw" style="margin-top: 8px;"></i>');
}

function removeSpinner(){
    $('#refreshSpinner').remove();
}