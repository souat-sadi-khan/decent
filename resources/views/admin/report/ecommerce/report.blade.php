@extends('layouts.app', ['title' => _lang('Ecommerce Order Report'), 'modal' => 'xl'])
@push('admin.css')
    <link rel="stylesheet" href="{{asset('backend/css/daterangepicker.css')}}">
@endpush
{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="E-Commerce Order Report."><i class="fa fa-shopping-cart mr-4"></i> {{_lang('E-Commerce Order Report')}}</h1>
            <p>{{_lang('View all request for E-Commerce Order List')}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('ecommerce-ordeer-list') }}
        </ul>
    </div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h4 class="tile-title">
                    {{_lang('Search Order List Report')}}
                </h4>
                <div class="tile-body">

                    <div class="row">
                        <div class="col-md-8 mx-auto form-group">
                            <label for="status">{{_lang('Employee')}}</label>
                            <select name="status" id="status" class="form-control select">
                                <option value="all">{{_lang('All Order')}}</option>
                                <option value="pending">{{_lang('Pending')}}</option>
                                <option value="confirm">{{_lang('Confirm')}}</option>
                                <option value="progressing">{{_lang('In Progressing')}}</option>
                                <option value="shipment">{{_lang('In Shipment')}}</option>
                                <option value="success">{{_lang('Success')}}</option>
                                <option value="cancel">{{_lang('Cancel')}}</option>
                                <option value="return">{{_lang('Return')}}</option>
                                <option value="payment_done">{{_lang('Payment Done')}}</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 form-group">
                            <label for="sDate">{{_lang('Start Date')}}</label>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" class="form-control date" name="sDate" id="sDate" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="eDate">{{_lang('End Date')}}</label>
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" class="form-control date" name="eDate" id="eDate" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-md-6 mx-auto">
                            <button data-url="{{ route('admin.report.ecommerce_report_date_wise')}} " type="button" id="submit" class="btn btn-block btn-info">{{ _lang('Get Sales Report') }}</button>
                            <button style="display: none;" type="button" id="submiting" class="btn btn-block btn-info" disabled>{{ _lang('Processing...') }}</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">Requested Report</div>
        <div id="report_data" class="card-body">
    
        </div>
    </div>
@stop

{{-- Script Section --}}
@push('scripts')
    <script>
        $('.select').select2();
        _componentDatefPicker();

        $(function() {
            $('#submit').hide();
            $('#submiting').show();
            var status = $('#status').val();
            var start_date = $('#sDate').val();
            var end_date = $('#eDate').val();

            get_data(status, start_date, end_date);
        });

        $('#submit').click(function() {
            $('#submit').hide();
            $('#submiting').show();
            var status = $('#status').val();
            var start_date = $('#sDate').val();
            var end_date = $('#eDate').val();


            get_data(status, start_date, end_date);
        });

        function get_data(status, start_date, end_date) {
            var url = $('#submit').data('url');
            $.ajax({
                url: url,
                data: {
                    status: status,
                    start_date: start_date,
                    end_date: end_date
                },
                type: 'POST',
                dataType: 'html'
            })
            .done(function(data) {
                $('#report_data').html(data);
                toastr.success('Report Genarate');
                $('#submit').show();
                $('#submiting').hide();
            });
        }
    </script>
@endpush