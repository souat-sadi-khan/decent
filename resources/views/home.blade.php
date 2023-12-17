@extends('layouts.app', ['title' => 'Dahsboard', 'modal' => false])

<style>

    .card-1{
        background-color: #14c1d7eb;
        border: 1px solid #0192a5;
        margin-bottom: 20px;
    }
    .card-1-bottom{
        background-color: #02bed6;
    }
    .card-2{
        background-color: #4caf50;
        border: 1px solid #028808;
        margin-bottom: 20px;
    }
    .card-2-bottom{
        background-color: #3aa53f;
    }
    .card-3{
        background-color: #f9652c;
        border: 1px solid #b93603;
        margin-bottom: 20px;
    }
    .card-3-bottom{
        background-color: #eb4d10;
    }
    .card-4{
        background-color: #f9a72c;
        border: 1px solid #c07300;
        margin-bottom: 20px;
    }
    .card-4-bottom{
        background-color: #e38a06;
    }

    i.icon.fa{
        float: right;
        position: relative;
        top: 5px;
        left: -10px;
        opacity: 0.5;
        color: #0000008a;
    }
    .info h4 {
        font-size: 16px;
    }
    .info p {
        font-size: 20px;
        margin-top: 10px;
    }

</style>

{{-- Header Option --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-toggle="tooltip" data-placement="bottom" title="Decent Footware Management Software Dashboard"><i
                    class="fa fa-dashboard mr-4"></i>{{_lang('Dashboard')}}</h1>
            <p>{{_lang('Dashboard for Decent Footware')}} </p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item">{{ Breadcrumbs::render('home') }}</li>
        </ul>
    </div>
@stop

@section('content')
    <!-- Basic initialization -->

    <div class="row">

    </div>

    <div class="card border-0 border-danger shadow rounded bg-white mb-5">
        <div class="card-header text-center"><h4>{{_lang('Employee Section')}} </h4></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card-1 pt-2 text-white rounded"><i class="icon fa fa-anchor fa-3x"></i>
                        <div class="info p-3">
                            <h4>{{_lang('Total Employee Category')}} </h4>
                            <p><b>
                                    @php
                                        $category = App\models\employee\EmployeeCategory::get();
                                        echo count($category)
                                    @endphp
                                </b></p>
                        </div>
                    </div>
                </div>
                <!-- Short Question -->
                <div class="col-md-4">
                    <div class="card-2 pt-2 text-white rounded"><i class="icon fa fa-university fa-3x"></i>
                        <div class="info p-3">
                            <h4>Total Employee Department</h4>
                            <p><b>
                                    @php
                                        $users = App\models\employee\Department::get();
                                        echo count($users)
                                    @endphp
                                </b></p>
                        </div>
                    </div>
                </div>

                <!-- True False -->
                <div class="col-md-4">
                    <div class="card-3 pt-2 text-white rounded"><i class="icon fa fa-user-o fa-3x"></i>
                        <div class="info p-3">
                            <h4>Total Employee</h4>
                            <p><b>
                                    @php
                                        $users = App\models\employee\Employee::get();
                                        echo count($users)
                                    @endphp
                                </b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border border-danger mt-3">
        <div class="card-header text-center"><h4>{{_lang('eCommerce Section')}} </h4></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card-4 pt-2 text-white rounded"><i class="icon fa fa-calendar-plus-o fa-3x"></i>
                        <div class="info p-3">
                            <h4>{{_lang('Today Sale')}} </h4>
                            <p><b>
                                    @php
                                        $count = App\models\Production\Transaction::where('created_at', Carbon\Carbon::today())->where('ecommerce_status', '!=', null)->sum('net_total');
                                        echo (get_option('currency') ? get_option('currency') : 'BDT' ). ' '. $count;
                                        echo '<br>'
                                    @endphp
                                </b></p>
                        </div>
                    </div>
                </div>
                <!-- Short Question -->
                <div class="col-md-4">
                    <div class="card-3 pt-2 text-white rounded"><i class="icon fa fa-calendar-check-o fa-3x"></i>
                        <div class="info p-3">
                            <h4>This Month's Sales</h4>
                            <p><b>
                                    @php
                                        $count = App\models\Production\Transaction::whereMonth('created_at', date('m'))->where('ecommerce_status', '!=', null)->sum('net_total');
                                        echo (get_option('currency') ? get_option('currency') : 'BDT' ). ' '. $count;
                                        echo '<br>'
                                    @endphp
                                </b></p>
                        </div>
                    </div>
                </div>

                <!-- True False -->
                <div class="col-md-4">
                    <div class="card-2 pt-2 text-white rounded"><i class="icon fa fa-calendar fa-3x"></i>
                        <div class="info p-3">
                            <h4>This Year's Sales</h4>
                            <p><b>
                                    @php
                                        $count = App\models\Production\Transaction::whereYear('created_at', date('Y'))->where('ecommerce_status', '!=', null)->sum('net_total');
                                        echo (get_option('currency') ? get_option('currency') : 'BDT' ). ' '. $count;
                                        echo '<br>'
                                    @endphp
                                </b></p>
                        </div>
                    </div>
                </div>

                <!-- Total Products -->
                <div class="col-md-4">
                    <div class="card-1 pt-2 text-white rounded"><i class="icon fa fa-archive fa-3x"></i>
                        <div class="info p-3">
                            <h4>Total Products</h4>
                            <p><b>

                            @php
                                $brand_id = get_option('default_brand');
                                $product = App\models\Production\VariationBrandDetails::where('brand_id', $brand_id)->get();
                                if(count($product)) {
                                    foreach ($product as $value) {
                                        $product_id[] = $value->product_id;
                                    }
                                } else {
                                    $product_id = [];
                                }
                                // $count = App\models\Production\Product::where('status', 'Active')->where('title', '!=', null)->get();
                                echo count($product_id);
                            @endphp
                            </b></p>
                        </div>
                    </div>
                </div>

                <!-- True False -->
                <div class="col-md-4">
                    <div class="card-4 pt-2 text-white rounded"><i class="icon fa fa-user fa-3x"></i>
                        <div class="info p-3">
                            <h4>Total Customers</h4>
                            <p><b>
                                    @php
                                        $count = App\models\Client::get();
                                        echo count($count)
                                    @endphp
                                </b></p>
                        </div>
                    </div>
                </div>

                <!-- True False -->
                <div class="col-md-4">
                    <div class="card-1 pt-2 text-white rounded"><i class="icon fa fa-newspaper-o fa-3x"></i>
                        <div class="info p-3">
                            <h4>Newsletter SUBSCRIBER</h4>
                            <p><b>
                                @php
                                    $count = App\models\eCommerce\Subscriber::get();
                                    echo count($count)
                                @endphp
                                </b></p>
                        </div>
                    </div>
                </div>

                <!-- Total Pending Order -->
                <div class="col-md-4">
                    <div class="card-2 pt-2 text-white rounded"><i class="icon fa fa-newspaper-o fa-3x"></i>
                        <div class="info px-3">
                            <h4>Total Pending Order</h4>
                            <p><b>
                                    @php
                                        echo App\models\Production\Transaction::where('ecommerce_status', 'pending')->orderBy('id', 'desc')->count()
                                    @endphp
                                </b></p>
                            </div>
                        <div class="card-2-bottom text-center py-1">
                            <a class="text-light" href="{{ route('admin.eCommerce.order.index', 'order=pending') }}"><span>More Infor</span></a>
                        </div>
                    </div>
                </div>

                <!-- Total Confirm Order -->
                <div class="col-md-4">
                    <div class="card-3 pt-2 text-white rounded"><i class="icon fa fa-newspaper-o fa-3x"></i>
                        <div class="info px-3">
                            <h4>Total Confirm Order</h4>
                            <p><b>
                                    @php
                                        echo App\models\Production\Transaction::where('ecommerce_status', 'confirm')->orderBy('id', 'desc')->count()
                                    @endphp
                                </b></p>
                        </div>
                        <div class="card-3-bottom text-center py-1">
                            <a class="text-white" href="{{ route('admin.eCommerce.order.index', 'order=confirm') }}"><span>More Info</span></a>
                        </div>
                    </div>
                </div>

                <!-- Total In Progressing Order -->
                <div class="col-md-4">
                    <div class="card-4 pt-2 text-white rounded"><i class="icon fa fa-newspaper-o fa-3x"></i>
                        <div class="info px-3">
                            <h4>Total In Progressing Order</h4>
                            <p><b>
                                    @php
                                        echo App\models\Production\Transaction::where('ecommerce_status', 'progressing')->orderBy('id', 'desc')->count()
                                    @endphp
                                </b></p>
                        </div>
                        <div class="card-4-bottom text-center py-1">
                            <a class="text-white" href="{{ route('admin.eCommerce.order.index', 'order=progressing') }}"><span>More Info</span></a>
                        </div>
                    </div>
                </div>

                <!-- Total In Shipment Order -->
                <div class="col-md-4">
                    <div class="card-4 pt-2 text-white rounded"><i class="icon fa fa-newspaper-o fa-3x"></i>
                        <div class="info px-3">
                            <h4>Total In Shipment Order</h4>
                            <p><b>
                                    @php
                                        echo App\models\Production\Transaction::where('ecommerce_status', 'shipmen')->orderBy('id', 'desc')->count()
                                    @endphp
                                </b></p>
                        </div>
                        <div class="card-4-bottom text-center py-1">
                            <a class="text-white" href="{{ route('admin.eCommerce.order.index', 'order=shipment') }}"><span>More Info</span></a>
                        </div>
                    </div>
                </div>

                <!-- Total Cancel Order -->
                <div class="col-md-4">
                    <div class="card-1 pt-2 text-white rounded"><i class="icon fa fa-newspaper-o fa-3x"></i>
                        <div class="info px-3">
                            <h4>Total Cancel Order</h4>
                            <p><b>
                                    @php
                                        echo App\models\Production\Transaction::where('ecommerce_status', 'cancel')->orderBy('id', 'desc')->count()
                                    @endphp
                                </b></p>
                        </div>
                        <div class="card-1-bottom text-center py-1">
                            <a class="text-white" href="{{ route('admin.eCommerce.order.index', 'order=cancel') }}"><span>More Info</span></a>
                        </div>
                    </div>
                </div>

                <!-- Total Success Order -->
                <div class="col-md-4">
                    <div class="card-2 pt-2 text-white rounded"><i class="icon fa fa-newspaper-o fa-3x"></i>
                        <div class="info px-3">
                            <h4>Total Success Order</h4>
                            <p><b>
                                    @php
                                        echo App\models\Production\Transaction::where('ecommerce_status', 'success')->orderBy('id', 'desc')->count()
                                    @endphp
                                </b></p>
                        </div>
                        <div class="card-2-bottom text-center py-1">
                            <a class="text-white" href="{{ route('admin.eCommerce.order.index', 'order=success') }}"><span>More Info</span></a>
                        </div>
                    </div>
                </div>

                {{-- Pending Order List --}}
                <div class="col-md-6 mt-3">
                    <div class="table-responsive">
                        <h4 class="text-center">Recent Ecommerce Order</h4>
                        <table style="font-size:15px;" class="table table-bordered table-striped">
                            <thead class="table-primary">
                            <tr>
                                <th>P. Type</th>
                                <th>T. Code</th>
                                <th>S. Name</th>
                                <th>Phone</th>
                                <th width="15%">Total</th>
                            </tr>
                            </thead>
                            @php
                                $query = App\models\Production\Transaction::where('transaction_type', 'ecommerce')->orderBy('id', 'desc')->limit(5)->get()
                                // $query = App\models\Production\Transaction::where('ecommerce_status', 'pending')->orderBy('id', 'desc')->limit(5)->get()
                            @endphp
                            <tbody>
                            @if (count($query))
                                {{-- @foreach ($query as $item)
                                    <tr>
                                        <td>
                                            @if ($item->ecommerce_status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($item->ecommerce_status == 'confirm')
                                            <span class="badge badge-primary"> Confirm</span>
                                            @elseif($item->ecommerce_status == 'progressing')
                                            <span class="badge badge-info">In Progressing</span>
                                            @elseif($item->ecommerce_status == 'shipment')
                                            <span class="badge badge-dark">In Shipment</span>
                                            @elseif($item->ecommerce_status == 'success')
                                                <span class="badge badge-success">Success</span>
                                            @else
                                                <span class="badge badge-danger">Cancel</span>
                                            @if ($item->payment_status == 'cash_on_delivery')
                                                Cash On Delivery
                                            @endif
                                        </td>
                                        <td>
                                            {{$item->reference_no}}
                                        </td>
                                        <td>{{get_client_name($item->client_id)}}</td>
                                        <td>{{get_client_phone($item->client_id)}}</td>
                                        <td>{{get_option('currency') ? '৳' : get_option('currenct') }}{{$item->net_total}}</td>
                                        <td>{{get_option('currency') ? '৳' : get_option('currenct') }} {{$item->net_total}}</td>
                                    </tr>
                                @endforeach --}}
                            @else
                                <tr>
                                    <td class="text-center" colspan="5">No Pending Order Found !</td>
                                </tr>
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="5" class="text-center"><a
                                        href="{{ route('admin.eCommerce.order.index') }}">View Info</a></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {{-- Recent Customer List --}}
                <div class="col-md-6 mt-3">
                    <div class="table-responsive">
                        <h4 class="text-center">Recently Added Customer</h4>
                        <table class="table table-bordered table-striped">
                            <thead class="table-primary">
                            <tr>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Address</th>
                                <th>Email</th>
                            </tr>
                            </thead>
                            @php
                                $query = App\models\Client::where('id', '!=', 1)->where('sub_type', 'ecommerce')->orderby('id', 'desc')->limit(5)->get()
                            @endphp
                            <tbody>
                            @if (count($query))
                                @foreach ($query as $item)
                                    <tr>
                                        <td>
                                            {{ $item->name }}
                                        </td>
                                        <td>
                                            {{$item->mobile}}
                                        </td>
                                        <td>{{$item->landmark}}</td>
                                        <td>{{$item->email}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center" colspan="5">No Customer Found !</td>
                                </tr>
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="5" class="text-center"><a href="{{ route('admin.client.index') }}">View
                                        Info</a></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    {{-- {!! $sells_graph->html() !!} --}}
                </div>
            </div>
        </div>

          <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    {{-- {!! $purchase_graph->html() !!} --}}
                </div>
            </div>
        </div>

             <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    {{-- {!! $line->html() !!} --}}
                </div>
            </div>
        </div>

            <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    {{-- {!! $donut->html() !!} --}}
                </div>
            </div>
        </div>
    </div>

    <!-- /basic initialization -->
{{-- {!! Charts::scripts() !!} --}}
{{-- {!! $sells_graph->script() !!}
{!! $line->script() !!}
{!! $purchase_graph->script() !!}
{!! $donut->script() !!} --}}
@stop

