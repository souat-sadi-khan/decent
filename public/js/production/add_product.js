        $(document).on('change', '#catagory_id', function () {
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
                    $('#sub_category').html("");
                    $('#sub_category').append($('<option>').text("--Select Sub Category--").attr('value', ""));
                    $.each(data, function (i, parts) {
                        $('#sub_category').append($('<option>').text(parts.name).attr('value', parts.id));
                    });
                })
        });

        _componentDropFile();
        var _ImageUpload = function () {
            if ($('#imageUpload').length > 0) {
                $('#imageUpload').parsley().on('field:validated', function () {
                    var ok = $('.parsley-error').length === 0;
                    $('.bs-callout-info').toggleClass('hidden', !ok);
                    $('.bs-callout-warning').toggleClass('hidden', ok);
                });
            }

            $('#imageUpload').on('submit', function (e) {
                e.preventDefault();
                $('#submit_photo').hide();
                $('#submiting_photo').show();
                $(".ajax_error").remove();
                var submit_url = $('#imageUpload').attr('action');
                //Start Ajax
                var formData = new FormData($("#imageUpload")[0]);
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
                            $('#submit_photo').show();
                            $('#submiting_photo').hide();
                            $('#imageUpload')[0].reset();
                            if (data.goto) {
                                setTimeout(function () {

                                    window.location.href = data.goto;
                                }, 500);
                            }

                            if (data.window) {
                                $('#imageUpload')[0].reset();
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
                        $('#submit_photo').show();
                        $('#submiting_photo').hide();
                    }
                });
            });
        };

        _ImageUpload();


        $(document).ready(function () {
            $('.summernote').summernote({
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ol', 'ul', 'paragraph', 'height']],
                    ['table', ['table']],
                    ['insert', ['link']]
                ]
            });
        });

/**
 * Quantity on value change
 */
$("#quantity").on('keyup', function (e) {
    $("#grossPrice").val($("#quantity").val() * $("#unitPrice").val());
    $("#child_unit_price").val($("#unitPrice").val() / convertion_rate);
});

/**
 * Unit Price on value change
 */
$("#unitPrice").on('keyup', function (e) {
    $("#grossPrice").val($("#quantity").val() * $("#unitPrice").val());
    $("#child_unit_price").val($("#unitPrice").val() / convertion_rate);
});

/**
 * Unit price on mouse scroll value change
 */
$("#unitPrice").on('wheel', function (e) {
    $("#grossPrice").val($("#quantity").val() * $("#unitPrice").val());
    $("#child_unit_price").val($("#unitPrice").val() / convertion_rate);
});


/**
 * Unit price on mouse scroll value change
 */
$("#waste").on('keyup', function (e) {
    var a = $(this).val();
    var total = 100 - a;
    $("#uses").val(total);
});

/**
 * Product dropdown on change Action
 */
$("#raw_material").on('change', function (e) {
    var productId = $("#raw_material").val()
    $.get('/admin/get-unit-of-product/' + productId, function (data) {
        $("#unit").text(data.unit.unit);
        $("#unit_id").val(data.unit.id);
        $("#unitPrice").val(data.price);

        var child_unit = data.unit.child_unit;
        if (child_unit) {
            $('#child_unit_row').show('slow');
            $("#child_unit").text(data.unit.child_unit);
            $("#unit_row").attr("class", "col-md-4");
            $("#unit_price_row").attr("class", "col-md-4");
        }else{
            $('#child_unit_row').hide('slow');
            $("#unit_row").attr("class", "col-md-6");
            $("#unit_price_row").attr("class", "col-md-6");
        }

        convertion_rate = data.unit.convert_rate;
        unitId = data.unit.id;
        unitName = data.unit.unit;
        
    });
});

//

$(document).on('click', '#add', function () {
    var url = $(this).data('url');
    var product = $("#raw_material").val();
    var unit = $("#unit_id").val();
    var unit_price = $("#unitPrice").val();
    var quantity = $("#quantity").val();
    var grossPrice = $("#grossPrice").val();
    var waste = $("#waste").val();
    var uses = $("#uses").val();
    var raw_status = $("#raw_status").val();
    var raw_description = $("#raw_description").val();
    if (product == "") {
        swal("Select Raw Material First");
    } else {
        $.ajax({
                url: url,
                data: {
                    product: product,
                    unit: unit,
                    unit_price: unit_price,
                    quantity: quantity,
                    grossPrice: grossPrice,
                    waste: waste,
                    uses: uses,
                    raw_status: raw_status,
                    raw_description: raw_description
                },
                type: 'Get',
                dataType: 'html'

            })

            .done(function (data) {

                $("#pursesDetailsRender").append(data);
                $("#raw_material").val("");
                $("#unit_id").val("");
                $("#quantity").val("");
                $("#unitPrice").val("");
                $("#child_unit_price").val("");
                $("#grossPrice").val("");
                $("#waste").val("");
                $("#uses").val("");
                $("#raw_description").val("");
                calculate();

            })
    }

});

$("#pursesDetailsRender").on('click', '.remmove', function () {
    $(this).closest('tr').remove();
})

var _remortUnitModal =function(){
// Modal :::::::::::::::::::
    $(document).on('click', '.btn-modal', function(e) {
        e.preventDefault();
        var container = $(this).data('container');
        $.ajax({
            url: $(this).data('url'),
            dataType: 'html',
            success: function(result) {
                $(container)
                    .html(result)
                    .modal('show');
                    _remortFormValidation();   
            },
        });
    });

};

    // Modal :::::::::::::::::::
    $(document).on('click', '.btn-modal', function(e) {
        e.preventDefault();
        var container = $(this).data('container');
        $.ajax({
            url: $(this).data('url'),
            dataType: 'html',
            success: function(result) {
                $(container)
                    .html(result)
                    .modal('show');
                    _remortUnitModal();
                    _remortClassFormValidation();
            },
        });
    });


    $(document).on('click', '#addVariation', function () {
        var url = $(this).data('url');
        var row = parseInt($('#row').val());
        row = row + 1;
            $.ajax({
                    url: url+'?row='+row,
                    type: 'Get',
                    dataType: 'html'
                })
                .done(function (data) {
                     $('#row').val(row);
                    $("#data").append(data);
        })
    });

    $("#data").on('click', '.remmove', function () {
        $(this).closest('tr').remove();
    })
