$(function () {
    $("#employee_id").select2({
        ajax: {
            url: "/admin/get_employee",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    term: params.term
                };
            },
            processResults: function (data, params) {
                return {
                    results: data.items,
                };
            },
            cache: true
        },
        placeholder: 'Search for a Employee',
        minimumInputLength: 1,
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });

    function formatRepo(repo) {
        if (repo.loading) return repo.text;

        var markup = '<div class="select2-result-repository clearfix">' +
            '<div class="select2-result-repository__title">' + repo.name + '</div></div>';

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.name || repo.text;
    }

});


// Get Work Order

$(function () {
    $("#wo_id").select2({
        ajax: {
            url: "/admin/get_work_order",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    term: params.term
                };
            },
            processResults: function (data, params) {
                return {
                    results: data.items,
                };
            },
            cache: true
        },
        placeholder: 'Search for a Work Order',
        minimumInputLength: 1,
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });

    function formatRepo(repo) {
        if (repo.loading) return repo.text;

        var markup = '<div class="select2-result-repository clearfix">' +
            '<div class="select2-result-repository__title">' + repo.code + '</div></div>';

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.code || repo.text;
    }

});


// Get Material

$(function () {
    $("#product_id").select2({
        ajax: {
            url: "/admin/get_product",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    term: params.term
                };
            },
            processResults: function (data, params) {
                return {
                    results: data.items,
                };
            },
            cache: true
        },
        placeholder: 'Search for a Work Order',
        minimumInputLength: 1,
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });

    function formatRepo(repo) {
        if (repo.loading) return repo.text;

        var markup = '<div class="select2-result-repository clearfix">' +
            '<div class="select2-result-repository__title">' + repo.name + '</div></div>';

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.name || repo.text;
    }

});


// Get Raw Material

$(function () {
    $("#raw_material").select2({
        ajax: {
            url: "/admin/get_raw_material",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    term: params.term
                };
            },
            processResults: function (data, params) {
                return {
                    results: data.items,
                };
            },
            cache: true
        },
        placeholder: 'Search for a Work Order',
        minimumInputLength: 1,
        escapeMarkup: function (markup) {
            return markup;
        },
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });

    function formatRepo(repo) {
        if (repo.loading) return repo.text;

        var markup = '<div class="select2-result-repository clearfix">' +
            '<div class="select2-result-repository__title">' + repo.name + '</div></div>';

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.name || repo.text;
    }

});

// Get Work Order Material
$(document).on('change', '#wo_id', function () {
    // it will get action url
    var url = $(this).data('url');
    var id = $(this).val();

    $.ajax({
            url: url,
            data: {
                id: id
            },
            type: 'Get',
            dataType: 'html'
        })
        .done(function (data) {
            $('#data').html(data);
            cal();
        })
});

// Get Product Material
$(document).on('change', '#product_id', function () {
    // it will get action url
    var url = $(this).data('url');
    var id = $(this).val();

    $.ajax({
            url: url,
            data: {
                id: id
            },
            type: 'Get',
            dataType: 'html'
        })
        .done(function (data) {
            $('#data').append(data);
            
            cal();
        })
});


// Get Raw Material
$(document).on('change', '#raw_material', function () {
    // it will get action url
    var url = $(this).data('url');
    var id = $(this).val();

    $.ajax({
            url: url,
            data: {
                id: id
            },
            type: 'Get',
            dataType: 'html'
        })
        .done(function (data) {
            $('#data').append(data);
            cal();
        })
});


    // invoice calculation 
    $("#data").delegate('#unit_price, #qty,#waste', 'keyup blur', function () {
        var tr = $(this).parent().parent();
        var quantity = tr.find("#qty").val();
        var price = tr.find("#unit_price").val();
        var waste = tr.find("#waste").val();
        if (waste >= 100) {
            alert("Waste Can't Getter then 100%");
            tr.find(".waste").val('');
        }
        var amt = quantity * price;
        var uses = 100 - waste;
        tr.find(".price").val(amt);
        tr.find(".uses").val(uses);

        $("#discount_calculated_amount").html('');
        $("#total_discount_amount").val('');
        $("#discount_amount").val('');
        $("#discount_type").val('');
        cal();
    });

    // Discount calculation 
    $("#discount_amount").on('keyup blur', function () {
        var discount = $(this).val();
        var type = $('#discount_type').val();
        var total = $('#total_subtotal_input').val();

        if (type == 'fixed') {
            var discount_amt = discount;
        } else if (type == 'percentage') {
            var discount_amt = (total*discount)/100;
        }
        var net_total =total-discount_amt;
         $("#grand_total_hidden").val(net_total);
         $("#grand_total").html(net_total);
        $('#discount_calculated_amount').html(discount_amt);
        $('#total_discount_amount').val(discount_amt);
    });

    // Discount calculation 
    $("#discount_type").on('change', function () {
        var discount = $('#discount_amount').val();
        var type = $(this).val();
        var total = $('#total_subtotal_input').val();

        if (type == 'fixed') {
            var discount_amt = discount;
        } else if (type == 'percentage') {
            var discount_amt = (total*discount)/100;
        }
        var net_total =total-discount_amt;
         $("#grand_total_hidden").val(net_total);
         $("#grand_total").html(net_total);
        $('#discount_calculated_amount').html(discount_amt);
        $('#total_discount_amount').val(discount_amt);
    });


$("#data").on('click', '.remmove', function () {
    $(this).closest('tr').remove();
    $("#discount_calculated_amount").html('');
    $("#total_discount_amount").val('');
    $("#discount_amount").val('');
    $("#discount_type").val('');
    cal();
})


    // Pay calculation 
    $("#amount").on('keyup blur', function () {
        var amount = $(this).val();
        var grand_total = $("#grand_total_hidden").val();
        
        var due = grand_total - amount;
        $("#payment_due_hidden").val(due);
        $("#payment_due").html(due);
    });

function cal() {
    var total_subtotal = 0;
    $(".price").each(function () {
        total_subtotal = total_subtotal + ($(this).val() * 1);
    });
    $("#total_subtotal").html(total_subtotal);
    $("#total_subtotal_input").val(total_subtotal);
    $("#grand_total_hidden").val(total_subtotal);
    $("#grand_total").html(total_subtotal);

}
