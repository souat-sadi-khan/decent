<?php

namespace App\Http\Controllers\Admin\Configuration\Employee;

use App\Helper\MathExpression;
use App\Http\Controllers\Admin\Employee\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\employee\Employee;
use App\models\employee\EmployeeSalary;
use App\models\employee\EmployeeSalaryDetail;
use App\models\employee\PayHead;
use App\models\employee\PayrollTemplate;
use App\models\employee\PayrollTemplateDetail;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class EmployeeSalaryStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.employee.payroll.structure.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $documents = EmployeeSalary::query();
                return Datatables::of($documents)
                ->addIndexColumn()
                ->editColumn('employee', function ($document) {
                    return $document->employee->name ;
                })
                ->editColumn('payroll_template', function ($document) {
                    return $document->payroll_template->name ;
                })
                ->editColumn('date_effective', function ($document) {
                    return formatDate($document->date_effective);
                })
                ->editColumn('net_salary', function ($document) {
                    $usd = get_option('currency') && get_option('currency') != '' ? get_option('currency') : 'BDT';
                    $salary = $document->net_salary;
                    return $usd . ' ' . $salary;
                })
                ->addColumn('action', function ($model) {
                    return view('admin.employee.payroll.structure.action', compact('model'));
                })->rawColumns(['action', 'employee', 'payroll_template', 'net_salary'])->make(true);
        }
    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // find all employee list
        $employees = Employee::all();
        
        // find all Template
        $templates = PayrollTemplate::where('is_active', 1)->get();

        // return 
        return view('admin.employee.payroll.structure.create', compact('employees', 'templates'));
    }

    public function ajaxcall(Request $request) {
        // ->where('category', '<>', 'computation')
        $id = $request->id;
        $details = PayrollTemplateDetail::where('payroll_template_id', $id)->with('payhead')->get();
        return view('admin.employee.payroll.structure.ajax', compact('details'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $x = array();

        // validate data from form
        $request->validate([
            'employee_id'   =>   'required',
            'date_effective'   =>   'required',
            'payroll_template_id'   =>   'required',
        ]);
        
        $payroll_template_id = $request->payroll_template_id;

        $payroll_template_details = PayrollTemplateDetail::where('payroll_template_id' ,$payroll_template_id)->get();
        $var = array();
        foreach($payroll_template_details as $details) {
            $pay_head_id = $details->pay_head_id;
            $pay_head = PayHead::where('id', $pay_head_id)->first();
            $alias = $pay_head->alias;
            $var[$pay_head->id] = $alias;
        }

        $uuid =  Str::uuid()->toString();

        $count_template_details_id = count($request->template_details_id);

        $count_amount = count($request->amount);

        $net_salary = 0;
        
        if($count_amount == $count_template_details_id) {

            $total_earning = 0;

            $total_deduction = 0;

            for($i = 0; $i < $count_template_details_id; $i++) {

                $template_id = $request->template_details_id[$i];

                $amount = $request->amount[$i];

                if($i == 0) {
                    $x[] = intval($amount);
                }

                // First Payroll Template Details row for creating computaion
                $first_payroll_details = PayrollTemplateDetail::findOrFail($request->template_details_id[0]);

                if($first_payroll_details->category == 'computaion') {
                    return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Sorry. First Template ca not be Computation')]);
                }

                if($first_payroll_details) {
                    
                   $pay_head_id = $first_payroll_details->pay_head_id;
                   $pay_head = PayHead::findOrFail($pay_head_id);

                } else {

                    $alias = '';

                }

                $template_model = PayrollTemplateDetail::where('id', $template_id)->first();

                                
                if($template_model) {


                    $pay_head_id= $template_model->pay_head_id;

                    $pay_head = PayHead::where('id', $pay_head_id)->first();

                    if($pay_head) {
                        $alias = $pay_head->alias;
                    } else {
                        $alias = '';
                    }

                    $category = $template_model->category;


                    if($category == 'flat_rate') {
                        if($pay_head->type == 'Earning') {
                            $total_earning = $total_earning + $amount;
                        } else {
                            $total_deduction = $total_deduction + $amount;
                        }
                    }

                    // if($category == 'user_defined') {
                    //     return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Sorry. User Defind is not working at this moment . Contact with Sadik')]);
                    // }
                    
                    // if($category == 'production') {
                    //     return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Sorry. On Production is not working at this moment . Contact with Sadik')]);
                    // }
                    
                    if($category == 'computation') {
                        $template_alias_id = $request->template_details_id[$i - 1];

                        $alias_template = PayrollTemplateDetail::where('id', $template_alias_id)->first();

                        if($alias_template) {
                            $pay_head_id = $alias_template->pay_head_id;
                            if($pay_head_id) {
                                $pay_head = PayHead::where('id', $pay_head_id)->first();
                                if($pay_head) {
                                    $alias = $pay_head->alias;
                                } else {
                                    $alias = '';
                                }
                            } else {
                                $alias = '';
                            }
                        } else {
                            $alias = '';
                        }

                        $computaion = $template_model->computation;

                        $explode = explode(' ', $computaion);

                        $g = $explode[0];
                        $g = trim($g);

                        $search = array_search($g , $var);


                        $eve = str_replace($alias, $request->amount[0], $computaion);

                        $obj = new MathExpression;
                        $result = $obj->execute($eve);
                        $x[] = $result;

                        $pay_head_id = $template_model->pay_head_id;
                        if($pay_head_id != NULL) {
                            $pay_head = PayHead::where('id', $pay_head_id)->first();
                            if($pay_head) {
                                $type = $pay_head->type;
                                if($type == 'Earning') {
                                    $total_earning = $total_earning + $result;
                                } else {
                                    $total_deduction = $total_deduction + $result;
                                }
                            }
                        }

                        
                    } 

                } else {

                    return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Sorry. Wrong Template Deails')]);

                }

            }

           


            $total_salary = $total_earning - $total_deduction ; 

            $model = new EmployeeSalary;
            $model->uuid = $uuid;
            $model->employee_id = $request->employee_id;
            $model->payroll_template_id = $request->payroll_template_id;
            $model->date_effective = $request->date_effective;
            $model->total_earning = $total_earning;
            $model->total_deduction = $total_deduction;
            $model->net_salary = $total_salary;
            $model->description = $request->description;
            $model->save();

            $employee_salary_id = $model->id;

            for($i = 0; $i < $count_template_details_id; $i++) {

                $template_id = $request->template_details_id[$i];                
                $amount = $request->amount[$i];

                $template_model = PayrollTemplateDetail::where('id', $template_id)->first();

                $template_details_id = $template_model->id;

                $item = new EmployeeSalaryDetail;
                $item->employee_salary_id = $employee_salary_id;
                $item->payroll_template_detail_id = $template_details_id;

                if($template_model->category == 'computation') {
                    $item->amount = $x[$i -1];
                } else {
                    
                    if($amount == NULL) {
                        $item->amount = $amount;
                    } else {
                        $item->amount = $amount;
                    }

                }
                
                $item->save();
            }
            
        } else {

            return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Sorry. Amount Not Matched')]);

        }

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Salary Structure Created')]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = EmployeeSalary::where('uuid', $id)->firstOrFail();

        return view('admin.employee.payroll.structure.show', compact('model'));
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
        $model = EmployeeSalary::where('uuid', $id)->firstOrFail();
        $model->delete();
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Salary Structure Deleted')]);
        
    }
}
