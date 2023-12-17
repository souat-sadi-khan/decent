<?php

namespace App\Http\Controllers\Admin\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\employee\Employee;
use App\models\employee\EmployeeSalary;
use App\models\employee\PayHead;
use App\models\employee\PayrollDetail;
use App\models\employee\Payrolls;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.employee.payroll.payroll.index');
    }

    // Ajax DataTable
    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $documents = Payrolls::query();
                return Datatables::of($documents)
                ->addIndexColumn()
                ->editColumn('employee', function ($document) { 
                    $name = find_employee_name_using_employee_id($document->employee_id);
                    $desig = employee_designation($document->employee_id);
                    $department = employee_department($document->employee_id);

                    $output = $name . '<br>' . $desig . '<strong>('. $department .')</strong>';
                    return $output;
                })
                ->editColumn('payroll_period', function ($document) {
                    return formatDate($document->start_date) . ' - '. formatDate($document->end_date);
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
                    return view('admin.employee.payroll.payroll.action', compact('model'));
                })->rawColumns(['action', 'employee', 'payroll_period', 'status', 'net_salary'])->make(true);
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

        return view('admin.employee.payroll.payroll.create', compact('employees'));
    }

    // step_one
    public function step_one(Request $request) {
        
        $request->validate([
            'employee_id'       =>      'required',
            'start_date'       =>      'required',
            'end_date'       =>      'required',
        ]);

        $emploee_id = $request->employee_id;
        
        $start_date = $request->start_date;

        $end_date = $request->end_date;

        $salary = EmployeeSalary::where('employee_id', $emploee_id)->where('date_effective', '<=', $start_date)->orderBy('created_at', 'desc')->first();

        if($salary) {

            $date_of_effective = $salary->date_effective;

            if(strtotime($date_of_effective) <= strtotime($request->start_date)) {
                
                $html = view('admin.employee.payroll.payroll.step_two', compact('salary', 'start_date', 'end_date'))->render();

                return response()->json(['success' => true, 'html' => $html, 'message' => _lang('Salary Structure Not Found For This Employee.')]);
          
            } else {
                
                return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Could not find selected salary structure..')]);
                
            }

        } else {

            return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Salary Structure Not Found For This Employee.')]);
                            
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
        $earning_amount = 0;
        $deduction_amount = 0;

        $request->validate([
            'employee_id'       =>      'required',
            'employee_salary_id'       =>      'required',
            'start_date'       =>      'required',
            'end_date'       =>      'required',
            'per_day_calculation_basis'       =>      'required',
            'total'       =>      'required',
        ]);
        $uuid =  Str::uuid()->toString();

        $count = count($request->pay_head);
        for($i = 0; $i < $count; $i++) {
            $pay_head_id = $request->pay_head[$i];
            $pay_head = PayHead::where('id', $pay_head_id)->first();
            if($pay_head->type == 'Earning') {
                $amount = $request->amount[$i];
                $earning_amount = $earning_amount + $amount;
            } else {
                $amount = $request->amount[$i];
                $deduction_amount = $deduction_amount + $amount;
            }
        }
        
        $total = $earning_amount - $deduction_amount;
        if($total < 0) {
            return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Total Amount is must be greater then 0')]);
        }
        $per_day_calculation_basis = $total / $request->total_present;
        
        $model = new Payrolls;
        $model->uuid = $uuid;
        $model->employee_id = $request->employee_id;
        $model->employee_salary_id = $request->employee_salary_id;
        $model->start_date = $request->start_date;
        $model->end_date = $request->end_date;
        $model->per_day_calculation_basis = $per_day_calculation_basis;
        $model->total = $total;
        $model->paid = 0;
        $model->payment_status = 'Due';
        $model->remarks = $request->remarks;
        $model->save();
        $id = $model->id; 

        for ($i = 0; $i < $count; $i++) {
            $pay_head_id = $request->pay_head[$i];
            $amount = $request->amount[$i];
            $item = new PayrollDetail;
            $item->payroll_id = $id;
            $item->pay_head_id = $pay_head_id;
            $item->amount = $amount;
            $item->save();
        }

        // Activity Log
        activity()->log('Created a Employee Payroll- ');
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'goto' => route('admin.payroll-initialize.index')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Payrolls::where('uuid', $id)->firstOrFail();
        $start_date = $model->start_date;
        $end_date = $model->end_date;
        $salary = EmployeeSalary::where('id', $model->employee_salary_id)->first();

        return view('admin.employee.payroll.payroll.show', compact('model', 'salary', 'start_date', 'end_date'));
    }

    // print 
    public function print($id) {
        $model = Payrolls::where('uuid', $id)->firstOrFail();
        $start_date = $model->start_date;
        $end_date = $model->end_date;
        $salary = EmployeeSalary::where('id', $model->employee_salary_id)->first();

        return view('admin.employee.payroll.payroll.print', compact('model', 'salary', 'start_date', 'end_date'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Payrolls::where('uuid', $id)->firstOrFail();
        $start_date = $model->start_date;
        $end_date = $model->end_date;
        $salary = EmployeeSalary::where('id', $model->employee_salary_id)->first();

        return view('admin.employee.payroll.payroll.print', compact('model', 'salary', 'start_date', 'end_date'));
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
        $model = Payrolls::where('uuid',$id)->firstOrFail();
        $model->delete();

        // Activity Log
        activity()->log('Deleted a Employee Payroll- ');
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted')]);
    }
}
