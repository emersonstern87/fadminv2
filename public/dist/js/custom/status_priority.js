"use strict";

/**
 * ticketStatusChange
 * change ticket status from the ticket list
 * @param  String url     
 * @param  String statusId
 * @param  String ticketId
 * @return void         
 */
function ticketStatusChange(url, statusId, ticketId) {
  $.ajax({
    url: url,
    method:"POST",
    data:{
      'status_id':statusId, 
      'ticketId':ticketId, 
      '_token':token
    },
    dataType:"json",
    success:function(data) {
      if (data.status == 1) {
        var previousTotal = parseInt($('#'+ data.preStatusName).html()) - parseInt(1);
        var newTotal = parseInt($('#'+ data.newStatusName).html()) + parseInt(1);
        $('#'+ data.preStatusName).html(previousTotal);
        $('#'+ data.newStatusName).html(newTotal);
        $("#dataTableBuilder").DataTable().ajax.reload();
      } else {
        var html = '<div class="alert alert-danger">' +
                      '<button type="button" class="close" data-dismiss="alert">×</button>' + 
                      '<strong>Something went wrong, please try again.</strong>' +
                    '</div>';
        $('.noti-alert').append(html);
        $('#notifications').css('display', 'block');
      }
    }
  });
}

/**
 * ticketPriorityChange
 * change ticket priority status from the ticket list
 * @param  String url     
 * @param  String priorityId
 * @param  String ticketId
 * @return void         
 */
function ticketPriorityChange(url, priorityId, ticketId) {
  $.ajax({
    url:url,
    method:"POST",
    data:{
      'priorityId':priorityId, 
      'ticketId':ticketId, 
      '_token':token
    },
    dataType:"json",
    success:function(data) {
      if (data.status == 1) {
        $("#dataTableBuilder").DataTable().ajax.reload();
      } else {
        var html = '<div class="alert alert-danger">' +
                      '<button type="button" class="close" data-dismiss="alert">×</button>' + 
                      '<strong>Something went wrong, please try again.</strong>' +
                    '</div>';
        $('.noti-alert').append(html);
        $('#notifications').css('display', 'block');
      }
    }
  });
}