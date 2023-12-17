@extends('layouts.app', ['title' => _lang('Update Job Costing'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Update Job Costing."><i class="fa fa-universal-access mr-4"></i>
        {{_lang('Product Job Costing')}}</h1>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="card card-box border border-primary">
    <div class="card-body">
<form action="{{ route('admin.paircosting.update',$model->id) }}" class="ajax_form" method="put">
    @method('PUT')
    <input type="hidden" name="product_id" value="{{ $model->id }}">
    <div class="row">
    <div class="col-md-12">
        <table class="table bg-green" id="item">
            <thead>
                <tr>
                    <th width="20%">{{ _lang('Component') }}</th>
                    <th width="20%">{{ _lang('Material Des') }}</th>
                    <th width="20%">{{ _lang('Consumstion') }}</th>
                    <th width="10%">{{ _lang('Unit') }}</th>
                    <th width="15%">{{ _lang('Unit Cost') }}</th>
                    <th width="15%">{{ _lang('Cost/PR') }}</th>
                </tr>
            </thead>
            <tbody class="bg-gray">
                @php
                    
                @endphp
                @foreach ($model->cost_material as $element)
                 <tr>
                    <td>
                        <input type="hidden" name="ingredients_category_id[]" value="{{ $element->ingredients_category_id }}">
                        {{ $element->category->name }}
                    </td>

                    <td>
                     <select name="raw_material_id[]" class="form-control select raw_material_id">
                        <option value="">Select Material</option>
                        @foreach ($materials as $raw)
                            <option {{ $element->raw_material_id==$raw->id?'selected':'' }} value="{{ $raw->id }}">{{ $raw->name }}</option>
                        @endforeach
                     </select>
                    </td>
                    <td>
                        <input type="text" name="consumstion[]" class="form-control consumstion input_number"  value="{{ $element->consumstion }}" />
                    </td>
                    <td>
                        <input type="hidden" name="unit_id[]" class="hidden_unit" value="{{ $element->unit_id }}">
                        <span class="unit">{{ $element->unit_name?$element->unit_name->unit:'' }}</span>
                    </td>
                    <td>
                        <input type="text" name="unit_cost[]" class="form-control unit_cost input_number" value="{{ $element->unit_cost }}" />
                    </td>

                    <td>
                        <input type="text" name="cost_pr[]" class="form-control cost_pr input_number"  value="{{ $element->cost_pr }}"/>
                    </td>

                 </tr>
 
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-6"></div>
    <div class="col-md-6">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ _lang('Total Material Cost') }}</th>
                    <th>
                        <input type="text" name="total_material_cost" class="form-control total_material_cost input_number" id="total_material_cost" readonly value="{{ $model->total_material_cost }}" />
                    </th>
                </tr>
                <tr>
                    <th>
                        {{ _lang('Rejection') }}%
                        <input type="text" name="rejection" class="form-control w-50 profit input_number d-inline-block ml-2" id="rejection" value="{{ $model->rejection }}" />
                    </th>
                    <th>
                        <input type="text" name="rejection_amt" class="form-control rejection_amt input_number" id="rejection_amt" value="{{ $model->rejection_amt }}"  readonly />
                    </th>
                </tr>

                <tr>
                    <th>{{ _lang('Overhead') }}</th>
                    <th>
                        <input type="text" name="overhead" class="form-control overhead input_number" value="{{ $model->overhead }}" id="overhead" />
                    </th>
                </tr>

                <tr>
                    <th>
                    {{ _lang('Profit') }}% 
                    <input type="text" name="profit_percent" class="form-control w-50 profit input_number d-inline-block ml-2" value="{{ $model->profit }}" id="profit" />
                   </th>
                    <th>
                        <input type="text" name="profit_amt" class="form-control profit_amt input_number" value="{{ $model->profit_amt }}" id="profit_amt" readonly />
                    </th>
                </tr>
                <tr>
                    <th>{{ _lang('Commercial') }}</th>
                    <th>
                        <input type="text" name="commercial" class="form-control commercial input_number" id="commercial" value="{{ $model->commercial }}" />
                    </th>
                </tr>
                <tr>
                    <th>{{ _lang('Grand Total CM') }}</th>
                    <th>
                        <input type="text" name="grand_total" class="form-control grand_total input_number" id="grand_total" readonly value="{{ $model->grand_total }}" />
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@can('paircosting.create')
<div class="row mt-2">
    <div class="col-md-6 mx-auto text-center">
        
        <button type="submit" class="btn btn-primary btn-sm w-100" id="submit">{{ _lang('Update Job Cost') }}</button>
        <button type="button" class="btn btn-sm btn-info w-100" id="submiting" style="display: none;">
        <i class="fa fa-spinner fa-spin fa-fw"></i>Checking...</button>
    </div>
</div>
@endcan
</form>
    </div>
</div>

<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script>
    _classformValidation();
$('.select').select2();
$("#item").delegate(".consumstion,.unit_cost,.cost_pr", "keyup", function() {
    var tr = $(this).parent().parent();
    if (tr.find(".consumstion").val() !='') {
    tr.find(".cost_pr").val(tr.find(".consumstion").val() * tr.find(".unit_cost").val());
     }
    calculate();
})

$("#item").delegate(".raw_material_id", "change", function() {
  var tr = $(this).parent().parent();
  var raw =tr.find(".raw_material_id").val();
  $.ajax({
    url: '/admin/paircosting/unit',
    data: {
    raw:raw
    },
    type: 'Get',
    dataType: 'json'
  })
   .done(function (data) {
    tr.find(".unit").text('');
    tr.find(".unit").text(data.unit.unit);
    tr.find(".hidden_unit").val('');
    tr.find(".hidden_unit").val(data.unit_id);
    })
})

function calculate() {
  
  var total_material_cost=0;

  $(".cost_pr").each(function() {
    total_material_cost = total_material_cost + ($(this).val() * 1);
  })

   grand_total = total_material_cost;
   $(".total_material_cost").val(total_material_cost);

   var rejection =percent(total_material_cost,'rejection');
   $('#rejection_amt').val(rejection);
   grand_total=total_material_cost+rejection;
   var overhead =overheadd();
   grand_total=grand_total+overhead;
   var profit =percent(grand_total,'profit');
   $('#profit_amt').val(profit);
   grand_total=grand_total+profit;
   var commercial =commerciall();
   grand_total=grand_total+commercial;
   $('#grand_total').val(grand_total).toFixed(2);
   // console.log(rejection);

}

    function percent(total_amount,type) {
        var calculation_type = 'percentage';
        var calculation_amount = __read_number($('#'+type));

        var parcent = __calculate_amount(calculation_type, calculation_amount, total_amount);
        return parcent;
    }

    function __read_number(input_element, use_page_currency = false) {
        return input_element.val();
    }

function __calculate_amount(calculation_type, calculation_amount, amount) {
    var calculation_amount = parseFloat(calculation_amount);
    calculation_amount = isNaN(calculation_amount) ? 0 : calculation_amount;

    var amount = parseFloat(amount);
    amount = isNaN(amount) ? 0 : amount;

    switch (calculation_type) {
        case 'fixed':
            return parseFloat(calculation_amount);
        case 'percentage':
            return parseFloat((calculation_amount / 100) * amount);
        default:
            return 0;
    }
}

function overheadd()
{
  var overhead =parseFloat($('#overhead').val()); 
  return isNaN(overhead) ? 0 : overhead;;
   
}

function commerciall()
{
  var commercial =parseFloat($('#commercial').val()); 
  return isNaN(commercial) ? 0 : commercial;;
   
}


$("#rejection,#overhead,#profit,#commercial").on('keyup blur change', function () {
   calculate();
});
</script>
@endpush