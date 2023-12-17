@extends('layouts.app', ['title' => _lang('Yearly Report'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Depertment Store Request."><i class="fa fa-universal-access mr-4"></i>
                {{_lang('Yearly Report')}}</h1>
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
                        {!! Form::label('year', _lang('Please Choose Year') . ':') !!}
                        <div class="input-group">
                            {!! Form::text('year', null, ['class' => 'form-control year',
                            'readonly','id'=>'year','placeholder' => _lang('Date Range')]) !!}


                        </div>
                    </div>
                </div>
            </div>


            <div id="print_table" class="card-body">
            <span class="text-center">
                <h3><b class="text-uppercase">{{ get_option('company_name') }}</b></h3>
                <h5>Yearly Report </h5>
                <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>

            </span>
                <div class="text-center col-md-12">
                    <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
                        class="bg-success text-light">
                        <b>Yearly Report</b></h4>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>

                                <p style="margin:0px ; margin-top: -8px;">

                                    Report Of Date : <span class="ml-1">{{ formatDate(date('Y-m-d'))}}</span>

                                </p>

                            </td>
                            <td class="text-center">

                            </td>
                            <td class="text-right">
                                <p style="margin:0px ; margin-top: -8px;">Printing Date :
                                    <span></span> {{ date('d F, Y') }} </span></p>
                                <p style="margin:0px ; margin-top: -4px;">Time :
                                    <span></span>{{date('h:i:s A')}}</span></p>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                @php
                    $months = array(01 => 'Jan.', 02 => 'Feb.', 03 => 'Mar.', 04 => 'Apr.', 05 => 'May', 06 => 'Jun.', 07 =>
                    'Jul.', '08' => 'Aug.', '09' => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
                @endphp
                <div class="table-responsive">
                    <table class="table table-hover table-sm table-bordered content_managment_table">

                        <thead>
                        <tr>
                            <th>{{ _lang('Month') }}</th>
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

                        @foreach ($months as $key=> $element)

                            <tr>
                                <td>{{ $element }}</td>
                                <td>{{ ovarallreport('Sale',null,null,null,$key,$year)->sum('net_total') }}</td>
                                <td>{{ ovarallreport('Sale',null,null,null,$key,$year)->sum('total_paid') }}</td>
                                <td>{{ ovarallreport('Sale',null,null,null,$key,$year)->sum('net_total') - ovarallreport('Sale',null,null,null,$key,$year)->sum('total_paid') }}
                                </td>
                                <td>{{ ovarallreport('Purchase',null,null,null,$key,$year)->sum('net_total') }}</td>
                                <td>{{ ovarallreport('Purchase',null,null,null,$key,$year)->sum('total_paid') }}</td>
                                <td>{{ ovarallreport('Purchase',null,null,null,$key,$year)->sum('net_total') - ovarallreport('Purchase',null,null,null,$key,$year)->sum('total_paid') }}
                                </td>
                                <td>
                                    @role('Super Admin')
                                    @php
                                        $expense=App\models\Expense\Expense::whereMonth('date',$key)->whereYear('date',$year)->sum('amount');
                                    @endphp
                                    @else
                                        @php
                                            $expense=App\models\Expense\Expense::whereMonth('date',$key)->whereYear('date',$year)->where('hidden',false)->sum('amount');
                                        @endphp
                                        @endrole
                                        {{ $expense }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr class="bg-green text-light">
                            <td>{{ _lang('Total') }}</td>
                            <td>{{ ovarallreport('Sale',null,null,null,null,$year)->sum('net_total') }}</td>
                            <td>{{ ovarallreport('Sale',null,null,null,null,$year)->sum('total_paid') }}</td>

                            <td>{{ ovarallreport('Sale',null,null,null,null,$year)->sum('net_total') - ovarallreport('Sale',null,null,null,null,$year)->sum('total_paid') }}
                            </td>
                            <td>{{ ovarallreport('Purchase',null,null,null,null,$year)->sum('net_total') }}</td>
                            <td>{{ ovarallreport('Purchase',null,null,null,null,$year)->sum('total_paid') }}</td>
                            <td>{{ ovarallreport('Purchase',null,null,null,null,$year)->sum('net_total') - ovarallreport('Purchase',null,null,null,null,$year)->sum('total_paid') }}
                            </td>
                            <td>
                                @role('Super Admin')
                                @php
                                    $expense_key=App\models\Expense\Expense::whereYear('date',$year)->sum('amount');
                                @endphp
                                @else
                                    @php
                                        $expense_key=App\models\Expense\Expense::whereYear('date',$year)->where('hidden',false)->sum('amount');
                                    @endphp
                                    @endrole
                                    {{ $expense_key }}
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

                <br>
                {{-- <h5>In Words: {{ucwords($in_words)}} Taka Only.</h5> --}}
                <br><br><br>

                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-4 text-center">
                        <hr class="border-dark">
                        <p> Chief Cashier </p>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-4 text-center">
                        <hr class="border-dark">
                        <p> Manager </p>
                    </div>
                    <div class="col-md-1"></div>


                </div>
            </div>

            <div class="text-center mb-3">


                @php
                    $print_table = 'print_table';

                @endphp

                <a class="text-light btn-primary btn" onclick="printContent('{{ $print_table }}')" name="print"
                   id="print_receipt">
                    <i class="fa fa-print" aria-hidden="true"></i>
                    Print Report

                </a>
            </div>
        </div>
    </div>



    <!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
    <script>


        _componentYearPicker();
        $('#year').change(function () {
            var year = $(this).val();
            $('.pageloader').show();
            $.ajax({
                type: 'GET',
                url: '/admin/report/yearly',
                data: {
                    year: year
                },
                dateType: 'html',

                success: function (data) {
                    $('.pageloader').hide();
                    $("#filter_data").html();
                    $("#filter_data").html(data);
                }
            });

        });

        function printContent(el) {
            console.log('print clicked');

            var a = document.body.innerHTML;
            var b = document.getElementById(el).innerHTML;
            document.body.innerHTML = b;
            window.print();
            document.body.innerHTML = a;

            return window.location.reload(true);

        }
    </script>
@endpush
