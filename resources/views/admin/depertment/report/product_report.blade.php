@extends('layouts.app', ['title' => _lang('Depertment Product Report'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Depertment Store Request."><i class="fa fa-universal-access mr-4"></i>
            {{_lang('Depertment Product Report')}}</h1>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<form action="{{route('admin.report.store')}}" method="post" class="ajax_form"
    enctype="multipart/form-data">
    @csrf
    <div class="card card-box border border-primary">
        <div class="card-body">
            <div class="row">

                {{-- Purchase Date: --}}
                   <div class="col-md-6 form-group">
                    <label for="department_id">{{_lang('Depertment')}}
                    </label>
                    <div class="input-group">
                        <select class="form-control select" data-placeholder="Select Depertment" name="department_id" id="department_id">
                            <option value="">Select One</option>
                            @foreach ($depertments as $depert)
                                <option value="{{ $depert->id }}">{{ $depert->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6 form-group" id="work_order">
                    <label for="work_order_id">{{_lang('WorkOrder')}}
                    </label>
                    <div class="input-group">
                        <select class="form-control select" data-placeholder="Select Work Order" name="work_order_id" id="work_order_id"  data-url="">
                            <option value="">Select One</option>
                            @foreach ($orders as $order)
                                <option value="{{ $order->id }}">{{ $order->prefix}}-{{  $order->code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

                <div class="row mt-2">
                         <div class="col-md-6 mx-auto text-center">
                            
                            <button type="button" class="btn btn-primary btn-sm w-100" id="check_it">Get Product InWorkOrder</button>
                            <button type="button" class="btn btn-sm btn-info w-100" id="checking" style="display: none;">
                            <i class="fa fa-spinner fa-spin fa-fw"></i>Checking...</button>
                        </div>
                    </div> <br> <hr>
                <div class="row" id="data">
                    
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
// $(document).on('change', '#work_order_id,#department_id', function () {
// // it will get action url
// $('.pageloader').show();
//     var url = "";
//     var id = $("#work_order_id").val();
//     var depertment = $("#department_id").val();
//         $.ajax({
//             url: url,
//             data: {
//             id: id,
//             depertment:depertment
//             },
//             type: 'Get',
//             dataType: 'html'
//         })
//     .done(function (data) {
//         $('.pageloader').hide();
//           $('#data').html(data);
//           $("#data").find('.select_custom').select2();
//     })
// });

$(document).on('click', '#check_it', function () {
    $("#check_it").hide();
    $('#checking').show();
    var url = "{{ route('admin.report.get_variation_product') }}";
    var id = $("#work_order_id").val();
    var depertment = $("#department_id").val();
    if (id =="" || depertment =="") {
      toastr.error("Select depertment/WorkOrder first");
       $("#check_it").show();
       $('#checking').hide();
    }else{
        $.ajax({
            url: url,
            data: {
            depertment:depertment,id:id
            },
            type: 'Get',
            dataType: 'html'
        })
    .done(function (data) {
          $("#check_it").show();
          $('#checking').hide();
          $('#data').html(data);
         $("#data").find('.select_custom').select2();
    })
  }
});
_classformValidation();
</script>

@endpush
