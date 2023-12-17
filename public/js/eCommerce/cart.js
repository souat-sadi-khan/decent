$(document).on('blur', '.cart-qty', function () {
    // it will get action url
    var tr = $(this).parent().parent();
    var url = $(this).data('url');
    var qty = $(this).val();
    var id = tr.find(".cart-id").val();

    $.ajax({
            url: url,
            data: {
                id: id,
                qty: qty
            },
            type: 'Get',
            dataType: 'json'
        })
        .done(function (data) {
            $('#data').html(data.view);
            $('#total').text(data.total);
            $('#total_hidden').val(data.total);
            $('#sub_total').text(data.sub_total);
            $('#sub_total_hidden').val(data.sub_total);
            var discount_type = $('#c_type').val();
            var amt = $('#c_amount').val();
            if (discount_type == 'percentage') {
                var total_amt = (data.total * amt) / 100;
                var sub_total = data.total - total_amt;
                $('#total').text(sub_total);
                $('#total_hidden').val(sub_total);
                $('#coupon_amt').val(total_amt);
                $('#show_discount_amount').html(total_amt);
            } else {
                var sub_total = data.total - amt;
                $('#c_amount').val(amt);
                $('#c_type').val(discount_type);
                $('#total').text(sub_total);
                $('#sub_total_hidden').val(sub_total);
                $('#coupon_amt').val(amt);
                $('#show_discount_amount').html(amt);
            }
            if(amt != 0) {
                $('#show_coupon_area').fadeIn();
            }
            $('#cart_total').text(data.bdt + ' ' + data.total);
        })
});

$(document).on('click', '.remove', function () {
// it will get action url
var tr = $(this).parent().parent();
var url = $(this).data('url');
var id = tr.find(".cart-id").val();

$.ajax({
        url: url,
        data: {
            id: id
        },
        type: 'Get',
        dataType: 'json'
    })
    .done(function (data) {
        $('#data').html(data.view);
        $('#total').text(data.total);
        $('#total_hidden').val(data.total);
        $('#sub_total').text(data.sub_total);
        $('#sub_total_hidden').val(data.sub_total);
        $('#cart_total').text(data.bdt + ' ' + data.total);
    })
});


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
                 if (data.goto) {
                     setTimeout(function () {

                         window.location.href = data.goto;
                     }, 500);
                 }
                toastr.error(data.message);

            } else {
                toastr.success(data.message);
                $('#cart_total').text(data.cart_total);
                $('#submit').show();
                $('#submiting').hide();
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


$(document).on('click', '#coupon-submit', function () {

$('#coupon-submit').hide();
$('#submitting').show();
// it will get action url
var url = $(this).data('url');
var coupon = $('#coupon-value').val();
var total_hidden = $('#total_hidden').val();
var sub_total_hidden = $('#sub_total_hidden').val();

$.ajax({
        url: url,
        data: {
            coupon: coupon
        },
        type: 'Get',
        dataType: 'json'
    })
    .done(function (data) {
        if (data.status == 'danger') {
            toastr.error(data.message);
        } else if (data.status == 'error') {
            toastr.error(data.message);
        } else if (data.status == 'success') {
            toastr.success(data.message);
            var amt = data.coupon.discount_amount;

            if (data.coupon.discount_type == 'percentage') {
                var total_amt = (total_hidden * amt) / 100;
                var sub_total = total_hidden - total_amt;
                $('#c_amount').val(amt);
                $('#c_type').val(data.coupon.discount_type);
                $('#total').text(sub_total);
                $('#show_discount_amount').html(total_amt);
                $('#total_hidden').val(sub_total);
                $('#coupon_amt').val(total_amt);
                $('.mt-holder').hide('500');
            } else {
                var sub_total = total_hidden - amt;
                $('#c_amount').val(amt);
                $('#c_type').val(data.coupon.discount_type);
                $('#total').text(sub_total);
                $('#show_discount_amount').html(amt);
                $('#sub_total_hidden').val(sub_total);
                $('#coupon_amt').val(amt);
                $('.mt-holder').hide('500');
            }

            if(amt != 0) {
                $('#show_coupon_area').fadeIn();
            }

        }

        $('#coupon-submit').show();
        $('#submitting').hide();
    })
});