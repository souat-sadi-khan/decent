@extends('layouts.app', ['title' => _lang('Monthly Report'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">

    <div>
        <h1 data-placement="bottom" title="Depertment Store Request."><i class="fa fa-universal-access mr-4"></i>
            {{_lang('Monthly Report')}}</h1>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8 mx-auto">
                  <div class="form-group">
                    {!! Form::label('month', _lang('Please Choose Month') . ':') !!}
                    <div class="input-group">
                        {!! Form::text('month', null, ['class' => 'form-control month', 'readonly','id'=>'month','placeholder' => _lang('Date Range')]) !!}

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12" id="filter_data">
              <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ _lang('Date') }}</th>
                            <th>{{ _lang('Sale') }}</th>
                            <th>{{ _lang('Sale Paid') }}</th>
                            <th>{{ _lang('Sale Due') }}</th>
                            <th>{{ _lang('Purchase') }}</th>
                            <th>{{ _lang('Purchase Paid') }}</th>
                            <th>{{ _lang('Purchase Due') }}</th>
                            <th>{{ _lang('Expense') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                            @for ($i = 1; $i <=$days ; $i++)
                              @php
                                $date =Carbon\Carbon::createFromDate($year, $month, $i);
                                $date = $date->format('Y-m-d');

                                @endphp
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ ovarallreport('Sale',null,null,$date)->sum('net_total') }}</td>
                                <td>{{ ovarallreport('Sale',null,null,$date)->sum('total_paid') }}</td>
                                <td>{{ ovarallreport('Sale',null,null,$date)->sum('net_total') - ovarallreport('Sale',null,null,$date)->sum('total_paid') }}</td>
                                <td>{{ ovarallreport('Purchase',null,null,$date)->sum('net_total') }}</td>
                                <td>{{ ovarallreport('Purchase',null,null,$date)->sum('total_paid') }}</td>
                                <td>{{ ovarallreport('Purchase',null,null,$date)->sum('net_total') - ovarallreport('Purchase',null,null,$date)->sum('total_paid') }}</td>
                                <td>
                                    @role('Super Admin')
                                    @php
                                        $expense=App\models\Expense\Expense::whereDate('date',$date)->sum('amount');
                                    @endphp
                                    @else
                                     @php
                                        $expense=App\models\Expense\Expense::whereDate('date',$date)->where('hidden',false)->sum('amount');
                                    @endphp
                                    @endrole

                                    {{ $expense }}
                                </td>
                            </tr>
                            @endfor
                    </tbody>
                    <tfoot>
                        <tr class="bg-green text-light">
                            <td>{{ _lang('Total') }}</td>
                            <td>{{ ovarallreport('Sale',null,null,null,$month)->sum('net_total') }}</td>
                            <td>{{ ovarallreport('Sale',null,null,null,$month)->sum('total_paid') }}</td>
                            <td>{{ ovarallreport('Sale',null,null,null,$month)->sum('net_total') - ovarallreport('Sale',null,null,null,$month)->sum('total_paid') }}</td>
                            <td>{{ ovarallreport('Purchase',null,null,null,$month)->sum('net_total') }}</td>
                            <td>{{ ovarallreport('Purchase',null,null,null,$month)->sum('total_paid') }}</td>
                            <td>{{ ovarallreport('Purchase',null,null,null,$month)->sum('net_total') - ovarallreport('Purchase',null,null,null,$month)->sum('total_paid') }}</td>
                             <td>
                                @role('Super Admin')
                                    @php
                                        $expense_month=App\models\Expense\Expense::whereMonth('date',$month)->sum('amount');
                                    @endphp
                                    @else
                                     @php
                                        $expense_month=App\models\Expense\Expense::whereMonth('date',$month)->where('hidden',false)->sum('amount');
                                    @endphp
                                 @endrole
                                    {{ $expense_month }}
                             </td>
                        </tr>
                    </tfoot>
                </table>
              </div>
          </div>
        </div>
            <div class="row mt-2">
                <div class="col-md-6 mx-auto text-center">
                    <button type="button" onclick="printContent('filter_data')" class="btn btn-primary btn-lg w-100">{{ _lang('Print') }}</button>
                </div>
            </div>
    </div>
</div>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script>
_componentMonthPicker();
        $('#month').change( function() {
            var month=$(this).val();
            $('.pageloader').show();
        $.ajax({
            type: 'GET',
            url: '/admin/report/monthly',
            data: {
                month: month
            },
            dateType: 'html',
            success: function(data) {
                $('.pageloader').hide();
                $("#filter_data").html();
                $("#filter_data").html(data);
            }
        });
        });
function printContent(el){
    var restorepage = document.body.innerHTML;
    var printcontent = document.getElementById(el).innerHTML;
    document.body.innerHTML = printcontent;
    window.print();
    document.body.innerHTML = restorepage;
    // window.close();
}
</script>
@endpush
