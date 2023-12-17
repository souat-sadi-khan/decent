   <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ _lang('Date') }}</th>
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
                            @for ($i = 1; $i <=$days ; $i++)
                              @php
                                $date =Carbon\Carbon::createFromDate($year, $month, $i);
                                $date = $date->format('Y-m-d');
                              
                                @endphp
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ ovarallreport('Sale',null,null,$date)->sum('net_total') }}</td>
                                <td>{{ ovarallreport('Sale',null,null,$date)->sum('total_paid') }}</td>
                                <td>{{ ovarallreport('Sale',null,null,$date)->sum('net_total') - ovarallreport('Sale',null,null,$date)->sum('total_paid') }}</td>
                                <td>{{ ovarallreport('Purchase',null,null,$date)->sum('net_total') }}</td>
                                <td>{{ ovarallreport('Purchase',null,null,$date)->sum('total_paid') }}</td>
                                <td>{{ ovarallreport('Purchase',null,null,$date)->sum('net_total') - ovarallreport('Purchase',null,null,$date)->sum('total_paid') }}</td>
                                <td>
                                    @role('Super Admin')
                                    @php
                                        $expense=App\models\Expense\Expense::whereDate('date',$date)->sum('amount');
                                    @endphp
                                    @else
                                     @php
                                        $expense=App\models\Expense\Expense::whereDate('date',$date)->where('hidden',false)->sum('amount');
                                    @endphp
                                    @endrole
                                   
                                    {{ $expense }}
                                </td>
                            </tr>
                            @endfor
                    </tbody>
                    <tfoot>
                        <tr class="bg-green text-light">
                            <td>{{ _lang('Total') }}</td>
                            <td>{{ ovarallreport('Sale',null,null,null,$month)->sum('net_total') }}</td>
                            <td>{{ ovarallreport('Sale',null,null,null,$month)->sum('total_paid') }}</td>
                            <td>{{ ovarallreport('Sale',null,null,null,$month)->sum('net_total') - ovarallreport('Sale',null,null,null,$month)->sum('total_paid') }}</td>
                            <td>{{ ovarallreport('Purchase',null,null,null,$month)->sum('net_total') }}</td>
                            <td>{{ ovarallreport('Purchase',null,null,null,$month)->sum('total_paid') }}</td>
                            <td>{{ ovarallreport('Purchase',null,null,null,$month)->sum('net_total') - ovarallreport('Purchase',null,null,null,$month)->sum('total_paid') }}</td>
                             <td> 
                                @role('Super Admin')
                                    @php
                                        $expense_month=App\models\Expense\Expense::whereMonth('date',$month)->sum('amount');
                                    @endphp
                                    @else
                                     @php
                                        $expense_month=App\models\Expense\Expense::whereMonth('date',$month)->where('hidden',false)->sum('amount');
                                    @endphp
                                 @endrole   
                                    {{ $expense_month }}
                             </td>
                        </tr>
                    </tfoot>
                </table>
              </div>