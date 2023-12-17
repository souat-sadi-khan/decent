<?php

namespace App\Http\Controllers\Admin\Configuration\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\models\employee\EmployeeCategory;

class EmployeeCategoryController extends Controller
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

        return view('admin.employee.category.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $document = EmployeeCategory::where('name', '!=', config('system.default_role.admin'))->get();

            return Datatables::of($document)
                ->addIndexColumn()
                ->editColumn('description', function($model) {
                    return str_limit($model->description, 60);
                })
                ->addColumn('action', function ($model) {
                    return view('admin.employee.category.action', compact('model'));
            })->rawColumns(['action', 'description'])->make(true);
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

        return view('admin.employee.category.create');
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

        $validator = $request->validate([
            'name' => 'required|min:1|max:50|unique:employee_categories,name,NULL,id,deleted_at,NULL',
            'description' => '',
        ]);

        $model = new EmployeeCategory;

        $model->name = $request->name;

        $model->description = $request->description;

        $model->save();

        // Activity Log
        activity()->log('Created a Employee Category - ' . $request->name);

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

        // find the data
        $model = EmployeeCategory::where('id', $id)->firstOrFail();

        // return
        return view('admin.employee.category.edit', compact('model'));
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
            'name' => 'required|min:3|max:255|unique:employee_categories,name,NULL,id,deleted_at,NULL'.$id,
        ]);

        $model = EmployeeCategory::findOrFail($id);

        $model->name = $request->name;

        $model->description = $request->description;

        $model->save();

        // Activity Log
        activity()->log('Update a Employee Category - ' . $request->name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){

        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }

        $type = EmployeeCategory::findOrFail($id);

        $name = $type->name;
        
        $type->delete();

        // Activity Log
        activity()->log('Delete a Employee Category - ' . $name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted Successfully')]);
    }
}
