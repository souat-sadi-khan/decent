<div class="card">
    <div class="card-header">
        <h6>{{_lang('Employee Qualification Details Information')}}</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody class="text-center">
                    <tr>
                        <td>{{_lang('Standard')}}</td>
                        <td>{{$model->standard}} </td>
                    </tr>
                 
                    <tr>
                        <td>{{_lang('Institute Name')}}</td>
                        <td>{{$model->institute_name}} </td>
                    </tr>
        
                    <tr>
                        <td>{{_lang('Board Name')}}</td>
                        <td>{{$model->board_name}} </td>
                    </tr>
                    
                    <tr>
                        <td>{{_lang('Start Period')}}</td>
                        <td>{{carbonDate($model->start_period)}} </td>
                    </tr>
        
                    <tr>
                        <td>{{_lang('End Period')}}</td>
                        <td>{{carbonDate($model->end_period)}} </td>
                    </tr>
        
                    <tr>
                        <td>{{_lang('Result')}}</td>
                        <td>{{$model->result}} </td>
                    </tr>
        
                    <tr>
                        <td>{{_lang('Description')}}</td>
                        <td>{!!$model->description!!}</td>
                    </tr>
                    
                    <tr>
                        <td>{{_lang('Created At')}} </td>
                        <td>{{$model->created_at}} </td>
                    </tr>
                    @if (carbonDate($model->updated_at))
                        
                    <tr>
                        <td>{{_lang('Updated At')}} </td>
                        <td>{{$model->updated_at}} </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="form-group col-md-12" align="right">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>