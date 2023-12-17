<div class="row p-4">
    <div class="col-md-12">
        <div align="right">
            @can('qualification.create')
                <button class="btn btn-info btn-sm" data-placement="bottom" title="Create New Qualification File" type="button" id="content_managment" data-url="{{ route('admin.employee-qua.create',$id)}}"> <i class="fa fa-plus mr-2" aria-hidden="true"></i>{{_lang('Add New Qualification')}}</button>
            @endcan
        </div>
        <br>
        <div class="row">
            @if (!count($models))
                <div class="col-md-12 text-center">
                    <i class="fa fa-th-list fa-4x" aria-hidden="true"></i><br>
                    <h2>{{_lang('Listing all Qualification here!')}}</h2>
                    <h4>{{_lang('Upload and manage various Qualification of your employees to specific Qualification type')}}</h4>
                    @can('qualification.create')
                        <button class="btn btn-info btn-sm" data-placement="bottom" title="Create New Qualification File" type="button" id="content_managment" data-url="{{ route('admin.employee-qua.create',$id)}}"> <i class="fa fa-plus mr-2" aria-hidden="true"></i>{{_lang('Add New Qualification')}}</button>
                    @endcan
                </div>
                @else 
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="text-center thead-dark">
                            <tr>
                                <th>{{_lang('Standard')}}</th>
                                <th>{{_lang('Institute Name')}}</th>
                                <th>{{_lang('Start Period')}}</th>
                                <th>{{_lang('Result')}}</th>
                                <th>{{_lang('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody class="text-centere">
                            @foreach ($models as $model)
                            <tr>
                                <td>{{$model->standard}} </td>
                                <td>{{$model->institute_name}} </td>
                                <td width="20%">{{carbonDate($model->start_period)}} </td>
                                <td>{{$model->result}} </td>
                                <td align="center">
                                    <div class="btn-group">
                                            <button data-toggle="tooltip" data-placement="bottom" title="Delete {{ $model->standard }}" id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.employee-qua.destroy',$model->id) }}" class="btn btn-danger btn-sm has-tooltip" data-original-title="null"data-placement="bottom"><i class="fa fa-trash"></i></button>
                                        
                                            <button data-toggle="tooltip" data-placement="bottom" title="Update {{ $model->standard }}" class="btn btn-info btn-sm has-tooltip" data-original-title="null" id="content_managment" data-url="{{ route('admin.employee-qua.edit',$model->id) }}" ><i class="fa fa-edit"></i></button>
    
                                            <button data-toggle="tooltip" data-placement="bottom" title="View {{ $model->standard }}" class="btn btn-success btn-sm has-tooltip" data-original-title="null" id="content_managment" data-url="{{ route('admin.employee-qua.show',$model->id) }}" ><i class="fa fa-arrow-circle-right"></i></button>
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