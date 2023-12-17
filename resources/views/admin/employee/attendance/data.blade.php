    @foreach ($employee as $model)
    <tr>
        <td>
            <input type="hidden" name="employee[]" value="{{$model->id}}">
            {{$model->name}} ({{$model->prefix.numer_padding($model->code, get_option('digits_employee_code'))}}) <br>
            <span class="font-80pc">{{current_designation($model->id)?current_designation($model->id):""}}
                ({{designation_category($model->id)}})</span>
        </td>
        <td>
            <select class="form-control select col-12 select_value" name="type[]" id="type" data-placeholder="Select Attendance Type">
                <option value="">Select One</option>
                @foreach ($types as $item)
                    <option value="{{$item->id}}">{{$item->name}} ({{$item->alias}})</option>
                @endforeach
            </select>
        </td>
        <td>
            <textarea rows="1" placeholder="Remarks" name="remarks[]" class="form-control" ></textarea>
        </td>
    </tr>
    @endforeach
