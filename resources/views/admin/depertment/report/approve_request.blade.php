@extends('layouts.app', ['title' => _lang('Submit Material Report'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
  <div>
    <h1 data-placement="bottom" title="Approve Request."><i class="fa fa-universal-access mr-4"></i> {{_lang('Submit Material Report')}}</h1>
  </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="row">
    <div class="col-md-12 mx-auto ">
        <div class="card card-box border border-primary">
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-md-6 mx-auto">
                       <input type="text" class="form-control date " id="date"  value="{{ date('Y-m-d') }}" placeholder="Date">
                    </div>
                      <div class="col-md-4">                        
                        <button type="button" class="btn btn-danger text-light btn-sm w-100" id="check_it">Print<i class="fa fa-print"></i></button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="row" id="print_table">
  <div class="col-md-12">
    <div class="tile">
      <div class="tile-title text-center">
        <h3>{{ get_option('institute_name') }}</h3>
        <h4>{{ _lang('Phone') }} :{{ get_option('phone') }}</h4>
        <p>{{ _lang('Submit Uses Everyday Raw Material Report ') }}</p>
      </div>
      <hr>
      <div class="tile-body">
        <form action="{{route('admin.report.material_store')}}" method="post" class="ajax_form" enctype="multipart/form-data">
          <input type="hidden" id="depertment_store_id" name="depertment_store_id" value="{{ $model->id }}">
          <div class="row">
            <table class="table table-bordered">
              <thead class="bg-green text-light">
                <tr>
                  <th width="15%">{{ _lang('Material') }}</th>
                  <th width="10%">{{ _lang('Request') }}</th>
                  <th width="10%">{{ _lang('Approve') }}</th>
                  <th width="10%">{{ _lang('Total Waste') }}</th>
                  <th width="15%">{{ _lang('Total Use') }}</th>
                  <th width="20%">{{ _lang('Remain') }}</th>
                  <th width="15%">{{ _lang('Waste') }}</th>
                </tr>
              </thead>
              <tbody class="bg-gray">
                @foreach ($model->store_request as $element)
                <tr>
                  <td>
                    {{ $element->material->name }}
                    <input type="hidden" name="raw_material_id[]" value="{{ $element->raw_material_id }}">
                    <input type="hidden" name="depertment_id[]" value="{{ $element->depertment_id }}">
                    <input type="hidden" name="store_request_id[]" value="{{ $element->id }}">
                  </td>
                  <td>
                    {{ $element->qty }}
                    {{ $element->material->unit->unit }}
                  </td>
                  <td>
                    <input type="hidden" name="approve_qty[]" value="{{ $element->approve_store_item->sum('qty') }}">
                    {{ $element->approve_store_item->sum('qty') }}
                    {{ $element->material->unit->unit }}
                  </td>
                  <td>
                    <input type="hidden" name="total_waste[]" value="{{ rawMaterialUseQty($element->id)->sum('waste') }}">
                    {{ rawMaterialUseQty($element->id)->sum('waste') }}
                    {{ $element->material->unit->unit }}
                  </td>
                  <td>
                    <div class="input-group mb-3">
                      <input type="text" name="total_use_qty[]" class="form-control" value="{{ rawMaterialUseQty($element->id)->sum('qty') }}" readonly>
                      <div class="input-group-append">
                        <span class="input-group-text">{{ $element->material->unit->unit }}</span>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="input-group mb-3">
                      <input type="text" name="qty[]" class="form-control input_number" value="{{$element->approve_store_item->sum('qty')- (rawMaterialUseQty($element->id)->sum('qty')+rawMaterialUseQty($element->id)->sum('waste')) }}" required>
                      <div class="input-group-append">
                        <span class="input-group-text">{{ $element->material->unit->unit }}</span>
                      </div>
                    </div>
                    
                  </td>
                  <td>
                    <input type="text" name="waste[]" class="form-control input_number" value="">
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="row mt-2">
            <div class="col-md-6 mx-auto text-center">
              <button type="button" class="btn btn-warning text-light d-print-none" onclick="printContent('print_table')">{{ _lang('Print') }} <i class="fa fa-print"></i></button>
              <button type="submit" class="btn btn-primary d-print-none" id="submit">Submit Report</button>
              <button type="button" class="btn btn-info" id="submiting" style="display: none;">
              <i class="fa fa-spinner fa-spin fa-fw"></i>Checking...</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script>
_classformValidation();
_componentDatefPicker();
     function printContent(el) {

        var a = document.body.innerHTML;
        var b = document.getElementById(el).innerHTML;
        document.body.innerHTML = b;
        window.print();
        document.body.innerHTML = a;

    }

  $(document).on('click', '#check_it', function () {
      var depertment_store_id = $("#depertment_store_id").val();
      var date = $("#date").val();
      var url ='/admin/every_matrial_report_print/'+depertment_store_id+'/'+date;
      myFunction(url);
});
</script>
@endpush