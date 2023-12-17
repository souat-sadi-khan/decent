@extends('layouts.report', ['title' => _lang('eCommerce Custom Date Report'),'report_title'=>_lang('eCommerce Custom Date Report')])

@section('content')
 <div class="container-fluid px-4 pt-4">

        <div class="row">
            <div class="col-md-6">
                <p class="h5 text-uppercase"><b> {{ _lang('Store Raw Material Report') }}: </b> </p>
                <p><b>{{ _lang('Date Range') }}: </b> {{ formatDate($start_date) }} <b>To</b> {{ formatDate($end_date) }} </p>
            </div>
            <div class="col-md-6 text-right">
                <p class="mb-0"> Printing Date : {{ formatDate(date('Y-m-d')) }}</p>
                <p class="mb-0">
                    Time : {{ date('H:i') }}</p>
            </div>
        </div>

        <div class="row mt-2 px-4">

            <div class="page-header-space"></div>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{_lang('ID')}}</th>
                        <th>{{_lang('Payment Type')}}</th>
                        <th>{{_lang('Transaction ID')}}</th>
                        <th>{{_lang('Subtotal')}}</th>
                        <th>{{_lang('Shipping')}}</th>
                        <th>{{_lang('Total')}}</th>
                        <th>{{_lang('Date')}}</th>
                        <th>{{_lang('Status')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($models as $model)
                        <tr>
                            <td>{{$loop->index + 1}}</td>
                            <td>{{$model->payment_status}}</td>
                            <td>{{$model->reference_no}}</td>
                            <td>{{get_option('currency') ? 'BDT' : get_option('currenct') }} {{$model->sub_total == NULL || $model->sub_total == 0 ? 0 : $model->sub_total}}</td>
                            <td>{{get_option('currency') ? 'BDT' : get_option('currenct') }} {{$model->shipping_charges == NULL || $model->shipping_charges == 0 ? 0 : $model->shipping_charges}}</td>
                            <td>{{get_option('currency') ? 'BDT' : get_option('currenct') }} {{$model->net_total == NULL || $model->net_total == 0 ? 0 : $model->net_total}}</td>
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
                    <tr>
                        <td class="text-right h5 font-weight-bold" colspan="7"> {{ _lang('Sub Total') }}</td>
                        <td> {{ get_option('currency') ? get_option('currency') : 'BDT'}} {{($models->sum('sub_total') == 0 ? 0 : $models->sum('sub_total') )}} </td>
                    </tr>
                    <tr>
                        <td class="text-right h5 font-weight-bold" colspan="7"> {{ _lang('Shipping') }}</td>
                        <td> {{ get_option('currency') ? get_option('currency') : 'BDT'}} {{($models->sum('shipping_charges') == 0 ? 0 : $models->sum('shipping_charges') )}} </td>
                    </tr>
                    <tr>
                        <td class="text-right h5 font-weight-bold" colspan="7"> {{ _lang('Total') }}</td>
                        <td> {{ get_option('currency') ? get_option('currency') : 'BDT'}} {{($models->sum('net_total') == 0 ? 0 : $models->sum('net_total') )}} </td>
                    </tr>
                </tbody>
            </table>

            <div class="page-footer-space"></div>
        </div>
  
        <div class="row mt-5 mb-3 text-center">
            <div class="col-md-3">
                <p class="border-top border-dark h4"> Received By </p>
            </div>
            <div class="col-md-3">
                <p class="border-top border-dark h4 text-color"> Prepared By </p>
            </div>
            <div class="col-md-3">
                <p class="border-top border-dark h4 text-color"> Checked By </p>
            </div>
            <div class="col-md-3">
                <p class="border-top border-dark h4 text-color"> Authorized By </p>
            </div>
        </div>
    </div>

@endsection