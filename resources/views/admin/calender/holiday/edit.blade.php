<div class="card">
    <div class="card-header">
        <h6>{{_lang('Edit Holiday For Date - ')}} <span class="badge badge-primary">{{carbonDate($model->date)}} </span>
        </h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.holiday.update', $model->id)}}" method="post" class="ajax_form">
            @csrf
            @method('PATCH')
            <div class="row">
                {{-- Calender for selecting holidays --}}
                <div class="col-md-12 form-group">
                    <label for="calender">{{_lang('Select Holidays')}}
                    </label>
                    <input type="text" name="calender" id="calender" class="form-control date"
                placeholder="Select Date" readonly required value="{{($model->date)}}">
                </div>

                {{--Holiday  Description --}}
                <div class="col-md-12 form-group">
                    <label for="name">{{_lang('Description')}}
                    </label>
                    <textarea name="description" class="form-control" id=""
                placeholder="Enter Holiday Description">{{$model->description}}</textarea>
                </div>

                @can('holiday.update')
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

<script>
 $('.date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            daysOfWeekDisabled: [5],
            todayHighlight: true,
        });
</script>
