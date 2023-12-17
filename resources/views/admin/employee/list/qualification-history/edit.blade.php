<div class="card">
    <div class="card-header">
        <h6>{{_lang('Edit Employee Qualification Information')}}</h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.employee-qua.update',$model->id)}}" method="post" id="content_form" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            @include('admin.employee.list.qualification-history.form')
            <div class="form-group col-md-12" align="right">
                <button type="submit" class="btn btn-primary btn-sm" id="submit">{{_lang('Save')}}<i class="fa ml-2 fa-crosshairs" aria-hidden="true"></i></button>
                <button type="button" class="btn btn-success btn-sm " id="submiting" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>{{_lang('Loading...')}} </button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('.date').attr('readonly', '1');
    $('.date').datepicker({
        format: "yyyy/mm/dd",
        autoclose: true,
        todayHighlight: true,
        changeMonth: true,
		changeYear: true
    });
    $('.select').select2({ width: '100%' });
</script>