<div class="mb-2">{{$model->description}}</div>
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Pay Head</th>
                    <th>Category</th>
                    <th>Computation Formula</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($model->details as $item)
                <tr>
                    <td class="{{$item->payhead->type== 'Earning'?'text-success':'text-danger'}}">{{$item->payhead?$item->payhead->name:''}}</td>
                    <td>
                        @if ($item->category == 'not_applicable')
                            {{_lang('Not Applicable')}}
                        @elseif ($item->category == 'attendance')
                            {{_lang('On Attendance')}}
                        @elseif ($item->category == 'flat_rate')
                            {{_lang('Flat Ratio')}}
                        @elseif ($item->category == 'user_defined')
                            {{_lang('User Defind')}}
                        @elseif ($item->category == 'computation')
                            {{_lang('Computation')}}
                        @else 
                            {{_lang('On Production')}}
                        @endif
                    </td>
                    <td>
                        {{$item->computation}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
    
<hr>
<p>
    <i class="fa fa-clock-o" aria-hidden="true"></i> <small>Created at {{$model->created_at}}</small> 
    <span class="pull-right">
        <i class="fa fa-clock-o" aria-hidden="true"></i> 
        <small>Last Updated at {{$model->updated_at}}</small>
    </span>
</p>
