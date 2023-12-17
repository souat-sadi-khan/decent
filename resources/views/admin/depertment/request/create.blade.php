@extends('layouts.app', ['title' => _lang('Store Request'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Store Request."><i class="fa fa-universal-access mr-4"></i> {{_lang('Store Request')}}</h1>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<p class="text-right"> 
{{-- <a class="btn btn-danger" href="{!!  url()->previous() !!}"><i class="fa fa-backward" aria-hidden="true"></i>{{ _lang('Go Back') }}</a> --}}
</p>
<div class="tile">
    <div class="row">
        <div class="col-md-12">
            
            <div class="tile-body">
                <div class="col-md-8 mx-auto" >
                    <div class="input-group mb-3">
                        {{-- data-placeholder="Select Depertment" --}}
                        <select class="form-control select"  name="depertment" id="depertment" class="form-control" data-url="{{ route('admin.request.get_reques_prev') }}">
                            <option value="">Select Depertment</option>
                            @foreach ($depertments as $element)
                            <option value="{{ $element->id }}">{{ $element->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div id="data">
                
            </div>
        </div>
    </div>
</div>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script>
$('.select').select2();
$(document).on('change', '#depertment', function () {
// it will get action url
$('.pageloader').show();
    var url = $(this).data('url');
    var id = $(this).val();
        $.ajax({
            url: url,
            data: {
            id: id
            },
            type: 'Get',
            dataType: 'html'
        })
    .done(function (data) {
        $('.pageloader').hide();
        $('#data').html(data);
    })
});
</script>
@endpush