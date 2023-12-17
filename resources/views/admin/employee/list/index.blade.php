@extends('layouts.app', ['title' => _lang('Employee List'), 'modal' => 'lg'])

{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Employee List."><i class="fa fa-universal-access mr-4"></i> {{_lang('Employee List')}}</h1>
            <p>{{_lang('Create Employee. Here you can Add, Edit & Delete The Employee ')}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('employee-list') }}
        </ul>
    </div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">
                    @can('employee_list.create')
                        <button data-placement="bottom" title="Create New Employee" type="button" class="btn btn-info" id="content_managment" data-url ="{{ route('admin.employee-list.create') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i></i>{{_lang('create')}}</button>
                    @endcan
                </h3>
                <div class="tile-body ">
                    @if(!get_option('employee_code_prefix') && !get_option('digits_employee_code')) 
                        <div class="col-md-12">
                            <div class="card mb-3 text-white bg-danger">
                                <div class="card-body text-center">
                                    <blockquote class="card-blockquote">
                                        <h2>{{_lang('Warning')}} </h2>
                                        <h4>{{_lang("Look Like You didn't set Some more Required Information")}} </h4>
                                        <p>{{_lang("Look Lijje You didn't set the Employee Code Prefix & Employee Code Digit. IF You don't set this 2 value, you can not add employee. If you want to add Employee, Please Set the value by clicking the below Link")}} </p>
                                        <p><a class="bg-info rounded px-2 text-light py-1" href="{{route('admin.module.setting')}}">{{_lang('Click Here to Set The Value')}} </a></p>
                                  </blockquote>
                                </div>
                            </div>
                        </div>            
                    @endif
                    <table class="table table-sm table-hover table-bordered content_managment_table" data-url="{{ route('admin.list.datatable') }}">
                        <thead>
                            <tr>
                                <th>{{_lang('id')}}</th>
                                <th>{{_lang('Code')}}</th>
                                <th>{{_lang('Name')}}</th>
                                <th>{{_lang('Status')}}</th>
                                <th>{{_lang('Shift')}}</th>
                                <th>{{_lang('Contact No')}}</th>
                                <th>{{_lang('Department')}}</th>
                                <th>{{_lang('Designation')}}</th>
                                <th>{{_lang('Joining Date')}}</th>
                                <th>{{_lang('action')}}</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<!-- /basic initialization -->
@stop

{{-- Script Section --}}
@push('scripts')
    <script type="text/javascript" src="{{asset('backend/js/plugins/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('backend/js/plugins/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('backend/js/plugins/select.min.js') }}"></script>
    {{-- <script src="{{ asset('backend/js/plugins/buttons.min.js') }}"></script> --}}
    <script src="{{ asset('backend/js/plugins/responsive.min.js') }}"></script>
    <script src="{{ asset('js/employee/list.js') }}"></script>
@endpush