<?php

namespace App\Http\Controllers\admin\employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\account\AccountTransaction;
use App\models\account\InvestmentAccount;
use App\models\employee\Employee;
use App\models\employee\Payrolls;
use App\models\employee\PayrollTransaction;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;

class PayrollTransectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.employee.payroll.transection.index');
    }

        // Ajax DataTable
        public function datatable(Request $request)
        {
            if ($request->ajax()) {
                $documents = PayrollTransaction::query();
                    return Datatables::of($documents)
                    ->addIndexColumn()
                    ->editColumn('employee', function ($document) { 
                        $name = find_employee_name_using_employee_id($document->employee_id);
                        $desig = employee_designation($document->employee_id);
                        $department = employee_department($document->employee_id);
    
                        $output = $name . '<br>' . $desig . '<strong>('. $department .')</strong>';
                        return $output;
                    })
                    ->editColumn('net_salary', function ($document) {
                        $usd = get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT';
                        $salary = $document->total;
                        return $usd . ' ' . $salary;
                    })
                    ->editColumn('status', function ($document) {
                        if($document->payment_status == 'Paid') {
                            $output = '<span class="badge badge-primary">Paid</span>';
                        } elseif($document->payment_status == 'Partial') {
                            $output = '<span class="badge badge-info">Partital</span>';
                        } else {
                            $output = '<span class="badge badge-danger">Due</span>';
                        }
    
                        return $output;
                    })
                    ->addColumn('action', function ($model) {
                        return view('admin.employee.payroll.transection.action', compact('model'));
                    })->rawColumns(['action', 'employee', 'status', 'net_salary'])->make(true);
            }
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::all();
        $accounts = InvestmentAccount::all();
        return view('admin.employee.payroll.transection.create', compact('employees', 'accounts'));
    }

    // ajax 
    public function ajax(Request $request) {
        $val = $request->val;
        return view('admin.employee.payroll.transection.ajax', compact('val'));
    }

    // check_employee_payroll
    public function check_employee_payroll(Request $request) {
        
        $id = $request->val;

        $payroll = Payrolls::where('employee_id', $id)->where('payment_status', '!=', 'Paid')->first();

        if($payroll) {
            $due = $payroll->total - $payroll->paid;
            $usd = get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT'  ;

            echo '<span class="text-success">Payroll #'.$payroll->id . 'from '. $payroll->start_date . ' to '. $payroll->end_date . ' unpaid amount '. $usd . ' '.  $due . '</span>';
        } else {
            echo '<span class="text-danger">No Unpaid payroll found</span>';
        }

    }

    // check_advane_return
    public function check_advane_return(Request $request) {
        $total_advance = total_advance_payment($request->val);
        $total_advance_return = total_advance_return($request->val);
        $usd = get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT'  ;

        $amount = $total_advance - $total_advance_return ;

        if($amount > 0) {
            echo '<span class="text-success">Advance returnable '. $usd . ' ' . $amount . '</span>' ;
        } else {
            echo '<span class="text-warning">Select Employee</span>';
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'employee_id'    =>   'required',
            'date'    =>   'required',
            'amount'    =>   'required',
            'payment_method'    =>   'required',
            'head'              =>  'required',
            'investment_account_id' =>  'required',
        ]);

        $investment_account_id = $request->investment_account_id;

        // Date of transaction cannot be less than payroll end date.
        if($request->head == 'Salary Payment') {

            $payroll = Payrolls::where('employee_id', $request->employee_id)->where('payment_status', '!=', 'Paid')->first();
        
            if(!$payroll) {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('No Unpaid payroll found for this Employee')]);
            }
            $payroll_id = $payroll->id;

            $payroll_end_date = $payroll->end_date;
            $date_of_tx = $request->date;
            if(strtotime($date_of_tx) < strtotime($payroll_end_date)) {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Date of transaction cannot be less than payroll end date.')]);
            }

            // Amount is greater than payroll balance ₹1,100
            $payroll_balance = $payroll->total;
            $amount = intval($request->amount);
            if($amount > $payroll_balance) {
                $due = $payroll->total - $payroll->paid;
                $usd = get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT'  ;
                $output = 'Amount is greater than payroll balance '. $usd . ' ' . $due ;
                return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang($output)]);
            }

            // 
            $paid = $payroll->paid;
            $new_paid = $paid + $amount ;
            $total = $payroll->total;
            
            if($total < $new_paid) {
                $output = 'Amount is greater than payroll balance.<br> Total Payable Amount '. $total . '. <br>Total Paid Amount ' . $new_paid ;
                return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang($output)]);
            }

            if(round($total) == round($new_paid)) {
                $status = 'Paid';
            } else {
                $status = 'Partial';
            }

            $payroll->paid = $new_paid;
            $payroll->payment_status = $status;
            $payroll->save();

            $model = new PayrollTransaction;
            $model->employee_id = $request->employee_id;
            $model->payroll_id = $payroll_id;
            $model->head = $request->head;
            $model->amount = $request->amount;
            $model->date_of_transaction = $request->date;

            if($request->payment_method == '3') {
                $model->payment_method = 'Mobile Banking';
                $model->mob_banking_name = $request->mob_banking_name;
                $model->mob_account_holder = $request->mob_account_holder;
                $model->sending_mob_no = $request->sending_mob_no;
                $model->receiving_mob_no = $request->receiving_mob_no;
                $model->mob_tx_id = $request->mob_tx_id;
            } elseif($request->payment_method == 2) {
                $model->payment_method = 'Bank Check';
                $model->bank_name = $request->bank_name;
                $model->account_holder = $request->account_holder;
                $model->account_no = $request->account_no;
                $model->check_no = $request->check_no;
                $model->check_active_date = $request->check_active_date;
            } else {
                $model->payment_method = 'Cash';
            }

            $model->tx_type = 'Salary Payment';
            $model->additional_note = $request->additional_note;
            $model->save();

            $acc_trans = new AccountTransaction;
            $acc_trans->investment_account_id = $investment_account_id;
            $acc_trans->acc_type = 'investment';
            $acc_trans->type  = 'Debit';
            $acc_trans->amount = $request->amount;
            $acc_trans->reff_no = rand(1, 100000000);
            $acc_trans->operation_date = date('Y-m-d');
            $acc_trans->payroll_transaction_id = $model->id;
            $acc_trans->save();
            
            return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Salary Payment Paid Successfully')]);
        
        } elseif ($request->head == 'Advance Payment') {
            
            $model = new PayrollTransaction;
            $model->employee_id = $request->employee_id;
            $model->head = $request->head;
            $model->amount = $request->amount;
            $model->date_of_transaction = $request->date;

            if($request->payment_method == '3') {
                $model->payment_method = 'Mobile Banking';
                $model->mob_banking_name = $request->mob_banking_name;
                $model->mob_account_holder = $request->mob_account_holder;
                $model->sending_mob_no = $request->sending_mob_no;
                $model->receiving_mob_no = $request->receiving_mob_no;
                $model->mob_tx_id = $request->mob_tx_id;
            } elseif($request->payment_method == 2) {
                $model->payment_method = 'Bank Check';
                $model->bank_name = $request->bank_name;
                $model->account_holder = $request->account_holder;
                $model->account_no = $request->account_no;
                $model->check_no = $request->check_no;
                $model->check_active_date = $request->check_active_date;
            } else {
                $model->payment_method = 'Cash';
            }

            $model->tx_type = 'Advance Payment';
            $model->additional_note = $request->additional_note;
            $model->save();

            $acc_trans = new AccountTransaction;
            $acc_trans->investment_account_id = $investment_account_id;
            $acc_trans->acc_type = 'investment';
            $acc_trans->type  = 'Debit';
            $acc_trans->amount = $request->amount;
            $acc_trans->reff_no = rand(1, 100000000);
            $acc_trans->operation_date = date('Y-m-d');
            $acc_trans->payroll_transaction_id = $model->id;
            $acc_trans->save();
            
            return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Payment Advanced Successfully')]);
        
        } elseif($request->head == 'Advance Return') {
            $amount = $request->amount;
            $total_advance = total_advance_payment($request->employee_id);
            $total_advance_return = total_advance_return($request->employee_id);
            $usd = get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT'  ;

            $total_due = $total_advance - $total_advance_return ;

            if($amount > $total_due) {
                $output = 'Amount is greater than advance returnable '. $usd . ' ' . $total_due ;
                return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang($output)]);
            }

            $model = new PayrollTransaction;
            $model->employee_id = $request->employee_id;
            $model->head = $request->head;
            $model->amount = $request->amount;
            $model->date_of_transaction = $request->date;

            if($request->payment_method == '3') {
                $model->payment_method = 'Mobile Banking';
                $model->mob_banking_name = $request->mob_banking_name;
                $model->mob_account_holder = $request->mob_account_holder;
                $model->sending_mob_no = $request->sending_mob_no;
                $model->receiving_mob_no = $request->receiving_mob_no;
                $model->mob_tx_id = $request->mob_tx_id;
            } elseif($request->payment_method == 2) {
                $model->payment_method = 'Bank Check';
                $model->bank_name = $request->bank_name;
                $model->account_holder = $request->account_holder;
                $model->account_no = $request->account_no;
                $model->check_no = $request->check_no;
                $model->check_active_date = $request->check_active_date;
            } else {
                $model->payment_method = 'Cash';
            }

            $model->tx_type = 'Advance Return';
            $model->additional_note = $request->additional_note;
            $model->save();

            $acc_trans = new AccountTransaction;
            $acc_trans->investment_account_id = $investment_account_id;
            $acc_trans->acc_type = 'investment';
            $acc_trans->type  = 'Debit';
            $acc_trans->amount = $request->amount;
            $acc_trans->reff_no = rand(1, 100000000);
            $acc_trans->operation_date = date('Y-m-d');
            $acc_trans->payroll_transaction_id = $model->id;
            $acc_trans->save();
            
            return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Payment Advanced Return Successfully')]);

        } elseif ($request->head == 'Other Payment') {

            $model = new PayrollTransaction;
            $model->employee_id = $request->employee_id;
            $model->head = $request->head;
            $model->amount = $request->amount;
            $model->date_of_transaction = $request->date;

            if($request->payment_method == '3') {
                $model->payment_method = 'Mobile Banking';
                $model->mob_banking_name = $request->mob_banking_name;
                $model->mob_account_holder = $request->mob_account_holder;
                $model->sending_mob_no = $request->sending_mob_no;
                $model->receiving_mob_no = $request->receiving_mob_no;
                $model->mob_tx_id = $request->mob_tx_id;
            } elseif($request->payment_method == 2) {
                $model->payment_method = 'Bank Check';
                $model->bank_name = $request->bank_name;
                $model->account_holder = $request->account_holder;
                $model->account_no = $request->account_no;
                $model->check_no = $request->check_no;
                $model->check_active_date = $request->check_active_date;
            } else {
                $model->payment_method = 'Cash';
            }

            $model->tx_type = 'Other Payment';
            $model->additional_note = $request->additional_note;
            $model->save();

            $acc_trans = new AccountTransaction;
            $acc_trans->investment_account_id = $investment_account_id;
            $acc_trans->acc_type = 'investment';
            $acc_trans->type  = 'Debit';
            $acc_trans->amount = $request->amount;
            $acc_trans->reff_no = rand(1, 100000000);
            $acc_trans->operation_date = date('Y-m-d');
            $acc_trans->payroll_transaction_id = $model->id;
            $acc_trans->save();
            
            return response()->json(['success' => true, 'status' => 'success', 'message' => _lang(' Other Payment Successfully')]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = PayrollTransaction::findOrFail($id);
        return view('admin.employee.payroll.transection.show', compact('model'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = PayrollTransaction::findOrFail($id);
        
        $tx_type = $model->tx_type;

        if($tx_type == 'Salary Payment') {
            $amount = $model->amount;
            $payroll_id = $model->payroll_id;
            $payroll = Payrolls::where('id', $payroll_id)->first();

            if($payroll) {

                $paid = $payroll->paid;
                $new_paid = $paid - $amount;  
                $payroll->paid = $new_paid;
                $total = $payroll->total;   
                if($total == $new_paid) {
                    $status = 'Paid';
                } elseif ($new_paid <= 0) {
                    $status = 'Due';
                } elseif ($total > $new_paid && $new_paid > 0 ) {
                    $status = 'Partial';
                }  else {
                    $usd = get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT';
                    $output = 'Transaction Salary is greater then Payroll Salary -' . $usd . ' ' . $total;
                    
                    return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang($output)]);
                }

                $payroll->payment_status = $status;

                $payroll->save();

            } else {

                return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Payrool Not Found')]);

            }
        }

        $model->delete();
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Transection Deleted Successfully')]);
    }

    // print
    public function print($id) {
        $model = PayrollTransaction::findOrFail($id);
        $emp = Employee::findOrFail($model->employee_id);
        $employee = $emp->name;
        $head = $model->head;

        // dd($model);
        return view('admin.employee.payroll.transection.print', compact('model', 'employee', 'head'));
    }
}
