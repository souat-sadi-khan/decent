@extends('layouts.app', ['title' => _lang('Customer'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('content')
<!-- Basic initialization -->
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <table class="table table-hover table-bordered content_managment_table">
                    <thead>
                        <tr>
                            <th>{{_lang('Name')}}</th>
                            <th>{{_lang('Mobile')}}</th>
                            <th>{{_lang('Address')}}</th>
                            <th>{{_lang('Email')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td>{{ $model->name }}</td>
                        <td>{{ $model->mobile }}</td>
                        <td>{{ $model->address }}</td>
                        <td>{{ $model->email }}</td>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#home">{{ _lang('Orders') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#menu1">{{ _lang('Cancel Orders') }}</a>
                    </li>

                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="home" class="container tab-pane active"><br>
                        <table class="table table table-hover table-bordered ">
                            <thead class="thead-dark">
                                <tr>
                                    <th>{{_lang('ID')}}</th>
                                    <th>{{_lang('Payment Type')}}</th>
                                    <th>{{_lang('Track Code')}}</th>
                                    <th>{{_lang('Subtotal')}}</th>
                                    <th>{{_lang('Shipping Name')}}</th>
                                    <th>{{_lang('Phone')}}</th>
                                    <th>{{_lang('Total')}}</th>
                                    <th>{{_lang('Date')}}</th>
                                    <th>{{_lang('Status')}}</th>
                                </tr>
                            </thead>
                            @php
                            $models = App\models\Production\Transaction::where('client_id', $model->id)->where('ecommerce_status', '!=', 'cancel')->orderBy('id', 'desc')->get();
                            @endphp
                            @if (count($models) > 0)
                            @foreach ($models as $model)
                            <tr>
                                <td>{{$loop->index + 1}}</td>
                                <td>{{$model->payment_status}}</td>
                                <td>{{$model->reference_no}}</td>
                                <td>{{get_option('currency') ? 'BDT' : get_option('currenct') }} {{$model->sub_total}}</td>
                                <td>{{get_client_name($model->client_id)}}</td>
                                <td>{{get_client_phone($model->client_id)}}</td>
                                <td>{{get_option('currency') ? 'BDT' : get_option('currenct') }} {{$model->net_total}}</td>
                                <td>{{formatDate($model->created_at)}}</td>
                                <td>
                                    @if ($model->ecommerce_status == 'pending')
                                    {{_lang('Pending')}}
                                    @elseif( $model->ecommerce_status == 'confirm')
                                    {{_lang('Confirm')}}
                                    @elseif( $model->ecommerce_status == 'progressing')
                                    {{_lang('In Progressing')}}
                                    @elseif( $model->ecommerce_status == 'shipment')
                                    {{_lang('In Shipment')}}
                                    @elseif( $model->ecommerce_status == 'success')
                                    {{_lang('Success')}}
                                    @else
                                    {{_lang('Cancel')}}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="9" class="text-center">No Records Found !</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <div id="menu1" class="container tab-pane fade"><br>
                         <table class="table table-hover table-bordered content_managment_table">
                        <thead class="thead-dark">
                            <tr>
                                <th>{{_lang('ID')}}</th>
                                <th>{{_lang('Payment Type')}}</th>
                                <th>{{_lang('Track Code')}}</th>
                                <th>{{_lang('Subtotal')}}</th>
                                <th>{{_lang('Shipping Name')}}</th>
                                <th>{{_lang('Phone')}}</th>
                                <th>{{_lang('Total')}}</th>
                                <th>{{_lang('Date')}}</th>
                                <th>{{_lang('Status')}}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                $models = App\models\Production\Transaction::where('client_id', $model->id)->where('ecommerce_status', 'cancel')->orderBy('id', 'desc')->get();
                            @endphp
                            @if (count($models) > 0)
                                @foreach ($models as $model)
                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td>{{$model->payment_status}}</td>
                                        <td>{{$model->reference_no}}</td>
                                        <td>{{get_option('currency') ? 'BDT' : get_option('currenct') }} {{$model->sub_total}}</td>
                                        <td>{{get_client_name($model->client_id)}}</td>
                                        <td>{{get_client_phone($model->client_id)}}</td>
                                        <td>{{get_option('currency') ? 'BDT' : get_option('currenct') }} {{$model->net_total}}</td>
                                        <td>{{formatDate($model->created_at)}}</td>
                                        <td>
                                            @if ($model->ecommerce_status == 'pending')
                                                {{_lang('Pending')}}
                                            @elseif( $model->ecommerce_status == 'confirm')
                                                {{_lang('Confirm')}}
                                            @elseif( $model->ecommerce_status == 'progressing')
                                                {{_lang('In Progressing')}}
                                            @elseif( $model->ecommerce_status == 'shipment')
                                                {{_lang('In Shipment')}}
                                            @elseif( $model->ecommerce_status == 'success')
                                                {{_lang('Success')}}
                                            @else 
                                                {{_lang('Cancel')}}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else 
                                <tr>
                                    <td colspan="9" class="text-center">No Records Found !</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
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
</script>
@endpush