@extends('layouts.app', ['title' => _lang('Job Work Accept'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Job Work Accept."><i class="fa fa-universal-access mr-4"></i> {{_lang('Job Work Accept')}}</h1>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<h3 class="tile-title">
@can('job_work.view')
<a data-placement="bottom" title="Create New JobWork" type="button" class="btn btn-info" href ="{{ route('admin.job_work') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i>{{_lang('New Job Work')}}
</a>
@endcan
@can('job_work.create')
<a data-placement="bottom" title="JobWork List" type="button" class="btn btn-info" href ="{{ route('admin.job_work.index') }}"><i class="fa fa-list-ul" aria-hidden="true"></i>{{_lang('Job Work List')}}
</a>
@endcan
</h3>
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ _lang('Accepting Depertment') }} : {{ $send_dept->accept_depertment->name }}</th>
                    <th>{{ _lang('Reference') }} : {{ $model->reference_no }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div class="tile">
    <div class="tile-body">
        <form action="{{ route('admin.job_work_accept') }}" method="post" class="ajax_form">
            <input type="hidden" name="transaction_id" value="{{ $model->id }}">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead class="bg-green text-light">
                            <tr>
                                <td>{{ _lang('Name') }}</td>
                                <td>{{ _lang('Job Qty') }}</td>
                                <td>{{ _lang('Accept Qty') }}</td>
                                <td>{{ _lang('Remain Qty') }}</td>
                            </tr>
                        </thead>
                        <tbody class="bg-gray" id="table_grid">
                            @foreach ($model->job_works as $product)
                            <tr>
                                <td>
                                    {{ $product->product->name }}-{{ variation_value($product->variation->variation_value_id)}}-{{ variation_value($product->variation->variation_value_id_2)}}
                                    <input type="hidden" name="job_work_id[]" value="{{ $product->id }}">
                                    <input type="hidden" name="variation_id[]" value="{{ $product->variation_id }}">
                                    <input type="hidden" name="product_id[]" value="{{ $product->product_id }}">
                                    <input type="hidden" name="work_order_id[]" value="{{ $product->work_order_id }}">
                                    <input type="hidden" name="depertment_id[]" value="{{ $product->depertment_id }}">
                                </td>
                                <td>
                                    <input type="hidden" class="form-control" name="total_qty[]" value="{{ $product->qty }}">
                                    {{ $product->qty }}
                                </td>
                                <td>
                                    <input type="hidden" class="form-control" name="accept_qty[]" value="{{ $product->accept_qty }}">
                                    {{ $product->accept_qty }}
                                </td>
                                <td>
                                    <input type="text" class="form-control qty" name="qty[]" value="{{ $product->qty-$product->accept_qty }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <label for="send_depertment_id">{{ _lang('Send Depertment') }} </label>
                    <select class="form-control select" data-placeholder="Select Depertment" name="send_depertment_id" id="send_depertment_id" required data-parsley-errors-container="#send_depertment_id_error">
                        <option value="">Select One</option>
                        @foreach ($depertments as $depert)
                        <option {{ isset($send_dept->depertment_id)?$send_dept->send_depertment_id==$depert->id?'selected':'':'' }} value="{{ $depert->id }}">{{ $depert->name }}</option>
                        @endforeach
                    </select>
                    <span id="send_depertment_id_error"></span>
                </div>
                <div class="col-md-6">
                    <label for="note">{{ _lang('Note') }} </label>
                    <textarea name="note" class="form-control" id="note" placeholder="Job Order Company details"></textarea>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6 mx-auto text-center">
                    <button type="submit" id="submit" class="btn btn-primary btn-lg w-100">{{ _lang('Accept Job Work') }}</button>
                    <button type="button" class="btn btn-info btn-lg w-100" id="submiting" style="display: none;" disabled="">{{ _lang('Submiting') }} <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script>
$('.select').select2();
_classformValidation();
</script>
@endpush