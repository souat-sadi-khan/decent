@extends('layouts.app', ['title' => _lang('Trail Balance'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Depertment Store Request."><i class="fa fa-universal-access mr-4"></i>
        {{_lang('Trail Balance')}}</h1>
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
                    {!! Form::label('end_date', _lang('Date Range') . ':') !!}
                    <div class="input-group">
                        {!! Form::text('end_date', date('Y-m-d'), ['class' => 'form-control date', 'readonly','id'=>'end_date','placeholder' => _lang('Date Range')]) !!}

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                 <table class="table table-border-center-col no-border table-pl-12" id="trial_balance_table">
                <thead>
                    <tr class="bg-gray">
                        <th>{{ _lang('Trail Balance') }}</th>
                        <th>{{ _lang('Credit') }}</th>
                        <th>{{ _lang('Debit') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>{{ _lang('Supplier Due') }}:</th>
                        <td>&nbsp;</td>
                        <td>
                            <input type="hidden" id="hidden_supplier_due" class="debit">
                            <span class="remote-data" id="supplier_due">
                                <i class="fa fa-refresh fa-spin fa-fw"></i>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>{{ _lang('Customer Due') }}:</th>
                        <td>
                            <input type="hidden" id="hidden_customer_due" class="credit">
                            <span class="remote-data" id="customer_due">
                                <i class="fa fa-refresh fa-spin fa-fw"></i>
                            </span>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <th>{{ _lang('Account Balance') }}:</th>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>

                </tbody>
                <tbody id="account_balances_details">
                </tbody>
                 <tr>
                        <th>{{ _lang('Investment Balance') }}:</th>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                <tbody id="invest_account_details">
                </tbody>
                <tfoot>
                    <tr class="bg-gray">
                        <th>{{ _lang('Total') }}</th>
                        <td>
                            <span class="remote-data" id="total_credit">
                                <i class="fa fa-refresh fa-spin fa-fw"></i>
                            </span>
                        </td>
                        <td>
                            <span class="remote-data" id="total_debit">
                                <i class="fa fa-refresh fa-spin fa-fw"></i>
                            </span>
                        </td>
                    </tr>
                </tfoot>
            </table>
            </div>
        </div>
    </div>
</div>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')

<script>
        $(document).ready( function(){
        //Date picker
        _componentDatefPicker();
        update_trial_balance();

        $('#end_date').change( function() {
            update_trial_balance();
            $('#hidden_date').text($(this).val());
        });

 
    });

    function update_trial_balance(){
        var loader = '<i class="fa fa-refresh fa-spin fa-fw"></i>';
        $('span.remote-data').each( function() {
            $(this).html(loader);
        });

        $('table#trial_balance_table tbody#capital_account_balances_details').html('<tr><td colspan="3"><i class="fa fa-refresh fa-spin fa-fw"></i></td></tr>');
        $('table#trial_balance_table tbody#account_balances_details').html('<tr><td colspan="3"><i class="fa fa-refresh fa-spin fa-fw"></i></td></tr>');

        var end_date = $('input#end_date').val();
        $.ajax({
            url: "{{route('admin.report.trail_balance')}}?end_date=" + end_date,
            dataType: "json",
            success: function(result){
                $('span#supplier_due').text(result.supplier_due.toFixed(2));
                $('input#hidden_supplier_due').val(result.supplier_due);

                $('span#customer_due').text(result.customer_due.toFixed(2));
                $('input#hidden_customer_due').val(result.customer_due);

                var account_balances = result.account_balances;
                $('table#trial_balance_table tbody#account_balances_details').html('');
                for (var key in account_balances) {
                    var accnt_bal = result.account_balances[key];
                    var accnt_bal_with_sym = result.account_balances[key];
                    var account_tr = '<tr><td class="pl-20-td">' + key + ':</td><td><input type="hidden" class="credit" value="' + accnt_bal + '">' + accnt_bal_with_sym + '</td><td>&nbsp;</td></tr>';
                    $('table#trial_balance_table tbody#account_balances_details').append(account_tr);
                }

                 var investmet_details = result.investmet_details;
                $('table#trial_balance_table tbody#invest_account_details').html('');
                for (var key in investmet_details) {
                    var accnt_bal = result.investmet_details[key];
                    var accnt_bal_with_sym = result.investmet_details[key];
                    var account_tr = '<tr><td class="pl-20-td">' + key + ':</td><td>&nbsp;</td><td><input type="hidden" class="debit" value="' + accnt_bal + '">' + accnt_bal_with_sym + '</td></tr>';
                    $('table#trial_balance_table tbody#invest_account_details').append(account_tr);
                }

                var capital_account_details = result.capital_account_details;
                $('table#trial_balance_table tbody#capital_account_balances_details').html('');
                for (var key in capital_account_details) {
                    var accnt_bal = result.capital_account_details[key];
                    var accnt_bal_with_sym = result.capital_account_details[key];
                    var account_tr = '<tr><td class="pl-20-td">' + key + ':</td><td><input type="hidden" class="credit" value="' + accnt_bal + '">' + accnt_bal_with_sym + '</td><td>&nbsp;</td></tr>';
                    $('table#trial_balance_table tbody#capital_account_balances_details').append(account_tr);
                }

                var total_debit = 0;
                var total_credit = 0;
                $('input.debit').each( function(){
                    total_debit += parseFloat($(this).val());
                });
                $('input.credit').each( function(){
                    total_credit += parseFloat($(this).val());
                });

                $('span#total_debit').text(total_debit.toFixed(2));
                $('span#total_credit').text(total_credit.toFixed(2));
            }
        });
    }
</script>
@endpush