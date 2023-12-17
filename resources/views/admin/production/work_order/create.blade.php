@extends('layouts.app', ['title' => _lang('Production Work Order Create'), 'modal' => 'lg'])

{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Work Order for Production."><i class="fa fa-universal-access mr-4"></i>
                {{_lang('Production work order Create')}}</h1>
            <p>{{_lang('Create brand for Production.')}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{Breadcrumbs::render('work-order-create') }}
        </ul>
    </div>
@stop

{{-- Main Section --}}
@section('content')
    <!-- Basic initialization -->
    <form action="{{route('admin.production-work-order.store')}}" method="post" id="content_form"
          enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header">
                <h6>{{_lang('Add New Production work order')}}</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="prefix">{{_lang('Code')}} <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="prefix" id="prefix" class="form-control" placeholder="Prefix"
                                       value="{{$code_prefix}}" required></div>
                            <div class="col-md-8">
                                <input type="text" name="code" id="code" class="form-control" placeholder="Code Here"
                                       required value="{{$uniqu_id}}"></div>
                        </div>
                    </div>

                    {{-- Select  Brand --}}
                    <div class="col-md-4">
                        <label for="brand_id">{{_lang('Select Brand')}}</label>
                        <div class="input-group">
                            <select required data-parsley-errors-container="#brand_id_error" data-placeholder="Select One" name="brand_id" id="brand_id"
                                    class="form-control select_custom brand_append">
                                <option value="">Select One</option>
                                @foreach ($brand as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <span class="btn-modal btn btn-info" id="btn-modal"
                                      data-url="{{ route('admin.remort_brand_modal') }}"
                                      data-container=".brand_modal">+</span>
                            </div>
                        </div>
                        <span id="brand_id_error"></span>
                    </div>

                    {{-- Select  work Order Type --}}
                    <div class="col-md-4 form-group">
                        <label for="type">{{_lang('Work Order Type')}} <span class="text-danger">*</span>
                        </label>
                        <select required data-parsley-errors-container="#work_order_type_error" data-placeholder="Select One" name="type" id="type" class="form-control select">
                            <option value="">Select One</option>
                            <option value="sample">Sample</option>
                            <option value="production">Production</option>
                        </select>
                        <span id="work_order_type_error"></span>
                    </div>

                    {{-- Select Work Order Date --}}
                    <div class="col-md-4 form-group">
                        <label for="date">{{_lang('Work Order date')}}</label>
                        <input type="text" readonly name="date" id="date" class="form-control date"/>
                    </div>

                    {{-- Select Work Order Delivery Date --}}
                    <div class="col-md-4 form-group">
                        <label for="delivery_date">{{_lang('Delivery Date')}}</label>
                        <input type="text" readonly name="delivery_date" id="delivery_date" class="form-control date"/>
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="name">{{_lang('Select Product')}} <span class="text-danger">*</span>
                        </label>
                        <select id="select_product" class="form-control select" data-placeholder="Select A Product">
                            <option value="">Select A Product</option>
                            @foreach ($models as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->articel }}) </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>

            <div class="card-header">
                <h6>{{_lang('Work Order Product For production')}}</h6>
            </div>
            <input type="hidden" value="0" id="row">
            <div class="card-body" >
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped work_order">
                            <thead>
                            <tr>
                                <td class="text-center"> <i class="fa fa-trash-o text-danger" aria-hidden="true"></i> </td>
                                <td>{{_lang('Product Name')}}</td>
                                <td>{{_lang('Quantity')}}</td>
                                <td>{{_lang('Price')}}</td>
                                <td>{{_lang('Sub Total')}}</td>
                            </tr>
                            </thead>
                            <tbody id="item"></tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="4">Total Amount</td>
                                    <td><span id="refresh_net_total">0.00</span> </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    
                    <div class="col-md-12 production_show" style="display: none;">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered border-dark" style="margin-bottom: 0px !important">
                                    <tbody>
                                        <tr>
                                            <td colspan="2">
                                                <span>{{ _lang('Total') }}</span> <br>
                                                <input type="hidden" name="net_total" id="net_total">
                                                <span id="show_net_total">0.00</span>
                                            </td>
                                            <td style="width: 40%">
                                                <span>{{ _lang('Discount Type') }}</span> <br>
                                                <select name="discount_type" class="form-control" id="discount_type">
                                                    <option value="percentage">Percentage</option>
                                                    <option value="fixed">Fixed</option>
                                                </select>
                                            </td>
                                            <td>
                                                <span>{{ _lang('Discount') }}</span> <br>
                                                <input type="text" autocomplete="off" name="discount" class="form-control input_number" id="discount_amount">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span>{{ _lang('Discount Value') }}</span> <br>
                                                <input type="text" name="discount_amount" class="form-control" id="total_discount" value="0" readonly>
                                            </td>
                                            <td>
                                                <span>{{ _lang('Tax') }}</span> <br>
                                                <input type="text" autocomplete="off" name="tax" class="form-control input_number" id="tax_calculation_amount">
                                            </td>
                                            <td>
                                                <span>{{ _lang('Shipping') }}</span> <br>
                                                <input type="text" autocomplete="off" name="shipping_charges" class="form-control input_number" id="shipping_charges">
                                            </td>
                                            <td>
                                                <span>{{ _lang('Total Payable') }}</span> <br>
                                                <input type="hidden" class="form-control" id="total_payable_amount" name="total_payable_amount">
                                                <span class="total_payable_amount"></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="paid">{{ _lang('Paid') }} </label>
                                            <input type="text" autocomplete="off" class="form-control input_number paid" name="paid" id="paid">
                                        </div>
                                    </div>
                                      <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="due">{{ _lang('Due') }} </label>
                                            <input type="text" class="form-control due" name="due" id="due" readonly>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="account_id">{{ _lang('Account') }} </label>
                                            <select name="account_id" class="form-control select" id="account_id">
                                                <option value="">Select Account</option>
                                                @foreach ($accounts as $element)
                                                   <option>{{ $element->name }}({{ toWord($element->account_type) }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="paid">{{ _lang('Method') }} </label>
                                            <select name="method" class="form-control method">
                                                <option value="cash">Cash</option>
                                                <option value="check">Check</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 reference_no" style="display: none;">
                                        <div class="form-group">
                                            <label for="check_no">{{ _lang('Reference') }} </label>
                                            <input type="text" class="form-control" name="check_no" id="check_no">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="sale_note">{{ _lang('Sale Note') }} </label>
                                        <textarea name="sale_note" class="form-control" id="" placeholder="Sale Note"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="stuff_note">{{ _lang('Stuff Note') }} </label>
                                        <textarea name="stuff_note" class="form-control" id="" placeholder="Stuff Note"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="form-group col-md-12" align="right">
                <button type="submit" class="btn btn-primary" id="submit">{{_lang('Create')}}<i
                        class="icon-arrow-right14 position-right"></i></button>
                <button type="button" class="btn btn-info" id="submiting"
                        style="display: none;">{{_lang('Processing')}} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
            </div>
        </div>
    </form>
    <div class="modal fade border-top-success rounded-top-0 brand_modal" role="dialog">
    </div>
    <!-- /basic initialization -->
@stop

{{-- Script Section --}}
@push('scripts')
{{--    <script src="{{ asset('backend/js/plugins/select.min.js') }}"></script>--}}
    <script src="{{ asset('js/production/work_order.js') }}"></script>

    <script>        
        $('#type').change(function() {
            var val = $(this).val();
            if(val == 'sample') {
                $('.production_show').fadeOut();
                $('#paid').removeAttr('required');
            } else {
                $('.production_show').fadeIn();
                $('#paid').attr('required', '1');

            }
        });
    </script>
@endpush
