@extends('layouts.app', ['title' => _lang('Add Purchase'), 'modal' => 'lg'])
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
        {{_lang('Add Purchase')}}</h1>
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
            <h6>{{_lang('Add Purchase ')}}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Purchase By --}}
                <div class="col-md-3">
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
                <div class="col-md-3 form-group">
                    <label for="reference_no">{{_lang('Reference No:')}}
                    </label>
                    <input type="text" class="form-control" placeholder="Reference No" name="reference_no"
                    id="reference_no" value="{{ $ref_no }}" readonly>
                </div>
                {{-- Invoice No: --}}
                <div class="col-md-3 form-group">
                    <label for="invoice_no">{{_lang('Invoice No:')}}
                    </label>
                    <input type="text" class="form-control" placeholder="Invoice No" name="invoice_no" id="invoice_no">
                </div>
                {{-- Purchase Date: --}}
                <div class="col-md-3 form-group" id="child_unit_row">
                    <label for="purchase_date">{{_lang('Purchase Date')}}</label>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                        </div>
                        <input type="text" class="form-control date" name="purchase_date" id="purchase_date" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
                {{-- Purchase Status: --}}
                <div class="col-md-3 form-group">
                    <label for="purchase_status">{{_lang('Purchase Status:')}}
                    </label>
                    <select class="form-control select" data-placeholder="Select Status" name="status" id="status" class="form-control select">
                        <option value="">Select Status</option>
                        <option value="Received">{{_lang('Received')}}</option>
                        <option value="Pending">{{_lang('Pending')}}</option>
                        <option value="Ordered">{{_lang('Ordered')}}</option>
                    </select>
                </div>
                @if ($type == 'work_order')
                {{-- Work Order --}}
                <div class="col-md-3 form-group" id="work_order">
                    <label for="wo_id">{{_lang('Work Order')}}
                    </label>
                    <div class="input-group">
                        <select class="form-control select" data-placeholder="Select Work Order" name="wo_id"
                            data-url='{{route('admin.purchase.product')}}' id="wo_id" class="form-control select">
                        </select>
                    </div>
                </div>
                @endif
                @if ($type == 'row_material')
                {{-- Product --}}
                <div class="col-md-3 form-group" id="product_row">
                    <label for="product_id">{{_lang('Product')}}
                    </label>
                    <div class="input-group">
                        <select class="form-control select" data-placeholder="Select Product" name="product_id"
                            data-url='{{route('admin.purchase.material')}}' id="product_id" class="form-control select">
                        </select>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-body">
            @if ($type == 'row_material')
            {{-- Product Raw Material --}}
            <div class="row pb-3">
                <div class="col-md-8 mx-auto">
                    <div class="input-group">
                        <select class="form-control select" data-placeholder="Select Product" name="raw_material"
                            data-url='{{route('admin.purchase.raw_material')}}' id="raw_material"
                            class="form-control select">
                        </select>
                    </div>
                </div>
            </div>
            @endif
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
                                <span id="total_subtotal" class="display_currency">00.00</span>
                                <input type="hidden" id="total_subtotal_input" value="00.00" name="total_before_tax">
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
                            <input id="grand_total_hidden" name="final_total" type="hidden" value="0">
                            <b>Purchase Total: </b><span id="grand_total" class="display_currency" data-currency_symbol="true">৳ 0.00</span>
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
                    <input id="payment_due_hidden" name="payment_due_hidden" type="hidden" value="0">
                    <div class="pull-right"><strong>Payment due:</strong> <span id="payment_due">৳ 0.00</span>
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
$('.select').select2();
// _formValidation();
</script>
<script src="{{ asset('js/production/purchase.js') }}"></script>
<script src="{{ asset('js/production/add_purchase.js') }}"></script>
@endpush