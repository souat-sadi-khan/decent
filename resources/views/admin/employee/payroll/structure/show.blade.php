<div class="table-responsie">
    <table class="table table-bordered table-striped">
        <tr>
            <th colspan="2" class="text-center">Name</th>
            <td colspan="2" class="text-center">{{$model->employee->name}}</td>
        </tr>
        <tr>
            <th colspan="2" class="text-center">Designation</th>
            <td colspan="2" class="text-center">{{employee_designation($model->employee_id)}} ( <strong>{{employee_department($model->employee_id)}}</strong> )</td>
        </tr>
        <tr>
            <th colspan="2" class="text-center">Date Effective</th>
            <td colspan="2" class="text-center">{{formatDate($model->date_effective)}}</td>
        </tr>
    </table>
    <div class="row">
        <div class="col-md-6 table-responsive">
            <table class="table table-bordered table-striped">
                <tr>
                    <th width="25%" class="text-center">Earning</th>
                    <th width="25%" class="text-center">Amount</th>
                </tr>
                @php
                    $items = App\models\employee\EmployeeSalaryDetail::where('employee_salary_id', $model->id)->get();
                @endphp
                @foreach ($items as $item)
                    @if ($item->amount != '')
                        @php
                            $template_id = $item->payroll_template_detail_id;
                            $templaate_details =App\models\employee\PayrollTemplateDetail::where('id', $template_id)->first();
                            if($templaate_details) {
                                $pay_head_id = $templaate_details->pay_head_id;
                                $template = App\models\employee\PayHead::where('id', $pay_head_id)->where('type', 'Earning')->first();
                            }
                        @endphp
                        @if ($template)
                            <tr>
                                <td class="text-center text-success" width="25%">{{$template->name}}</td>
                                <td class="text-center" width="25%"> {{get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT' }} {{$item->amount}}</td>
                            </tr>
                        @endif
                    @else 
                        @php
                            $template_id = $item->payroll_template_detail_id;
                            $templaate_details =App\models\employee\PayrollTemplateDetail::where('id', $template_id)->first();
                            if($templaate_details) {
                                $pay_head_id = $templaate_details->pay_head_id;
                                $template = App\models\employee\PayHead::where('id', $pay_head_id)->where('type', 'Earning')->first();
                            }
                        @endphp
                        @if ($template)
                            <tr>
                                <td class="text-center text-success" width="25%">{{$template->name}}</td>
                                <td class="text-center" width="25%"> {{get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT' }} {{$item->amount == NULL ? '0' : $item->amount }}</td>
                            </tr>
                        @endif
                    @endif
                @endforeach
            </table>
        </div>

        <div class="col-md-6 table-responsive">
            <table class="table table-bordered table-striped">
                <tr>
                    <th width="25%" class="text-center">Deduction</th>
                    <th width="25%" class="text-center">Amount</th>
                </tr>
                @php
                    $items = App\models\employee\EmployeeSalaryDetail::where('employee_salary_id', $model->id)->get();
                @endphp
                @foreach ($items as $item)
                    @if ($item->amount != '')
                        @php
                            $template_id = $item->payroll_template_detail_id;
                            $templaate_details =App\models\employee\PayrollTemplateDetail::where('id', $template_id)->first();
                            if($templaate_details) {
                                $pay_head_id = $templaate_details->pay_head_id;
                                $template = App\models\employee\PayHead::where('id', $pay_head_id)->where('type', 'Deduction')->first();
                            }
                        @endphp
                        @if ($template)
                            <tr>
                                <td class="text-center text-danger" width="25%">{{$template->name}}</td>
                                <td class="text-center" width="25%"> {{get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT' }} {{$item->amount}}</td>
                            </tr>
                        @endif
                    @else 
                        @php
                            $template_id = $item->payroll_template_detail_id;
                            $templaate_details =App\models\employee\PayrollTemplateDetail::where('id', $template_id)->first();
                            if($templaate_details) {
                                $pay_head_id = $templaate_details->pay_head_id;
                                $template = App\models\employee\PayHead::where('id', $pay_head_id)->where('type', 'Deduction')->first();
                            }
                        @endphp
                        @if ($template)
                            <tr>
                                <td class="text-center text-danger" width="25%">{{$template->name}}</td>
                                <td class="text-center" width="25%"> {{get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT' }} {{$item->amount == NULL ? '0' : $item->amount}}</td>
                            </tr>
                        @endif
                    @endif
                @endforeach
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 table-responsive">
            <table class="table table-bordered table-striped">
                <tr>
                    <th width="50%" class="text-center">Total Earning</th>
                    <th with="50%" class="text-center text-success">{{get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT' }} {{$model->total_earning}}</th>
                </tr>
            </table>
        </div>
        <div class="col-md-6 table-responsive">
            <table class="table table-bordered table-striped">
                <tr>
                    <th width="50%" class="text-center">Total Deduction</th>
                    <th with="50%" class="text-center text-danger">{{get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT' }} {{$model->total_deduction != '' ? $model->total_deduction : 0}}</th>
                </tr>
            </table>
        </div>
    </div>

    <div class="col-md-12 table-responsive">
        <table class="table table-bordered table-stringped">
            <tr>
                <th width="50%" class="text-center">Net Salary</th>
                <th with="50%" class="text-center">{{get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT' }} {{$model->net_salary != '' ? $model->net_salary : 0}}</th>
            </tr>
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
