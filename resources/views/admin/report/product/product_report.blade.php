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
				<div class="col-md-8 mx-auto form-group">
					<label for="product">{{_lang('Product')}}</label>
                  <select name="product" id="product" class="form-control select">
                  	<option value="All">All Product</option>
                  	@foreach ($products as $product)
                  	@if ($product->variation)
          
                  		<option value="{{ $product->product_id }}/{{ $product->variation_id }}">{{ $product->pro_name }}({{ $product->variation }})</option>
                  	@endif
                  	@endforeach
                  </select>
				</div>
				<div class="col-md-6 mx-auto">
					<button data-url="{{route('admin.report.product_report_print')}}" type="button" id="submit" class="btn btn-block btn-sm btn-info">{{ _lang('Get  Report') }}</button>
		             <button style="display: none;" type="button" id="submiting" class="btn btn-block btn-sm btn-info" disabled>{{ _lang('Processing...') }}</button>
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
    var product = $('#product').val();

    get_data(product);
});
$('#submit').click(function() {
    $('#submit').hide();
    $('#submiting').show();
    var product = $('#product').val();

    get_data(product);
   
});

function get_data(product) {
    var url = $('#submit').data('url');
    
    $.ajax({
        url: url,
        data: {
            product: product,
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