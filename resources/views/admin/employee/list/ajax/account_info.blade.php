<div class="row p-4">
    <div class="col-md-12">
        <div align="right">
            @can('employee_account.view')
                <button class="btn btn-info btn-sm" data-placement="bottom" title="Create New Employee Account Information" type="button"  id="content_managment" data-url ="{{ route('admin.account.create',$id) }}"><i class="fa fa-plus mr-2" aria-hidden="true"></i>{{_lang('Add New Account')}} </button>
            @endcan
        </div>
        <br>
        <div class="row">
            @if (!count($models))
                <div class="col-md-12 text-center">
                    <i class="fa fa-th-list fa-4x" aria-hidden="true"></i><br>
                    <h2>{{_lang('Listing all Account here!')}} </h2>
                    <h4>{{_lang('Upload and manage various Qualification of your employees to specific Qualification type')}} </h4>
                    @can('employee_account.create')
                        <button class="btn btn-info btn-sm" data-placement="bottom" title="Create New Employee Account Information" type="button"  id="content_managment" data-url="{{ route('admin.account.create',$id) }}"><i class="fa fa-plus mr-2" aria-hidden="true"></i> Add New</button>
                    @endcan
                </div>
            @else 
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="text-center thead-dark"> 
                            <tr>    
                                <th>{{_lang('Account Name')}} </th>
                                <th>{{_lang('Account Number')}} </th>
                                <th>{{_lang('Bank Name')}} </th>
                                <th>{{_lang('Action')}} </th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($models as $model)
                                <tr>
                                    <td>{{$model->name}} </td>
                                    <td>{{$model->account_number}} </td>
                                    <td>{{$model->bank_name}} </td>
                                    <td>
                                        <button data-toggle="tooltip" data-placement="bottom" title="Delete {{ $model->name }}" id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.account.destroy',$model->id) }}" class="btn btn-danger btn-sm has-tooltip" data-original-title="null" data-placement="bottom"><i class="fa fa-trash"></i></button>

                                        <button data-toggle="tooltip" data-placement="bottom" title="Edit {{ $model->name }}" class="btn btn-info btn-sm has-tooltip" data-original-title="null" id="content_managment" data-url="{{ route('admin.account.edit',$model->id) }}" ><i class="fa fa-edit"></i></button>

                                        <button data-toggle="tooltip" data-placement="bottom" title="View {{ $model->name }}" class="btn btn-success btn-sm has-tooltip" data-original-title="null" id="content_managment" data-url="{{ route('admin.account.show',$model->id) }}" ><i class="fa fa-arrow-circle-right"></i></button>
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