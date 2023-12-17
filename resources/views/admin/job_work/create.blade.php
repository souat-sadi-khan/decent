@extends('layouts.app', ['title' => _lang('Job Work'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Job Work."><i class="fa fa-universal-access mr-4"></i> {{_lang('Job Work')}}</h1>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="tile">
  <h3 class="tile-title">
            @can('job_work.create')
            <a data-placement="bottom" title="Create New JobWork" type="button" class="btn btn-info" href ="{{ route('admin.job_work') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i>{{_lang('New Job Work')}}
            </a>
            @endcan

            @can('job_work.view')
            <a data-placement="bottom" title="JobWork List" type="button" class="btn btn-info" href ="{{ route('admin.job_work.index') }}"><i class="fa fa-list-ul" aria-hidden="true"></i>{{_lang('Job Work List')}}
            </a>
            @endcan
    </h3>
    <div class="tile-body">
        <form action="{{ route('admin.job_work_post') }}" method="post" class="ajax_form">
            <div class="row">
                <div class="col-md-6">
                    <label for="department_id">{{_lang('Depertment')}}
                    </label>
                    <div class="input-group">
                        <select class="form-control select" data-placeholder="Select Depertment" name="department_id" id="department_id" required data-parsley-errors-container="#department_id_error">
                            <option value="">Select One</option>
                            @foreach ($depertments as $depert)
                            <option value="{{ $depert->id }}">{{ $depert->name }}</option>
                            @endforeach
                        </select>
                        <span id="department_id_error"></span>
                    </div>
                </div>
                <div class="col-md-6" >
                    <label for="work_order_id">{{_lang('WorkOrder')}}
                    </label>
                    <div class="input-group mb-3">
                        {{-- data-placeholder="Select Workworder" --}}
                        <select class="form-control select"  name="work_order_id" id="work_order_id" class="form-control">
                            <option value="">Select Workorder</option>
                            @foreach ($workorder as $element)
                            <option value="{{ $element->id }}">{{ $element->prefix }}-{{ $element->code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div id="data">
                
            </div>
        </form>
    </div>
</div>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script>
 $('.select').select2();
var loaded =false;
$(document).on('change', '#work_order_id', function () {
// it will get action url
$('.pageloader').show();
    var url = "{{ route('admin.get_job_product') }}";
    var id = $("#work_order_id").val();
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
          $("#data").find('.select_custom').select2();
          if (!loaded) {
          _classformValidation();
          _componentSelect2Normal();
          loaded=true;
      }
        
    })
});
</script>
@endpush