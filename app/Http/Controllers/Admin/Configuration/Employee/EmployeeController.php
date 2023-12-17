<?php

namespace App\Http\Controllers\Admin\Configuration\Employee;

use App\models\employee\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\models\employee\Department;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{

    public function Department_index()
    {
        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('admin.employee.department.index');
    }


    // Datatable Data
    public function Department_datatable(Request $request)
    {
        if ($request->ajax()) {
            $department = Department::where('name', '!=', config('system.default_role.admin'))->get();
            return Datatables::of($department)
                ->addIndexColumn()
                ->editColumn('description', function($model) {
                    return str_limit($model->description, 60);
                })
                ->addColumn('action', function ($model) {
                    return view('admin.employee.department.action', compact('model'));
                })->rawColumns(['action', 'description'])->make(true);
        }
    }

    public function Department_create()
    {
        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.employee.department.create');
    }


    public function Department_store(Request $request)
    {
        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }

        $validator = $request->validate([
            'name' => 'required|min:3|max:50|unique:departments,name,NULL,id,deleted_at,NULL',
            'description' => '',
        ]);

        $model = new Department;

        $model->name = $request->name;

        $model->description = $request->description;
        
        $model->save();

        // Activity Log
        activity()->log('Created a Employee Department - ' . $request->name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created')]);

    }

    public function Department_edit($id)
    {
        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }

        // find the data
        $model = Department::where('id', $id)->firstOrFail();

        // return
        return view('admin.employee.department.edit', compact('model'));
    }

    public function Department_update(Request $request, $id)
    {
        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }

        $model = Department::findOrFail($id);

        $request->validate([
            'name' => 'required|min:3|max:50|unique:departments,name,NULL,id,deleted_at,NULL'.$id,
        ]);

        $model->name = $request->name;
        $model->description = $request->description;
        $model->save();

        // Activity Log
        activity()->log('Update a Employee Department - ' . $request->name);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated')]);
    }

    public function Department_delete(Request $request, $id)
    {
        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }

        $type = Department::findOrFail($id);
        $name = $type->name;
        $type->delete();

        // Activity Log
        activity()->log('Delete a Employee Department - ' . $name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted Successfully')]);
    }
}