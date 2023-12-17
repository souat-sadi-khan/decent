@extends('layouts.app', ['title' => _lang('Department'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
  <div>
    <h1 data-placement="bottom" title="Department."><i class="fa fa-universal-access mr-4"></i> {{_lang('Department')}}</h1>
  </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <a class="btn btn-danger btn-sm" href="{!!  url()->previous() !!}"><i class="fa fa-backward" aria-hidden="true"></i>{{ _lang('Go Back') }}</a>
      <div class="tile-body">
        <div class="row">
          <div class="col-md-5">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>{{ _lang('Department Name') }}</th>
                  <th>{{ $model->name }}</th>
                </tr>
                <tr>
                  <th>{{ _lang('Department Head') }}</th>
                  <th>{{ $model->employee->name }}</th>
                </tr>
                <tr>
                  <th>{{ _lang('Description') }}</th>
                  <th>{{ $model->description }}</th>
                </tr>
                <tr>
                  <th>{{ _lang('Store Request') }}</th>
                  <th>
                    @can('store_request.create')
                    <a href="{{ route('admin.request.department',$model->id) }}" class="btn btn-success btn-sm" target="_blank">
                      <i class="fa fa-share-square" aria-hidden="true"></i>
                      {{ _lang('Send Store Request') }}
                    </a>
                    @endcan
                  </th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="col-md-7">
            @can('production_department.create')
            <button data-placement="bottom" title="Create New Department" type="button" class="btn btn-info btn-sm" id="content_managment" data-url ="{{ route('admin.depertment_new_employee',$model->id) }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i>{{_lang('New Employee')}}</button>
            @endcan
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>{{ _lang('Employee Name') }}</th>
                  <th>{{ _lang('Designation') }}</th>
                  <th>{{ _lang('Action') }}</th>
                </tr>
                @foreach ($model->depertment_employee as $element)
                <tr>
                  <td>{{ $element->employee->name }}</td>
                  <td>{{ $element->designation }}</td>
                  <td>
                    @can('production_department.delete')
                    <a href="" data-id ="{{$element->id}}" data-url="{{route('admin.depertment.employee.delete',$element->id)  }}" id="delete_item" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> {{ _lang('Remove') }}</a>
                    @endcan
                  </td>
                </tr>
                @endforeach
              </thead>
            </table>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h3 class="border border-primary text-center py-2">Production ingredients category</h3>
            <div class="row">
              @can('production_department.create')
              <button data-placement="bottom" title="Create New Department" type="button" class="btn btn-info btn-sm" id="content_managment" data-url ="{{ route('admin.depertment_new_category',$model->id) }}">
              <i class="fa fa-plus-square mr-2" aria-hidden="true"></i>
              {{_lang('New ingredients category')}}
              </button>
              @endcan
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>{{ _lang('Category') }}</th>
                    <th>{{ _lang('Action') }}</th>
                  </tr>
                </thead>
                <thead>
                  @foreach ($model->igcategory as $category)
                  {{--  {{ dd($category) }} --}}
                  <tr>
                    <td>{{ $category->ingcategory->name }}</td>
                    <td>
                      @can('production_department.create')
                      <a href="" class="btn btn-danger btn-sm" data-id ="{{$category->id}}" data-url="{{route('admin.depertment.category.delete',$category->id)  }}" id="delete_item"><i class="fa fa-trash"></i> {{ _lang('Remove') }}</a>
                      @endcan
                    </td>
                  </tr>
                  @endforeach
                </thead>
              </table>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h3 class="text-center py-2 border border-primary">Store Request</h3>
            <div class="row">
              <table class="table table-bordered example">
                <thead>
                  <tr>
                    <th>{{ _lang('Date') }}</th>
                    <th>{{ _lang('Status') }}</th>
                    <th>{{ _lang('Total Materials Qty') }}</th>
                    <th>{{ _lang('Action') }}</th>
                  </tr>
                </thead>
                <thead>
                  @foreach ($model->depertment_request as $store)
                  {{--  {{ dd($category) }} --}}
                  <tr>
                    <td>{{ formatDate($store->request_date) }}</td>
                    <td>
                      {{ $store->status }}
                    </td>
                    <td>
                      {{ $store->store_request->sum('qty') }}
                    </td>
                    <td>
                      @can('store_request.view')
                      <a href="{{ route('admin.report.approve_request',$store->id) }}" class="btn btn-success btn-sm" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i>{{ _lang('Submit Report') }}
                      </a>
                      @endcan
                      @can('store_request.view')
                      <a onclick="myFunction('{{route('admin.total_matrial_report_print',$store->id)}}')" class="btn btn-warning text-light btn-sm"><i class="fa fa-print" aria-hidden="true"></i>{{ _lang('Print') }}
                      </a>
                      @endcan
                      @can('store_request.delete')
                      <a href="" data-id ="{{$store->id}}" data-url="{{route('admin.mainrequest.destroy',$store->id)  }}" id="delete_item" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> {{ _lang('Remove') }}
                      </a>
                      @endcan
                    </td>
                  </tr>
                  @endforeach
                </thead>
              </table>
            </div>
          </div>
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
<script src="{{ asset('js/department/department_details.js') }}"></script>
<script>
$('.example').DataTable();
</script>
@endpush