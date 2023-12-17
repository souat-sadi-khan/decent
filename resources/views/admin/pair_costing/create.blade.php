@extends('layouts.app', ['title' => _lang('Job Costing'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Job Costing."><i class="fa fa-universal-access mr-4"></i>
        {{_lang('Product Job Costing')}}</h1>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="card card-box border border-primary">
    <div class="card-body">
        <div class="row">
            {{-- Purchase Date: --}}
            <div class="col-md-6 mx-auto form-group">
                <label for="product_id">{{_lang('Product')}}
                </label>
                <div class="input-group">
                    <select class="form-control select" id="product_id">
                        <option value="">Select One</option>
                        @foreach ($products as $element)
                        <option value="{{ $element->id }}">{{ $element->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-6 mx-auto text-center">
                
                <button type="button" class="btn btn-primary btn-sm w-100" id="check_it">Get Product Material</button>
                <button type="button" class="btn btn-sm btn-info w-100" id="checking" style="display: none;">
                <i class="fa fa-spinner fa-spin fa-fw"></i>Checking...</button>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="car-body">
        <div id="data"></div>
    </div>
</div>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script>
$('.select').select2();
$(document).on('click', '#check_it', function () {
    $("#check_it").hide();
    $('#checking').show();
    var url = "{{ route('admin.paircosting.create') }}";
    var product_id = $("#product_id").val();
    if (product_id =="") {
      toastr.error("Select Product first");
       $("#check_it").show();
       $('#checking').hide();
    }else{
        $.ajax({
            url: url,
            data: {
            product_id:product_id
            },
            type: 'Get',
            dataType: 'html'
        })
    .done(function (data) {
          $("#check_it").show();
          $('#checking').hide();
          $('#data').html(data);
          $("#data").find('.select_custom').select2();
          _classformValidation();
    })
  }
});
</script>
@endpush