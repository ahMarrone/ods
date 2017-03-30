
function showSimpleModal(modalID, messageType, message, acceptCallback, acceptMsgButton){
    var icon = "";
    var fullMessage = "";
    var modalObject = $('#'+ modalID);
    var modalBody = modalObject.find('.modal-body');
    var acceptMsg = (acceptMsgButton) ? acceptMsgButton : "Aceptar";
    var modalOptions = {}
    switch(messageType){
      case 'success':  icon = '<i class="fa fa-check" style="color: green"></i>';
                       break;
      case 'error' :   icon = '<i class="fa fa-times" style="color: red"></i>';
    }
    var fullMessage = icon + "  " + message;
    if (acceptCallback){
      modalOptions = {backdrop: "static", keyboard: "false"};
      fullMessage += '<div class="modal-footer"><button id="acceptSimpleModal" type="button" class="btn btn-'+messageType+'">'+acceptMsg+'</button></div>';
    }
    modalBody.html(fullMessage);
    modalObject.modal(modalOptions);
    $('#'+modalID).on('click', '#acceptSimpleModal',function(){
        acceptCallback();
    });
}

function appendSpinner(domElement){
    domElement.append('<i id="refreshSpinner" class="fa fa-refresh fa-spin fa-fw" style="margin-top: 8px;"></i>');
}

function removeSpinner(){
    $('#refreshSpinner').remove();
}


function constructHTMLList(strings){
  var list = "<ul>";
  $.each(strings, function(i, string){
    list += "<li>"+string+"</li>";
  });
  list += "</ul>";
  return list;
}