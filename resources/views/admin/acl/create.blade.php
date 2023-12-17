@extends('layouts.app', ['title' => _lang('Create User Role System'), 'modal' => 'lg'])

{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Create Role & Permission System for Users."><i class="fa fa-universal-access mr-4"></i> {{_lang('Create Roll & Permission')}}</h1>
            <p>{{_lang('Create New Role & Permission System for Users.')}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            {{ Breadcrumbs::render('role/create') }}
        </ul>
    </div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    {!! Form::open(['route' => 'admin.user.role.create', 'id'=>'content_form','files' => true, 'method' => 'POST']) !!}
                        <div class="row">
                            <div class="col-md-4 mx-auto">
                                <div class="form-group">
                                    {{ Form::label('name', _lang('Roll Name') , ['class' => 'col-form-label required']) }}
                                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => _lang('Enter Roll Name'),'required'=>'']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12 table-responsive">
                            <h2>{{_lang('permission')}}</h2>
                                <table class="table table-bordered">
                                    @foreach (split_name($permissions) as $key => $element)
                                        <tr>
                                            <td rowspan ="{{count($element)+1}}">{!! $key !!} </td>
                                            <td rowspan="{{count($element)+1}}">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input select_all" id="select_all_{{tounderscore($key)}}" data-id="{{tounderscore($key)}}">
                                                    <label class="custom-control-label" for="select_all_{{tounderscore($key)}}">{{_lang('select_all')}}</label>
                                                </div>
                                            </td>
                                        </tr>
                                        @foreach ($element as $per)
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input {{tounderscore($key)}}" id="{{$per}}" multiple="multiple" name="permissions[]" value="{{$per}}">
                                                        <label class="custom-control-label" for="{{$per}}">{{tospane($per)}}</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($key=='Accounting')
                                           <tr>
                                               <td colspan="3" class="text-center bg-green">{{ _lang('Visible Some Section') }}</td>
                                           </tr>
                                        @endif
                                    @endforeach
                              
                                </table>
                            </div>
                            @can('role.create')
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary"  id="submit">{{_lang('set_permission')}}<i class="icon-arrow-right14 position-right"></i></button>
                                    <button type="button" class="btn btn-info" id="submiting" style="display: none;">{{_lang('processing')}}  <i class="fa fa-spinner fa-spin" style="font-size: 20px" aria-hidden="true"></i></button>
                                </div>
                            @endcan
                        {!!Form::close()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- /basic initialization -->
@stop

{{-- Script Section --}}
@push('scripts')
    <script src="{{ asset('js/pages/role.js') }}"></script>
    <script>
        $(document).on('click','.select_all',function(){
            var id =$(this).data('id');
            if (this.checked) {
                $("."+id).prop('checked', true);
            } else{
                $("."+id).prop('checked', false);
            }
        });
    </script>
@endpush

