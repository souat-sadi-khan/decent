@extends('layouts.report', ['title' => _lang('Store Request Print'),'report_title'=>_lang('Store Request')])
@section('content')
<div class="container-fluid px-4 pt-4">
    <div class="row">
        <div class="col-md-6">
            <p class="h5 text-uppercase"><b>{{ _lang('Store Request') }}: </b> {{ _lang('Date Wise') }} </p>
            <p><b>{{ _lang('Store Request Date') }}: </b> {{ formatDate($model->request_date) }} </p>
        </div>
        <div class="col-md-6 text-right">
            <p class="mb-0"> Printing Date : {{ formatDate(date('Y-m-d')) }}</p>
            <p class="mb-0">
            Time : {{ date('H:i') }}</p>
        </div>
        <div class="col-md-12">
            <p class="mb-0"> Request Depertment : {{ $model->depertment?$model->depertment->name:'' }}</p>
            <p class="mb-0"> Store ID: {{ $model->dstore_id }}</p>
        </div>
    </div>
    <div class="row mt-2 px-4">
        <div class="page-header-space"></div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">{{ _lang('WorkOrder') }}</th>
                    <th scope="col">{{ _lang('Raw Material') }}</th>
                    <th scope="col">{{ _lang('Request Qty') }}</th>
                    <th scope="col">{{ _lang('Approve Qty') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($model->store_request as $element)
            <tr>
                <td>{{ $element->work_order?$element->work_order->prefix:'' }}-{{ $element->work_order?$element->work_order->code:'' }}</td>
                <td>{{ $element->material?$element->material->name:'' }}</td>
                <td>{{ $element->qty }}</td>
                <td>{{ $element->approve_qty }}</td>
            </tr>
            @endforeach
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