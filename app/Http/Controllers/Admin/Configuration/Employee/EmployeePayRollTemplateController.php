<?php

namespace App\Http\Controllers\Admin\Configuration\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\models\employee\EmployeeAttendanceType;
use App\models\employee\PayHead;
use App\models\employee\PayrollTemplate;
use App\models\employee\PayrollTemplateDetail;
use Illuminate\Support\Str;

class EmployeePayRollTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function view()
    {
        return view('admin.employee.payroll.view');
    }

    public function index()
    {
        return view('admin.employee.payroll.template.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $documents = PayrollTemplate::query();

            return Datatables::of($documents)
                ->addIndexColumn()
                ->editColumn('is_active', function ($document) {
                    if ($document->is_active == '0') {
                        return '<span class="badge badge-danger">' . 'Inactive' . '</span>';
                    } elseif ($document->is_active == '1') {
                        return '<span class="badge badge-success">' . 'Active' . '</span>';
                    }
                })
                ->addColumn('action', function ($model) {
                    return view('admin.employee.payroll.template.action', compact('model'));
                })->rawColumns(['action', 'is_active'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = EmployeeAttendanceType::where('is_active', '1')->whereIn('type', ['production_based_deduction', 'production_based_earning'])->get();
        $models = PayHead::where('is_active','1')->get();
        return view('admin.employee.payroll.template.create', compact('models','type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $uuid =  Str::uuid()->toString();
        $pay_head = $request->pay_head_category;
        $request->validate([
            'name' => 'required',
        ]);

        $model = new PayrollTemplate;
        $model->uuid = $uuid;
        $model->name = $request->name;
        $model->is_active = $request->is_active;
        $model->description = $request->description;
        $model->save();
        $id = $model->id;

        foreach ($pay_head as $key => $value) {
            $data = new PayrollTemplateDetail;
            $data['payroll_template_id'] = $id;
            $data['pay_head_id'] = $key;
            $data['category'] = $value;
            $data['employee_attendance_type_id'] = $request->attendance_type[$key];
            $data['computation'] = $request->pay_head_computation[$key];
            $data->save();
        }
        // Activity Log
        activity()->log('Created a Employee Payroll Template - ' . $request->name);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'goto' => route('admin.payroll-template.index')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = PayrollTemplate::where('uuid', $id)->with('details')->firstOrFail();
        return view('admin.employee.payroll.template.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = EmployeeAttendanceType::where('is_active', '1')->whereIn('type', ['production_based_deduction', 'production_based_earning'])->get();
        $model = PayrollTemplate::where('uuid', $id)->with('details')->firstOrFail();
        return view('admin.employee.payroll.template.edit', compact('model','type'));
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
        $pay_head = $request->pay_head_category;
        $model = PayrollTemplate::findOrFail($id);
        $model->name = $request->name;
        $model->is_active = $request->is_active;
        $model->description = $request->description;
        $model->save();

        $type = PayrollTemplateDetail::where('payroll_template_id', $id)->get();
        if (count($type)) {
            foreach ($type as $details) {
                $details->delete();
            }
        }
        
        foreach ($pay_head as $key => $value) {
            $data = new PayrollTemplateDetail;
            $data['payroll_template_id'] = $id;
            $data['pay_head_id'] = $key;
            $data['category'] = $value;
            $data['employee_attendance_type_id'] = $request->attendance_type[$key];
            $data['computation'] = $request->pay_head_computation[$key];
            $data->save();
        }
        // Activity Log
        activity()->log('Created a Employee Payroll Template - ' . $request->name);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated'), 'goto' => route('admin.payroll-template.index')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = PayrollTemplate::where('uuid', $id)->firstOrFail();
        $name = $type->name;
        $type->delete();

        // Activity Log
        activity()->log('Created a Employee Payroll Template - ' . $name);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted Successfully')]);
    }
}
