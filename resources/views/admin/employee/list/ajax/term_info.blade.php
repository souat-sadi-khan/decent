<div class="row p-4">
    <div class="col-md-12">
        <br>
        <div class="row">
            @if (!count($models))
                <div class="col-md-12 text-center">
                    <i class="fa fa-th-list fa-4x" aria-hidden="true"></i><br>
                    <h2>{{_lang('Listing all Account here!')}}</h2>
                    <h4>{{_lang('Upload and manage various Qualification of your employees to specific Qualification type')}} </h4>
                </div>
            @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="text-center thead-dark">
                        <tr>
                            <th>{{_lang('Date of Joining ')}} </th>
                            <th>{{_lang('Date of Leaving')}}  </th>
                            <th>{{_lang('Action')}} </th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($models as $model)
                        <tr>
                            <td>{{carbonDate($model->date_of_joining)}} </td>
                            <td>{{carbonDate($model->date_of_leaving)}} </td>
                            <td align="center">
                                <div class="btn-group">
                                    @if ($model->date_of_leaving == '')
                                    <button id="delete_item" data-id="{{$model->id}}"
                                        data-url="{{route('admin.term.delete_term',$model->id) }}"
                                        class="btn btn-danger btn-sm has-tooltip" data-original-title="null"
                                        data-placement="bottom"><i class="fa fa-trash"></i></button>

                                    <button class="btn btn-info btn-sm has-tooltip" data-original-title="null"
                                        id="content_managment"
                                        data-url="{{ route('admin.term.edit_term',$model->id) }}"><i
                                            class="fa fa-edit"></i></button>

                                    <button class="btn btn-success btn-sm has-tooltip" data-original-title="null"
                                        id="content_managment"
                                        data-url="{{ route('admin.term.show_term',$model->id) }}"><i
                                            class="fa fa-arrow-circle-right"></i></button>
                                    @else
                                    <button title="View term." id="content_managment"
                                        data-url="{{ route('admin.term.show_term',$model->id) }}"
                                        class="btn btn-success btn-sm has-tooltip" data-original-title="null"><i
                                            class="fa fa-arrow-circle-right"></i></button>
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
