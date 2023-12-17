<div class="card">
    <div class="card-header">
        <h6>{{_lang('Employee Account Details Information')}}</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>{{_lang('Account Name')}} </td>
                        <td>{{$model->name}}</td>
                    </tr>
                    <tr>
                        <td>{{_lang('Account Number')}} </td>
                        <td>{{$model->account_number}}</td>
                    </tr>
                    <tr>
                        <td>{{_lang('Bank Name')}} </td>
                        <td>{{$model->bank_name}}</td>
                    </tr>
                    <tr>
                        <td>{{_lang('Branch Name')}} </td>
                        <td>{{$model->branch_name}}</td>
                    </tr>
                    <tr>
                        <td>{{_lang('Bank Identification Code')}} </td>
                        <td>{{$model->bank_identification_code}}</td>
                    </tr>
                    <tr>
                        <td>{{_lang('Description')}}</td>
                        <td>{!!$model->description!!}</td>
                    </tr>
                </tbody>
            </table>
            <div align="right" class="col-md-12">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>