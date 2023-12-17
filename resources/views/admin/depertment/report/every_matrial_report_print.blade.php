@extends('layouts.report', ['title' => _lang('Material Report'),'report_title'=>_lang('Everyday Material Report')])
@section('content')
<div class="container-fluid px-4 pt-4">
    <div class="row">
        <div class="col-md-6">
            <p class="h5 text-uppercase"><b>{{ _lang('Everyday Material Report') }}: 
            <p><b>{{ _lang('Everyday Material Report') }}: </b> {{ date('Y-m-d') }} </p>
        </div>

    </div>
    <div class="row mt-2 px-4">
        <div class="page-header-space"></div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col">{{ _lang('Depertment') }}</th>
                    <th scope="col">{{ _lang('Raw Material') }}</th>
                    <th scope="col">{{ _lang('Report Qty') }}</th>
                    <th scope="col">{{ _lang('Waste Qty') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($model as $element)
            <tr>
                <td>{{ $element->depertment?$element->depertment->name:'' }}</td>
                <td>{{ $element->material?$element->material->name:'' }}</td>
                <td>{{ $element->qty }} {{ $element->material->unit?$element->material->unit->unit:'' }}</td>
                <td>{{ $element->waste }} {{ $element->material->unit?$element->material->unit->unit:'' }}</td>
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