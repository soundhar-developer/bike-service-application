var currentBookingTable;
var previousBookingTable;
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
    $('#manageBookingServiceBtn').trigger('click');
    var dtToday = new Date();
    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();
    var maxDate = year + '-' + month + '-' + day;
    $('#serviceDate').attr('min', maxDate);
})


function loadAllServices() {
  $.get("/loadAllServices", function(response) {
    $('#serviceId').empty().html(' ');
    $('#serviceId').append(
        $("<option disabled></option>")
        .attr("value", 0)
        .attr("data-value", 0)
        .text("Select Service")
    );
    for (var i = 0; i < response.data.length; i++) {
      $('#serviceId').append(
          $("<option></option>")
          .attr("value", response.data[i].service_name)
          .attr("data-value", response.data[i].id)
          .text(response.data[i].service_code + ' - ' +response.data[i].service_name)
      );
    }
    $('#serviceId').selectpicker('refresh');
  })
}


// $('#serviceId').on('change', function() {
//   $('#serviceName').val( $('#serviceId option:selected').attr('data-value') );
// })


function currentBooking() {
    $('#bookServiceBtn').show();
    $('#allCurrentBoookingDiv').show();
    $('#allPreviousBookingDiv').hide();
    $.fn.dataTable.ext.errMode = 'none';
    currentBookingTable = $('#manageCurrentBookingTable').DataTable({
        ajax: '/loadCurrentBooking',
        dom: "",
        scrollX: true,
        lengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, "All"]
        ],
        columns: [
            {
                "data": "booking_name"
            },
            {
                "data": "service_name"
            },
            {
                "data": "booking_date"
            },
            {
                "data": "status"
            },
        ],
        aoColumnDefs: [{
            targets: [1],
            render: function (data, type, row) {
              var str = row.service_name.replace(/[_\W]+/g, " ")
              actionButton = str;
            return actionButton;
            }
        },{
            targets: [3],
            render: function (data, type, row) {
              var status = "<b>Pending</b>";
              if(row.status == "ready-for-delivery") {
                status = "<b>Ready For Delivery</b>"
              }
              actionButton = status;
            return actionButton;
            }
        },
        ]
    });
}



function previousBooking() {
  $('#bookServiceBtn').hide();
    $('#allPreviousBookingDiv').show();
    $('#allCurrentBoookingDiv').hide();
    $.fn.dataTable.ext.errMode = 'none';
    previousBookingTable = $('#managePreviousBookingTable').DataTable({
        ajax: '/loadPreviousBookingCustomer',
        dom: "",
        scrollX: true,
        lengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, "All"]
        ],
        columns: [
            {
                "data": "booking_name"
            },
            {
                "data": "service_name"
            },
            {
                "data": "booking_date"
            },
            {
                "data": "status"
            },
        ],
        aoColumnDefs: [{
            targets: [1],
            render: function (data, type, row) {
              var str = row.service_name.replace(/[_\W]+/g, " ")
              actionButton = str;
            return actionButton;
            }
        },
        {
            targets: [3],
            render: function (data, type, row) {
              actionButton = '<b>Completed</b>';
            return actionButton;
            }
        },
        ]
    });
}

 $('#bookingAddForm').submit(function() {
   $('#userId').val(localStorage.getItem('user_id'))
    var formData = $('#bookingAddForm').serialize();
    $.post('/addBooking', formData ,function(response) {
      if(response.data.success == true) {
          $('#bookingAddForm')[0].reset();
          $('#addBookingModal').modal('hide');
          PNotify.removeAll();
          successMessage(response.data.message);
          currentBookingTable.ajax.reload();
      } else {
          PNotify.removeAll();
          errorMessage(response.data.message);
      }
    })
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