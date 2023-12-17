<?php

namespace App\Http\Controllers\Admin\Configuration\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\models\employee\EmployeeAttendanceType;

class EmployeeAttendanceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.employee.attendance-type.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $document = EmployeeAttendanceType::where('name', '!=', config('system.default_role.admin'))->get();
            return Datatables::of($document)
                ->addIndexColumn()
                ->editColumn('is_active', function($model){
                    return $model->is_active == 1?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">Inactive</span>';
                })
                ->addColumn('action', function ($model) {
                    return view('admin.employee.attendance-type.action', compact('model'));
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
        return view('admin.employee.attendance-type.create');
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
            'name' => 'required|unique:employee_attendance_types|max:255',
        ]);

        $model = new EmployeeAttendanceType;

        $model->name = $request->name;

        $model->alias = $request->alias;

        $model->type = $request->type;

        $model->is_active = $request->is_active?1 : 0;

        $model->description = $request->description;

        $model->save();

        // Activity Log
        activity()->log('Created a Employee Attendance Type - ' . $request->name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created')]);
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
        // find the data
        $model = EmployeeAttendanceType::where('id', $id)->firstOrFail();

        // return
        return view('admin.employee.attendance-type.edit', compact('model'));
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
        $model = EmployeeAttendanceType::findOrFail($id);

        $model->name = $request->name;

        $model->alias = $request->alias;

        $model->type = $request->type;

        $model->is_active = $request->is_active ? 1 : 0;

        $model->description = $request->description;

        $model->save();

        // Activity Log
        activity()->log('Update a Employee Attendance Type - ' . $request->name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = EmployeeAttendanceType::findOrFail($id);
        $name = $type->name;
        $type->delete();

        // Activity Log
        activity()->log('Delete a Employee Attendance Type - ' . $name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted Successfully')]);
    }
}
