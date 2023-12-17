@php
    $total_present  = 1;
@endphp
<form action="{{route('admin.payroll-initialize.store')}}" method="POST" id="content_form">
    @csrf
<div class="row">
    <div class="col-md-4">

        <table class="table bordered table-striped">

            @php

                $attendance_types = App\models\employee\EmployeeAttendanceType::where('is_active', 1)->get();

            @endphp

            @foreach ($attendance_types as $item)

                @php
                    
                    $present = 0;
                    $absent = 0;
                    $holiday = 0;
                    $default_holiday = 0;

                @endphp

                <tr>

                    <td>

                        {{$item->name}} ( {{$item->alias}} ) 

                        <span class="float-right">

                            @php


                                $dt = Carbon\Carbon::create($start_date);
                                $dt2 = Carbon\Carbon::create($end_date);

                                $period = Carbon\CarbonPeriod::create($dt , $dt2);
                                
                                foreach($period as $date) {
                                    if($date->isWeekend()) {
                                        $query = App\models\employee\EmployeeAttendance::where('employee_id', $salary->employee_id)->where('date_of_attendance', $date)->where('employee_attendance_type_id', 1)->first();
                                        if(!$query) {
                                            $default_holiday = $default_holiday + 1;
                                        }
                                    }
                                }

                                $holiday = $holiday + $default_holiday;

                            
                                $query = App\models\employee\EmployeeAttendance::where('employee_id', $salary->employee_id)->whereBetween('date_of_attendance', [$start_date, $end_date])->where('employee_attendance_type_id', $item->id)->where('employee_attendance_type_id', '!=', 3)->count();

                                // check present date
                                $check_present = App\models\employee\EmployeeAttendance::where('employee_id', $salary->employee_id)->whereBetween('date_of_attendance', [$start_date, $end_date])->where('employee_attendance_type_id', 1)->count();

                                // check the default holiday


                                $present = $check_present + $present;

                                // check holiday

                                $check_holiday = App\models\holiday\Holiday::whereBetween('date', [$start_date, $end_date])->get();

                                // check employee is present on the holiday

                                foreach($check_holiday as $holi) {

                                    $holiday_date = $holi->date;

                                    $check = App\models\employee\EmployeeAttendance::where('employee_id', $salary->employee_id)->where('date_of_attendance', $holiday_date)->first();

                                    if(!$check) {

                                        $holiday = $holiday + 1;
                                    
                                    }

                                }

                            @endphp

                            @if ($item->type != 'Holiday')
                                {{$query}}
                            @endif

                            @if ($item->type == 'Holiday')
                                {{$holiday}}
                            @endif

                           
                        </span>

                    </td>

                </tr>

            @endforeach

        </table>

    </div>

    <div class="col-md-8">

        <table class="table table-bordered table-striped">

            <tr>

                <th colspan="2" class="text-center">Name</th>

                <td colspan="2" class="text-center">{{find_employee_name_using_employee_id($salary->employee_id)}}</td>

            </tr>

            <tr>

                <th colspan="2" class="text-center">Designation</th>

                <td colspan="2" class="text-center">{{employee_designation($salary->employee_id)}} ( <strong>{{employee_department($salary->employee_id)}}</strong> )</td>

            </tr>

            <tr>

                <th colspan="2" class="text-center">From - To</th>

                <td colspan="2" class="text-center">{{formatDate($start_date)}} - {{formatDate($end_date)}}</td>

            </tr>

        </table>

    </div>

    <div class="row col-md-12">

        <div class="col-md-6 table-responsive">

            <table class="table table-bordered table-striped payroll_table_earning">
                
                <tr>

                    <th width="25%" class="text-center">Earning</th>

                    <th width="25%" class="text-center">Amount</th>

                </tr>

                @php

                    $total_paid_amount = 0;
                    $total_earning = 0;
                    $total_deduction = 0;

                    $items = App\models\employee\EmployeeSalaryDetail::where('employee_salary_id', $salary->id)->get();

                    $start_date = Carbon\Carbon::parse($start_date);
                    $end_date = Carbon\Carbon::parse($end_date);
                    $date_diff = $start_date->diffInDays($end_date);
                    $date_diff = $date_diff + 1;
                    $i = 0;

                @endphp

                @foreach ($items as $item)
                    @php
                        $i++;
                    @endphp

                        @php
                        
                            $template_id = $item->payroll_template_detail_id;
                            $templaate_details =App\models\employee\PayrollTemplateDetail::where('id', $template_id)->first();
                            
                            if($templaate_details) {
                                $pay_head_id = $templaate_details->pay_head_id;
                                $template = App\models\employee\PayHead::where('id', $pay_head_id)->where('type', 'Earning')->first();
                            }
                        @endphp
                            
                            <input type="hidden" name="pay_head[]" value="{{$templaate_details->pay_head_id}}">

                        @if ($template)
                            @php
                                $total_amount = $item->amount;
                                $per_day_amount = number_format($total_amount / $date_diff, 2) ;

                                $total_present = $present + $holiday;

                                $amount = $total_present * intval($per_day_amount) ;
                                // $amount = intval(number_format($amount, 2));
                                $amount = round($amount);

                                $total_earning = $total_earning + $amount;
                            @endphp
                            <tr>
                                <td class="text-center text-success" width="25%">{{$template->name}}</td>
                                <td class="text-center" width="25%"> 
                                    <input type="hidden" name="earning[]" value="{{$template->id}}">
                                    <div class="input-group col-md-12 mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT'}} </span>
                                        </div>
                                        
                                        <input autocomplete="off" type="number" class="form-control earning" name="amount[]" placeholder="Enter Amount" required value="{{intval(round($amount))}}" {{$templaate_details->category == 'not_applicable' ? 'readonly' : ''}}>       
                                    </div>

                                </td>
                            </tr>
                        @endif
                @endforeach

            </table>
        </div>

        <div class="col-md-6 table-responsive">

            <table class="table table-bordered table-striped payroll_table_deduction">

                <tr>

                    <th width="25%" class="text-center">Deduction</th>

                    <th width="25%" class="text-center">Amount</th>

                </tr>

                @php
                    $i = 0;
                    $items = App\models\employee\EmployeeSalaryDetail::where('employee_salary_id', $salary->id)->get();
                @endphp

                <tbody>
                    @foreach ($items as $item)
                    @php
                        $i++;
                    @endphp

                    @php
                        $template_id = $item->payroll_template_detail_id;
                        $templaate_details =App\models\employee\PayrollTemplateDetail::where('id', $template_id)->first();
                        
                        if($templaate_details) {
                            $pay_head_id = $templaate_details->pay_head_id;
                            $template = App\models\employee\PayHead::where('id', $pay_head_id)->where('type', 'Deduction')->first();
                        }
                    @endphp

                    @if ($template)
                        @php

                            $total_amount = $item->amount;
                            $per_day_amount = $total_amount / $date_diff ;

                            $total_present = $present + $holiday;

                            $amount = $total_present * $per_day_amount ;
                            $amount = number_format($amount, 2);

                            $total_deduction = $total_deduction + $amount;

                        @endphp
                        <tr>
                            <td class="text-center text-danger" width="25%">{{$template->name}}</td>
                            <td class="text-center" width="25%"> 
                                <input type="hidden" name="deduction[]" value="{{$template->id}}">
                                
                                <div class="input-group col-md-12 mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT'}} </span>
                                    </div>
                                    <input autocomplete="off" type="number" class="form-control deduction" name="amount[]" placeholder="Enter Amount" required value="{{intval(round($amount))}}" {{$templaate_details->category == 'not_applicable' ? 'readonly' : ''}}>       
                                </div>
                            </td>
                        </tr>
                    @endif

                @endforeach
                </tbody>
                    
            </table>

        </div>

    </div>

    <div class="row col-md-12">

        <div class="col-md-6 table-responsive">

            <table class="table table-bordered table-striped">

                <tr>

                    <th width="50%" class="text-center">Total Earning</th>

                    <th with="50%" class="text-center">{{get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT' }} <span id="refresh_total_earning">{{$total_earning}}</span></th>
                    <input type="hidden" id="total_earning_amount" value="0">
                </tr>

            </table>

        </div>

        <div class="col-md-6 table-responsive">

            <table class="table table-bordered table-striped">

                <tr>

                    <th width="50%" class="text-center">Total Deduction</th>

                    <th with="50%" class="text-center">{{get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT' }} <span id="refresh_total_amount">{{$total_deduction}}</span></th>
                    <input type="hidden" id="total_deduction_amount" value="0">

                </tr>

            </table>

        </div>

    </div>

    <div class="col-md-12 table-responsive">

        <table class="table table-bordered table-stringped">

            <tr>

                <th width="50%" class="text-center">Net Salary</th>

                <th with="50%" class="text-center">{{get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT' }} <span id="total__amount">{{$total_earning - $total_deduction}}</span></th>

            </tr>

        </table>

    </div>

</div>

@php
    $total_amount = $total_earning + $total_deduction ;
    
    if($total_amount == 0) {
        $total_amount = 1;
    }

    $per = round($total_amount / $total_present) ;
@endphp
    
        <input type="hidden" name="employee_id" id="employee_id" value="{{$salary->employee_id}}" class="form-control" >
        <input type="hidden" name="payroll_template_id" id="payroll_template_id" value="{{$salary->payroll_template_id}}" class="form-control" >
        <input type="hidden" name="total_present" id="total_present" value="{{$total_present}} ">
        <input type="hidden" name="employee_salary_id" id="employee_salary_id" value="{{$salary->id}}" class="form-control" >
        <input type="hidden" name="start_date" id="start_date" value="{{$start_date}}" class="form-control" >
        <input type="hidden" name="end_date" id="end_date" value="{{$end_date}}" class="form-control" >
        <input type="hidden" name="per_day_calculation_basis" id="per_day_calculation_basis" value="{{$per}}" class="form-control" >
        <input type="hidden" name="total" id="total" value="{{$total_earning + $total_deduction}}" class="form-control">
        
        <div class="form-group">
            <label for="remarks">{{_lang('Remarks')}}</label>
            <textarea name="remarks" id="remarks" cols="30" rows="2" class="form-control"></textarea>
        </div>

        <div class="form-group col-md-12" align="right">
            <button type="submit" class="btn btn-primary" id="submit">{{_lang('Create')}}<i class="icon-arrow-right14 position-right"></i></button>
            <button type="button" class="btn btn-link" id="submiting" style="display: none;">{{_lang('Processing')}}<img src="{{ asset('ajaxloader.gif') }}" width="80px"></button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </form>
</div>
<script>
    _formValidation();

    // for earning
    $('.payroll_table_earning tbody').on('keyup change',function(){
        var earning = earning_function();
        $('#refresh_total_earning').html(earning.toFixed(2));
        $('#total_earning_amount').val(earning);

        var deduction = $('#total_deduction_amount').val();
        var total = parseInt(earning) - parseInt(deduction);
        $('#total__amount').html(total.toFixed(2));
        // $('#total__amount').val(total);
    });

    function earning_function()
    {
        var total = 0;
        $('.payroll_table_earning tbody tr').each(function(i, element) {
            
            var html = $(this).html();
            if(html!='')
            {
                var earning = $(this).find('.earning');
                if(earning.length > 0){
                    total += parseInt(earning.val());
                }
               
            }
        });
        
        return total;
    }

    // for deduction
    $('.payroll_table_deduction tbody').on('keyup change',function(){
        var deduction = deduction_function();
        $('#refresh_total_deduction').html(deduction.toFixed(2));
        $('#total_deduction_amount').val(deduction);

        var earning = $('#total_earning_amount').val();
        var total = parseInt(earning) - parseInt(deduction);
        $('#total__amount').html(total.toFixed(2));

    });

    function deduction_function()
    {
        var total = 0;
        $('.payroll_table_deduction tbody tr').each(function(i, element) {
            
            var html = $(this).html();
            if(html!='')
            {
                var deduction = $(this).find('.deduction');
                if(deduction.length > 0){
                    total += parseInt(deduction.val());
                }
               
            }
        });
        
        return total;
    }
</script>