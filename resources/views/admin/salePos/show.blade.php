@extends('layouts.app', ['title' => _lang('Sale Details'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Purchases for Production."><i class="fa fa-universal-access mr-4"></i> {{_lang('Sale Details')}}</h1>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="row">
                <div class="col-md-4 mx-auto ">
                    <div class="card card-box border border-primary">
                        <div class="card-body">
                            <div class="text-center">
                                <i class="fa fa-user fa-4x" aria-hidden="true"></i>
                                <h4 class="card-title">{{ _lang('Client Details') }}</h4>
                            </div>
                            
                            <p class="card-text font-80pc">
                                <span><b>{{ _lang('Name') }}: </b>{{ $model->client->name }}</span> <br>
                                <span><b>{{ _lang('Email') }}</b> : {{ $model->client->email }}</span> <br>
                                <span><b>{{ _lang('Phone') }}</b> : {{ $model->client->mobile }}</span> <br>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mx-auto">
                    <div class="card card-box border border-primary">
                        <div class="card-body">
                            <div class="text-center">
                                <i class="fa fa-inbox fa-4x" aria-hidden="true"></i>
                                <h4 class="card-title">{{ _lang('Sale Details') }}</h4>
                            </div>
                            
                            <p class="card-text font-80pc">
                                <span><b>{{ _lang('Ref No') }}: </b>{{ $model->reference_no }}</span> <br>
                                <span><b>{{ _lang('Date') }}</b> : {{ formatDate($model->date) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mx-auto">
                    <div class="card card-box border border-primary">
                        <div class="card-body">
                            <div class="text-center">
                                <i class="fa fa-file-powerpoint-o fa-4x" aria-hidden="true"></i>
                                <h4 class="card-title">{{ _lang('Payment Details') }}</h4>
                            </div>
                            
                            <p class="card-text font-80pc">
                                @can('view_sale.sale_price')
                                <span><b>{{ _lang('Total') }}: </b>{{ $model->net_total }}</span> <br>
                                @endcan

                                @can('view_purchase.discount')
                                @if ($model->discount)
                                <span><b>{{ _lang('Discount Amount') }}: </b>{{ $model->discount_amount }}</span> <br>
                                @endif
                                @endcan

                                @can('view_purchase.paid')
                                <span><b>{{ _lang('Sale Paid') }}</b> : {{  $model->payment->sum('amount') }}</span>
                                @if($model->return == 1)
                                <small>(This Sale has return item)</small>
                                @endif <br>
                                @if($model->net_total - $model->paid > 0)
                                <span><b>{{ _lang('Sale Due') }}</b> : {{ $model->net_total- $model->payment->sum('amount') }}</span> <br>
                                @endif
                                @if($model->return == 1 || ($model->net_total - $model->payment->sum('amount')) > 0 )
                               
                                @if($model->return == 1)
                                 @php
                                $return =$model->return_parent->net_total
                                @endphp
                                <span><b>{{ _lang('Return Amt') }}: </b>{{ $return }}</span> <br>
                                <span><b>{{ _lang('Return Paid') }}: </b>{{ $model->return_parent->payment->sum('amount')}}</span> <br>
                                @endif
                                @endif
                                @endcan
                                @if ($model->return_parent)
                                   <span><b>{{ _lang('Balance') }}: </b>{{  ($model->net_total-($model->payment()->sum('amount')+$model->return_parent->net_total))}}</span> <br>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @if($model->return == 1)
                    <div class="well" style="background-color: rgba(255, 222, 160, 0.25);">
                        This Sale has return item
                    </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#home">{{ _lang('Sale Item') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#menu1">{{ _lang('Payment History') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#menu2">{{ _lang('Make Payment') }}</a>
                                </li>
                                @if($model->return == 1)
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#menu3">{{ _lang('Return Details') }}</a>
                                </li>
                                @endif
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div id="home" class="container tab-pane active"><br>
                                    @include('admin.salePos.partials.sale_item')
                                </div>
                                <div id="menu1" class="container tab-pane fade"><br>
                                    @include('admin.salePos.partials.payment_list')
                                </div>
                                <div id="menu2" class="container tab-pane fade"><br>
                                    @include('admin.salePos.partials.make_payment')
                                </div>
                                 @if($model->return == 1)
                                <div id="menu3" class="container tab-pane fade"><br>
                                    @include('admin.salePos.partials.return_item_list')
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script>
    $('select').select2();
_componentDatefPicker();
$(document).on('change','.method',function(){
    var method =$(".method").val();
    if (method=='cash') {
        $('.reference_no').hide(300);
    }
    else
    {
      $('.reference_no').show(400);  
    }
});
 _formValidation();

   function myFunction(url) {
    window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=auto,left=auto,width=1400,height=400");
    }
</script>
@endpush