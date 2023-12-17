@extends('layouts.app', ['title' => _lang('Customer'), 'modal' => 'lg'])
{{-- Header Section --}}
@section('page.header')
    <div class="app-title">
        <div>
            <h1 data-placement="bottom" title="Customer."><i class="fa fa-universal-access mr-4"></i> {{_lang('Customer')}}</h1>
            <p>{{_lang('Create Customer. Here you can Add, Edit & Delete Customer')}}</p>
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
                    <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.eCommerce.e_customer') }}">
                        <thead>
                            <tr>
                                <th>{{_lang('Name')}}</th>
                                <th>{{_lang('Mobile')}}</th>
                                <th>{{_lang('Address')}}</th>
                                <th>{{_lang('Email')}}</th>
                                <th>{{_lang('Sale Due')}}</th>
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
    {{-- <script src="{{ asset('backend/js/plugins/buttons.min.js') }}"></script> --}}
    <script src="{{ asset('backend/js/plugins/responsive.min.js') }}"></script>
   <script>
            emran = $('.content_managment_table').DataTable({
            responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },
            dom: 'Bfrtip',
            buttons: [{
                extend: 'copy',
                className: 'btn btn-primary glyphicon glyphicon-duplicate'
            }, {
                extend: 'csv',
                className: 'btn btn-primary glyphicon glyphicon-save-file'
            }, {
                extend: 'excel',
                className: 'btn btn-primary glyphicon glyphicon-list-alt'
            }, {
                extend: 'pdf',
                className: 'btn btn-primary glyphicon glyphicon-file'
            }, {
                extend: 'print',
                className: 'btn btn-primary glyphicon glyphicon-print'
            }],
            columnDefs: [{
                orderable: false,
                targets: [4]
            }],

            order: [0, 'asc'],
            processing: true,
            serverSide: true,

            ajax: $('.content_managment_table').data('url'),
            columns: [
                // { data: 'checkbox', name: 'checkbox' },
                 {
                    data: 'name',
                    name: 'name'
                }, {
                    data: 'mobile',
                    name: 'mobile'
                }, {
                    data: 'address',
                    name: 'address'
                }, {
                    data: 'email',
                    name: 'email'
                },{
                    data: 'due',
                    name: 'due'
                }, {
                    data: 'action',
                    name: 'action'
                }
            ]

        });

              $(document).on('click', '#content_managment', function(e) {
            e.preventDefault();
            //open modal
            $('#modal_remote').modal('toggle');
            // it will get action url
            var url = $(this).data('url');
            // leave it blank before ajax call
            $('.modal-body').html('');
            // load ajax loader
            $('#modal-loader').show();
            $.ajax({
                    url: url,
                    type: 'Get',
                    dataType: 'html'
                })
                .done(function(data) {
                    $('.modal-body').html(data).fadeIn(); // load response
                    $('#modal-loader').hide();
                    $('#branch_no').focus();
                    _modalFormValidation();
                    _componentSelect2Normal();
                    _componentDatefPicker();
                })
                .fail(function(data) {
                    $('.modal-body').html('<span style="color:red; font-weight: bold;"> Something Went Wrong. Please Try again later.......</span>');
                    $('#modal-loader').hide();
                });
        });      
   </script>
@endpush

