@extends('layouts.app', ['title' => _lang('Approve Request'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
  <div>
    <h1 data-placement="bottom" title="Approve Request."><i class="fa fa-universal-access mr-4"></i> {{_lang('Approve Request')}}</h1>
  </div>
</div>
@stop
{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="row">
  <div class="col-md-12">
    <div class="tile">
      <div class="tile-body">
        <h3 class="">Store Request</h3>
                  <div class="row">
                      <table class="table table-bordered">
                          <thead>
                              <tr>
                                  <th>{{ _lang('Date') }}</th>
                                  <th>{{ _lang('Material') }}</th>
                                  <th>{{ _lang('Approved Qty') }}</th>
                                  <th>{{ _lang('Action') }}</th>
                              </tr>
                          </thead>
                          <thead>
                              @foreach ($model->store_request as $element)
                                @foreach ($element->approve_store_item as $store)
                                <tr>
                                    <td>{{ formatDate($store->request_date) }}</td>
                                     <td>
                                      {{$store->material?$store->material->name:''}}
                                     </td>
                                     <td>
                                       {{ $store->qty }}
                                     </td>
                                     <td>
                                      @can('production_department.create')
                                        <a href="{{ route('admin.department.flow',$store->id) }}" class="btn btn-success btn-sm">{{ _lang('Flow') }}
                                        </a>
                                        @endcan
                                        @can('production_department.delete')
                                       <a href="" data-id ="{{$store->id}}" data-url="{{route('admin.request.destroy',$store->id)  }}" id="delete_item" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> {{ _lang('Remove') }}
                                       </a>
                                       @endcan
                                     </td>

                                </tr>
                                   @endforeach
                              @endforeach
                          </thead>
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
<script src="{{ asset('js/department/department_details.js') }}"></script>
@endpush