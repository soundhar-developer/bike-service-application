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


$('#loginForm').submit(function() {
    var formData = $('#loginForm').serialize();
    $.post('/login' , formData ,function(response) {
        if(response.data.success == true) {
            localStorage.setItem('user_id', response.data.id);
            localStorage.setItem('name', response.data.name);
            localStorage.setItem('user_type', response.data.user_type);
            if(response.data.user_type == "owner") {
             window.location.replace('/owner');
            } else {
              window.location.replace('/customer');
            }
        } else {
          PNotify.removeAll();
          errorMessage(response.data.message);
        }
    })
    return false;
})

$('#registerForm').submit(function() {
    var formData = $('#registerForm').serialize();
    $.post('/registerCustomer' , formData ,function(response) {
        if(response.data.success == true) {
             window.location.replace('/login');
        } else {
            PNotify.removeAll();
            errorMessage(response.data.message);
        }
    })
    return false;
})

