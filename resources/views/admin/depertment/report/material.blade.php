@extends('layouts.app', ['title' => _lang('Depertment Material Report'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Depertment Store Request."><i class="fa fa-universal-access mr-4"></i>
        {{_lang('Depertment Material Report')}}</h1>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<p class="text-right"> 
{{-- <a class="btn btn-danger mb-2" href="{!!  url()->previous() !!}"><i class="fa fa-backward" aria-hidden="true"></i>{{ _lang('Go Back') }}</a>
</p> --}}
<form action="{{route('admin.report.store')}}" method="post" class="ajax_form"
    enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            <h6>{{_lang('Depertment Material Report ')}}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Purchase Date: --}}

                <div class="col-md-5 mx-auto form-group">
                    <label for="department_id">{{_lang('Depertment')}}
                    </label>
                        <select class="form-control select"  name="department_id" id="department_id">
                            <option value="">Select One</option>
                            @foreach ($depertments as $depert)
                            <option value="{{ $depert->id }}">{{ $depert->name }}</option>
                            @endforeach
                        </select>
                        </div>
                          <div class="col-md-5 mx-auto form-group">
                            <label for="dstore_id">{{_lang('Store ID')}}
                            </label>
                                <select class="form-control select"  name="dstore_id" id="dstore_id">
                                    <option value="">Select One</option>
                                   
                                </select>
                        </div>
                    </div>

                <div class="row mt-2">
                         <div class="col-md-6 mx-auto text-center">
                            
                            <button type="button" class="btn btn-primary btn-sm w-100" id="check_it">Get Store Request List</button>
                            <button type="button" class="btn btn-sm btn-info w-100" id="checking" style="display: none;">
                            <i class="fa fa-spinner fa-spin fa-fw"></i>Checking...</button>
                        </div>
                    </div>
        </div>
    </div>
    <div id="data">
        
    </div>
</form>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script type="text/javascript" src="{{asset('backend/js/plugins/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('backend/js/plugins/dataTables.bootstrap.min.js')}}"></script>
<script>
$('.select').select2();
$(document).on('click', '#check_it', function () {
    $("#check_it").hide();
    $('#checking').show();
    var url = "{{ route('admin.report.get_depertment_material') }}";
    var depertment = $("#department_id").val();
    var dstore_id = $("#dstore_id").val();
        $.ajax({
            url: url,
            data: {
            depertment:depertment,dstore_id:dstore_id
            },
            type: 'Get',
            dataType: 'html'
        })
    .done(function (data) {
          $("#check_it").show();
          $('#checking').hide();
          $('#data').html(data);
          $(".example").DataTable({
            searching: true
          });
    })
});

    $(document).on('change', '#department_id', function() {
    var department_id = $(this).val();
    $.ajax({
        type: 'GET',
        url: '/admin/get_dstore_id',
        data: {
            department_id: department_id
        },
        dateType: 'json',
        success: function(data) {
            $('#dstore_id').html("");
            $('#dstore_id').append($('<option>').text("All Store Request").attr('value', ""));
            $.each(data, function(i, dstore) {
                $('#dstore_id').append($('<option>').text(dstore.dstore_id+'('+dstore.request_date+')').attr('value', dstore.id));
            });
        }
    });
});
_classformValidation();
</script>
@endpush