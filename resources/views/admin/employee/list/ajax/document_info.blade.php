<div class="row p-4">
    <div class="col-md-12">
        <div align="right">
            <button class="btn btn-info btn-sm" data-placement="bottom" title="Create New Document File"
                type="button" id="content_managment" data-url="{{ route('admin.employee-document.create',$id)}}">
                <i class="fa fa-plus mr-2" aria-hidden="true"></i>{{_lang('Add New Document')}}</button>
        </div>
        <br>
        <div class="row">
            @if (!count($models))
                <div class="col-md-12 text-center">
                    <i class="fa fa-th-list fa-4x" aria-hidden="true"></i><br>
                    <h2>Listing all Document here!</h2>
                    <h4>Upload and manage various documents of your employees to specific document type</h4>
                    <button class="btn btn-info btn-sm" data-placement="bottom" title="Create New Document File"
                        type="button" id="content_managment" data-url="{{ route('admin.employee-document.create',$id)}}">
                        <i class="fa fa-plus mr-2" aria-hidden="true"></i>{{_lang('Add New Document')}}</button>
                </div>
            @else 
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="text-center thead-dark">
                        <tr>
                            <th>Document Type</th>
                            <th>Title</th>
                            <th>File</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($models as $model)
                        <tr>
                            <td>{{$model->document_type->name}} </td>
                            <td>{{$model->title}} </td>
                            <td>
                                <a target="_blank" href="{{asset('storage/document')}}/{{$model->upload_token}}" alt="Document Not Uploaded"><i class="fa fa-folder-open mr-2" aria-hidden="true"></i></a>
                            </td>
                            <td align="center">
                                <div class="btn-group">
                                        <button id="delete_item" data-toggle="tooltip" data-placement="bottom" title="Delete {{ $model->title }}" data-id ="{{$model->id}}" data-url="{{route('admin.employee-document.destroy',$model->id) }}" class="btn btn-danger btn-sm has-tooltip" data-original-title="null"
                                        data-placement="bottom"><i class="fa fa-trash"></i></button>

                                        <button data-toggle="tooltip" data-placement="bottom" title="Edit {{ $model->title }}" class="btn btn-info btn-sm has-tooltip" data-original-title="null" id="content_managment" data-url="{{ route('admin.employee-document.edit',$model->id) }}" ><i class="fa fa-edit"></i></button>
                                    
                                        <button data-toggle="tooltip" data-placement="bottom" title="View {{ $model->title }}" class="btn btn-success btn-sm has-tooltip" data-original-title="null" id="content_managment" data-url="{{ route('admin.employee-document.show',$model->id) }}" ><i class="fa fa-arrow-circle-right"></i></button>
                               </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>