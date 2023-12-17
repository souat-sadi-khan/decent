@extends('layouts.app', ['title' => _lang('Edit Purchase'), 'modal' => 'lg'])
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
        <h1 data-placement="bottom" title="Purchase for Production."><i class="fa fa-universal-access mr-4"></i>
            {{_lang('Edit Purchase')}}</h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        {{ Breadcrumbs::render('purchase-create') }}
    </ul>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<form action="{{route('admin.production-purchase.update', $model->id)}}" method="post" id="content_form">
    @csrf
    @method('PATCH')
    <div class="card">
        <div class="card-header">
            <h6>{{_lang('Edit Purchase ')}}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Purchase By --}}
                <div class="col-md-4">
                    <label for="employee_id">{{_lang('Purchase By')}}
                    </label>
                    <div class="input-group">
                        <select required data-placeholder="Select Purchase By" name="purchase_by" class="form-control" id="employee_id">
                            <option value="{{$model->purchase_by}}" selected>{{$model->employee?$model->employee->name:''}}</option>
                        </select>
                    </div>
                </div>

                {{-- Reference No: --}}
                <div class="col-md-4 form-group">
                    <label for="reference_no">{{_lang('Reference No:')}}
                    </label>
                    <input type="text" value="{{$model->reference_no}}" class="form-control" placeholder="Reference No"
                        name="reference_no" id="reference_no" readonly>
                </div>

                {{-- Invoice No: --}}
                <div class="col-md-4 form-group">
                    <label for="invoice_no">{{_lang('Invoice No:')}}
                    </label>
                    <input type="text" readonly value="{{$model->invoice_no}}" class="form-control"
                        placeholder="Invoice No" name="invoice_no" id="invoice_no">
                </div>

                {{-- Purchase Date: --}}
                <div class="col-md-6 form-group" id="child_unit_row">
                    <label for="purchase_date">{{_lang('Purchase Date')}}</label>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                        </div>
                        <input type="text" value="{{$model->date}}" class="form-control date" name="purchase_date"
                            id="purchase_date">
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="purchase_status">{{_lang('Purchase Status:')}}
                    </label>
                    <select class="form-control select" data-placeholder="Select Status" name="status" id="status" class="form-control select">
                        <option {{ $model->status=='Received'?'selected':'' }} value="Received">{{_lang('Received')}}</option>
                        <option {{ $model->status=='Ordered'?'selected':'' }} value="Ordered" {{ $model->status=='Received'?'disabled':'' }}>{{_lang('Ordered')}}</option>
                        <option {{ $model->status=='Pending'?'selected':'' }} value="Pending" {{ $model->status=='Received'?'disabled':'' }}>{{_lang('Pending')}}</option>
                    </select>
                </div>


            </div>
        </div>
    </div>
       <div class="card card-box border border-primary">
            <div class="card-body">
                 <label for="purchase_status">{{_lang('Supplier:')}}
                    </label>
                    <input type="text" class="form-control"  value="{{ $model->client->name }}" readonly>
                    <small class="text-danger">This is Not Editable</small>
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
                        @foreach ($model->purchase as $item)
                        <tr>
                            <td>
                                <input type="hidden" name="raw_material[]" value="{{ $item->raw_material_id }}" class="pid">
                                <input type="hidden" name="product_id[]" value="{{ $item->product?$item->product->id:'' }}">
                                 {{ $item->product?$item->product->name:'' }}({{  $item->material?$item->material->name:'' }})
                            </td>
                            <td>
                                <input type="text" class="form-control input_number qty" id="qty" name="qty[]"
                                    value="{{ $item->order_qty }}">
                                    <input type="hidden" class="form-control qty" name="old_qty[]"
                                    value="{{ $item->qty }}">
                            </td>
                            <td>
                                <input type="hidden" class="form-control" name="unit_id[]"
                                    value="{{ $item->material->unit->id }}">{{ $item->material->unit->unit }}
                                @if ($item->material->unit->child_unit)
                                / {{$item->material->unit->child_unit}}
                                @endif
                            </td>
                            <td>
                                <input type="text" class="form-control input_number unit_price" id="unit_price" name="unit_price[]"
                                    value="{{ $item->price }}">
                            </td>
                            <td>
                                <input type="text" class="form-control price" id="price" readonly name="price[]"
                                    value="{{ $item->line_total }}">
                            </td>
                            <td>
                                <button type="button" name="remove" class="btn btn-danger btn-sm remmove" {{ $model->status=='Received'?'disabled':'' }}><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </td>
                        </tr>
                        @endforeach
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
                                <span id="total_subtotal" class="display_currency">{{$model->sub_total}}</span>
                                <input type="hidden" id="total_subtotal_input" value="{{$model->sub_total}}" name="total_before_tax">
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
                                    <option {{$model->discount_type == 'fixed'?'selected':''}} value="fixed">Fixed</option>
                                    <option {{$model->discount_type == 'percentage'?'selected':''}} value="percentage">Percentage</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label for="discount_amount">Discount Amount:</label>
                                <input class="form-control input_number" required="" name="discount_amount" type="text"
                                value="{{$model->discount}}" id="discount_amount">
                            </div>
                        </td>
                        <td>&nbsp;</td>
                        <td class="text-right pt-5">
                            <b>Discount:</b>(-)
                            <span id="discount_calculated_amount" class="display_currency">৳ {{$model->discount_amount}}</span>
                            <input name="total_discount_amount" type="hidden" id="total_discount_amount" value="{{$model->discount_amount}}">
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td class="text-right">
                            <input class="net_total" name="final_total" type="hidden" value="{{$model->net_total}}">
                            <b>Purchase Total: </b><span class="display_currency net_total" data-currency_symbol="true">৳ {{$model->net_total}}</span>
                        </td>
                    </tr>


                    <tr>
                        <td colspan="">
                            <div class="form-group">
                                <label for="stuff_notes">Stuff Notes</label>
                                <textarea style="resize: none;" class="form-control" rows="3" name="stuff_notes" cols="50"
                                    id="stuff_notes">{{$model->stuff_note}}</textarea>
                            </div>
                        </td>
                        <td colspan="">
                            <div class="form-group">
                                <label for="sell_notes">Sell Notes</label>
                                <textarea style="resize: none;" class="form-control" rows="3" name="sell_notes" cols="50"
                                    id="sell_notes">{{$model->sell_note}}</textarea>
                            </div>
                        </td>
                        <td colspan="2">
                            <div class="form-group">
                                <label for="transaction_notes">Transaction Notes</label>
                                <textarea style="resize: none;" class="form-control" rows="3" name="transaction_notes" cols="50"
                                    id="transaction_notes">{{$model->transaction_note}}</textarea>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        

          <div class="row mt-2">
                        <div class="col-md-6 mx-auto text-center">
                            <button type="submit" id="submit" class="btn btn-primary btn-sm w-100">{{ _lang('Edit Purchase') }}</button>
                            <button type="button" class="btn btn-info btn-sm w-100" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                        </div>
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
