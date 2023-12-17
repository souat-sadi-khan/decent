<div class="card">
    <div class="card-body">
        <h6 class="text-center">{{_lang('Payroll Transaction Details')}}</h6>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{{_lang('Transaction')}}</th>
                    <th>{{_lang('Payroll ID')}}</th>
                    <th>{{_lang('Head')}}</th>
                    <th>{{_lang('Amount')}}</th>
                    <th>{{_lang('Date of Transaction')}}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$model->id}}</td>
                    <td>{{$model->payroll_id}}</td>
                    <td>{{$model->head}}</td>
                    <td>{{$model->amount}}</td>
                    <td>{{$model->date_of_transaction}}</td>
                </tr>
            </tbody>
        </table>
        <table class="table table-bordered table-striped">
            <tr>
                <th class="text-center">{{_lang('Employee Information')}}</th>
                <td>
                    @php
                        $name = find_employee_name_using_employee_id($model->employee_id);
                        $desig = employee_designation($model->employee_id);
                        $department = employee_department($model->employee_id);
    
                        $output = $name . '<br>' . $desig . '<strong>('. $department .')</strong>';
                        echo $output;
                    @endphp
                </td>
            </tr>
        </table>
        <table class="table table-bordered table-striped">
            <tr>
                <th>{{_lang('Payment Method')}}</th>
                <td>{{$model->payment_method}}</td>
            </tr>
            @if ($model->payment_method == 'Bank Check')
                <tr>
                    <th>{{_lang('Bank Name')}}</th>
                    <td>{{$model->bank_name}} </td>
                </tr>
                <tr>
                    <th>{{_lang('Account Holder Name')}}</th>
                    <td>{{$model->account_holder}} </td>
                </tr>
                <tr>
                    <th>{{_lang('Account Number')}}</th>
                    <td>{{$model->account_no}} </td>
                </tr>
                <tr>
                    <th>{{_lang('Cheque Number')}}</th>
                    <td>{{$model->check_no}} </td>
                </tr>
                <tr>
                    <th>{{_lang('Check Active Date')}}</th>
                    <td>{{$model->check_active_date}} </td>
                </tr>
            @elseif ($model->payment_method == 'Mobile Banking')
                <tr>
                    <th>{{_lang('Mobile Banking Name')}}</th>
                    <td>{{$model->mob_banking_name}} </td>
                </tr>
                <tr>
                    <th>{{_lang('Mobile Account Holder Name')}}</th>
                    <td>{{$model->mob_account_holder}} </td>
                </tr>
                <tr>
                    <th>{{_lang('Sending Mobile Number')}}</th>
                    <td>{{$model->sending_mob_no}} </td>
                </tr>
                <tr>
                    <th>{{_lang('Receiving Mobile Number')}}</th>
                    <td>{{$model->receiving_mob_no}} </td>
                </tr>
                <tr>
                    <th>{{_lang('Transaction Number')}}</th>
                    <td>{{$model->mob_tx_id}} </td>
                </tr>
            @endif
        </table>
        <table class="table table-bordered table-striped">
            <tr>
                <th>{{_lang('Additional Note')}}</th>
                <td>
                    {!!$model->additional_note!!}
                </td>
            </tr>
        </table>
    </div>
</div>