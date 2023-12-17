   $(document).ready(function () {
       $('.select').select2();
   });
    $(document).on('change', '#get_price', function () {
        // it will get action url
        var url = $(this).data('url');
        var id = $(this).val();

        $.ajax({
                url: url,
                data: {
                    id: id
                },
                type: 'Get',
                dataType: 'json'
            })
            .done(function (data) {
                $('#product_price').val(data.price.default_sell_price);
                $('#price').html('BDT ' + data.price.price);
                if (data.qty) {

                    $('#qty').html('( ' + data.qty + ' pieces available )');
                } else {
                    $('#qty').html('(Out Of Stock)');
                }
            })
    });




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
                    $('#cart_total').text(data.bdt + ' ' + data.cart_total);
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

