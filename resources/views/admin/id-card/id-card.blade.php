@extends('layouts.app', ['title' => _lang('Employee Id Card'), 'modal' => 'lg'])

{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Employee Id Card."><i class="fa fa-universal-access mr-4"></i>
            {{_lang('Employee Id Card')}}</h1>
        <p>{{_lang('Create Employee Id Card. Here you can Add, Edit & Delete The Employee Id Card')}}</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        {{ Breadcrumbs::render('employee-id-card') }}
    </ul>
</div>
@stop

{{-- Main Section --}}
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">

            @if($errors->any())
                <div class="alert alert-warning">
                    <ul class="list-group">
                        <li class="text-center">{{$errors->first()}}</li>
                    </ul>
                </div>
            @endif

            <div class="tile-body">
                @if (count($card))
                    <form action="{{route('admin.employee-id-card.show')}}" method="post" target="_blank" id="">
                        @csrf
                        <div class="row">
                            {{-- Department --}}
                            <div class="col-md-7 mx-auto form-group">
                                <label for="name">{{_lang('Department')}} <span class="text-danger">*</span>
                                </label>
                                <select name="department" data-placeholder="Please Select One.." class="form-control select"
                                    id="department" required>
                                    <option value="">Please Select One..</option>
                                    @foreach($department as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Id Card Template --}}
                            <div class="col-md-7 mx-auto form-group">
                                <label for="">{{_lang('Id Card Template')}}
                                </label>
                                <select name="card" data-placeholder="Please Select One.." class="form-control select"
                                    id="card" required>
                                    <option value="">Please Select One..</option>
                                    @foreach($card as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group col-md-7 mx-auto">
                                <button type="submit" class="btn btn-primary btn-block" id="submit">{{_lang('Generate Id Card')}}
                                    <i class="fa ml-3 fa-print" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                @else 
                    <div class="border border-danger m-1 p-1 text-center">
                        You Didn't add any Id Card Template Yet. If You Wnt to make ID Card, you have to make ID Card Template First . <br> For this go to the <strong> Setting</strong> > <strong> ID Card </strong>. Or Click to <a href="{{route('admin.id-card-template')}}">This Link</a>
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</div>
@stop

{{-- Script Section --}}
@push('scripts')
<script type="text/javascript" src="{{asset('backend/js/plugins/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('backend/js/plugins/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ asset('backend/js/plugins/select.min.js') }}"></script>
{{-- <script src="{{ asset('backend/js/plugins/buttons.min.js') }}"></script> --}}
<script src="{{ asset('backend/js/plugins/responsive.min.js') }}"></script>
<script src="{{ asset('js/pages/id-card.js') }}"></script>
@endpush