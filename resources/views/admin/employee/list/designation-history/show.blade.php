<div class="card">
    <div class="card-header">
        <h6>{{_lang('Employee Designation Details Information')}}</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody class="text-center">
                    <tr>
                        <td>{{_lang('Designation')}} </td>
                        <td>{{$model->designation->name}} </td>
                    </tr>
                    
                    <tr>
                        <td>{{_lang('Department')}} </td>
                        <td>{{$model->department->name}} </td>
                    </tr>
                    <tr>
                        <td>{{_lang('Date Effective')}} </td>
                        <td>{{carbonDate($model->terms->date_of_joining)}}</td>
                    </tr>
                    @if ($model->terms->date_of_leaving)
                        <tr>
                            
                        <td>{{_lang('Leaving Date')}} </td>
                        <td>{{carbonDate($model->terms->date_of_leaving)}}</td>
                    </tr>
                    @endif
                    <tr>
                        <td>{{_lang('Remarks')}} </td>
                        <td>{!!$model->remarks!!} </td>
                    </tr>
                        @if ($model->document)
                    <tr>
                        <td>{{_lang('Document')}} </td>
                        <td><a target="_blank" href="{{asset('storage/document')}}/{{$model->document}}"
                                alt="Document Not Uploaded">Download/Open Document</a></td>
                    </tr>
        
                    @endif
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
        <div class="col-md-12" align="right">
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>