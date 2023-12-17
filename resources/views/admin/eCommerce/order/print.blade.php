
@extends('layouts.app', ['title' => _lang('Ecommerce Order List'), 'modal' => 'xl'])
@push('admin.css')
    <link rel="stylesheet" href="{{asset('backend/css/daterangepicker.css')}}">
@endpush
{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="E-Commerce Order List."><i class="fa fa-shopping-cart mr-4"></i> {{_lang('E-Commerce Order List')}}</h1>
            <p>{{_lang('View all request for E-Commerce Order List')}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('ecommerce-ordeer-list') }}
        </ul>
    </div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="card">
    <div class="card-body">
        <div id="print_table" style="color:black">
            <span class="text-center">
                <h3><b class="text-uppercase">{{ get_option('site_title') }}</b></h3>
                <h5> {{ get_option('description') }} </h5>
                <h6>{{ get_option('phone') }},{{ get_option('email') }}</h6>
            
            </span>
            <div class="text-center col-md-12">
                <h4 style="margin:0px ; margin-top: 7px; border:solid 1px #000; border-radius:50px; display:inline-block; padding:10px;"
                    class="bg-success text-light">
                    <b>Curier Print</b></h4>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-sm">
                    <tbody>
                        <tr>
                            <td>
        
                                <p style="margin:0px ; margin-top: -8px;">
        
                                    Report Of Date : <span class="ml-1">{{ formatDate(date('Y-m-d'))}}</span>
        
                                </p>
        
                            </td>
                            <td class="text-center">
        
                            </td>
                            <td class="text-right">
                                <p style="margin:0px ; margin-top: -8px;">Printing Date :
                                    <span></span> {{ date('d F, Y') }} </span></p>
                                <p style="margin:0px ; margin-top: -4px;">Time :
                                    <span></span>{{date('h:i:s A')}}</span></p>
                            </td>
                        </tr>
        
                    </tbody>
                </table>
            </div>
            <div class="tavle-responsice col-md-12">
                {{-- <h6 class="text-center py-2">{{ formatDate($start_date) }}-{{ formatDate($end_date) }} </h6> --}}
                <table class="table table-bordered table-striped table-sm">
                    <thead class="table-info"> 
                        <tr>
                            <th>Artical</th>
                            <th>Product Name</th>
                            <th>Quantity.</th>
                            <th>Size</th>
                            <th>Invoice</th>
                            <th>Barcode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($data))
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item['Artical'] }}</td>
                                    <td>{{ $item['Name'] }}</td>
                                    <td>{{ $item['Quantity'] }}</td>
                                    <td>{{ toWord($item['Size']) }}</td>
                                    <td>{{ $item['Invoice'] }}</td>
                                    <td>  <img src='https://barcode.tec-it.com/barcode.ashx?data={{ $item["Invoice"]}}' alt='Barcode Generator TEC-IT'/ width="70px"></td>
                                </tr>
                            @endforeach
                        @else 
                            <tr>
                                <td colspan="7" class="text-center">No Data Found !</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        
        
           
            <br>
            {{-- <h5>In Words: {{ucwords($in_words)}} Taka Only.</h5> --}}
            <br><br><br>
        
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-4 text-center">
                    <hr class="border-dark">
                    <p> Chief Cashier </p>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4 text-center">
                    <hr class="border-dark">
                    <p> Manager </p>
                </div>
                <div class="col-md-1"></div>
        
        
            </div>
        
        
        </div>
    </div>

    <div class="text-center mb-3">


        @php
        $print_table = 'print_table';
    
        @endphp
    
        <a class="text-light btn-primary btn" onclick="printContent('{{ $print_table }}')" name="print"
            id="print_receipt">
            <i class="fa fa-print" aria-hidden="true"></i>
            Print Report
    
        </a>
    </div>
    
</div>



<!-- /basic initialization -->
@stop

{{-- Script Section --}}
@push('scripts')
<script>
    function printContent(el) {
        console.log('print clicked');

        var a = document.body.innerHTML;
        var b = document.getElementById(el).innerHTML;
        document.body.innerHTML = b;
        window.print();
        document.body.innerHTML = a;

        return window.location.reload(true);

    }
</script>
@endpush

