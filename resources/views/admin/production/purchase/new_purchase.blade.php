@extends('layouts.app', ['title' => _lang('New Purchase'), 'modal' => 'lg'])
@push('admin.css')
<style>
.table th, .table td {
padding: 0.2rem 0.5rem;
}
</style>
@endpush
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Product for Production."><i class="fa fa-universal-access mr-4"></i>
        {{_lang('New Purchase')}}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        {{ Breadcrumbs::render('purchase-create') }}
    </ul>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<form action="{{route('admin.production-purchase.store')}}" method="post" id="content_form" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            <h6>{{_lang('New Purchase ')}}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Purchase By --}}
                <div class="col-md-4">
                    <label for="employee_id">{{_lang('Purchase By')}}
                    </label>
                    <div class="input-group">
                        <select required data-placeholder="Select Purchase By" name="purchase_by" id="employee_id"
                            class="form-control select">
                            <option value="0" selected>Select Purchase By</option>
                        </select>
                    </div>
                </div>
                {{-- Reference No: --}}
                <div class="col-md-4 form-group">
                    <label for="reference_no">{{_lang('Reference No:')}}
                    </label>
                    <input type="text" class="form-control" placeholder="Reference No" name="reference_no"
                    id="reference_no" value="{{ $ref_no }}" readonly>
                </div>
                {{-- Invoice No: --}}
                <div class="col-md-4 form-group">
                    <label for="invoice_no">{{_lang('Invoice No:')}}
                    </label>
                    <input type="text" class="form-control" placeholder="Invoice No" name="invoice_no" id="invoice_no">
                </div>
                {{-- Purchase Date: --}}
                <div class="col-md-6 form-group" id="child_unit_row">
                    <label for="purchase_date">{{_lang('Purchase Date')}}</label>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                        </div>
                        <input type="text" class="form-control date" name="purchase_date" id="purchase_date" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                {{-- Purchase Status: --}}
                <div class="col-md-6 form-group">
                    <label for="purchase_status">{{_lang('Purchase Status:')}}
                    </label>
                    <select class="form-control select" data-placeholder="Select Status" name="status" id="status" class="form-control select">
                        <option value="">Select Status</option>
                        <option value="Received">{{_lang('Received')}}</option>
                        <option value="Pending">{{_lang('Pending')}}</option>
                        <option value="Ordered">{{_lang('Ordered')}}</option>
                    </select>
                </div>

            </div>
        </div>
    </div>
    <div class="card card-box border border-primary">
    <div class="card-body">
     <div class="row">
         <div class="col-md-6 mx-auto">
            <label for="client_id">{{_lang('Supplier:')}}
                    </label>
                    <select class="form-control select" name="client_id" id="client_id" class="form-control select">
                        <option value="">Select Supplier</option>
                        @foreach ($suppliers as $element)
                            <option value="{{ $element->id }}">{{ $element->name }}</option>
                        @endforeach
                    </select>
         </div>

        <div class="col-md-6 mx-auto">
            <label for="work_order_id">{{_lang('WorkOrder:')}}
                    </label>
                    <select class="form-control select" name="work_order_id" id="work_order_id" class="form-control select">
                        <option value="">Select Workorder</option>
                        @foreach ($workorders as $order)
                                <option value="{{ $order->id }}">{{ $order->prefix}}-{{  $order->code }}</option>
                            @endforeach
                    </select>
         </div>
     </div>
        <div class="row mt-2">
            <div class="col-md-6 mx-auto text-center">

                <button type="button" class="btn btn-primary btn-sm w-100" id="check_it">Get Material</button>
                <button type="button" class="btn btn-sm btn-info w-100" id="checking" style="display: none;">
                <i class="fa fa-spinner fa-spin fa-fw"></i>Checking...</button>
            </div>
        </div>
    </div>
    </div>
    <div class="card mt-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-condensed table-bordered table-th-green text-center table-striped"
                    id="purchase_entry_table">
                    <thead>
                        <tr>
                            <th width="25%">Product/Material</th>
                            <th width="15%">Purchase Quantity</th>
                            <th width="10%">Unit</th>
                            <th width="10%">Price</th>
                            <th width="15%">Line Total</th>
                            {{-- <th width="10%">Waste</th>
                            <th width="10%">Uses</th> --}}
                            <th width="5%"><i class="fa fa-trash" aria-hidden="true"></i></th>
                        </tr>
                    </thead>
                    <tbody id="data">
                    </tbody>
                </table>
            </div>
            <hr>
            <div class="pull-right col-md-5">
                <table class="pull-right col-md-12">
                    <tbody>
                        <tr>
                            <th class="col-md-7 text-right">Net Total Amount:</th>
                            <td class="col-md-5 text-left">
                                <span  class="display_currency sub_total">00.00</span>
                                <input type="hidden" class="sub_total" value="" name="total_before_tax">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-body">
            <table class="table">
                <tbody>
                    <tr>
                        <td>
                            <div class="form-group">
                                <label for="discount_type">Discount Type:</label>
                                <select class="form-control select2 " id="discount_type" name="discount_type">
                                    <option value="" selected="selected">None</option>
                                    <option value="fixed">Fixed</option>
                                    <option value="percentage">Percentage</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label for="discount_amount">Discount Amount:</label>
                                <input class="form-control input_number" required="" name="discount_amount" type="text"
                                value="0" id="discount_amount">
                            </div>
                        </td>
                        <td>&nbsp;</td>
                        <td class="text-right pt-5">
                            <b>Discount:</b>(-)
                            <span id="discount_calculated_amount" class="display_currency">৳ 0.00</span>
                            <input name="total_discount_amount" type="hidden" id="total_discount_amount">
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td class="text-right">
                            <input class="net_total" name="final_total" type="hidden" value="0">
                            <b>Purchase Total: </b><span class="display_currency net_total" data-currency_symbol="true">৳ 0.00</span>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="">
                            <div class="form-group">
                                <label for="stuff_notes">Stuff Notes</label>
                                <textarea style="resize: none;" class="form-control" rows="3" name="stuff_notes" cols="50"
                                id="stuff_notes"></textarea>
                            </div>
                        </td>
                        <td colspan="">
                            <div class="form-group">
                                <label for="sell_notes">Sell Notes</label>
                                <textarea style="resize: none;" class="form-control" rows="3" name="sell_notes" cols="50"
                                id="sell_notes"></textarea>
                            </div>
                        </td>
                        <td colspan="2">
                            <div class="form-group">
                                <label for="transaction_notes">Transaction Notes</label>
                                <textarea style="resize: none;" class="form-control" rows="3" name="transaction_notes" cols="50"
                                id="transaction_notes"></textarea>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="amount">Amount:</label>
                    <div class="input-group  mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-money"></i></span>
                        </div>
                        <input class="form-control payment-amount input_number" id="amount" placeholder="Amount"
                        name="payment" type="text" value="0.00">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="investment_account_id">{{ _lang('Pay Account') }} </label>
                        <select name="investment_account_id" id="investment_account_id" class="form-control select">
                            <option value="">Select Account</option>
                            @foreach ($inves_account as $element)
                                <option value="{{ $element->id }}">{{ $element->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="method">Payment Method:</label>
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-money"></i></span>
                            </div>
                            <select class="form-control payment_types_dropdown" id="method"
                                name="method">
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="cheque">Cheque</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="other">Other</option>
                                <option value="custom_pay_1">Custom Payment 1</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="transaction">Transaction No.</label>
                        <input class="form-control" placeholder="Transaction No." id="transaction"
                        name="transaction_no" type="text" value="">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="note_0">Payment note:</label>
                        <textarea class="form-control" rows="3" id="note_0" name="payment_note"
                        cols="50"></textarea>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12">
                    <input id="due" name="payment_due_hidden" type="hidden" value="0">
                    <div class="pull-right"><strong>Payment due:</strong> <span class="change_return_span">৳ 0.00</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-6 mx-auto text-center">
            <button type="submit" id="submit" class="btn btn-primary btn-sm w-100">{{ _lang('New Purchase') }}</button>
            <button type="button" class="btn btn-info btn-sm w-100" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
        </div>
    </div>
</div>
</form>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script>
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
$('.select').select2();
_formValidation();
_componentDatefPicker();
$(document).on('click', '#check_it', function () {
    $("#check_it").hide();
    $('#checking').show();
    var url = "/admin/supplier/material";
    var client_id = $("#client_id").val();
    var work_order_id = $("#work_order_id").val();
    if (client_id =="") {
      toastr.error("Select Supplier first");
       $("#check_it").show();
       $('#checking').hide();
    }else{
        $.ajax({
            url: url,
            data: {
            client_id:client_id,
            work_order_id:work_order_id
            },
            type: 'Get',
            dataType: 'html'
        })
    .done(function (data) {
          $("#check_it").show();
          $('#checking').hide();
          $('#data').html(data);
          $("#client_id").val();
        calculate();
    })
  }
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
        calculate();
    });


$("#data").on('click', '.remmove', function () {
    $(this).closest('tr').remove();
  calculate();

})


   function calculate() {
        var sub_total = 0;
        var shipping_charges=0;
        var qty = 0;
        $(".price").each(function() {
            sub_total = sub_total + ($(this).val() * 1);
        })

        $(".qty").each(function() {
            qty = qty + ($(this).val() * 1);
        })

        $(".total_item").val(qty);
        $(".total_item").text(qty);
          net_total = sub_total;
        $(".sub_total").val(sub_total);
        $(".sub_total").text(sub_total);
        var discount =pos_discount(sub_total);
        net_total =sub_total-discount;

        var tax =pos_order_tax(net_total,discount);
        net_total =net_total+tax;

        shipping_charges =shipping();
        net_total =net_total+shipping_charges;

        $(".net_total").val(net_total);
        $(".net_total").text(net_total);
        $("#due").val(net_total);
        var change_amount =calculate_balance_due(net_total);
        $('.change_return_span').text(change_amount);
        $('#due').val(change_amount);

    }


    $("#discount_amount, #discount_type,#tax_calculation_amount,#shipping_charges,#amount").on('keyup blur change', function () {
       calculate();
    });


 function pos_discount(total_amount) {
    var calculation_type = $('#discount_type').val();
    var calculation_amount = __read_number($('#discount_amount'));

    var discount = __calculate_amount(calculation_type, calculation_amount, total_amount);

    $('#total_discount_amount').val(discount, false);
    $('#discount_calculated_amount').text(discount, false);

    return discount;
}

function __read_number(input_element, use_page_currency = false) {
    return input_element.val();
}

function pos_order_tax(price_total, discount) {
    var calculation_type = 'percentage';
    var calculation_amount = __read_number($('#tax_calculation_amount'));
    var total_amount = price_total;

    var order_tax = __calculate_amount(calculation_type, calculation_amount, total_amount);


    $('span#order_tax').text(order_tax, false);
    return order_tax;
}

function shipping()
{
  var shipping_charges =parseFloat($('#shipping_charges').val());
  return isNaN(shipping_charges) ? 0 : shipping_charges;;

}

function __calculate_amount(calculation_type, calculation_amount, amount) {
    var calculation_amount = parseFloat(calculation_amount);
    calculation_amount = isNaN(calculation_amount) ? 0 : calculation_amount;

    var amount = parseFloat(amount);
    amount = isNaN(amount) ? 0 : amount;

    switch (calculation_type) {
        case 'fixed':
            return parseFloat(calculation_amount);
        case 'percentage':
            return parseFloat((calculation_amount / 100) * amount);
        default:
            return 0;
    }
}


function calculate_balance_due(total) {
    var paid =parseFloat($('#amount').val());
    paid=isNaN(paid) ? 0 : paid;
    $('.total_paying').text(paid);
    var total_change =total-paid;
    return total_change;
}




</script>
@endpush
