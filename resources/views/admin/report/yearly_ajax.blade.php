        @php
            $months = array(01 => 'Jan.', 02 => 'Feb.', 03 => 'Mar.', 04 => 'Apr.', 05 => 'May', 06 => 'Jun.', 07 => 'Jul.', '08' => 'Aug.', '09' => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
        @endphp
         <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ _lang('Month') }}</th>
                            <th>{{ _lang('Sale') }}</th>
                            <th>{{ _lang('Sale Paid') }}</th>
                            <th>{{ _lang('Sale Due') }}</th>
                            <th>{{ _lang('Purchase') }}</th>
                            <th>{{ _lang('Purchase Paid') }}</th>
                            <th>{{ _lang('Purchase Due') }}</th>
                            <th>{{ _lang('Expense') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($months as $key=> $element) 

                            <tr>
                                <td>{{ $element }}</td>
                                <td>{{ ovarallreport('Sale',null,null,null,$key,$year)->sum('net_total') }}</td>
                                <td>{{ ovarallreport('Sale',null,null,null,$key,$year)->sum('total_paid') }}</td>
                                <td>{{ ovarallreport('Sale',null,null,null,$key,$year)->sum('net_total') - ovarallreport('Sale',null,null,null,$key,$year)->sum('total_paid') }}</td>
                                <td>{{ ovarallreport('Purchase',null,null,null,$key,$year)->sum('net_total') }}</td>
                                <td>{{ ovarallreport('Purchase',null,null,null,$key,$year)->sum('total_paid') }}</td>
                                <td>{{ ovarallreport('Purchase',null,null,null,$key,$year)->sum('net_total') - ovarallreport('Purchase',null,null,null,$key,$year)->sum('total_paid') }}</td>
                                <td>
                                    @role('Super Admin')
                                    @php
                                        $expense=App\models\Expense\Expense::whereMonth('date',$key)->whereYear('date',$year)->sum('amount');
                                    @endphp
                                    @else
                                     @php
                                        $expense=App\models\Expense\Expense::whereMonth('date',$key)->whereYear('date',$year)->where('hidden',false)->sum('amount');
                                    @endphp
                                    @endrole
                                    {{ $expense }}
                                </td>
                            </tr>
                            @endforeach 
                    </tbody>
                    <tfoot>
                        <tr class="bg-green text-light">
                            <td>{{ _lang('Total') }}</td>
                            <td>{{ ovarallreport('Sale',null,null,null,null,$year)->sum('net_total') }}</td>
                            <td>{{ ovarallreport('Sale',null,null,null,null,$year)->sum('total_paid') }}</td>
                            <td>{{ ovarallreport('Sale',null,null,null,null,$year)->sum('net_total') - ovarallreport('Sale',null,null,null,null,$year)->sum('total_paid') }}</td>
                            <td>{{ ovarallreport('Purchase',null,null,null,null,$year)->sum('net_total') }}</td>
                            <td>{{ ovarallreport('Purchase',null,null,null,null,$year)->sum('total_paid') }}</td>
                            <td>{{ ovarallreport('Purchase',null,null,null,null,$year)->sum('net_total') - ovarallreport('Purchase',null,null,null,null,$year)->sum('total_paid') }}</td>
                             <td>
                                @role('Super Admin')
                                    @php
                                        $expense_key=App\models\Expense\Expense::whereYear('date',$year)->sum('amount');
                                    @endphp
                                   @else
                                    @php
                                        $expense_key=App\models\Expense\Expense::whereYear('date',$year)->where('hidden',false)->sum('amount');
                                    @endphp
                                 @endrole   
                                    {{ $expense_key }}
                             </td>
                        </tr>
                    </tfoot>
                </table>
              </div>