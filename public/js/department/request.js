
// Get Work Order
_componentDatefPicker();
$(function () {
    $("#wo_id").select2({
        ajax: {
            url: "/admin/get_work_order_request",
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
            url: "/admin/get_product_request",
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

$(function () {
    $("#row_material").select2({
        ajax: {
            url: "/admin/get_row_material_request",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    term: params.term
                };
            },
            processResults: function (data, params) {
                console.log(data);
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
            $('#submit_btn').show(500);
            $('#data').html(data);
        })
});

// Get Product Material
$(document).on('change', '#row_material', function () {
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
            $('#submit_btn').show(500);
            $('#data').append(data);
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
            $('#submit_btn').show(500);
            $('#data').append(data);
        })
});

$("#data").on('click', '.remmove', function () {
    $(this).closest('tr').remove();
})

_classformValidation();