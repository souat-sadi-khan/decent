<?php

namespace App\Http\Controllers\Admin\Configuration\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\models\employee\EmployeeLeaveType;
use Illuminate\Validation\Rule;

class EmployeeLeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.employee.leave-type.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $document = EmployeeLeaveType::where('name', '!=', config('system.default_role.admin'))->get();
            return Datatables::of($document)
                ->addIndexColumn()
                ->editColumn('is_active',function($model){
                    return $model->is_active == 1? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                })
                ->editColumn('description', function($model) {
                    return str_limit($model->description, 50);
                })
                ->addColumn('action', function ($model) {
                    return view('admin.employee.leave-type.action', compact('model'));
                })->rawColumns(['action', 'is_active', 'description'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.employee.leave-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|min:3|unique:employee_document_types|max:50',
            'alias' => 'required|min:1|max:50',
            'description' => '',
            'is_active' => '',
        ]);

        $model = new EmployeeLeaveType;

        $model->name = $request->name;

        $model->alias = strtoupper($request->alias);

        $model->is_active = $request->is_active;

        $model->description = $request->description;

        $model->save();

        // Activity Log
        activity()->log('Created a Employee Leave Type - ' . $request->name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view()
    {
        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.employee.leave.view');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }

        // find the data
        $model = EmployeeLeaveType::where('id', $id)->firstOrFail();

        // return
        return view('admin.employee.leave-type.edit', compact('model'));
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
        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }

        $model = EmployeeLeaveType::findOrFail($id);

        $request->validate([
            'name' => "required|unique:employee_leave_types,name,{$id},id,deleted_at,NULL",
            'alias' => 'required|min:1|max:50',
        ]);

        $model->name = $request->name;
        $model->alias = strtoupper($request->alias);
        $model->is_active = $request->is_active;
        $model->description = $request->description;
        $model->save();

        // Activity Log
        activity()->log('Update a Employee Leave Type - ' . $request->name);

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
        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }

        $type = EmployeeLeaveType::findOrFail($id);
        $name = $type->name;
        $type->delete();

        // Activity Log
        activity()->log('Delete a Employee Leave Type - ' . $name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted Successfully')]);
    }
}
