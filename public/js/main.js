var _componentSelect2Normal = function() {

    $('.select').select2({width:'100%'});
};

function __highlight(value, obj) {
    obj.removeClass('text-success').removeClass('text-danger');
    if (value > 0) {
        obj.addClass('text-success');
    } else if (value < 0) {
        obj.addClass('text-danger');
    }
}

//Return the font-awesome html based on class value
function __fa_awesome($class = 'fa-refresh fa-spin fa-fw ') {
    return '<i class="fa ' + $class + '"></i>';
}



// $('.date').attr('readonly', true);

var _componentDatefPicker = function() {
    $('.date').attr('readonly', true);
    $('.date').datepicker({
        dateFormat: "yy-mm-dd",
        autoclose: true,
        todayHighlight: true,
        changeMonth: true,
		changeYear: true,
    });

};

var _componentMonthPicker = function() {
    $('.month').datepicker({
        dateFormat: "yy-mm",
        viewMode: "months",
        minViewMode: "months"
    });

};


var _componentYearPicker = function() {
    $('.year').datepicker({
        dateFormat: "yy",
        viewMode: "years",
        minViewMode: "years"
    });

};

var _componenteditor = function() {
    $('.summernote').summernote({
        height: 200, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: false // set focus to editable area after initializing summernote
    });
};


var _componentDropFile = function() {

    $('.dropify').dropify();

};


/*
 * Form Validation
 */

var _formValidation = function () {
    if ($('#content_form').length > 0) {
        $('#content_form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });
    }

    $('#content_form').on('submit', function (e) {
        e.preventDefault();
        $('#submit').hide();
        $('#submiting').show();
        $(".ajax_error").remove();
        var submit_url = $('#content_form').attr('action');
        //Start Ajax
        var formData = new FormData($("#content_form")[0]);
        $.ajax({
            url: submit_url,
            type: 'POST',
            data: formData,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            dataType: 'JSON',
            success: function (data) {
                if (data.status == 'danger') {
                    toastr.error(data.message);
                } else {
                    toastr.success(data.message);

                    $('#content_form')[0].reset();
                    if (data.goto) {
                        setTimeout(function () {

                            window.location.href = data.goto;
                        }, 500);
                    }

                    if (data.window) {
                        $('#content_form')[0].reset();
                        window.open(data.window, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=auto,left=auto,width=700,height=400");
                        setTimeout(function () {
                            window.location.href = '';
                        }, 1000);
                    }

                    if (data.load) {
                        setTimeout(function () {

                            window.location.href = "";
                        }, 1000);
                    }

                    if (typeof(emran) != "undefined" && emran !== null) {
                        if (typeof(emran.ajax) != "undefined" && emran.ajax !== null) {
                            emran.ajax.reload(null, false);
                        }
                    }
                }

                $('#submit').show();
                $('#submiting').hide();
            },
            error: function (data) {
                var jsonValue = $.parseJSON(data.responseText);
                const errors = jsonValue.errors;
                if (errors) {
                    var i = 0;
                    $.each(errors, function (key, value) {
                        const first_item = Object.keys(errors)[i]
                        const message = errors[first_item][0];
                        if ($('#' + first_item).length > 0) {
                            $('#' + first_item).parsley().removeError('required', {
                                updateClass: true
                            });
                            $('#' + first_item).parsley().addError('required', {
                                message: value,
                                updateClass: true
                            });
                        }
                        // $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');
                        toastr.error(value);
                        i++;

                    });
                } else {
                    toastr.warning(jsonValue.message);

                }
                // _componentSelect2Normal();
                $('#submit').show();
                $('#submiting').hide();
            }
        });
    });
};




var _formValidation2 = function () {
    if ($('#content_form2').length > 0) {
        $('#content_form2').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });
    }

    $('#content_form2').on('submit', function (e) {
        e.preventDefault();
        $('#submit').hide();
        $('#submiting').show();
        $(".ajax_error").remove();
        var submit_url = $('#content_form2').attr('action');
        //Start Ajax
        var formData = new FormData($("#content_form2")[0]);
        $.ajax({
            url: submit_url,
            type: 'POST',
            data: formData,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            dataType: 'JSON',
            success: function (data) {
                if (data.status == 'danger') {
                    toastr.error(data.message);

                } else {
                    toastr.success(data.message);
                    $('#submit').show();
                    $('#submiting').hide();
                    $('#content_form2')[0].reset();
                    if (data.goto) {
                        setTimeout(function () {

                            window.location.href = data.goto;
                        }, 500);
                    }

                    if (data.window) {
                        $('#content_form2')[0].reset();
                        window.open(data.window, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=auto,left=auto,width=700,height=400");
                        setTimeout(function () {
                            window.location.href = '';
                        }, 1000);
                    }

                    if (data.load) {
                        setTimeout(function () {

                            window.location.href = "";
                        }, 2500);
                    }
                }
            },
            error: function (data) {
                var jsonValue = $.parseJSON(data.responseText);
                const errors = jsonValue.errors;
                if (errors) {
                    var i = 0;
                    $.each(errors, function (key, value) {
                        const first_item = Object.keys(errors)[i]
                        const message = errors[first_item][0];
                        if ($('#' + first_item).length > 0) {
                            $('#' + first_item).parsley().removeError('required', {
                                updateClass: true
                            });
                            $('#' + first_item).parsley().addError('required', {
                                message: value,
                                updateClass: true
                            });
                        }
                        // $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');
                        toastr.error(value);
                        i++;
                    });
                } else {
                    toastr.warning(jsonValue.message);

                }
                _componentSelect2Normal();
                $('#submit').show();
                $('#submiting').hide();
            }
        });
    });
};

var _classformValidation = function() {
if ($('.ajax_form').length > 0) {
        $('.ajax_form').parsley().on('field:validated', function() {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });
    }
    $('.ajax_form').on('submit', function(e) {
        e.preventDefault();
        $('#submit').hide();
        $('#submiting').show();
        $(".ajax_error").remove();
        var submit_url = $(this).attr('action');
        console.log(submit_url);
        //Start Ajax
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: submit_url,
            type: 'POST',
            data: formData,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            dataType: 'JSON',
            success: function(data) {
                if (data.status == 'danger') {
                    toastr.error(data.message);

                } else {
                    toastr.success(data.message);
                    $('#submit').show();
                    $('#submiting').hide();
                    if (data.goto) {
                        setTimeout(function() {

                            window.location.href = data.goto;
                        }, 2500);
                    }

                    if (data.load) {
                        setTimeout(function() {

                            window.location.href ="";
                        }, 2500);
                    }
                    if (data.window) {
                        window.open(data.window, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=auto,left=auto,width=700,height=400");
                        setTimeout(function() {
                            window.location.href = '';
                        }, 1000);
                    }

                    if (data.windowup) {
                        window.open(data.windowup, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=auto,left=auto,width=700,height=400");
                        setTimeout(function() {
                            window.location.href = data.back;
                        }, 1000);
                    }
                }
            },
            error: function(data) {
                var jsonValue = $.parseJSON(data.responseText);
                const errors = jsonValue.errors;
                if (errors) {
                    var i = 0;
                    $.each(errors, function(key, value) {
                        const first_item = Object.keys(errors)[i]
                        const message = errors[first_item][0];
                        if ($('#' + first_item + '_error').length > 0) {
                            $('#' + first_item + '_error').html('<span style="color:red" class="ajax_error">' + value + '</span>');
                        } else {
                            $('#' + first_item).after('<span style="color:red" class="ajax_error">' + value + '</span>');
                        }

                        toastr.error(value);
                        i++;
                    });
                } else {
                    toastr.error(jsonValue.message);
                }
                $('#submit').show();
                $('#submiting').hide();
            }
        });
    });
};

$(document).ready(function() {
    /*
     * For Logout
     */
    $(document).on('click', '#logout', function(e) {
        e.preventDefault();
        $("#loader").show('fade');
        var url = $(this).data('url');
        $.ajax({
            url: url,
            method: 'Post',
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            dataType: 'JSON',
            success: function(data) {
                toastr.success(data.message);

                setTimeout(function() {
                    window.location.href = data.goto;
                }, 2000);
            },
            error: function(data) {
                var jsonValue = $.parseJSON(data.responseText);
                const errors = jsonValue.errors
                var i = 0;
                $.each(errors, function(key, value) {
                    toastr.success(value);
                    i++;
                });
            }
        });
    });
});


var _modalFormValidation = function () {
    if ($('#content_form').length > 0) {
        $('#content_form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });
    }
    $('#content_form').on('submit', function (e) {
        e.preventDefault();
        $('#submit').hide();
        $('#submiting').show();
        $(".ajax_error").remove();
        var submit_url = $('#content_form').attr('action');
        //Start Ajax
        var formData = new FormData($("#content_form")[0]);
        $.ajax({
            url: submit_url,
            type: 'POST',
            data: formData,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            dataType: 'JSON',
            success: function (data) {
                if (data.status == 'danger') {
                    toastr.error(data.message);
                } else {
                    toastr.success(data.message);

                    if(data.chage_order_status) {

                    } else {
                        $('#modal_remote').modal('toggle');
                    }

                    if (data.goto) {
                        setTimeout(function () {

                            window.location.href = data.goto;
                        }, 2500);
                    }

                    if (data.load) {
                        setTimeout(function () {

                            window.location.href = "";
                        }, 1000);
                    }

                    if (data.window) {
                        $('#content_form')[0].reset();
                        window.open(data.window, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=auto,left=auto,width=1200,height=400");
                        setTimeout(function() {
                            window.location.href = '';
                        }, 1000);
                    }

                    if (typeof(emran) != "undefined" && emran !== null) {
                        emran.ajax.reload(null, false);
                    }

                }

                $('#submit').show();
                $('#submiting').hide();
            },
            error: function (data) {
                var jsonValue = data.responseJSON;
                const errors = jsonValue.errors;
                if (errors) {
                    var i = 0;
                    $.each(errors, function (key, value) {
                        const first_item = Object.keys(errors)[i];
                        const message = errors[first_item][0];
                        if ($('#' + first_item).length > 0) {
                            $('#' + first_item).parsley().removeError('required', {
                                updateClass: true
                            });
                            $('#' + first_item).parsley().addError('required', {
                                message: value,
                                updateClass: true
                            });
                        }

                        // $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');
                        toastr.error(value);
                        i++;
                    });
                } else {
                    toastr.error(jsonValue.message);

                }
                $('#submit').show();
                $('#submiting').hide();
            }
        });
    });
};

var _modalClassFormValidation = function () {
    if ($('.content_form').length > 0) {
        $('.content_form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });
    }
    $('.content_form').on('submit', function (e) {
        e.preventDefault();
        $('#submit').hide();
        $('#submiting').show();
        $(".ajax_error").remove();
        var submit_url = $('.content_form').attr('action');
        //Start Ajax
        var formData = new FormData($(".content_form")[0]);
        $.ajax({
            url: submit_url,
            type: 'POST',
            data: formData,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            dataType: 'JSON',
            success: function (data) {
                if (data.status == 'danger') {
                    toastr.error(data.message);


                } else {
                    toastr.success(data.message);
                    $('#submit').show();
                    $('#submiting').hide();
                    $('#modal_remote').modal('toggle');
                    if (data.goto) {
                        setTimeout(function () {

                            window.location.href = data.goto;
                        }, 1000);
                    }

                    if (data.load) {
                        setTimeout(function () {

                            window.location.href = "";
                        }, 1000);
                    }

                    if (typeof(emran) != "undefined" && emran !== null) {
                        emran.ajax.reload(null, false);
                    }

                }
            },
            error: function (data) {
                var jsonValue = data.responseJSON;
                const errors = jsonValue.errors;
                if (errors) {
                    var i = 0;
                    $.each(errors, function (key, value) {
                        const first_item = Object.keys(errors)[i];
                        const message = errors[first_item][0];
                        if ($('#' + first_item).length > 0) {
                            $('#' + first_item).parsley().removeError('required', {
                                updateClass: true
                            });
                            $('#' + first_item).parsley().addError('required', {
                                message: value,
                                updateClass: true
                            });
                        }

                        // $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');
                        toastr.error(value);
                        i++;
                    });
                } else {
                    toastr.error(jsonValue.message);

                }
                $('#submit').show();
                $('#submiting').hide();
            }
        });
    });
};


var _remortFormValidation = function () {
    if ($('#remort_add').length > 0) {
        $('#remort_add').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });
    }
    $('#remort_add').on('submit', function (e) {
        e.preventDefault();
        $('#submit').hide();
        $('#submiting').show();
        $(".ajax_error").remove();
        var submit_url = $('#remort_add').attr('action');
        //Start Ajax
        var formData = new FormData($("#remort_add")[0]);
        $.ajax({
            url: submit_url,
            type: 'POST',
            data: formData,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            dataType: 'JSON',
            success: function (result) {
                if (result.status == 'danger') {
                    toastr.error(data.message);


                } else {
                    console.log(result.data);
                    $('#submit').show();
                    $('#submiting').hide();
                     $('select.'+result.addto).append(
                     $('<option>', {
                         value: result.id,
                         text: result.name
                     })

                 );
                    $('select.'+result.addto)
                     .val(result.id)
                     .trigger('change');
                    $('.'+result.modal).modal('toggle');


                }
            },
            error: function (data) {
                var jsonValue = data.responseJSON;
                const errors = jsonValue.errors;
                if (errors) {
                    var i = 0;
                    $.each(errors, function (key, value) {
                        const first_item = Object.keys(errors)[i];
                        const message = errors[first_item][0];
                        if ($('#' + first_item).length > 0) {
                            $('#' + first_item).parsley().removeError('required', {
                                updateClass: true
                            });
                            $('#' + first_item).parsley().addError('required', {
                                message: value,
                                updateClass: true
                            });
                        }

                        // $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');
                        toastr.error(value);
                        i++;
                    });
                } else {
                    toastr.error(jsonValue.message);

                }
                $('#submit').show();
                $('#submiting').hide();
            }
        });
    });
};

var _remortClassFormValidation = function () {
    if ($('.remort_addClass').length > 0) {
        $('.remort_addClass').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        });
    }
    $('.remort_addClass').on('submit', function (e) {
        e.preventDefault();
        $('#submit').hide();
        $('#submiting').show();
        $(".ajax_error").remove();
        var submit_url = $('.remort_addClass').attr('action');
        //Start Ajax
        var formData = new FormData($(".remort_addClass")[0]);
        $.ajax({
            url: submit_url,
            type: 'POST',
            data: formData,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            dataType: 'JSON',
            success: function (result) {
                if (result.status == 'danger') {
                    toastr.error(data.message);


                } else {
                    $('#submit').show();
                    $('#submiting').hide();
                     $('select.'+result.addto).append(
                     $('<option>', {
                         value: result.id,
                         text: result.name
                     })

                 );
                    $('select.'+result.addto)
                     .val(result.id)
                     .trigger('change');
                    $('.'+result.modal).modal('toggle');


                }
            },
            error: function (data) {
                var jsonValue = data.responseJSON;
                const errors = jsonValue.errors;
                if (errors) {
                    var i = 0;
                    $.each(errors, function (key, value) {
                        const first_item = Object.keys(errors)[i];
                        const message = errors[first_item][0];
                        if ($('#' + first_item).length > 0) {
                            $('#' + first_item).parsley().removeError('required', {
                                updateClass: true
                            });
                            $('#' + first_item).parsley().addError('required', {
                                message: value,
                                updateClass: true
                            });
                        }

                        // $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');
                        toastr.error(value);
                        i++;
                    });
                } else {
                    toastr.error(jsonValue.message);

                }
                $('#submit').show();
                $('#submiting').hide();
            }
        });
    });
};
/*
 * For Delete Item
 */
$(document).on('click', '#delete_item', function(e) {
    e.preventDefault();
    var row = $(this).data('id');
    var url = $(this).data('url');
    $('#action_menu_' + row).hide();
    $('#delete_loading_' + row).show();
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel plx!",
        closeOnConfirm: true,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: url,
                method: 'Delete',
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                dataType: 'JSON',
                success: function(data) {

                    if (data.status == "danger") {
                        toastr.warning(data.message);
                    } else {
                        toastr.success(data.message);
                        if (typeof(emran) != "undefined" && emran !== null) {
                            emran.ajax.reload(null, false);
                        }
                        if (data.goto) {
                            setTimeout(function() {

                                window.location.href = data.goto;
                            }, 1000);
                        }





                        if (data.load) {
                            setTimeout(function() {

                                window.location.href = "";
                            }, 1000);
                        }
                    }
                    $('#delete_loading_' + row).hide();
                    $('#action_menu_' + row).show();
                },
                error: function(data) {
                    var jsonValue = $.parseJSON(data.responseText);
                    const errors = jsonValue.errors
                    var i = 0;
                    $.each(errors, function(key, value) {
                        toastr.error(value);
                        i++;
                    });
                    $('#delete_loading_' + row).hide();
                    $('#action_menu_' + row).show();
                }
            });
        } else {
            $('#delete_loading_' + row).hide();
            $('#action_menu_' + row).show();
            swal("Cancelled", "Your imaginary file is safe :)", "error");
        }
    });
});

/*
 * For Restore Item
 */
$(document).on('click', '#restore_item', function(e) {
    e.preventDefault();
    var row = $(this).data('id');
    var url = $(this).data('url');
    $('#action_menu_' + row).hide();
    $('#delete_loading_' + row).show();
    swal({
        title: "Are you sure want to Restore this Data?",
        text: "It Will be go back in the main Folder!",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Restore it!",
        cancelButtonText: "No, cancel plx!",
        closeOnConfirm: true,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: url,
                method: 'DELETE',
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                dataType: 'JSON',
                success: function(data) {

                    if (data.status == "danger") {
                        toastr.warning(data.message);
                    } else {
                        toastr.success(data.message);
                        if (typeof(emran) != "undefined" && emran !== null) {
                            emran.ajax.reload(null, false);
                        }
                        if (data.goto) {
                            setTimeout(function() {

                                window.location.href = data.goto;
                            }, 1000);
                        }

                        if (data.load) {
                            setTimeout(function() {

                                window.location.href = "";
                            }, 1000);
                        }
                    }
                    $('#delete_loading_' + row).hide();
                    $('#action_menu_' + row).show();
                },
                error: function(data) {
                    var jsonValue = $.parseJSON(data.responseText);
                    const errors = jsonValue.errors
                    var i = 0;
                    $.each(errors, function(key, value) {
                        toastr.error(value);
                        i++;
                    });
                    $('#delete_loading_' + row).hide();
                    $('#action_menu_' + row).show();
                }
            });
        } else {
            $('#delete_loading_' + row).hide();
            $('#action_menu_' + row).show();
            swal("Cancelled", "Your imaginary file is safe :)", "error");
        }
    });
});




/*
 * For Status Change
 */
$(document).on('click', '#change_status', function(e) {
    e.preventDefault();
    var row = $(this).data('id');
    var url = $(this).data('url');
    var status = $(this).data('status');
    if (status == 1) {
        msg = 'Change Status Form Online To Offline';
    } else {
        msg = 'Change Status Form Offline To Online';
    }
    $('#status_' + row).hide();
    $('#status_loading_' + row).show();
    swal({
        title: "Are you sure?",
        text: msg,
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Change it!",
        cancelButtonText: "No, cancel plx!",
        closeOnConfirm: true,
        closeOnCancel: true
    }, function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: url,
                method: 'Put',
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                dataType: 'JSON',
                success: function(data) {
                    toastr.success(data.message);
                    if (typeof(emran) != "undefined" && emran !== null) {
                        emran.ajax.reload(null, false);
                    }

                    if (data.load) {
                        setTimeout(function() {

                            window.location.href = "";
                        }, 500);
                    }

                },
                error: function(data) {
                    var jsonValue = $.parseJSON(data.responseText);
                    const errors = jsonValue.errors
                    if (errors) {
                        var i = 0;
                        $.each(errors, function(key, value) {
                            toastr.error(value);
                            i++;
                        });
                    } else {
                        toastr.error(data.message);
                    }
                    $('#status_loading_' + row).hide();
                    $('#status_' + row).show();
                }
            });
        } else {
            $('#status_loading_' + row).hide();
            $('#status_' + row).show();
        }
    });
});

var _componentRemoteModalLoadAfterAjax = function () {
    $(document).on('click', '#content_managment', function (e) {
        e.preventDefault();
        //open modal
        $('#modal_remote').modal('toggle');
        // it will get action url
        var url = $(this).data('url');
        // leave it blank before ajax call
        $('.modal-body').html('');
        // load ajax loader
        $('#modal-loader').show();
        $.ajax({
                url: url,
                type: 'Get',
                dataType: 'html'
            })
            .done(function (data) {
                $('.modal-body').html(data).fadeIn(); // load response
                $('#modal-loader').hide();
                $('#branch_no').focus();
                _componentSelect2Normal();
                _modalFormValidation();

            })
            .fail(function (data) {
                $('.modal-body').html('<span style="color:red; font-weight: bold;"> Something Went Wrong. Please Try again later.......</span>');
                $('#modal-loader').hide();
            });
    });
};

/*
 * For Status Change
 */
$(document).on('click', '#change_hidden', function(e) {
    e.preventDefault();
    var row = $(this).data('id');
    var url = $(this).data('url');
    var model = $(this).data('table');


    $('#status_' + row).hide();
    $('#status_loading_' + row).show();
      $.ajax({
                url: url,
                method: 'Put',
                data: {model:model},
                success: function(data) {
                    toastr.success(data.message);
                    if (typeof(emran) != "undefined" && emran !== null) {
                        emran.ajax.reload(null, false);
                    }

                    if (data.load) {
                        setTimeout(function() {

                            window.location.href = "";
                        }, 500);
                    }

                },

            });
});


function sum_table_col(table, class_name) {
    var sum = 0;
    table
        .find('tbody')
        .find('tr')
        .each(function() {
            if (
                parseFloat(
                    $(this)
                        .find('.' + class_name)
                        .data('orig-value')
                )
            ) {
                sum += parseFloat(
                    $(this)
                        .find('.' + class_name)
                        .data('orig-value')
                );
            }
        });

    return sum;
}

function __sum_status(table, class_name) {
    var statuses = [];
    var status_html = [];
    table
        .find('tbody')
        .find('tr')
        .each(function() {
            element = $(this).find('.' + class_name);
            if (element.data('orig-value')) {
                var status_name = element.data('orig-value');
                if (!(status_name in statuses)) {
                    statuses[status_name] = [];
                    statuses[status_name]['count'] = 1;
                    statuses[status_name]['display_name'] = element.data('status-name');
                } else {
                    statuses[status_name]['count'] += 1;
                }
            }
        });

    return statuses;
}

function __sum_status_html(table, class_name) {
    var statuses_sum = __sum_status(table, class_name);
    var status_html = '<p class="text-left"><small>';
    for (var key in statuses_sum) {
        status_html +=
            statuses_sum[key]['display_name'] + ' - ' + statuses_sum[key]['count'] + '</br>';
    }

    status_html += '</small></p>';

    return status_html;
}


$(document).on('keypress', 'input.input_number', function(event) {
     var is_decimal = $(this).data('decimal');

     if (is_decimal == 0) {
         if (__currency_decimal_separator == '.') {
             var regex = new RegExp(/^[0-9,-]+$/);
         } else {
             var regex = new RegExp(/^[0-9.-]+$/);
         }
     } else {
         var regex = new RegExp(/^[0-9.,-]+$/);
     }

     var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
     if (!regex.test(key)) {
         event.preventDefault();
         return false;
     }
 });

function myFunction(url) {
    window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=auto,left=auto,width=700,height=400");
}
    $(document).on('click', '.btn_modal', function(e) {

            e.preventDefault();
            //open modal
            $('#modal_remote').modal('toggle');
            // it will get action url
            var url = $(this).data('url');
            // leave it blank before ajax call
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
                    $('#customer_name').focus();
                    _modalFormValidation();
                    _remortClassFormValidation();
                    _componentDatePicker();
                    _componentSelect2Normal();
                })
                .fail(function(data) {
                    $('.modal-body').html('<span style="color:red; font-weight: bold;"> Something Went Wrong. Please Try again later.......</span>');
                    $('#modal-loader').hide();
                });
        });

function  _componentDatePicker (){
    return;
}
