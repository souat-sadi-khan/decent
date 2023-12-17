/* ------------------------------------------------------------------------------
 *
 *  # Select extension for Datatables
 *
 *  Demo JS code for datatable_extension_select.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------
var emran="";
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
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            }
        });

         emran =$('.content_managment_table').DataTable({
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
                targets: [5]
            }],

            order: [0, 'asc'],
            processing: true,
            serverSide: true,
            ajax: { 
                url: $('.content_managment_table').data('url'),
                data: function(d) {
                    d.status = $('select#status').val();
                },
              },
            columns: [
                // { data: 'checkbox', name: 'checkbox' },
                 {
                    data: 'code',
                    name: 'code'
                }, {
                    data: 'type',
                    name: 'type'
                }, {
                    data: 'date',
                    name: 'date'
                }, {
                    data: 'delivery_date',
                    name: 'delivery_date'
                }, {
                    data: 'payment_status',
                    name: 'payment_status'
                },{
                    data: 'status',
                    name: 'status'
                }, {
                    data: 'action',
                    name: 'action'
                }
            ]
        });


    };


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

$(function () {

    function total_function()
    {
        var total = 0;
        $('.work_order tbody tr').each(function(i, element) {
            
            var html = $(this).html();
            if(html!='')
            {
                var net_total = $(this).find('.sub_total');
                if(net_total.length > 0){
                    total += parseInt(net_total.val());
                }
            
            }
        });
        
        return total;
    }

        $('.work_order tbody').on('keyup change',function(){
            var total = total_function();
            $('#refresh_net_total').html(total.toFixed(2));
            $('#net_total').val(total);
            $('#show_net_total').html(total.toFixed(2));
            $('.total_payable_amount').html(total.toFixed(2));
            $('#total_payable_amount').val(total.toFixed(2));
        });

    $("#item").on('click', '.remove', function () {
        $(this).closest('tr').remove();
        $("#discount_amount").val("");
        $("#discount").val("");
        $("#paid").val("");
    });


    $("#item").on('keyup change', '.qty, .price', function () {
        var tr = $(this).parent().parent();
        update_sub_total(tr);
        var tax = $('#tax_calculation_amount').val();
        var discount = $('#total_discount').val();
        var sub_total = $('#net_total').val();
        var shipping_charges = $('#shipping_charges').val();

        if(tax == '') {
            tax = 0;
        } else {
            tax = parseInt(tax);
        }

        console.log(tax);

        if(discount == '') {
            discount = 0;
        } else {
            discount = parseInt(discount);
        }

        if(sub_total == '') {
            sub_total = 0;
        } else {
            sub_total = parseInt(sub_total);
        }

        if(shipping_charges == '') {
            shipping_charges = 0;
        } else {
            shipping_charges = parseInt(shipping_charges);
        }

        var total_payable = parseFloat(sub_total) - parseFloat(discount) + parseInt(tax) + parseInt(shipping_charges); 

        $('.total_payable_amount').html(total_payable.toFixed(2));
        $('#total_payable_amount').val(total_payable.toFixed(2));
    });

    function update_sub_total(tr) {
        var qty = tr.find('.qty').val();
        var price = tr.find('.price').val();
        var total = qty * price;
        tr.find('.sub_total').val(total);
        tr.find('.net_total').val(total);
        tr.find('.sub_total_text').text(total);
        tr.find('.net_total_text').text(total);
    }


    $('.select_custom').select2({
        width: '88%'
    });

    // Modal :::::::::::::::::::
    $(document).on('click', '.btn-modal', function (e) {
        e.preventDefault();
        var container = $(this).data('container');
        $.ajax({
            url: $(this).data('url'),
            dataType: 'html',
            success: function (result) {
                $(container)
                    .html(result)
                    .modal('show');
                _remortFormValidation();
            },
        });
    });

    // if ($('#search_product').length > 0) {
    //     $('#search_product')
    //         .autocomplete({
    //             source: '/admin/product/get_product',
    //             minLength: 2,
    //             response: function (event, ui) {
    //                 if (ui.content.length == 1) {
    //                     ui.item = ui.content[0];
    //                     $(this)
    //                         .data('ui-autocomplete')
    //                         ._trigger('select', 'autocompleteselect', ui);
    //                     $(this).autocomplete('close');
    //                 } else if (ui.content.length == 0) {
    //                     var term = $(this).data('ui-autocomplete').term;
    //                     toastr.error('No Product Found', 'Opps!');
    //                     /*swal({
    //                         title: 'No Product found',
    //                         text: term + 'Add as a new Product',
    //                         buttons: ['Cancel', 'Ok'],
    //                     }).then(value => {
    //                         if (value) {
    //                             var container = $('.quick_add_product_modal');
    //                             $.ajax({
    //                                 url: '/products/quick_add?product_name=' + term,
    //                                 dataType: 'html',
    //                                 success: function(result) {
    //                                     $(container)
    //                                         .html(result)
    //                                         .modal('show');
    //                                 },
    //                             });
    //                         }
    //                     });*/
    //                 }
    //             },
    //             select: function (event, ui) {
    //                 $(this).val(null);
    //                 get_purchase_entry_row(ui.item.product_id, ui.item.variation_id);
    //             },
    //         })
    //         .autocomplete('instance')._renderItem = function (ul, item) {
    //         return $('<li>')
    //             .append('<div>' + item.text + '</div>')
    //             .appendTo(ul);
    //     };
    // }

    $('#select_product').change(function() {
        var product_id = $(this).val();
        get_purchase_entry_row(product_id);
        // $('#select_product').val('');
    });

    function get_purchase_entry_row(product_id) {
        //Get item addition method
        var is_added = false;
        //Search for variation id in each row of pos table
        $('#item')
            .find('tr')
            .each(function () {
                var row_v_id = $(this)
                    .find('.product_id')
                    .val();
                if (
                    row_v_id == product_id
                ) {
                    // is_added = true;
                    // //Increment product quantity
                    // qty_element = $(this).find('.qty');
                    // qty_element.val(parseInt(qty_element.val()) + 1);
                    // update_sub_total($(this));
                    // $('input#search_product')
                    //     .focus()
                    //     .select();
                    toastr.warning('Product available');
                    is_added = true;
                }
            });


        if (!is_added && product_id) {
            var row_count = $('#row').val();
            $.ajax({
                method: 'POST',
                url: '/admin/production-work-order/append',
                dataType: 'json',
                data: {product_id: product_id, row_count: row_count},
                success: function (result) {
                    $('#item').append(result.html);

                    if ($(result.html).find('.qty').length) {
                        $('#row').val(
                            $(result.html).find('.qty').length + parseInt(row_count)
                        ).trigger('change');
                    }
                    var net_total = total_function();
                    $('#refresh_net_total').html(net_total.toFixed(2));
                    $('#net_total').val(net_total);
                    $('#show_net_total').html(net_total.toFixed(2));
                    $('.total_payable_amount').html(net_total.toFixed(2));
                    $('#total_payable_amount').val(net_total.toFixed(2));
                },
            });
        }

        // console.log(net_total);
    }

    // ager function

    // function get_purchase_entry_row(product_id, variation_id) {
    //     //Get item addition method
    //     var is_added = false;
    //     //Search for variation id in each row of pos table
    //     $('#item')
    //         .find('tr')
    //         .each(function () {
    //             var row_v_id = $(this)
    //                 .find('.variation_id')
    //                 .val();
    //             if (
    //                 row_v_id == variation_id
    //             ) {
    //                 is_added = true;
    //                 //Increment product quantity
    //                 qty_element = $(this).find('.qty');
    //                 qty_element.val(parseInt(qty_element.val()) + 1);
    //                 update_sub_total($(this));
    //                 $('input#search_product')
    //                     .focus()
    //                     .select();
    //             }
    //         });


    //     if (!is_added && product_id) {
    //         var row_count = $('#row').val();
    //         $.ajax({
    //             method: 'POST',
    //             url: '/admin/production-work-order/append',
    //             dataType: 'json',
    //             data: {product_id: product_id, row_count: row_count, variation_id: variation_id},
    //             success: function (result) {
    //                 $('#item').append(result.html);

    //                 if ($(result.html).find('.qty').length) {
    //                     $('#row').val(
    //                         $(result.html).find('.qty').length + parseInt(row_count)
    //                     ).trigger('change');
    //                 }
    //                 var net_total = total_function();
    //                 $('#refresh_net_total').html(net_total.toFixed(2));
    //                 $('#net_total').val(net_total);
    //                 $('#show_net_total').html(net_total.toFixed(2));
    //                 $('.total_payable_amount').html(net_total.toFixed(2));
    //                 $('#total_payable_amount').val(net_total.toFixed(2));
    //             },
    //         });
    //     }

    //     // console.log(net_total);
    // }

    // discount_type
    $('#discount_amount').keyup(function() {
        var net_total = $('#net_total').val();
        var discount_type = $('#discount_type').val();
        var discount_amount = $(this).val();
        if(discount_amount == '') {
            discount_amount = 0;
        }
        if(discount_type == 'percentage') {
            var discount_amount_for_show = (net_total * discount_amount) / 100;
            $('#total_discount').val(discount_amount_for_show.toFixed(2));
        } else {
            var discount_amount_for_show = parseFloat(discount_amount);
            $('#total_discount').val(discount_amount_for_show.toFixed(2));

        }

        var tax = $('#tax_calculation_amount').val();
        var discount = $('#total_discount').val();
        var sub_total = $('#net_total').val();
        var shipping_charges = $('#shipping_charges').val();

        if(tax == '') {
            tax = 0;
        } else {
            tax = parseInt(tax);
        }

        if(discount == '') {
            discount = 0;
        } else {
            discount = parseInt(discount);
        }

        if(sub_total == '') {
            sub_total = 0;
        } else {
            sub_total = parseInt(sub_total);
        }

        if(shipping_charges == '') {
            shipping_charges = 0;
        } else {
            shipping_charges = parseInt(shipping_charges);
        }

        var total_payable = parseFloat(sub_total) - parseFloat(discount) + parseInt(tax) + parseInt(shipping_charges); 

        $('.total_payable_amount').html(total_payable.toFixed(2));
        $('#total_payable_amount').val(total_payable.toFixed(2));

        $('.total_payable_amount').html(total_payable.toFixed(2));
        $('#total_payable_amount').val(total_payable.toFixed(2));
        
    });

    // discount_type
    $('#discount_type').change(function() {
        var net_total = $('#net_total').val();
        var discount_type = $('#discount_type').val();
        var discount_amount = $('#discount_amount').val();
        if(discount_amount == '') {
            discount_amount = 0;
        }

        if(discount_type == 'percentage') {
            var discount_amount_for_show = (net_total * discount_amount) / 100;
            $('#total_discount').val(discount_amount_for_show.toFixed(2));
        } else {

            var discount_amount_for_show = parseFloat(discount_amount);
            $('#total_discount').val(discount_amount_for_show.toFixed(2));

        }

        var tax = $('#tax_calculation_amount').val();
        var discount = $('#total_discount').val();
        var sub_total = $('#net_total').val();
        var shipping_charges = $('#shipping_charges').val();

        if(tax == '') {
            tax = 0;
        } else {
            tax = parseInt(tax);
        }

        if(discount == '') {
            discount = 0;
        } else {
            discount = parseInt(discount);
        }

        if(sub_total == '') {
            sub_total = 0;
        } else {
            sub_total = parseInt(sub_total);
        }

        if(shipping_charges == '') {
            shipping_charges = 0;
        } else {
            shipping_charges = parseInt(shipping_charges);
        }

        var total_payable = parseFloat(sub_total) - parseFloat(discount) + parseInt(tax) + parseInt(shipping_charges); 

        $('.total_payable_amount').html(total_payable.toFixed(2));
        $('#total_payable_amount').val(total_payable.toFixed(2));

        $('.total_payable_amount').html(total_payable.toFixed(2));
        $('#total_payable_amount').val(total_payable.toFixed(2));
    });

    // tax_calculation_amount
    $('#tax_calculation_amount').keyup(function() {
        var tax = $('#tax_calculation_amount').val();
        var discount = $('#total_discount').val();
        var sub_total = $('#net_total').val();
        var shipping_charges = $('#shipping_charges').val();

        if(shipping_charges == '') {
            shipping_charges = 0;
        } else {
            shipping_charges = parseInt(shipping_charges);
        }

        if(tax == '') {
            tax = 0;
        } else {
            tax = parseInt(tax);
        }

        if(discount == '') {
            discount = 0;
        } else {
            discount = parseInt(discount);
        }

        if(sub_total == '') {
            sub_total = 0;
        } else {
            sub_total = parseInt(sub_total);
        }

        var total_payable = parseFloat(sub_total) - parseFloat(discount) + parseInt(tax) + parseInt(shipping_charges); 

        $('.total_payable_amount').html(total_payable.toFixed(2));
        $('#total_payable_amount').val(total_payable.toFixed(2));
    });

    // shipping_charges
    $('#shipping_charges').keyup(function() {
        var tax = $('#tax_calculation_amount').val();
        var discount = $('#total_discount').val();
        var sub_total = $('#net_total').val();
        var shipping_charges = $('#shipping_charges').val();

        if(tax == '') {
            tax = 0;
        } else {
            tax = parseInt(tax);
        }

        if(discount == '') {
            discount = 0;
        } else {
            discount = parseInt(discount);
        }

        if(sub_total == '') {
            sub_total = 0;
        } else {
            sub_total = parseInt(sub_total);
        }

        if(shipping_charges == '') {
            shipping_charges = 0;
        } else {
            shipping_charges = parseInt(shipping_charges);
        }

        var total_payable = parseFloat(sub_total) - parseFloat(discount) + parseInt(tax) + parseInt(shipping_charges); 

        $('.total_payable_amount').html(total_payable.toFixed(2));
        $('#total_payable_amount').val(total_payable.toFixed(2));
    });

    $('#paid').keyup(function() {
        var payable = $('#total_payable_amount').val();
        console.log(payable);
        var paid = $(this).val();
        if(paid == '') {
            paid = 0;
        }
        var due = parseInt(payable) - parseInt(paid);
        $('#due').val(due);
    });

    // payment method
    $('.method').change(function() {
        var val = $(this).val();

        if(val == 'check' || val == 'other') {
            $('.reference_no').fadeIn();
        } else {
            $('.reference_no').fadeOut();
        }
    });

});


 $('select#status').on(
        'change',
        function() {
            emran.ajax.reload(null, false);
        }
    );
