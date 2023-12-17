@extends('layouts.app', ['title' => _lang('Work Order Delivery'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Work Order Delivery."><i class="fa fa-universal-access mr-4"></i>
            {{_lang('Work Order Delivery: '.$work_order->prefix . '-'. $work_order->code )}}</h1>
    </div>
</div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
@php
    $product_ids = [];
    $quantitys = [];
@endphp
<div class="card">
    <div class="card-header">
        <h6>{{_lang('Production Product Details')}}</h6>
    </div>
    <div class="card-body">

        {{-- Now Delivery Status --}}
        <div class="col-md-12 table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th class="text-center">Status</th>
                    <td class="text-center">
                        @if ($delivery->status == 'due')
                            <span class="badge badge-danger">Full Delivery Due</span>
                        @elseif($delivery->status == 'partial')
                            <span class="badge badge-info">Partial Delivery Complete</span>
                        @elseif($delivery->status == 'paid')
                            <span class="badge badge-success">Full Delivery Complete</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <div class="row">
            {{-- Requested Product Quantity --}}
            <div class="col-md-6 table-responsive">
                <table class="table table-danger table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-center">Requested Product Quantity</th>
                        </tr>
                        <tr>
                            <th class="text-center" width="80%">Product Name (Variation)</th>
                            <th width="20%">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($work_order_products))
                            @foreach ($work_order_products as $work_order_product)
                                @php
                                    $product_ids[] = $work_order_product->product_id;
                                    $quantitys[] = $work_order_product->qty;
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $work_order_product->product ? $work_order_product->product->name : ''  }} ({{ $work_order_product->variation ? $work_order_product->variation->name : '' }}) </td>
                                    <td>{{ $work_order_product->qty}} </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- Delivery Product Quantity --}}
            <div class="col-md-6 table-responsive">
                <table class="table table-success table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-center">Delivery Product Quantity</th>
                        </tr>
                        <tr>
                            <th class="text-center" width="80%">Product Name (Variation)</th>
                            <th width="20%">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($delivery_array))
                            @foreach ($delivery_array as $item)
                                <tr>
                                    <td class="text-center">{{ $item['Product'] }} </td>
                                    <td>{{ $item['Quantity']}} </td>
                                </tr>
                            @endforeach
                        @else 
                            <tr>
                                <th class="text-center text-danger" colspan="2">No Product is Deliveried Yet !</th>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if ($delivery->status != 'paid')
                {{-- Ready Product Quantity --}}
                <div class="col-md-6 mx-auto table-responsive">
                    <table class="table table-info table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">Ready Product Quantity</th>
                            </tr>
                            <tr>
                                <th class="text-center" width="80%">Product Name (Variation)</th>
                                <th width="20%">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($ready_products))
                                @foreach ($ready_products as $ready_product)
                                    <tr>
                                        <td class="text-center">
                                            {{ $ready_product['Product Name'] }} ({{ $ready_product['Variation Name'] }}) 
                                        </td>
                                        <td>{{ $ready_product['Quantity']}} </td>
                                    </tr>
                                @endforeach
                            @else 
                                <tr>
                                    <th class="text-center text-danger" colspan="2">No Product is Deliveried Yet !</th>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <th class="text-center" colspan="2"><button data-toggle="modal" data-target="#sendDelivery" class="btn btn-primary btn-sm" type="button">Delivery The Product</button></th>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>

        <div id="print_table" class="card-body">
            <span class="text-center">
                <h3><b class="text-uppercase">{{ get_option('company_name') }}</b></h3>
                <h5> Work Order ( {{ $work_order->prefix }} {{ $work_order->code}} ) Delivery Invoice </h5>
                <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>
            
            </span>
            <div class="text-center col-md-12">
                <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
                    class="bg-success text-light">
                    <b> Work Order ( {{ $work_order->prefix }} {{ $work_order->code}} ) Delivery Invoice</b></h4>
            </div>
            <br>
            
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
        
                                <p style="margin:0px ; margin-top: -8px;">
        
                                    Report Of Date : <span class="ml-1">{{ formatDate(date('Y-m-d'))}}</span>
        
                                </p>
        
                            </td>
                            <td class="text-center">
        
                            </td>
                            <td class="text-right">
                                <p style="margin:0px ; margin-top: -8px;">Printing Date :
                                    <span></span> {{ date('d F, Y') }} </span></p>
                                <p style="margin:0px ; margin-top: -4px;">Time :
                                    <span></span>{{date('h:i:s A')}}</span></p>
                            </td>
                        </tr>
        
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 table-responsive">
                @php
                    $from = get_option('default_brand');
                    $from = App\models\Production\Brand::where('id', $from)->firstorFail();
                    $to = $work_order->brand_id;
                    $to = App\models\Production\Brand::where('id', $to)->firstorFail();
                @endphp
                <table class="table table-sm">
                    <tr>
                        <th>From</th>
                        <th class="text-right">To</th>
                    </tr>
                    <tr>
                        <td>{{ $from->name }}</td>
                        <td class="text-right">{{ $to->name }}</td>
                    </tr>
                    <tr>
                        <td>{{ $from->owner_name }}</td>
                        <td class="text-right">{{ $to->owner_name }}</td>
                    </tr>
                    <tr>
                        <td>{{ $from->phone }}</td>
                        <td class="text-right">{{ $to->phone }}</td>
                    </tr>
                    <tr>
                        <td>{{ $from->email }}</td>
                        <td class="text-right">{{ $to->email }}</td>
                    </tr>
                </table>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-hover table-sm table-bordered content_managment_table">
                    <thead class="table-info">
                        <tr>
                            <th width="30%" class="text-center">Date</th>
                            <th width="40%" class="text-center">Product (Variation)</th>
                            <th width="30%" class="text-center">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                            $work_order_delivery = App\models\Production\WorkOrderDelivery::where('work_order_id', $work_order->id)->first();
                            $work_order_delivery_id = $work_order_delivery->id;
                            $work_order_delivery_items = App\models\Production\WorkOrderDeliveryItem::where('work_order_deliveries_id', $work_order_delivery_id)->get();
                        @endphp
                        @if (count($work_order_delivery_items))
                            
                        @else 
                            <tr>
                                <td colspan="3" class="text-center">No Data Found!</td>
                            </tr>
                        @endif
                        @foreach ($work_order_delivery_items as $work_order_delivery_item)
                            @php
                                $total += $work_order_delivery_item->quantity;
                            @endphp
                            <tr>
                                <td class="text-center">{{ formatDate($work_order_delivery_item->date) }} </td>
                                <td class="text-center">{{ $work_order_delivery_item->product->name }} ({{ $work_order_delivery_item->variation->name }})</td>
                                <td class="text-right">{{ get_option('currency') }} {{ number_format($work_order_delivery_item->quantity, 2)}} </td>
                            </tr>
                       @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-right" colspan="2">Total</td>
                            <td class="text-right">{{ number_format($total, 2)}} </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        
            <br>
            {{-- <h5>In Words: {{ucwords($in_words)}} Taka Only.</h5> --}}
            <br><br><br>
        
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-4 text-center">
                    <hr class="border-dark">
                    <p> Chief Cashier </p>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4 text-center">
                    <hr class="border-dark">
                    <p> Manager </p>
                </div>
                <div class="col-md-1"></div>
        
        
            </div>
        </div>
        
        <div class="text-center mb-3">
        
        
            @php
            $print_table = 'print_table';
        
            @endphp
        
            <a class="text-light btn-primary btn" onclick="printContent('{{ $print_table }}')" name="print"
                id="print_receipt">
                <i class="fa fa-print" aria-hidden="true"></i>
                Print Report
        
            </a>
        </div>
        
        <script>
            function printContent(el) {
                console.log('print clicked');
        
                var a = document.body.innerHTML;
                var b = document.getElementById(el).innerHTML;
                document.body.innerHTML = b;
                window.print();
                document.body.innerHTML = a;
        
                return window.location.reload(true);
        
            }
        </script>
        
    </div>
</div>
<br>

<!-- Modal -->
<div class="modal fade" id="sendDelivery" tabindex="-1" role="dialog" aria-labelledby="sendDeliveryTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Delivery This Items</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('admin.production-work-order.send-delivery',$work_order->id)}}" method="post" id="content_form">
            @csrf
            @method('PATCH')
            <div class="modal-body" id="data">
                <div class="col-md-12 form-group">
                    <label for="date">Date <span class="text-danger">*</span></label>
                    <input required type="text" name="date" id="date" class="form-control date" placeholder="Enter Delivery Date">
                </div>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-center">Ready Product Quantity</th>
                        </tr>
                        <tr>
                            <th class="text-center" width="80%">Product Name (Variation)</th>
                            <th width="20%">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($ready_products))
                            @foreach ($ready_products as $ready_product)
                                <tr>
                                    <td class="text-center">
                                        {{ $ready_product['Product Name'] }} ({{ $ready_product['Variation Name'] }}) 
                                        <input type="hidden" name="product_id[]" value="{{ $ready_product['Product ID'] }}">
                                        <input type="hidden" name="variation_id[]" value="{{ $ready_product['Variation ID'] }}">
                                    </td>
                                    <td>
                                        {{ $ready_product['Quantity']}} 
                                        <input type="hidden" name="quantity[]" value="{{ $ready_product['Quantity'] }}">
                                    </td>
                                </tr>
                            @endforeach
                        @else 
                            <tr>
                                <th class="text-center text-danger" colspan="2">No Product is Deliveried Yet !</th>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <div class="text-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id='submit' type="submit" class="btn btn-primary">Send Delivery</button>
                    <button style="display: none;" id='submiting' type="button" disabled class="btn btn-primary">Processing..</button>
                </div>
            </div>
            <div class="modal-footer">
                
            </div>
        </form>
    </div>
    </div>
  </div>

{{-- <div class="card py-4">
    <div class="col-md-12">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>{{ _lang('#') }}</th>
                    <th>{{ _lang('Prodjuct Name') }}</th>
                    <th>{{ _lang('Quantity') }}</th>
                    <th>{{ _lang('Price') }}</th>
                    <th>{{ _lang('Sub Price') }}</th>
                    <th>{{ _lang('Net Total') }}</th>
                </tr>
            </thead>
            <tbody>
               @foreach ($model->workOrderProduct as $key => $item)
                   <tr>
                       <td>{{$key+1}}</td>
                       <td>{{$item->product->name}}</td>
                       <td>{{$item->qty}}</td>
                       <td>{{$item->price}}</td>
                       <td>{{$item->sub_total}}</td>
                       <td>{{$item->net_total}}</td>
                   </tr>
               @endforeach
            </tbody>
        </table>
    </div>
</div> --}}
<!-- /basic initialization -->
@stop

{{-- Script Section --}}
@push('scripts')
<script>
    $('.date').attr('readonly', true);
    $('.date').datepicker({
        dateFormat: "yy-mm-dd",
        autoclose: true,
        todayHighlight: true,
        changeMonth: true,
		changeYear: true,
    });

    var _sendDelivery = function () {
        if ($('#content_form').length > 0) {
            $('#content_form').parsley().on('field:validated', function () {
                var ok = $('.parsley-error').length === 0;
                $('.bs-callout-info').toggleClass('hidden', !ok);
                $('.bs-callout-warning').toggleClass('hidden', ok);
            });
        }

        $('#content_form').on('submit', function (e) {
            e.preventDefault();
            $('#submit').hide();
            $('#submiting').show();
            $(".ajax_error").remove();
            var submit_url = $('#content_form').attr('action');
            //Start Ajax
            var formData = new FormData($("#content_form")[0]);
            $.ajax({
                url: submit_url,
                type: 'POST',
                data: formData,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                dataType: 'JSON',
                success: function (data) {
                    if (data.status == 'danger') {
                        toastr.error(data.message);
                    } else {
                        toastr.success(data.message);
                        

                        if(data.html) {

                            $('#data').html(data.html);

                        }
                    }

                    $('#submit').show();
                    $('#submiting').hide();
                },
                error: function (data) {
                    var jsonValue = $.parseJSON(data.responseText);
                    const errors = jsonValue.errors;
                    if (errors) {
                        var i = 0;
                        $.each(errors, function (key, value) {
                            const first_item = Object.keys(errors)[i]
                            const message = errors[first_item][0];
                            if ($('#' + first_item).length > 0) {
                                $('#' + first_item).parsley().removeError('required', {
                                    updateClass: true
                                });
                                $('#' + first_item).parsley().addError('required', {
                                    message: value,
                                    updateClass: true
                                });
                            }
                            // $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');
                            toastr.error(value);
                            i++;

                        });
                    } else {
                        toastr.warning(jsonValue.message);

                    }
                    // _componentSelect2Normal();
                    $('#submit').show();
                    $('#submiting').hide();
                }
            });
        });

    };

_sendDelivery();

</script>
@endpush
