@extends('layouts.app', ['title' => _lang('Investment Details Account'), 'modal' => 'lg'])
@push('admin.css')
    <link rel="stylesheet" href="{{asset('backend/css/picker/daterangepicker.css')}}">
@endpush
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Account."><i class="fa fa-universal-access mr-4"></i> {{_lang('Investment Account')}}</h1>
        <p>{{_lang('Investment Details Account.')}}</p>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            
            <div class="tile-body">
                <div class="row">
                    <div class="col-sm-4 col-xs-6">
                        <div class="card">
                            <div class="card-body">
                                <table class="table">
                                    <tr>
                                        <th>{{ _lang('Account Name') }}: </th>
                                        <td>{{$investment->name}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ _lang('Account No') }}:</th>
                                        <td>{{$investment->account_number}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ _lang('Balance') }}:</th>
                                        <td><span id="account_balance">{{ $balance }}</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8 col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"> <i class="fa fa-filter" aria-hidden="true"></i> {{ _lang('Filter') }}:</h3>
                            </div>
                            <div class="card-body">
                               <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('transaction_date_range', _lang('Date Range') . ':') !!}
                                        <div class="input-group">
                                            {!! Form::text('transaction_date_range', null, ['class' => 'form-control', 'readonly','id'=>'transaction_date_range','placeholder' => _lang('Date Range')]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('transaction_type', _lang('Transection Type') . ':') !!}
                                        <div class="input-group">
                                            {!! Form::select('transaction_type', ['' => _lang('All'),'debit' => _lang('Debit'), 'credit' => _lang('Credit')], '', ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                @can('account.access')
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="account_book">
                                        <thead>
                                            <tr>
                                                <th>{{ _lang('Date') }}</th>
                                                <th>{{ _lang('Description') }}</th>
                                                <th>{{ _lang('Credit') }}</th>
                                                <th>{{ _lang('Debit') }}</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class="bg-gray">
                                                <td colspan="2">{{ _lang('Total') }}</td>
                                                <td><span id="footer_total_credit"></span></td>
                                                <td><span id="footer_total_debit"></span></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script type="text/javascript" src="{{asset('backend/js/plugins/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('backend/js/plugins/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ asset('backend/js/plugins/select.min.js') }}"></script>
{{-- <script src="{{ asset('backend/js/plugins/buttons.min.js') }}"></script> --}}
<script src="{{ asset('backend/js/plugins/responsive.min.js') }}"></script>
<script src="{{ asset('backend/js/moment.min.js') }}"></script>
<script src="{{ asset('backend/js/picker/daterangepicker.js') }}"></script>
<script src="{{ asset('backend/js/picker/moment-timezone-with-data.min.js') }}"></script>
<script>
        $(document).ready(function(){
        
        // Account Book
        account_book = $('#account_book').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: '{{route('admin.accounting.investment.show',$investment->id)}}',

                        order: [0, 'asc'],
                        "searching": false,
                        columns: [
                            {data: 'operation_date', name: 'operation_date'},
                            {data: 'sub_type', name: 'sub_type'},
                            {data: 'credit', name: 'amount'},
                            {data: 'debit', name: 'amount'}
                        ],
                        "fnDrawCallback": function (oSettings) {
                             $('#footer_total_credit').text(sum_table_col($('#account_book'), 'credit'));
                             $('#footer_total_debit').text(sum_table_col($('#account_book'), 'debit'));
                        }
                    });
    });

        $('#transaction_date_range').daterangepicker(
            $("#transaction_date_range").on('apply.daterangepicker',function(start,end){
                var start = '';
                var end = '';
                if($('#transaction_date_range').val()){
                    start = $('input#transaction_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    end = $('input#transaction_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
                }
                var transaction_type = $('select#transaction_type').val();
                console.log(transaction_type);
                account_book.ajax.url( '{{route('admin.accounting.investment.show',$investment->id)}}?start_date=' + start + '&end_date=' + end + '&type=' + transaction_type ).load();
                
            })
        );

        $('#transaction_type').change( function(){
                var start = '';
                var end = '';
                if($('#transaction_date_range').val()){
                    start = $('input#transaction_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    end = $('input#transaction_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
                }
            var transaction_type = $('select#transaction_type').val();
               account_book.ajax.url( '{{route("admin.accounting.investment.show",[$investment->id])}}?start_date=' + start + '&end_date=' + end + '&type=' + transaction_type ).load();
        });

        $('#transaction_date_range').on('cancel.daterangepicker', function(ev, picker) {
            $('#transaction_date_range').val('');
            account_book.ajax.url( '{{route("admin.accounting.investment.show",[$investment->id])}}' ).load();
        });


    function sum_table_col(table, class_name) {
    var sum = 0;
    table
        .find('tbody')
        .find('tr')
        .each(function() {
            if (
                parseFloat(
                    $(this)
                        .find('.' + class_name)
                        .data('orig-value')
                )
            ) {
                sum += parseFloat(
                    $(this)
                        .find('.' + class_name)
                        .data('orig-value')
                );
            }
        });

    return sum;
}
</script>
@endpush