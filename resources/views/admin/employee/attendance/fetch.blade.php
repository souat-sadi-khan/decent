<table class="table table-sm table-bordered attendance-table">
    <thead>
        <tr>
            <th>Employee</th>
            
            @foreach ($dates as $item)
                <th class="date-cell">{{$item}}</th>
            @endforeach
            
            <th class="text-center font-weight-bold" data-toggle="tooltip" data-placement="bottom"
                title="Leave">
                L
            </th>
            
            @foreach ($types as $item)
                <th class="text-center font-weight-bold" data-toggle="tooltip" data-placement="bottom"
                    title="{{$item->description}}">
                    {{$item->alias}}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $employee)
        <tr>
            <td>
                <input type="hidden" name="employee[]" value="{{$employee->id}}">
                {{$employee->name}}
                ({{$employee->prefix.numer_padding($employee->code, get_option('digits_employee_code'))}}) <br>
                <span class="font-80pc">{{current_designation($employee->id)?current_designation($employee->id):""}}
                    ({{designation_category($employee->id)}})</span>
            </td>

            @foreach ($dates as $item)
            @php
            $a = explode("-", $months);
            $year = $a[0];
            $month = $a[1];
            $days = $today;
            $date = $months.'-'.$item;
            $query = App\models\employee\EmployeeAttendance::where('employee_id',$employee->id)->whereDate('date_of_attendance',$date)->first();

            $fridays=[];
            foreach (range(1, $days) as $day) {
                $date = \Carbon\Carbon::createFromDate($year, $month, $day);
                if ($date->isFriday()===true) {
                    $fridays[]=($date->day);
                }
            }

            $holidays = App\models\holiday\Holiday::whereMonth('date',$month)->whereYear('date',$year)->get();
            $hday= [];
            foreach ($holidays as $holiday) {
               $hday[] = \Carbon\Carbon::parse($holiday['date'])->format('d');
            }


            App\models\employee\EmployeeAttendance::where('employee_id',$employee->id)->whereDate('date_of_attendance',$date)->with('attendance_type')->first();

            @endphp
            
            @if (isset($query->employee_attendance_type_id))

                @php
                    $type = $query->attendance_type->type;
                @endphp
                
                <td class="text-center font-weight-bold
                    @if($type == 'Present')
                    text-success
                    @elseif($type == 'Holiday')
                    text-worning
                    @elseif($type == 'On_leave')
                    text-danger
                    @else
                    text-default
                    @endif
                    " data-toggle="tooltip" data-placement="bottom" title="{{$query->attendance_type->name}}">
                    <span class="marking-cell">{{$query->attendance_type->alias}}</span>
                </td>

            @elseif(in_array($item,$fridays))

                <td class="text-center font-weight-bold text-light bg-danger" data-toggle="tooltip" data-placement="bottom"
                    title="Weekend">
                    <span class="marking-cell">H</span>
                </td>

            @elseif(in_array($item,$hday))

                <td class="text-center font-weight-bold text-light bg-danger" data-toggle="tooltip" data-placement="bottom"
                    title="Holiday">
                    <span class="marking-cell">H</span>
                </td>

            @else
                <td class="text-center font-weight-bold text-default">
                    <span class="marking-cell"></span>
                </td>
            
            @endif
            
        @endforeach
            
        <td class="text-center font-weight-bold">0</td>
        
        @foreach ($types as $item)
            
            @php
            
                $count = App\models\employee\EmployeeAttendance::with('attendance_type')->where('employee_id',$employee->id)->where('employee_attendance_type_id',$item->id)->whereMonth('date_of_attendance',$month)->whereYear('date_of_attendance',$year)->get();

                $alias = App\models\employee\EmployeeAttendanceType::where('type', 'Holiday')->where('is_active', 1)->first();
                        
                $holiday = count($hday) + count($fridays);
            
            if ($item->id == $alias->id) {
                $count_h = count($count) + $holiday;
                $holiday = 0;
            }else{
                $count_h = count($count);
            }

            @endphp
            <td class="text-center font-weight-bold">{{$count_h}}</td>
            @endforeach

        </tr>
        @endforeach
    </tbody>
</table>
