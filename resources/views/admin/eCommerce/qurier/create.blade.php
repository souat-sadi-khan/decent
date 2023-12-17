<div class="card">
    <div class="card-header">
        <h6 class="text-center">Create New Qurier Option</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.eCommerce.qurier.store') }}" method="post" id="content_form">
            <div class="row">
                {{-- Name --}}
                <div class="col-md-4 form-group">
                    <label for="name">{{_lang('Qurier Name')}}</label>
                    <input value="{{$model->name}}" type="text" name="name" id="name" class="form-control" autocomplete="off" placeholder="Enter Qurier Name" required>
                </div>

                {{-- Phone --}}
                <div class="col-md-4 form-group">
                    <label for="phone">{{_lang('Enter Qurier Phone Number')}}</label>
                    <input value="{{$model->phone}}" type="text" name="phone" id="phone" class="form-control" required placeholder="Enter Qurier Phone Number">
                </div>

                {{-- Status --}}
                <div class="col-md-4 form-group">
                    <label for="status">{{_lang('Qurier Status')}}</label>
                    <select name="status" id="status" class="form-control select" data-placeholder="Select Qurier Status" required>
                        <option value="">{{_lang('Select Qurier Status')}}</option>
                        <option {{$model->status == 1 ? 'selected' : ''}} value="1">{{_lang('Active')}}</option>
                        <option {{$model->status == 0 ? 'selected' : ''}} value="0">{{_lang('Inctive')}}</option>
                    </select>
                </div>

                <div class="col-md-12 form-group">
                    <label for="address">{{_lang('Address')}}</label>
                    <textarea name="address" id="address" class="form-control" cols="30" rows="2" placeholder="Enter Address Here">{{$model->address}}</textarea>
                </div>
            </div>


            <div class="form-group col-md-12" align="right">
                <button type="submit" class="btn btn-primary btn-sm"  id="submit">{{_lang('Create')}}<i class="fa ml-2 fa-plus-circle" aria-hidden="true"></i></button>
                <button type="button" class="btn btn-success btn-sm " id="submiting" style="display: none;"><i class="fa fa-spinner fa-spin fa-fw"></i>{{_lang('Loading...')}} </button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>
<script>
    $('.select').select2();
</script>