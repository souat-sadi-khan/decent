@extends('layouts.app', ['title' => _lang('Purchase Received'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Purchase Received."><i class="fa fa-universal-access mr-4"></i>
        {{_lang('Purchase Received')}}</h1>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<form action="{{ route('admin.purchase.received',$model->id) }}" class="ajax_form">
    @method('PUT')
    <div class="card card-box border border-primary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <address>
                        <strong>{{_lang('Employee')}} :
                        {{$model->employee ? $model->employee->name : ''}}({{$model->employee ? $model->employee->prefix : ''}}-{{$model->employee ? $model->employee->code : ''}})</strong>
                        <br>
                        {{_lang('Address')}} : {{$model->employee ? $model->employee->present_address_line_1 : ''}}<br>
                        {{_lang('Mobile')}} : {{$model->employee ? $model->employee->contact_number : ''}}<br>
                    </address>
                </div>
                <div class="col-md-4">
                    <address>
                        <strong>{{_lang('Supplier')}} :
                        {{$model->client ? $model->client->name : ''}}</strong>
                        <br>
                        {{_lang('Email')}} : {{$model->client ? $model->client->email : ''}}<br>
                        {{_lang('Mobile')}} : {{$model->client ? $model->client->mobile : ''}}<br>
                    </address>
                </div>
                <div class="col-md-4">
                    <address>
                        <strong>{{_lang('Reference')}} :
                        {{$model->reference_no}}</strong>
                        <br>
                        {{_lang('Status')}} : {{$model->status}}<br>
                        </strong>
                    </address>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="25%">Product/Material</th>
                                <th width="20%">Order Quantity</th>
                                <th width="10%">Unit</th>
                                <th width="20%">Received Qty</th>
                                <th width="25%">Quantity</th>
                            </tr>
                        </thead>
                        <tbody id="data">
                            @foreach ($model->purchase as $item)
                            <tr>
                                <td>
                                    {{  $item->material?$item->material->name:'' }}
                                </td>
                                <td>
                                    <input type="text" class="form-control input_number order" value="{{ $item->order_qty }}" readonly>
                                    <input type="hidden" name="purchase_id[]" value="{{ $item->id }}">
                                    <input type="hidden" name="raw_material_id[]" value="{{ $item->raw_material_id }}">
                                </td>
                                <td>
                                    {{ $item->material?$item->material->unit->unit:'' }}
                                </td>
                                <td>
                                    <input type="text" class="form-control input_number r_qty" value="{{ $item->qty }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control input_number qty" name="qty[]" value="{{$item->order_qty-$item->qty }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <label for="purchase_status">{{_lang('Purchase Status:')}}
                    </label>
                    <select class="form-control select" data-placeholder="Select Status" name="status" id="status" class="form-control select">
                        <option {{ $model->status=='Received'?'selected':'' }} value="Received">{{_lang('Received')}}</option>
                        <option {{ $model->status=='Ordered'?'selected':'' }} value="Ordered">{{_lang('Ordered')}}</option>
                        <option {{ $model->status=='Pending'?'selected':'' }} value="Pending">{{_lang('Pending')}}</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <br>
                    <small class="text-danger">If Submitted Then Add Stock Value of This Raw Material</small>
                    <button type="submit" id="submit" class="btn btn-primary btn-sm w-100">{{ _lang('Submitted') }}</button>
                    <button type="button" class="btn btn-info btn-sm w-100" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script>
    $('document').ready(function(){
        var t =totall();
        if (t==0) {
            $('#submit').prop('disabled', true);
        }
    })
    $("#data").delegate('.qty', 'keyup blur', function () {
      var tr = $(this).parent().parent();
      var qty =tr.find('.qty');
      var t =totall();
      if (t==0) {
        $('#submit').prop('disabled', true);
      }else{
        $('#submit').prop('disabled', false); 
      }
      var order =parseFloat(tr.find('.order').val());
      var r_qty =parseFloat(tr.find('.r_qty').val());
      var remain =order-r_qty;
      var total =parseFloat(qty.val())?parseFloat(qty.val()):0+r_qty;
        if ((total-0) > (order-0))
        {
         toastr.error('Sorry! this much  quantity is not available');
          qty.val(remain);
        }

    })
   _componentSelect2Normal();
   _classformValidation();  

   function totall()
   { 
    var total=0;
        $(".qty").each(function() {
            total = total + ($(this).val() * 1);
        })
     return total;   
   }   
</script>
@endpush