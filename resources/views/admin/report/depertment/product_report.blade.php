@extends('layouts.app', ['title' => _lang('Product Report'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Product Report."><i class="fa fa-universal-access mr-4"></i>
                {{_lang('Report')}}</h1>
        </div>
    </div>
@stop
{{-- Main Section --}}
@section('content')
    <!-- Basic initialization -->
    <div class="card">
        <div class="card-header">
            <h6>{{_lang('Product Report')}}</h6>
        </div>
        <div class="card-body">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="depertment_id">{{_lang('Depertment')}}</label>
                      <select name="depertment_id" id="depertment_id" class="form-control select">
                          @foreach ($depertments as $element)
                              <option value="{{ $element->id }}">{{ $element->name }}</option>
                          @endforeach
                      </select>
                    </div>
    
                    <div class="col-md-4 form-group">
                        <label for="work_order_id">{{_lang('Work Order')}}</label>
                      <select name="work_order_id" id="work_order_id" class="form-control select">
                          <option value="All">All Work Order</option>
                          @foreach ($orders as $order)
                              <option value="{{ $order->id }}">{{ $order->prefix}}-{{  $order->code }}</option>
                          @endforeach
                      </select>
                    </div>
    
                    <div class="col-md-4 form-group">
                        <label for="user_id">{{_lang('User')}}</label>
                      <select name="user_id" id="user_id" class="form-control select">
                          <option value="All">All User</option>
                          @foreach ($users as $user)
                              <option value="{{ $user->id }}">{{ $user->email }}</option>
                          @endforeach
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
                        <button data-url="{{route('admin.report.depertment.get_product_report')}}" type="button" id="submit" class="btn btn-block btn-info">{{ _lang('Get  Report') }}</button>
                         <button style="display: none;" type="button" id="submiting" class="btn btn-block btn-info" disabled>{{ _lang('Processing...') }}</button>
                    </div>
                </div>
        </div>
    </div>
    <div class="card mt-3">
    <div class="card-header">Requested Report</div>
    <div id="report_data" class="card-body">

    </div>
</div>
    <!-- /basic initialization -->
@stop
{{-- Script Section --}}

@push('scripts')
<script>
$('.select').select2();
_componentDatefPicker();

$(function() {
    $('#submit').hide();
    $('#submiting').show();
    var depertment_id = $('#depertment_id').val();
    var work_order_id = $('#work_order_id').val();
    var user_id = $('#user_id').val();
    var sDate = $('#sDate').val();
    var eDate = $('#eDate').val();


    get_data(depertment_id,work_order_id, sDate, eDate);
});

$('#submit').click(function() {
    $('#submit').hide();
    $('#submiting').show();
    var depertment_id = $('#depertment_id').val();
    var work_order_id = $('#work_order_id').val();
    var user_id = $('#user_id').val();
    var sDate = $('#sDate').val();
    var eDate = $('#eDate').val();


    get_data(depertment_id,work_order_id,user_id, sDate, eDate);
});

function get_data(depertment_id,work_order_id,user_id, sDate, eDate) {
    var url = $('#submit').data('url');
    
    $.ajax({
        url: url,
        data: {
            depertment_id: depertment_id,
            work_order_id: work_order_id,
            user_id: user_id,
            sDate: sDate,
            eDate: eDate
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

