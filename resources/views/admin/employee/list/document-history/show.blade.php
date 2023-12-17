<div class="card">
    <div class="card-header">
        <h6>{{_lang('Employee Document Details Information')}} </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody class="text-center">
                    <tr>
                        <td>{{_lang('Document Type')}}</td>
                        <td>{{$model->document_type->name}} </td>
                    </tr>
                 
                    <tr>
                        <td>{{_lang('Title')}}</td>
                        <td>{{$model->title}} </td>
                    </tr>
                    <tr>
                        <td>{{_lang('Description')}}</td>
                        <td>{!!$model->description!!}</td>
                    </tr>
                    <tr>
                        <td>{{_lang('File')}} </td>
                        <td> 
                            <a target="_blank" href="{{asset('storage/document')}}/{{$model->upload_token}}" alt="Document Not Uploaded"><i class="fa fa-folder-open mr-2" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>{{_lang('Created At')}}</td>
                        <td>{{$model->created_at}} </td>
                    </tr>
                    @if (carbonDate($model->updated_at))
                    <tr>
                        <td>{{_lang('Updated At')}}</td>
                        <td>{{$model->updated_at}} </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="form-group col-md-12" align="right">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
    </div>
</div>