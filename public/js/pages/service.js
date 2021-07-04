var manageService;
var managePendingBooking;
var manageReadyForDeliveryBooking;
var manageCompleteBooking;
var errorMessage = function(text) {
   new PNotify({
       title: 'Error',
       text: '<b>' + text + '</b>',
       type: 'error',
       delay: '2500',
       buttons: {
           closer: true,
           sticker: true
       },
       hide: true,
       after_init: function(error) {
           error.attention('shake');
       }
   });
};
var successMessage = function(text) {
   new PNotify({
       title: 'Success!',
       text: text,
       type: 'success',
       delay: '2500',
       buttons: {
           closer: true,
           sticker: true
       },
       hide: true
   });
};



$(document).ready(function() {
    $('#manageServiceBtn').trigger('click');
})

function allServices() {
    $('#addServiceBtn').show();
    $('#allServiceDiv').show();
    $('#allPendingBookingDiv').hide();
    $('#allReadyForDeliveryBookingDiv').hide();
    $('#allPreviousBookingDiv').hide();
    $.fn.dataTable.ext.errMode = 'none';
    manageService = $('#manageServiceTable').DataTable({
        ajax: '/loadAllServices',
        dom: "",
        scrollX: true,
        lengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, "All"]
        ],
        columns: [
            {
                "data": "id"
            },
            {
                "data": "service_code"
            },
            {
                "data": "service_name"
            },
        ],
        aoColumnDefs: [{
            targets: [0],
            render: function (data, type, row) {
              actionButton = '<div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">Action</button><ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1"><li><a class="dropdown-item" type="button" onclick="fetchService('+ row.id +')">Edit</a></li><li><a class="dropdown-item" type="button" onclick="removeServiceConfirm('+ row.id +')">Delete</a></li></ul></div>'
            return actionButton;
            }
        },
        ]
    });
}

function pendingBooking() {
    $('#allServiceDiv').hide();
    $('#allPendingBookingDiv').show();
    $('#allReadyForDeliveryBookingDiv').hide();
    $('#allPreviousBookingDiv').hide();
    $('#addServiceBtn').hide();
    $.fn.dataTable.ext.errMode = 'none';
    managePendingBooking = $('#managePendingBookingTable').DataTable({
        ajax: '/loadPendingBooking',
        dom: "",
        scrollX: true,
        lengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, "All"]
        ],
        columns: [
            {
                "data": "service_name"
            },
            {
                "data": "user.name"
            },
            {
                "data": "booking_name"
            },
            {
                "data": "booking_date"
            },
            {
                "data": "status"
            },
            {
                "data": "id"
            },
        ],
        aoColumnDefs: [{
            targets: [0],
            render: function (data, type, row) {
              var str = row.service_name.replace(/[_\W]+/g, " ")
              actionButton = str;
            return actionButton;
            }
        },
        {
            targets: [4],
            render: function (data, type, row) {
              actionButton = '<b>Pending</b>';
            return actionButton;
            }
        },
        {
            targets: [5],
            render: function (data, type, row) {
              var status = "ready-for-delivery";
              actionButton = '<button class="btn btn-success" onclick="updateStatus(\'' + row.id + '\', \'' + status + '\')">Ready For Delivery</button>'
            return actionButton;
            }
        },
        ]
    });
}



function readyForDeliveryBooking() {
    $('#allServiceDiv').hide();
    $('#allPendingBookingDiv').hide();
    $('#allReadyForDeliveryBookingDiv').show();
    $('#allPreviousBookingDiv').hide();
    $('#addServiceBtn').hide();
    $.fn.dataTable.ext.errMode = 'none';
    manageReadyForDeliveryBooking = $('#manageReadyForDeliveryBookingTable').DataTable({
        ajax: '/loadReadyForDeliveryBooking',
        dom: "",
        scrollX: true,
        lengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, "All"]
        ],
        columns: [
            {
                "data": "service_name"
            },
            {
                "data": "user.name"
            },
            {
                "data": "booking_name"
            },
            {
                "data": "booking_date"
            },
            {
                "data": "status"
            },
            {
                "data": "id"
            },
        ],
        aoColumnDefs: [{
            targets: [0],
            render: function (data, type, row) {
              var str = row.service_name.replace(/[_\W]+/g, " ")
              actionButton = str;
            return actionButton;
            }
        },
        {
            targets: [4],
            render: function (data, type, row) {
              actionButton = '<b>Ready For Delivery</b>';
            return actionButton;
            }
        },
        {
            targets: [5],
            render: function (data, type, row) {
              var status = "completed";
              actionButton = '<button class="btn btn-success" onclick="updateStatus(\'' + row.id + '\', \'' + status + '\')">Mark Completed</button>'
            return actionButton;
            }
        },
        ]
    });
}

function previousBooking() {
    $('#allServiceDiv').hide();
    $('#allPendingBookingDiv').hide();
    $('#allReadyForDeliveryBookingDiv').hide();
    $('#allPreviousBookingDiv').show();
    $('#addServiceBtn').hide();
    $.fn.dataTable.ext.errMode = 'none';
    manageCompleteBooking = $('#manageCompletedBookingTable').DataTable({
        ajax: '/loadPreviousBooking',
        dom: "",
        scrollX: true,
        lengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, "All"]
        ],
        columns: [
            {
                "data": "service_name"
            },
            {
                "data": "user.name"
            },
            {
                "data": "booking_name"
            },
            {
                "data": "booking_date"
            },
            {
                "data": "status"
            },
        ],
        aoColumnDefs: [{
            targets: [0],
            render: function (data, type, row) {
              var str = row.service_name.replace(/[_\W]+/g, " ")
              actionButton = str;
            return actionButton;
            }
        },
        {
            targets: [4],
            render: function (data, type, row) {
              actionButton = '<b>Completed</b>';
            return actionButton;
            }
        },
        ]
    });
}

function updateStatus(bookingId, status) {
    var data = {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        'id' : bookingId,
        'status' : status
    };
    $.post('/updateBookingStatus', data,  function(response) {
        if(response.data.success == true) {
            PNotify.removeAll();
            successMessage(response.data.message);
            managePendingBooking.ajax.reload();
            manageReadyForDeliveryBooking.ajax.reload();
            manageCompleteBooking.ajax.reload();
        } else {
            PNotify.removeAll();
            errorMessage(response.data.message);
        }
    })
}


 $('#serviceAddForm').submit(function() {
    var formData = $('#serviceAddForm').serialize();
    $.post('/addService', formData ,function(response) {
      if(response.data.success == true) {
          $('#serviceAddForm')[0].reset();
          $('#addServiceModal').modal('hide');
          PNotify.removeAll();
          successMessage(response.data.message);
          manageService.ajax.reload();
      } else {
          PNotify.removeAll();
          errorMessage(response.data.message);
      }
    })
    return false;
  })


  $('#serviceEditForm').submit(function() {
    var formData = $('#serviceEditForm').serialize();
    $.post('/editService', formData ,function(response) {
      if(response.data.success == true) {
          $('#editServiceModal').modal('hide');
          PNotify.removeAll();
          successMessage(response.data.message);
          manageService.ajax.reload();
      } else {
          PNotify.removeAll();
          errorMessage(response.data.message);
      }
    })
    return false;
  })

  $('#serviceDeleteForm').submit(function() {
    var formData = $('#serviceDeleteForm').serialize();
    $.ajax({
        url: '/deleteService',
        type: 'delete',
        data : formData,
        dataType: 'json',
        success: function (response) {
            if(response.data.success == true) {
                $("#deleteServiceConfirmModal").modal('hide');
                PNotify.removeAll();
                successMessage(response.data.message);
                manageService.ajax.reload();
            } else {
                PNotify.removeAll();
                errorMessage(response.data.message);
            }
        }
    }); 
    return false;
  })



function fetchService(serviceId) {
    $('#editServiceModal').modal('show');
    $.get('/getService/'+ serviceId, function(response) {
        if(response.data.success = true) {
            $('#editServiceId').val(response.data.id);
            $('#editServiceCode').val(response.data.service_code);
            $('#editServiceName').val(response.data.service_name);
        } else {

        }
    })
}

function removeServiceConfirm(serviceId) {
    $('#deleteServiceConfirmModal').modal('show');
    $('#deleteServiceId').val(serviceId);
}