            <div class="table-responsive">
                <table class="table custom-show-table">
                    <tbody>
                        <tr>
                            <td>Joining Date</td>
                            <td>{{carbonDate($model->date_of_joining)}} </td>
                        </tr>
                        <tr>
                            <td>Joining Remark</td>
                            <td>{{(($model->employee_designation AND $model->employee_designation->remarks)?$model->employee_designation->remarks:'')}}
                            </td>
                        </tr>

                        @if ($model->date_of_leaving)
                        <tr>
                            <td>Leaving Date</td>
                            <td>{{carbonDate($model->date_of_leaving)}}</td>
                        </tr>

                        <tr>
                            <td>Leaving Remarks</td>
                            <td>{{($model->leaving_remarks)?$model->leaving_remarks:''}}</td>
                        </tr>
                        @endif
                        @if ($model->document)
                        <tr>
                            <td>Document</td>
                            <td><a target="_blank" href="{{asset('storage/document')}}/{{$model->document}}"
                                    alt="Document Not Uploaded">Download/Open Document</a></td>
                        </tr>

                        @endif
                        <tr>
                            <td>Created At</td>
                            <td>{{$model->created_at}} </td>
                        </tr>
                        @if (carbonDate($model->updated_at))

                        <tr>
                            <td>Updated At</td>
                            <td>{{$model->updated_at}} </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <!---->
            <hr>
