@extends('layouts.app', ['title' => _lang('Approve Store Request'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Approve Store Request."><i class="fa fa-universal-access mr-4"></i>
        {{_lang('Approve Store Request')}}</h1>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<form action="{{route('admin.approve_all_request',$models->id)}}" method="post" class="ajax_form"
    enctype="multipart/form-data">
    @method('PUT')
    @csrf
    
    <div class="card">
        <div class="card-header">
            <h6>{{_lang('Store Request ')}}</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ _lang('Depertment') }}</th>
                        <th>{{ $models->depertment->name }}</th>
                    </tr>
                    <tr>
                        <th>{{ _lang('Send By') }}</th>
                        <th>{{ $models->send_by->email }}</th>
                    </tr>
                    <tr>
                        <th>{{ _lang('Send Date') }}</th>
                        <th>{{ formatDate($models->request_date) }}</th>
                    </tr>
                </thead>
            </table>
            <div class="table-responsive">
                <table class="table table-condensed table-bordered table-th-green text-center table-striped"
                    id="purchase_entry_table">
                    <thead class="bg-green text-light">
                        <tr>
                            <th>Product/Material</th>
                            <th>Request Quantity</th>
                            <th>Approve Qty</th>
                            <th>Remaining Qty</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray">
                        @foreach ($models->store_request as $model)
                        @php
                        $approve_item =$model->approve_store_item->sum('qty');
                        @endphp
                        <tr>
                            <td>
                                <input type="hidden" name="raw_material_id[]" value="{{ $model->raw_material_id}}" class="raw_material_id">
                                <input type="hidden" name="store_request_id[]" value="{{ $model->id}}" class="store_request_id">
                                <input type="hidden" name="depertment_id[]" value="{{ $model->depertment_id }}">
                                <input type="hidden" name="work_order_id[]" value="{{ $model->work_order_id }}">
                                {{ $model->material->name }}
                            </td>
                            <td>
                                {{ $model->qty }}
                            </td>
                            <td>
                                {{ $approve_item }}
                            </td>
                            <td>
                                <input type="text" class="form-control qty " id="{{$model->id}}" name="qty[]"
                                value="{{ $model->qty-$approve_item }}" required>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2">
                            <label for="note">{{_lang('Status')}} </label>
                            <select name="status" class="form-control" style="width: 100%">
                                <option value="Approve">Approve</option>
                                <option value="Partial">Partial</option>
                            </select>
                        </td>
                        <td colspan="2">
                            <label for="note">{{_lang('Note')}}
                            </label>
                            <textarea name="note" class="form-control" id="" placeholder="Note"></textarea>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="form-group col-md-12" id="submit_btn" align="right">
            <button type="submit" class="btn btn-primary" id="submit">{{_lang('Approve & Store')}}<i
            class="icon-arrow-right14 position-right"></i></button>
            <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{_lang('Processing')}}
            <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
        </div>
    </div>
</form>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script>
$('.select').select2();
</script>
<script src="{{ asset('js/department/request.js') }}"></script>
@endpush