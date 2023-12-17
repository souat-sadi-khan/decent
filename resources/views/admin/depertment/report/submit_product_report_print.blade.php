@extends('layouts.report', ['title' => _lang('Submitted Product Report '),'report_title'=>_lang('Total Submitted Product Report Report ')])
@section('content')
<div class="container-fluid px-4 pt-4">
    <div class="row">
        <div class="col-md-6">
            <p class="h5 text-uppercase"><b>{{ _lang('Total Submitted Product Report ') }}: 
            <p><b>{{ _lang('Total Submitted Product Report') }}: </b> {{ date('Y-m-d') }} </p>
        </div>

    </div>
    <div class="row mt-2 px-4">
        <div class="page-header-space"></div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">{{ _lang('Depertment') }}</th>
                    <th scope="col">{{ _lang('Send Depertment') }}</th>
                    <th scope="col">{{ _lang('WorkOrder') }}</th>
                    <th scope="col">{{ _lang('Product') }}</th>
                    <th scope="col">{{ _lang('Sending Qty') }}</th>
                    <th scope="col">{{ _lang('Work By') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($model as $element)
            <tr>
                <td>{{ $element->depertment?$element->depertment->name:'' }}</td>
                <td>{{ $element->send_depertment?$element->send_depertment->name:'' }}</td>
                <td>{{ $element->work_order->prefix }}-{{ $element->work_order->code }}</td>
                <td>{{ $element->product?$element->product->name:'' }}{{ $element->variation?$element->variation->name:'' }}</td>
                <td>{{ $element->qty }} {{ _lang('Pair') }}</td>
                <td>{{ $element->send_by->email }}</td>
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