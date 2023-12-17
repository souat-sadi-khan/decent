@extends('layouts.app', ['title' => _lang('Report'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Depertment Store Request."><i class="fa fa-universal-access mr-4"></i>
            {{_lang('Report')}}</h1>
    </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="row">
    <div class="col-md-4 mx-auto ">
        <div class="card card-box border border-primary">
            <div class="card-body text-center">
                <i class="fa fa-registered fa-4x" aria-hidden="true"></i>
                <h4 class="card-title">{{ _lang('Depertment Report') }}</h4>
                 <a href="{{ route('admin.report.depertment.product_report') }}" class="btn btn-primary btn-sm">{{ _lang('Go to Report') }}</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mx-auto">
        <div class="card card-box border border-primary">
            <div class="card-body text-center">
                <i class="fa fa-registered fa-4x" aria-hidden="true"></i>
                <h4 class="card-title">{{ _lang('Expense Report') }}</h4>
                <a href="{{ route('admin.report.expense.index') }}" class="btn btn-primary btn-sm">{{ _lang('Go to Report') }}</a>
            </div>
        </div>
    </div>
       <div class="col-md-4 mx-auto">
        <div class="card card-box border border-primary">
            <div class="card-body text-center">
                <i class="fa fa-registered fa-4x" aria-hidden="true"></i>
                <h4 class="card-title">{{ _lang('Ecommerce Report') }}</h4>
                <a href="{{ route('admin.report.eCommerce-report.index') }}" class="btn btn-primary btn-sm">{{ _lang('Go to Report') }}</a>
            </div>
        </div>
    </div>
</div>
<div class="row mt-1">
	       <div class="col-md-4 mx-auto">
        <div class="card card-box border border-primary">
            <div class="card-body text-center">
                <i class="fa fa-registered fa-4x" aria-hidden="true"></i>
                <h4 class="card-title">{{ _lang('Sale Report') }}</h4>
                <a href="{{ route('admin.report.selling.sales') }}" class="btn btn-primary btn-sm">{{ _lang('Go to Report') }}</a>
            </div>
        </div>
    </div>

       <div class="col-md-4 mx-auto">
        <div class="card card-box border border-primary">
            <div class="card-body text-center">
                <i class="fa fa-registered fa-4x" aria-hidden="true"></i>
                <h4 class="card-title">{{ _lang('Purchase Report') }}</h4>
                <a href="{{ route('admin.report.purchasing.purchase') }}" class="btn btn-primary btn-sm">{{ _lang('Go to Report') }}</a>
            </div>
        </div>
    </div>

       <div class="col-md-4 mx-auto">
        <div class="card card-box border border-primary">
            <div class="card-body text-center">
                <i class="fa fa-registered fa-4x" aria-hidden="true"></i>
                <h4 class="card-title">{{ _lang('Product Report') }}</h4>
                <a href="{{ route('admin.report.product_report') }}" class="btn btn-primary btn-sm">{{ _lang('Go to Report') }}</a>
            </div>
        </div>
    </div>
</div>

    <div class="row mt-1">
              <div class="col-md-4 mx-auto">
        <div class="card card-box border border-primary">
            <div class="card-body text-center">
                <i class="fa fa-registered fa-4x" aria-hidden="true"></i>
                <h4 class="card-title">{{ _lang('Purchase Sale') }}</h4>
                <a href="{{ route('admin.report.purchase_sale') }}" class="btn btn-primary btn-sm">{{ _lang('Go to Report') }}</a>
            </div>
        </div>
    </div>

        <div class="col-md-4 mx-auto">
        <div class="card card-box border border-primary">
            <div class="card-body text-center">
                <i class="fa fa-registered fa-4x" aria-hidden="true"></i>
                <h4 class="card-title">{{ _lang('Customer Report') }}</h4>
                <a href="{{ route('admin.report.getCustomerSuppliers') }}" class="btn btn-primary btn-sm">{{ _lang('Go to Report') }}</a>
            </div>
        </div>
    </div>

        <div class="col-md-4 mx-auto">
        <div class="card card-box border border-primary">
            <div class="card-body text-center">
                <i class="fa fa-registered fa-4x" aria-hidden="true"></i>
                <h4 class="card-title">{{ _lang('Trail Balance') }}</h4>
                <a href="{{ route('admin.report.trail_balance') }}" class="btn btn-primary btn-sm">{{ _lang('Go to Report') }}</a>
            </div>
        </div>
    </div>
    </div>
     <div class="row mt-2">
            <div class="col-md-6">
        <div class="card card-box border border-primary">
            <div class="card-body text-center">
                <i class="fa fa-registered fa-4x" aria-hidden="true"></i>
                <h4 class="card-title">{{ _lang('Monthly Report') }}</h4>
                <a href="{{ route('admin.report.monthly_report') }}" class="btn btn-primary btn-sm">{{ _lang('Go to Report') }}</a>
            </div>
        </div>
    </div>

        <div class="col-md-6">
        <div class="card card-box border border-primary">
            <div class="card-body text-center">
                <i class="fa fa-registered fa-4x" aria-hidden="true"></i>
                <h4 class="card-title">{{ _lang('Yearly Report') }}</h4>
                <a href="{{ route('admin.report.yearly_report') }}" class="btn btn-primary btn-sm">{{ _lang('Go to Report') }}</a>
            </div>
        </div>
    </div>
     </div>
<!-- /basic initialization -->
@stop
{{-- Script Section --}}
@push('scripts')
<script>
    $('.select').select2();

</script>
<script src="{{ asset('js/department/request.js') }}"></script>

@endpush
