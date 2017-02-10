
function showModalOnSteroids(modalID, messageType, message, blocked=false){
    var icon = "";
    var fullMessage = "";
    var modalObject = $('#'+ modalID);
    var modalBody = modalObject.find('.modal-body');
    /*switch(messageType){
      case 'success':  icon = '<i class="fa fa-check" style="color: green"></i>';
                       break;
      case 'error' :   icon = '<i class="fa fa-times" style="color: red"></i>';
    }
    var fullMessage = icon + "  " + message;
    var fullMessage = message;
    modalBody.html(fullMessage);*/
    modalBody.html(message);

    if (blocked) {
      modalObject.modal({
        backdrop: 'static',
        keyboard: false
      });
    }
    modalObject.modal('show');
}