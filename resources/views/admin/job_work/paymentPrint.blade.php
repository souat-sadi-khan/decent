@extends('layouts.invoice')
@section('content')
<div class="container-fluid px-4 pt-4">
    <div class="row px-5">
        <div class="col-md-4 ml-auto">
            <p class="">
                <span class="font-weight-bold text-uppercase h5"> bill No : {{ $model->transaction->reference_no }}
                </span>
                
            </p>
        </div>
    </div>
    <p class="h2 text-uppercase mt-5 text-center"> bill for : {{ $bill_for }} {{ $model->transaction->reference_no }}
    </p>
    <div class="row mt-5 px-4">
        <table class="table table-bordered border-dark">
            <thead>
                <tr class="table-danger">
                    <th scope="col">{{ _lang('Note') }}</th>
                    <th scope="col">{{ _lang('Amount') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $model->note }}</td>
                    <td>{{ $model->amount }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <p class="h2 text-capitalize mt-4 text-center"> In Words : ........................................................................................................</p>
    <br><br>
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