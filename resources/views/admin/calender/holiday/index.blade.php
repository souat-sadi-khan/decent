@extends('layouts.app', ['title' => _lang('Holiday'), 'modal' => 'lg'])
@push('css')
@endpush
{{-- Header Section --}}
@section('page.header')
<div class="app-title">
    <div>
        <h1 data-placement="bottom" title="Holiday."><i class="fa fa-calendar mr-4"></i> {{_lang('Holiday')}}
        </h1>
        <p>{{_lang('Create Holiday. Here you can Add, Edit & Delete The Holidays')}}</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        {{ Breadcrumbs::render('holiday') }}
    </ul>
</div>
@stop

{{-- Main Section --}}
@section('content')
<!-- Basic initialization -->
<div class="row">
    {{-- following section is for the form --}}
    @can('holiday.create')
    <div class="col-md-4">
        <div class="tile">
            <div class="tile-head mb-2">
                {{_lang('Add Holiday')}}
                <hr>
            </div>
            <div class="tile-body">
                <form action="{{route('admin.holiday.store')}}" method="post" id="content_form">
                    @csrf
                    <div class="row">
                        {{-- Calender for selecting holidays --}}
                        <div class="col-md-12 form-group">
                            <label for="calender">{{_lang('Select Holidays')}} <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="calender" id="holiday_calender" class="form-control date_format"
                                placeholder="Select Date" readonly required>
                        </div>

                        {{-- Selected holidays --}}
                        <div class="col-md-12 form-group">
                            <input type="text" name="holiday" id="holiday" class="form-control w-100" >
                        </div>

                        {{-- Holiday Description --}}
                        <div class="col-md-12 form-group">
                            <label for="name">{{_lang('Purpose')}} <span class="text-danger">*</span>
                            </label>
                            <textarea required name="description" class="form-control" id=""
                                placeholder="Purpose Of This Day"></textarea>
                        </div>

                        @can('holiday.create')
                        <div class="form-group col-md-12" align="right">
                            {{-- <input type="hidden" name="type[]" value=" "> --}}
                            <button type="submit" class="btn btn-primary" id="submit">{{_lang('Create')}}<i
                                    class="icon-arrow-right14 position-right"></i></button>
                            <button type="button" class="btn btn-link" id="submiting"
                                style="display: none;">{{_lang('Processing')}}<img src="{{ asset('ajaxloader.gif') }}"
                                    width="80px"></button>
                            <button type="reset" class="btn btn-danger" data-dismiss="modal">Reset</button>
                        </div>
                        @endcan
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan

    {{-- The following section is for the table to show data  --}}
    @can('holiday.view')
    <div class="col-md-8">
        <div class="tile">

            <div class="tile-body">
                <table class="table table-hover table-bordered content_managment_table"
                    data-url="{{ route('admin.holiday.datatable') }}">
                    <thead>
                        <tr>
                            <th>{{_lang('Sl No')}}</th>
                            <th>{{_lang('Date')}}</th>
                            <th>{{_lang('Description')}}</th>
                            <th>{{_lang('action')}}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
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
<script src="{{ asset('backend/js/plugins/buttons.min.js') }}"></script>
<script src="{{ asset('backend/js/plugins/responsive.min.js') }}"></script>
<script src="{{ asset('js/pages/bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('js/pages/holiday.js') }}"></script>

<script>
    $('#holiday').tagsinput({
        tagClass: 'btn btn-sm btn-info mt-1'
    })
    
    /*  $('.bootstrap-tagsinput input').keydown(function (event) {
         if (event.which == 13) {
             $(this).blur();
             $(this).focus();
             return false;
         }
     }) */



    $(document).ready(function () {
        var dates = [];
        var i = 0;
        var i = 0;
        $('.date').attr('readonly', true);
        date_p();
        $(document).on('change', '#holiday_calender', function () {
            var selected_date = $(this).val();
            if (selected_date) {
                $('#holiday').tagsinput('add', selected_date);
                dates[i] = selected_date;
                var show_date = dates.pop();
                i++;
            }
        });
    });

    function date_p() {
        $('.date_format').datepicker({
            dateFormat: "yy-mm-dd",
            autoclose: true,
            daysOfWeekDisabled: [5],
            todayHighlight: true,
        });
    }

</script>
@endpush
