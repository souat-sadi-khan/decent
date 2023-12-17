@extends('layouts.app', ['title' => _lang('Production Category'), 'modal' => 'lg'])
@push('admin.css')
<link rel="stylesheet" href="{{ asset('jstree/dist/themes/default/style.min.css') }}" />
@endpush
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Production Category for Users."><i class="fa fa-universal-access mr-4"></i>
            {{_lang('Production Category')}}</h1>
        <p>{{_lang('Create Production Category for Users. Here you can Add, Edit & Delete The Production Category')}}
        </p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        {{ Breadcrumbs::render('production-category') }}
    </ul>
</div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="card border-top-success rounded-top-0" id="table_card">
    <div class="card-header header-elements-inline bg-light border-grey-300">
        <h3 class="tile-title">
                    @can('production_category.create')
                        <button data-placement="bottom" title="Create New Production Category" type="button" class="btn btn-info" id="content_managment" data-url ="{{ route('admin.production-category.create') }}"><i class="fa fa-plus-square mr-2" aria-hidden="true"></i></i>{{_lang('create')}}</button>
                    @endcan
                </h3>

        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="fullscreen" title="{{ _lang('fullscreen') }}"
                    data-popup="tooltip" data-placement="bottom"></a>
                <a class="list-icons-item" data-action id="reload" title="{{ _lang('reload') }}" data-popup="tooltip"
                    data-placement="bottom"><i class="icon-reload-alt"></i></a>
                <a class="list-icons-item" data-action="collapse" title="{{ _lang('collapse') }}" data-popup="tooltip"
                    data-placement="bottom"></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="text-center">
                            <h4>{{_lang('Catagory Tree')}} </h4>
                        </div>
                    </div>
                    <div id="tree-default">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /basic initialization -->
@stop
@push('scripts')

<script src="{{ asset('backend/js/plugins/select.min.js') }}"></script>
<script src="{{ asset('backend/js/plugins/responsive.min.js') }}"></script>
<script src="{{ asset('js/production/category.js') }}"></script>

<!-- Theme JS files -->
<script src="{{ asset('jstree/dist/jstree.min.js') }}"></script>

<script>
    $.jstree.defaults.core.themes.variant = "large";
    $('#tree-default').jstree({
        'core': {
            'data': {
                'url': '{{ route('admin.production-category.index') }}',
                'data': function (node) {
                    console.log(node);
                    return {
                        'id': node.id
                    };
                }
            }
        }
    });

    function delete_item(url) {
        swal({
                title: "Are you sure?",
                text: "Once deleted, it will deleted all related Data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: url,
                        method: 'Delete',
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false,
                        dataType: 'JSON',
                        success: function (data) {
                            if (data.status == 'danger') {
                                new PNotify({
                                    title: 'Error',
                                    text: data.message,
                                    type: 'error',
                                    addclass: 'alert alert-danger alert-styled-left',
                                });

                            } else {
                                new PNotify({
                                    title: 'Well Done!',
                                    text: data.message,
                                    type: 'success',
                                    addclass: 'alert alert-styled-left',
                                });
                            }
                            if (data.goto) {
                                setTimeout(function () {

                                    window.location.href = data.goto;
                                }, 2500);
                            }
                        },
                        error: function (data) {
                            var jsonValue = $.parseJSON(data.responseText);
                            const errors = jsonValue.errors
                            var i = 0;
                            $.each(errors, function (key, value) {
                                new PNotify({
                                    title: 'Error',
                                    text: value,
                                    type: 'error',
                                    addclass: 'alert alert-danger alert-styled-left',
                                });
                                i++;
                            });

                        }
                    });
                }
            });
    }

</script>

<!-- /theme JS files -->
@endpush
