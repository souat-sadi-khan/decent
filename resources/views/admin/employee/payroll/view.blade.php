@extends('layouts.app', ['title' => _lang('Employee PayRoll'), 'modal' => 'lg'])

{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Employee PayRoll."><i class="fa fa-calculator mr-4"></i>
            {{_lang('Employee PayRoll')}}</h1>
        <p>{{_lang('Create Employee PayRoll. Here you can Add, Edit & Delete The Employee PayRoll')}}</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        {{ Breadcrumbs::render('employee-payroll') }}
    </ul>
</div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="row">
    
    @can('employee_payroll_template.view')
    <div class="col-md-5 mx-auto ">
        <div class="card card-box shadow mb-5">
            <div class="card-body text-center">
                <i class="fa fa-id-card-o fa-4x" aria-hidden="true"></i>
                <h4 class="card-title">Payroll Template</h4>
                <p class="card-text font-80pc">Create payroll templates, allocate template to employees and generate
                    payroll for your employees.</p> <a href="{{ route('admin.payroll-template.index') }}" class="btn btn-primary btn-sm">Go
                    to Payroll Template</a>
            </div>
        </div>
    </div>
    @endcan

    @can('employee_payroll_salary_structure.view')
    <div class="col-md-5 mx-auto">
        <div class="card card-box shadow mb-5">
            <div class="card-body text-center">
                <i class="fa fa-picture-o fa-4x" aria-hidden="true"></i>
                <h4 class="card-title">Salary Structure</h4>
                <p class="card-text font-80pc">Define salary structure of all employees with different effective dates,
                    generate payroll for your employees.</p> 
                        <a href="{{route('admin.payroll-s-structure.index')}} " class="btn btn-primary btn-sm">Go to Salary Structure</a>
            </div>
        </div>
    </div>
    @endcan

    @can('employee_payroll_init.view')
    <div class="col-md-5 mx-auto m-2">
        <div class="card card-box shadow mb-5">
            <div class="card-body text-center">
                <i class="fa fa-calculator fa-4x" aria-hidden="true"></i>
                <h4 class="card-title">Payroll</h4>
                <p class="card-text font-80pc">Generate employee's payroll based on their attendance, take print out,
                    send it to your employee's email</p> <a href="{{route('admin.payroll-initialize.index')}} " class="btn btn-primary btn-sm">Go
                    to Payroll</a>
            </div>
        </div>
    </div>
    @endcan

    @can('employee_payroll_transection.view')
    <div class="col-md-5 mx-auto m-2">
        <div class="card card-box shadow mb-5">
            <div class="card-body text-center">
                <i class="fa fa-ticket fa-4x" aria-hidden="true"></i>
                <h4 class="card-title">Payroll Transaction</h4>
                <p class="card-text font-80pc">Make payment of employee's salary, record loan/advance, load
                    return/advance return of your employees</p> <a href="{{route('admin.payroll-transection.index')}}"
                    class="btn btn-primary btn-sm">Go to Payroll Transaction</a>
            </div>
        </div>
    </div>
    @endcan
    
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
<script src="{{ asset('js/employee/leave.js') }}"></script>
@endpush
