<div class="card">
    <div class="card-header">
        <h6>{{_lang('Edit Employee Account Information')}}</h6>
    </div>
    <div class="card-body">
        <form action="{{route('admin.account.update', $model->id)}}" method="post" id="content_form">
            @csrf
            @method('PATCH')
            <input type="hidden" name="uuid" value="{{$model->employee->uuid}}">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="name">{{_lang('Account Name')}} <span class="text-danger">*</span></label> 
                        <input value="{{$model->name}}" required type="text" name="name" id="name" autocomplete="off" placeholder="Account Name" class="form-control">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="account_number">{{_lang('Account Number')}} <span class="text-danger">*</span></label> 
                        <input value="{{$model->account_number}}" required type="text" name="account_number" id="account_number" autocomplete="off" placeholder="Account Number" class="form-control">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="bank_name">{{_lang('Bank Name')}} <span class="text-danger">*</span></label> 
                        <input value="{{$model->bank_name}}" required type="text" name="bank_name" id="bank_name" autocomplete="off" placeholder="Bank Name" class="form-control">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="branch_name">{{_lang('Branch Name')}} <span class="text-danger">*</span></label> 
                        <input value="{{$model->branch_name}}" required type="text" name="branch_name" id="branch_name" autocomplete="off" placeholder="Branch Name" class="form-control">
                    </div>
                </div>
                <div class="col-12 col-sm-12">
                    <div class="form-group">
                        <label for="bank_identification_code">{{_lang('Bank Identification Code')}} <span class="text-danger">*</span></label> 
                        <input value="{{$model->bank_identification_code}}" autocomplete="off" id="bank_identification_code" required type="text" name="bank_identification_code" placeholder="Bank Identification Code" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="description">{{_lang('Description')}}</label>
                <textarea required rows="2" placeholder="Description" name="description" class="form-control">{{$model->description}}</textarea>
            </div> 
            
            <div class="form-group col-md-12" align="right">
                <button type="submit" class="btn btn-primary btn-sm" id="submit">{{_lang('Save')}}<i class="fa ml-2 fa-crosshairs" aria-hidden="true"></i></button>
                <button type="button" class="btn btn-success btn-sm " id="submiting" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>{{_lang('Loading...')}} </button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $('.date').datepicker({
        format: "yyyy/mm/dd",
        autoclose: true,
        todayHighlight: true
    });
    $('.select').select2({
        width: '100%'
    });
</script>