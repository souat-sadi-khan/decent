@extends('layouts.app', ['title' => _lang('Employee Leave Request'), 'modal' => 'lg'])

{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Employee Leave Request."><i class="fa fa-universal-access mr-4"></i>
            {{_lang('Employee Leave Request')}}</h1>
        <p>{{_lang('Create Employee Leave Request. Here you can Add, Edit & Delete The Employee Leave Request')}}</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        {{ Breadcrumbs::render('employee-leave-request') }}
    </ul>
</div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="row">
    <div class="col-12 col-sm-6">
        <div class="card border-right">
            <div class="card-body">
                <h4 class="card-title m-3">Leave Request Detail</h4>
                <div class="table-responsive">
                    <table class="table table-sm custom-show-table">
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>{{$model->employee->name}}</td>
                            </tr>
                            <tr>
                                <td>Code</td>
                                <td>({{$model->employee->prefix}}{{numer_padding($model->employee->code, get_option('digits_employee_code'))}})</td>
                            </tr>
                            <tr>
                                <td>Designation</td>
                                <td>{{current_designation($model->employee_id)}}</td>
                            </tr>
                            <tr>
                                <td>Period</td>
                                <td>{{$model->start_date}} to {{$model->end_date}}</td>
                            </tr>
                            <tr>
                                <td>Count</td>
                                <td>
                                    {{to_date($model->start_date, $model->end_date)}}
                                </td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>
                                    @if ($model->status == 'pending')
                                       <span class="badge badge-info">Pending</span> 
                                    @elseif($model->status == 'approved')
                                       <span class="badge badge-success">Approved</span> 
                                    @elseif($model->status == 'rejected')
                                       <span class="badge badge-danger">Rejected</span> 
                                    @elseif($model->status == 'cancelled')
                                       <span class="badge badge-warning">Cancelled</span> 
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Reason</td>
                                <td>{{$model->reason}}</td>
                            </tr>
                            <tr>
                                <td>Requested by</td>
                                <td>
                                    {{$model->request->name}}
                                </td>
                            </tr>
                            <tr>
                                <td>Created at</td>
                                <td>{{$model->created_at}}</td>
                            </tr>
                            <tr>
                                <td>Last Updated at</td>
                                <td>{{$model->updated_at}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!---->
                <h4 class="card-title m-3">Leave Allocation</h4>
                <div class="table-responsive">
                    <table class="table table-sm custom-show-table">
                        <tbody>
                            <tr>
                                <td>Period</td>
                                <td>{{$allocation->start_date}} to {{$allocation->end_date}}</td>
                            </tr>
                            @foreach ($leave as $item)
                            <tr>

                                    <td>{{$item->leave_type->name}}</td>
                                    <td>{{$item->used ? $item->used : '0'}}/{{$item->allotted ? $item->allotted : '0'}}</td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6">
        <div class="card">
            <div class="card-body border-right p-4">
                <form action="{{route('admin.employee-leave-request.details')}}" method="post" id="content_form">
                    @csrf
                <input type="hidden" name="id" value="{{$model->id}}">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group"><label for="">Status</label> 
                                <select name="status" required class="custom-select col-12">
                                    <option value="null">Select One</option>
                                    <option {{$model->status == 'pending'?'selected':''}} value="pending">
                                        Pending
                                    </option>
                                    <option {{$model->status == 'approved'?'selected':''}} value="approved">
                                        Approved
                                    </option>
                                    <option {{$model->status == 'rejected'?'selected':''}} value="rejected">
                                        Rejected
                                    </option>
                                    <option {{$model->status == 'cancelled'?'selected':''}} value="cancelled">
                                        Cancelled
                                    </option>
                                </select>
                                <!---->
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group"><label for="">Comment</label> <textarea rows="3"
                                    placeholder="Comment" required name="comment" class="form-control"></textarea>
                                <!---->
                            </div>
                        </div>
                    </div>
                    <div class="form-group"><button type="submit" class="btn btn-info">Update</button></div>
                </form>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Comment</th>
                                <th>Updated by</th>
                                <th>Last Updated at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($request)
                            @foreach ($request as $item)
                            <tr>
                                <td>
                                   @if ($item->status == 'pending')
                                       <span class="badge badge-info">Pending</span> 
                                    @elseif($item->status == 'approved')
                                       <span class="badge badge-success">Approved</span> 
                                    @elseif($item->status == 'rejected')
                                       <span class="badge badge-danger">Rejected</span> 
                                    @elseif($item->status == 'cancelled')
                                       <span class="badge badge-warning">Cancelled</span> 
                                    @endif
                                </td>
                                @if (auth()->user()->employee_id)
                                @php
                                    $employee = App\models\employee\Employee::where('id',auth()->user()->employee_id)->first();
                                @endphp
                                    <td>{{$employee->name}} ({{$employee->prefix}}{{numer_padding($employee->code, get_option('digits_employee_code'))}})</td>
                                @else 
                                @php
                                    $name = App\models\User::select('name')->where('id',auth()->user()->id)->first();
                                @endphp
                                    <td>{{$name->name}}</td>
                                @endif
                                <td>{{$item->comment}}</td>
                                
                                <td>{{$item->updated_at}}</td>
                            </tr>
                            @endforeach
                            @else
                               <td class="text-center">Data Not Found</td> 
                            @endif
                        </tbody>
                    </table>
                </div>
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
<script src="{{ asset('js/employee/leave_request.js') }}"></script>
@endpush
