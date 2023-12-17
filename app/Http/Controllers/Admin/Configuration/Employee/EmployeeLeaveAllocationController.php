<?php

namespace App\Http\Controllers\Admin\Configuration\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\models\employee\EmployeeLeaveType;
use App\models\employee\EmployeeLeaveAllocation;
use App\models\employee\EmployeeLeaveAllocationDetail;
use App\models\employee\Employee;
use Illuminate\Support\Str;

class EmployeeLeaveAllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.employee.leave.allocation.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $documents = EmployeeLeaveAllocation::query();
            return Datatables::of($documents)
                ->addIndexColumn()
                ->editColumn('name', function ($document) {
                    return $document->employee->name.' (' . $document->employee->prefix . numer_padding($document->employee->code, get_option('digits_employee_code')).')';
                })
                ->editColumn('designation', function ($document) {
                    return current_designation($document->employee_id) ? current_designation($document->employee_id) : "";
                })
                ->editColumn('period', function ($document) {
                    return $document->start_date. ' To ' . $document->end_date;
                })

                ->editColumn('leave_allotted', function ($document) {
                    $kanak = "";
                    foreach ($document->allocation_details as  $value) {
                        $used = $value->used ? $value->used : '0';
                        $allotted = $value->allotted ? $value->allotted : '0';
                        $kanak .= $value->leave_type->name . ': ' . $used . '/' . $allotted.'<br>';

                    }
                    return $kanak ;
                    
                })
                ->addColumn('action', function ($model) {
                    return view('admin.employee.leave.allocation.action', compact('model'));
                })->rawColumns(['action','name', 'leave_allotted'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $models = Employee::all();
        $leave_types = EmployeeLeaveType::all();
        return view('admin.employee.leave.allocation.create', compact('models' , 'leave_types'));
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
        $leave_type = $request->leave_type;
         $request->validate([
            'employee' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $model = new EmployeeLeaveAllocation;
        $model->uuid = $uuid;
        $model->employee_id = $request->employee;
        $model->start_date = $request->start_date;
        $model->end_date = $request->end_date;
        $model->description = $request->description;
        $model->save();
        $id = $model->id;

        foreach ($leave_type as $key => $value) {
            $data = new EmployeeLeaveAllocationDetail;
            $data['employee_leave_allocation_id'] = $id;
            $data['employee_leave_type_id'] = $key;
            $data['allotted'] = $value;
            $data->save();
        }
        // Activity Log
        activity()->log('Created a Employee Leave Allocation Employee - ' . $request->employee_id);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'goto' => route('admin.employee-leave-allocation.index')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model =  EmployeeLeaveAllocation::where('uuid', $id)->firstOrFail();
        return view('admin.employee.leave.allocation.edit', compact('model'));
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
        $leave_type = $request->leave_type;
        $model = EmployeeLeaveAllocation::findOrFail($id);
        $model->start_date = $request->start_date;
        $model->end_date = $request->end_date;
        $model->description = $request->description;
        $model->save();

        foreach ($leave_type as $key => $value) {
            $data = EmployeeLeaveAllocationDetail::findOrFail($key);
            $data['allotted'] = $value;
            $data->save();
        }
        // Activity Log
        activity()->log('Created a Employee Leave Allocation Employee - ' . $model->employee_id);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated'), 'goto' => route('admin.employee-leave-allocation.index')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = EmployeeLeaveAllocation::where('uuid', $id)->firstOrFail();
        $name = $type->employee_id;
        $type->delete();

        // Activity Log
        activity()->log('Created a Employee Leave Allocation Employee - ' . $name);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted Successfully'), 'goto' => route('admin.employee-leave-allocation.index')]);
    }
}
