<div class="card">
    <div class="card-header">
        <h6>{{_lang('Create New Account for Employee')}}</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.account.store',$id) }}" method="post" id="content_form">
            @csrf
            <div class="row">
            <input type="hidden" name="uuid" value="{{$model->uuid}}">
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="name">{{_lang('Account Name')}} <span class="text-danger">*</span></label> 
                        <input required type="text" name="name" id="name" autocomplete="off" placeholder="Account Name" class="form-control">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="account_number">{{_lang('Account Number')}} <span class="text-danger">*</span></label> 
                        <input required type="text" name="account_number" autocomplete="off" id="account_number" placeholder="Account Number" class="form-control">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="bank_name">{{_lang('Bank Name')}} <span class="text-danger">*</span></label> 
                        <input required type="text" name="bank_name" id="bank_name" autocomplete="off" placeholder="Bank Name" class="form-control">
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="form-group">
                        <label for="branch_name">{{_lang('Branch Name')}} <span class="text-danger">*</span></label> 
                        <input required type="text" name="branch_name" id="branch_name" autocomplete="off" placeholder="Branch Name" class="form-control">
                    </div>
                </div>
                <div class="col-12 col-sm-12">
                    <div class="form-group">
                        <label for="bank_identification_code">{{_lang('Bank Identification Code')}} <span class="text-danger">*</span></label> 
                        <input required type="text" autocomplete="off" name="bank_identification_code" id="bank_identification_code" placeholder="Bank Identification Code" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="description">{{_lang('Description')}}</label>
                <textarea rows="2" placeholder="Description" name="description" class="form-control"></textarea>
            </div> 
            @can('employee_account.create')
                <div class="form-group col-md-12" align="right">
                    <button type="submit" class="btn btn-primary btn-sm"  id="submit">{{_lang('Create')}}<i class="fa ml-2 fa-plus-circle" aria-hidden="true"></i></button>
                    <button type="button" class="btn btn-success btn-sm " id="submiting" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>{{_lang('Loading...')}} </button>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                </div>
            @endcan
        </form>
    </div>
</div>