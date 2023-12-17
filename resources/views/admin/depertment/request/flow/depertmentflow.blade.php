@extends('layouts.app', ['title' => _lang('Depertment Store Request'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Depertment Store Request."><i class="fa fa-universal-access mr-4"></i>
        {{_lang('Depertment Store Request')}}</h1>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="card">
    <div class="card-header">
        <h6>{{_lang('Store Request ')}}</h6>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ _lang('Depertment') }}</th>
                    <th>{{ $model->depertment->name }}</th>
                </tr>
                <tr>
                    <th>{{ _lang('Approve Date') }}</th>
                    <th>{{ formatDate($model->approve_date) }}</th>
                </tr>
            </thead>
        </table>
<<<<<<< HEAD
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>{{ _lang('Name') }}</td>
                    @foreach ($variations as $variation)
                        <td>{{ $variation->name }}</td>
                    @endforeach
                    <td>{{ _lang('Qty') }}</td>
                </tr>
                <tr>
                    @foreach ($products as $product)
                    <td>{{ $product->name }}</td>
                       <td>{{ variation_value($product->variation_value_id)}}</td>
                       <td>{{ variation_value($product->variation_value_id_2)}}</td>

                    @endforeach
                </tr>
            </thead>
        </table>
=======
>>>>>>> 2b3e0fa082000a0e5de81a7f6c77d88a37fd5608
        <div class="table-responsive">
            <table class="table table-condensed table-bordered table-th-green text-center table-striped"
                id="purchase_entry_table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Request Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="hidden" name="" value="{{ $model->raw_material_id}}" class="pid">
                            {{ $model->material->name }}
                        </td>
                        <td>
                            <input type="text" class="form-control qty " id="{{$model->id}}" name=""
                            value="{{ $model->qty }}" readonly>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>
<form action="{{route('admin.request.update',$model->id)}}" method="post" class="ajax_form" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <label for="note">{{_lang('Use Qty')}}
                            </label>
                            <input type="text" class="form-control" placeholder="Use Qty">
                        </th>
                        <th>
                            <label for="note">{{_lang('Waste Qty')}}
                            </label>
                            <input type="text" class="form-control" placeholder="Waste Qty">
                        </th>
                         <th>
                            <label for="note">{{_lang('Date')}}
                            </label>
                            <input type="text" class="form-control date" placeholder="Date">
                        </th>
                    </tr>
                    <tr>
                        <th>
                             <label for="note">{{_lang('Waste Qty')}}
                            </label><br>
                            <select name="" class="form-control select" style="width: 100%">
                                @foreach ($depertment as $element)
                                    <option value="{{ $element->id }}">{{ $element->name }}
                                    </option>
                                @endforeach
                            </select>
                        </th>
                        <th colspan="2">
                              <label for="note">{{_lang('Note')}}
                    </label>
                    <textarea name="note" class="form-control" id="" placeholder="Note"></textarea> 
                        </th>
                    </tr>
                </thead>
            </table>
            <div class="form-group col-md-12" id="submit_btn" align="right">
                {{-- <input type="hidden" name="type[]" value=" "> --}}
                <button type="submit" class="btn btn-primary" id="submit">{{_lang('Approve & Store')}}<i
                class="icon-arrow-right14 position-right"></i></button>
                <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{_lang('Processing')}}
                <img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
            </div>
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