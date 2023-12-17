@php
    $emp = App\models\employee\Employee::where('id', $salary->employee_id)->firstOrFail();
    $present = 0;
    $absent = 0;
    $holiday = 0;
    $default_holiday = 0;
    $total_earning  = 0;
    $total_deduction  = 0;

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
                
            </span>

        </td>

    </tr>

@endforeach
<!DOCTYPE html>
<html>
<head>
	<title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <style>
    	*{font-family:'Helvetica';}
	    body{width:auto;  max-width:800px;  min-width: 600px; margin:0 auto;font-size:12px;}
	    h2{font-size: 16px;font-weight: bold;}
	    .heading{font-size: 16px;font-weight: bold;}
	    .font-weight-bold{font-weight: bold;}
	    .font-120pc{font-size: 14px;}
	    .tw-50 {width: 50%;}
	    table.table-head th{font-size: 12px; font-weight: bold;text-align: right;}
	    table.table-head td{font-size: 12px;text-align: right;}

	    table.fancy-detail {  font-size:12px; border-collapse: collapse;  width:100%;  margin:0 auto;}
	    table.fancy-detail th{  background:#696969; color:#FFFFFF; border-bottom: 1px #2e2e2e solid;  padding: 0.5em;  padding-left:10px; vertical-align:top;text-align: left;}
	    table.fancy-detail td {padding: 0.5em;  padding-left:10px; border-bottom:1px solid #2e2e2e;text-align: left;}
	    table.fancy-detail caption {  margin-left: inherit;  margin-right: inherit;}
	    table.fancy-detail tr:hover{}

	    table.report-card {  font-size:12px; border-collapse: collapse;  width:100%;  margin:0 auto;}
	    table.report-card th{  background:#696969; color:#FFFFFF; border-bottom: 1px #2e2e2e solid;  padding: 0.5em;  padding-left:10px; vertical-align:top;text-align: left;}
	    table.report-card td {padding: 0.5em;  padding-left:10px; border:1px solid #2e2e2e;text-align: left;}
	    table.report-card caption {  margin-left: inherit;  margin-right: inherit;}
	    table.report-card tr:hover{}
	    table.no-border {width: 100%;}
	    table.no-border td {border:0px;}
	    .tc {font-size: 14px;}
	    .page-break {page-break-after: always;}
	    .table-striped {
		    vertical-align: top;
		    border-top: 0.0625rem solid #e1e5f1;
		}
		.font-weight-bold {
		    font-weight: bold;
		}
		.table-striped tbody tr:nth-of-type(odd) {
		    background-color: rgba(1, 5, 17, 0.05);
		}
		.table-striped tr {
		    display: table-row;
		    vertical-align: inherit;
		    border-color: inherit;
		}
		.comma:not(:first-child) {
		margin-left: -.3em;  
		}
		.comma:empty {
		display: none;
		}
		.comma:not(:first-child):before {
		content: ", ";
		}
		.table-padded-lg td {
		    padding: 0.8em;
		}
		.pagination {
			list-style: none;
			display: flex;
		}
		.pagination .page-item {
			margin-right: 10px;
		}
		@media  print {
		    .hide-print {display:none;}
		    .pagination {display:none;}
		}
    </style>
</head>
<body>
	    <div style=" border:1px dashed #696969;  margin-top: 10px;">
	        <div style="padding:10px;background: #ffffff;">
	            <table border="0" style="width:100%;margin-top: 20px;height: 100px;">
		            <tr>
		                <td style="width:40%;vertical-align: top;">
		                    @if(get_option('logo'))
    
                                <img class="w-50" src="{{asset('storage/logo')}}/{{get_option('logo')}}" alt="">
                            
                            @else 
                        
                                <img src="{{asset('logo.png')}}" alt="Company Logo">
                            
                            @endif
		                </td>
		                <td style="width:60%;vertical-align: top;">
		                    <table align="right" class="table-head">
		                        <tr>
		                            <th style="font-size: 20px;">{{get_option('site_title')}}</th>
		                        </tr>
		                        <tr>
		                            <td>
		                        {{get_option('address') == '' ? 'Please Enter Address' : get_option('address') }}        <br>           
		                        {{get_option('address_2') == '' ? 'Please Enter Address' : get_option('address_2') }}                  
                                    </td>
		                        </tr>
		                        <tr>
                                    <td>{{get_option('phone') == '' ? 'Enter Phone Number First' : get_option('phone')}}</td>
                                </tr>
			                    <tr>
			                        <td>{{get_option('email')}}</td>
			                    </tr>
		                        <tr>
			                        <td>{{get_option('website_url')}}</td>
			                    </tr>
			                </table>
		                </td>
		            </tr>
		        </table>
                <h2 style="text-align: center;"></h2>

                <table class="heading" style="width: 100%; margin-bottom: 20px;">
                    <tr>
                        <td>Payroll #{{$model->id}} </td>
                        <td style="text-align: right;">Date: {{date('d-m-Y')}}</td>
                    </tr>
                </table>
    
                <table class="fancy-detail">
                    <tbody>
                        <tr>
                            <td><strong>Name</strong></td>
                            <td>{{find_employee_name_using_employee_id($salary->employee_id)}}</td>
                            <td><strong>Code</strong></td>
                            <td>{{$emp->prefix.numer_padding($emp->code, get_option('digits_employee_code'))}}</td>
                        </tr>
                        <tr>
                            <td><strong>Designation</strong></td>
                            <td>{{employee_designation($salary->employee_id)}} ( <strong>{{employee_department($salary->employee_id)}}</td>
                            <td><strong>Contact Number</strong></td>
                            <td>{{$emp->contact_number}}</td>
                        </tr>
                        <tr>
                            <td><strong>Payroll Period</strong></td>
                            <td>{{$model->start_date}} to {{$model->end_date}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <table class="fancy-detail" style="margin-top: 20px;">
                    <tbody>
                        <tr>
                            <th>Earning Salary</th>
                            <th>Deduction Salary</th>
                        </tr>
                        <tr>
                        <td valign="top">
                            <table class="no-border">
                                <tbody>
                                    @php
                                        $items = App\models\employee\PayrollDetail::where('payroll_id', $model->id)->get();
                                    @endphp

                                    @foreach ($items as $item)
                                        @php
                                            $pay_head_id = $item->pay_head_id;
                                            $pay_head = App\models\employee\PayHead::where('id', $pay_head_id)->first();
                                            $type = $pay_head->type;
                                        @endphp
                                        @if ($type == 'Earning')
                                            @php
                                                $total_earning = $total_earning + $item->amount;
                                            @endphp
                                            <tr>
                                                <td width="50%">{{$pay_head->name}}</td>
                                                <td style="text-align: right;"> {{get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT' }} {{round($item->amount)}}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>                    
                        </td>

                        <td valign="top">
                            <table class="no-border">
                                <tbody>
                                    @php
                                        $items = App\models\employee\PayrollDetail::where('payroll_id', $model->id)->get();
                                    @endphp

                                    @foreach ($items as $item)
                                        @php
                                            $pay_head_id = $item->pay_head_id;
                                            $pay_head = App\models\employee\PayHead::where('id', $pay_head_id)->first();
                                            $type = $pay_head->type;
                                        @endphp
                                        @if ($type == 'Deduction')
                                            @php
                                                $total_deduction = $total_deduction + $item->amount;
                                            @endphp
                                            <tr>
                                                <td width="50%">{{$pay_head->name}}</td>
                                                <td style="text-align: right;"> {{get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT' }} {{round($item->amount)}}</td>
                                            </tr>
                                        @endif

                                    @endforeach
                                </tbody>
                            </table>                
                        </td>
            </tr>
            <tr>
                <td valign="top">
                    <table class="no-border">
                        <tbody>
                            <tr>
                                <td width="50%">Total Earning</td>
                                <td style="text-align: right;">{{get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT' }} {{$total_earning}}</td>
                            </tr>
                        </tbody>
                    </table>                    
                </td>
                <td valign="top">
                    <table class="no-border">
                        <tbody>
                            <tr>
                                <td width="50%">Total Deduction</td>
                                <td style="text-align: right;">{{get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT' }} {{$total_deduction}}</td>
                            </tr>
                        </tbody>
                    </table>                
                </td>
            </tr>
            <tr>
                <th>Net Salary</th>
                <th style="text-align: right;">{{get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT' }} {{$total_earning - $total_deduction}}</th>
            </tr>
        </tbody>
    </table>

        <p style="margin-top:40px; font-size: 12px; font-weight: bold;">Authorized Signatory</p>
            <p style="text-align: right; font-size: 12px;">Printed on {{date('d-m-Y h:i:s')}}</p>
        </div>
    </div>
</body>
</html>