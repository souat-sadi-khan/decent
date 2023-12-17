var tariq = '';
var flag = true;
var DatatableButtonsHtml5 = function() {

    var _componentRemoteModalLoad = function() {
        $(document).on('click', '#content_managment', function(e) {
            e.preventDefault();
            //open modal
            $('#modal_remote').modal('toggle');
            // it will get action url
            var url = $(this).data('url');
            //leave it blank before ajax call
            $('.modal-body').html('');
            // load ajax loader
            $('#modal-loader').show();
            $.ajax({
                    url: url,
                    type: 'Get',
                    dataType: 'html'
                })
                .done(function(data) {
                    $('.modal-body').html(data).fadeIn(); // load response
                    $('#modal-loader').hide();
                    _modalFormValidation();

                })
                .fail(function(data) {
                    $('.modal-body').html('<span style="color:red; font-weight: bold;"> Something Went Wrong. Please Try again later.......</span>');
                    $('#modal-loader').hide();
                });
        });
    };

    return {
        init: function() {

            _componentRemoteModalLoad();
            _componentSelect2Normal();
            _componentDatePicker();
            _componentDropFile();
            _formValidation();

        }
    }
}();
// Initialize module
// ------------------------------
document.addEventListener('DOMContentLoaded', function() {
    DatatableButtonsHtml5.init();
});

// $('#sampleTable').DataTable({
//     responsive: true
// });


// Mail Configaration
$("#mail_driver").change(function () {
    var mail = $(this).val();
    if (mail == 'mailgun') {
        $('#mailgun_contain').show('slow');
        $('#smtp_contain').hide('slow');
    } else if (mail == 'smtp'){
        $('#mailgun_contain').hide('slow');
        $('#smtp_contain').show('slow');
    }else{
        $('#mailgun_contain').hide('slow');
        $('#smtp_contain').hide('slow');
    }
});

$(document).ready(function () {
    var mail = $('#mail_driver').val();
    if (mail == 'mailgun') {
        $('#mailgun_contain').show('slow');
        $('#smtp_contain').hide('slow');
    } else if (mail == 'smtp') {
        $('#mailgun_contain').hide('slow');
        $('#smtp_contain').show('slow');
    } else {
        $('#mailgun_contain').hide('slow');
        $('#smtp_contain').hide('slow');
    }
});

// SMS COnfigaration
$("#sms_gateway").change(function () {
    var mail = $(this).val();
    if (mail == 'Nexmo') {
        $('#nexmo_contain').show('slow');
        $('#twillo_contain').hide('slow');
        $('#custom_contain').hide('slow');
    } else if (mail == 'Twillo'){
        $('#nexmo_contain').hide('slow');
        $('#twillo_contain').show('slow');
        $('#custom_contain').hide('slow');
    } else if (mail == 'Custom'){
        $('#nexmo_contain').hide('slow');
        $('#twillo_contain').hide('slow');
        $('#custom_contain').show('slow');
    }else{
        $('#nexmo_contain').hide('slow');
        $('#twillo_contain').hide('slow');
        $('#custom_contain').hide('slow');
    }
});

$(document).ready(function () {
    var sms = $('#sms_gateway').val();
    if (sms == 'Nexmo') {
        $('#nexmo_contain').show('slow');
        $('#twillo_contain').hide('slow');
        $('#custom_contain').hide('slow');
    } else if (sms == 'Twillo') {
        $('#nexmo_contain').hide('slow');
        $('#twillo_contain').show('slow');
        $('#custom_contain').hide('slow');
    } else if (sms == 'Custom') {
        $('#nexmo_contain').hide('slow');
        $('#twillo_contain').hide('slow');
        $('#custom_contain').show('slow');
    } else {
        $('#nexmo_contain').hide('slow');
        $('#twillo_contain').hide('slow');
        $('#custom_contain').hide('slow');
    }
});


// Module Configaration
$("#per_day_sarary").change(function () {
    var module = $(this).val();
    if (module == 'User_defined') {
        $('#defined-days').show('slow');
    }else{
        $('#defined-days').hide('slow');
    }
});

$(document).ready(function () {
    var mail = $('#sms_gateway').val();
    if (mail == 'Nexmo') {
        $('#nexmo_contain').show('slow');
        $('#twillo_contain').hide('slow');
        $('#custom_contain').hide('slow');
    } else if (mail == 'Twillo') {
        $('#nexmo_contain').hide('slow');
        $('#twillo_contain').show('slow');
        $('#custom_contain').hide('slow');
    } else if (mail == 'Custom') {
        $('#nexmo_contain').hide('slow');
        $('#twillo_contain').hide('slow');
        $('#custom_contain').show('slow');
    } else {
        $('#nexmo_contain').hide('slow');
        $('#twillo_contain').hide('slow');
        $('#custom_contain').hide('slow');
    }
});
