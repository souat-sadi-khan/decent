/* ------------------------------------------------------------------------------
 *
 *  # Select extension for Datatables
 *
 *  Demo JS code for datatable_extension_select.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------
var emran='';
var DatatableSelect = function () {


    //
    // Setup module components
    //

    // Basic Datatable examples
    var _componentDatatableSelect = function () {
        if (!$().DataTable) {
            console.warn('Warning - datatables.min.js is not loaded.');
            return;
        }

        // Setting datatable defaults
        $.extend($.fn.dataTable.defaults, {
            autoWidth: false,
            responsive: true,
            columnDefs: [{
                orderable: false,
                width: 100,
                targets: [2]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
            language: {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            }
        });

        emran=$('.content_managment_table').DataTable({
            responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },
            dom: 'Bfrtip',
            buttons: [{
                extend: 'copy',
                className: 'btn btn-primary glyphicon glyphicon-duplicate'
            }, {
                extend: 'csv',
                className: 'btn btn-primary glyphicon glyphicon-save-file'
            }, {
                extend: 'excel',
                className: 'btn btn-primary glyphicon glyphicon-list-alt'
            }, {
                extend: 'pdf',
                className: 'btn btn-primary glyphicon glyphicon-file'
            }, {
                extend: 'print',
                className: 'btn btn-primary glyphicon glyphicon-print'
            }],
            columnDefs: [{
                orderable: false,
                targets: [8]
            }],

            order: [0, 'asc'],
            processing: true,
            serverSide: true,

            ajax: {
            url: $('.content_managment_table').data('url'),
            data: function(d) {
                d.employee_id = $('select#employee_id').val();
                d.client_id = $('select#client_id').val();
                d.status = $('select#status').val();
                d.payment_status = $('select#payment_status').val();
            },
          },
            columns: [
                // { data: 'checkbox', name: 'checkbox' },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                }, {
                    data: 'purchase_by',
                    name: 'purchase_by'
                }, {
                    data: 'client',
                    name: 'client'
                }, {
                    data: 'reference_no',
                    name: 'reference_no'
                },  {
                    data: 'date',
                    name: 'date'
                }, {
                    data: 'total',
                    name: 'total'
                }, {
                    data: 'status',
                    name: 'status'
                }, {
                    data: 'payment_status',
                    name: 'payment_status'
                }, {
                    data: 'action',
                    name: 'action'
                }
            ]

        });


    };

    $('select#status, select#employee_id,select#client_id, select#payment_status').on(
        'change',
        function() {
            if (typeof(emran.ajax) != "undefined" && emran.ajax !== null) {
                emran.ajax.reload(null, false);
            }
        }
    );

    var _componentRemoteModalLoad = function () {
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
                    _modalFormValidation();
                    _componentSelect2Normal();
                })
                .fail(function (data) {
                    $('.modal-body').html('<span style="color:red; font-weight: bold;"> Something Went Wrong. Please Try again later.......</span>');
                    $('#modal-loader').hide();
                });
        });
    };



    //
    // Return objects assigned to module
    //

    return {
        init: function () {
            _componentDatatableSelect();
            _componentRemoteModalLoad();
            _componentSelect2Normal();
            _componentDatefPicker();
            _formValidation();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function () {
    DatatableSelect.init();
});

    $("#method").on('change', function () {
        var type = $(this).val();
        if (type == 'cash') {
            $("#tr_hide").hide(500);
        } else {
            $("#tr_hide").show(500);
        }
    });

    $("#paidAmount").on('keyup blur', function () {
        var paid = $(this).val();
        var total = $('#Totalamt').val();
        var due = total - paid;

        if (due < 0) {
            alert('aaa');
            $('#paidAmount').val('');
        }
        $('#dueAmmount').val(due);
    });
