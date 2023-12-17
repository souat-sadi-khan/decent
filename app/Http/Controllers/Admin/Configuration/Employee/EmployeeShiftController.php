<?php

namespace App\Http\Controllers\Admin\Configuration\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employee\EmployeeShift;
use Yajra\Datatables\Datatables;

class EmployeeShiftController extends Controller
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
        
        return view('admin.employee.shift.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $document = EmployeeShift::where('name', '!=', config('system.default_role.admin'))->get();

            return Datatables::of($document)
                ->addIndexColumn()
                ->editColumn('status', function ($document) {
                    return $document->status == 1 ? '<span class="badge badge-primary">Active</span>' : '<span class="badge badge-warning">Inactive</span>';
                })
                ->editColumn('note', function($model) {
                    return str_limit($model->note, 40);
                })
                ->addColumn('action', function ($model) {
                    return view('admin.employee.shift.action', compact('model'));
            })->rawColumns(['action', 'status', 'note'])->make(true);
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

        return view('admin.employee.shift.create');
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
            'name'          =>      'required|min:3|max:50|unique:employee_shifts,name,NULL,id,deleted_at,NULL',
            'status'        =>      'required|max:255',
            'start_time'    =>      'required',
            'end_time'      =>      'required',
        ]);

        $model = new EmployeeShift;
        $model->name = $request->name;
        $model->status = $request->status;
        $model->start_time = $request->start_time;
        $model->end_time = $request->end_time;
        $model->note = $request->note;
        $model->save();

        // Activity Log
        activity()->log('Created a Employee Shift - ' . $request->name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created')]);
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

        $model = EmployeeShift::findOrFail($id);
        return view('admin.employee.shift.edit', compact('model'));
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

        $request->validate([
            'name'          =>      'required|min:3|max:50|unique:employee_shifts,name,{$id},id,deleted_at,NULL',
            'status'        =>      'required',
            'start_time'    =>      'required',
            'end_time'      =>      'required',
        ]);

        $model = EmployeeShift::findOrFail($id);
        $model->name = $request->name;
        $model->status = $request->status;
        $model->start_time = $request->start_time;
        $model->end_time = $request->end_time;
        $model->note = $request->note;
        $model->save();

        // Activity Log
        activity()->log('Edited a Employee Shift - ' . $request->name);

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

        $model = EmployeeShift::findOrFail($id);
        $model->delete();

        // Activity Log
        activity()->log('Deleted a Employee Shift - ' . $model->name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted')]);
    }
}
