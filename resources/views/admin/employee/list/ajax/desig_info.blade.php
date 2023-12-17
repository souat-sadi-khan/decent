<div class="row p-4">
    <div class="col-md-12">
        <div align="right">
            <button class="btn btn-info btn-sm" data-placement="bottom" title="Create New Employee Leave Type" type="button" id="content_managment" data-url="{{ route('admin.designation.add',$id) }}"><i class="fa fa-plus mr-2" aria-hidden="true"></i>{{_lang('Add New designaiton')}} </button>
        </div>
        <br>
        <div class="row">
            @if (!count($models))
                <div class="col-md-12 text-center">
                    <i class="fa fa-th-list fa-4x" aria-hidden="true"></i><br>
                    <h2>{{_lang('Listing all Account here!')}} </h2>
                    <h4>{{_lang('Upload and manage various Qualification of your employees to specific Qualification type')}} </h4>
                    @can('designation.create')
                        <button class="btn btn-info btn-sm" type="button"><i class="fa fa-plus mr-2" aria-hidden="true"></i> Add New</button>
                    @endcan
                </div>
            @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="text-center thead-dark">
                        <tr>
                            <th>{{_lang('Designation')}} </th>
                            <th> {{_lang('Department')}}</th>
                            <th>{{_lang('Date Effective')}} </th>
                            <th>{{_lang('Date End')}} </th>
                            <th>{{_lang('Action')}} </th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($models as $model)
                        <tr>
                            <td>{{$model->designation->name}} </td>
                            <td>{{$model->department->name}} </td>
                            <td>{{carbonDate($model->date_effective)}} </td>
                            <td>{{$model->date_end? carbonDate($model->date_end) : ''}} </td>
                            <td align="center">
                                <div class="btn-group">
                                    @if ($model->date_end == '')
                                        <button data-toggle="tooltip" data-placement="bottom" title="Delete {{ $model->designation->name }}" id="delete_item" data-id ="{{$model->id}}" data-url="{{route('admin.designation.delete_designation',$model->id) }}" class="btn btn-danger btn-sm has-tooltip" data-original-title="null" data-placement="bottom"><i class="fa fa-trash"></i></button>

                                        <button data-toggle="tooltip" data-placement="bottom" title="Update {{ $model->designation->name }}" class="btn btn-info btn-sm has-tooltip" data-original-title="null" id="content_managment" data-url="{{ route('admin.designation.edit_designation',$model->id) }}" ><i class="fa fa-edit"></i></button>

                                        <button data-toggle="tooltip" data-placement="bottom" title="View {{ $model->designation->name }}" class="btn btn-success btn-sm has-tooltip" data-original-title="null" id="content_managment" data-url="{{ route('admin.designation.show_designation',$model->id) }}" ><i class="fa fa-arrow-circle-right"></i></button>
                                    @else
                                        <button data-toggle="tooltip" data-placement="bottom" title="View {{ $model->designation->name }}" title="View Designation." id="content_managment"data-url="{{ route('admin.designation.show_designation',$model->id) }}"class="btn btn-success btn-sm has-tooltip" data-original-title="null"><i class="fa fa-arrow-circle-right"></i></button>
                                    @endif
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
<script src="{{ asset('js/employee/edit_designation.js') }}"></script>