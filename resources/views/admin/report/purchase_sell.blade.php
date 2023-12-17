@extends('layouts.app', ['title' => _lang('Purchase Sale'), 'modal' => 'lg'])
{{-- Header Section --}}
@push('admin.css')
<link rel="stylesheet" href="{{asset('backend/css/picker/daterangepicker.css')}}">
@endpush
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Depertment Store Request."><i class="fa fa-universal-access mr-4"></i>
        {{_lang('Purchase Sale')}}</h1>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 mx-auto">
                <div class="form-group">
                    {!! Form::label('transaction_date_range', _lang('Date Range') . ':') !!}
                    <div class="input-group">
                        {!! Form::text('transaction_date_range', null, ['class' => 'form-control', 'readonly','id'=>'transaction_date_range','placeholder' => _lang('Date Range')]) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <table class="table table-striped">
                    <tr>
                        <th>{{ _lang('Total Purchase') }}:</th>
                        <td>
                            <span class="total_purchase">
                                <i class="fa fa-refresh fa-spin fa-fw"></i>
                            </span>
                            {{ get_option('currency') }}
                        </td>
                    </tr>
                    <tr>
                        <th>{{ _lang('Purchase Including Tax') }}:</th>
                        <td>
                            <span class="purchase_inc_tax">
                                <i class="fa fa-refresh fa-spin fa-fw"></i>
                            </span>
                            {{ get_option('currency') }}
                        </td>
                    </tr>
                    <tr>
                        <th>{{ _lang('Purchase Return Including Tax') }}:</th>
                        <td>
                            <span class="purchase_return_inc_tax">
                                <i class="fa fa-refresh fa-spin fa-fw"></i>
                            </span>
                            {{ get_option('currency') }}
                        </td>
                    </tr>
                    <tr>
                        <th>{{ _lang('Purchase Due') }}:</th>
                        <td>
                            <span class="purchase_due">
                                <i class="fa fa-refresh fa-spin fa-fw"></i>
                            </span>
                            {{ get_option('currency') }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-6">
                <table class="table table-striped">
                    <tr>
                        <th>{{ _lang('Total Sale') }}:</th>
                        <td>
                            <span class="total_sell">
                                <i class="fa fa-refresh fa-spin fa-fw"></i>
                            </span>
                            {{ get_option('currency') }}
                        </td>
                    </tr>
                    <tr>
                        <th>{{ _lang('Sale Including Tax') }}:</th>
                        <td>
                            <span class="sell_inc_tax">
                                <i class="fa fa-refresh fa-spin fa-fw"></i>
                            </span>
                            {{ get_option('currency') }}
                        </td>
                    </tr>
                    <tr>
                        <th>{{ _lang('Total Sale Return Including Tax') }}:</th>
                        <td>
                            <span class="total_sell_return">
                                <i class="fa fa-refresh fa-spin fa-fw"></i>
                            </span>
                            {{ get_option('currency') }}
                        </td>
                    </tr>
                    <tr>
                        <th>{{ _lang('Sale Due') }}: </th>
                        <td>
                            <span class="sell_due">
                                <i class="fa fa-refresh fa-spin fa-fw"></i>
                            </span>
                            {{ get_option('currency') }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                 <h5 class="text-muted">
                Overall (Sale-Sale Return-Purchase-Purchase Return)
            </h5>
                <h4 class="text-muted">
                Sale-Purchase :
                <span class="sell_minus_purchase">
                    <i class="fa fa-refresh fa-spin fa-fw"></i>
                </span>
                {{ get_option('currency') }}
                </h4>
                <h4 class="text-muted">
                Due :
                <span class="difference_due">
                    <i class="fa fa-refresh fa-spin fa-fw"></i>
                </span>
                {{ get_option('currency') }}
                </h4>
            </div>
        </div>
    </div>
</div>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script src="{{ asset('backend/js/moment.min.js') }}"></script>
<script src="{{ asset('backend/js/picker/daterangepicker.js') }}"></script>
<script src="{{ asset('backend/js/picker/moment-timezone-with-data.min.js') }}"></script>
<script>
    $('.select').select2();
    updatePurchaseSell();

     $('#transaction_date_range').daterangepicker(
            $("#transaction_date_range").on('apply.daterangepicker',function(start,end){
                var start = '';
                var end = '';
                if($('#transaction_date_range').val()){
                    start = $('input#transaction_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    end = $('input#transaction_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
                }
               updatePurchaseSell(start,end);
                
            })
        );
function updatePurchaseSell(start_date=null,end_date=null) {
    var start = start_date;
    var end = end_date;
    var location_id = $('#purchase_sell_location_filter').val();

    var data = { start_date: start, end_date: end, location_id: location_id };

    var loader = __fa_awesome();
    $('.total_purchase').html(loader);
    $('.purchase_due').html(loader);
    $('.total_sell').html(loader);
    $('.invoice_due').html(loader);
    $('.purchase_return_inc_tax').html(loader);
    $('.total_sell_return').html(loader);

    $.ajax({
        method: 'GET',
        url: '/admin/report/purchase-sale',
        dataType: 'json',
        data: data,
        success: function(data) {
            $('.total_purchase').html(
                (data.purchase.total_purchase_exc_tax)
            );
            $('.purchase_inc_tax').html(
                (data.purchase.total_purchase_inc_tax)
            );
            $('.purchase_due').html((data.purchase.purchase_due));

            $('.total_sell').html((data.sell.total_sell_exc_tax));
            $('.sell_inc_tax').html((data.sell.total_sell_inc_tax));
            $('.sell_due').html((data.sell.invoice_due));
            $('.purchase_return_inc_tax').html(
                (data.total_purchase_return)
            );
            $('.total_sell_return').html((data.total_sell_return));

            $('.sell_minus_purchase').html((data.difference.total));
            __highlight(data.difference.total, $('.sell_minus_purchase'));

            $('.difference_due').html((data.difference.due));
            __highlight(data.difference.due, $('.difference_due'));

            // $('.purchase_due').html( __currency_trans_from_en(data.purchase_due, true));
        },
    });
}
</script>
@endpush