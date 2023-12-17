<?php

namespace App\Http\Controllers\Admin\Configuration\Employee;

use App\models\employee\Designation;
use App\models\employee\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\models\employee\EmployeeCategory;
use App\models\employee\EmployeeDesignation;
use App\models\employee\EmployeeTerm;
use Illuminate\Validation\Rule;

class DesignationController extends Controller
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

        $categories = EmployeeCategory::all();
        
        $designations = Designation::all();

        return view('admin.employee.designation.index',compact('categories','designations'));
    }

    
    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $document = Designation::where('name', '!=', config('system.default_role.admin'))->get();
            return Datatables::of($document)
            ->addIndexColumn()
            ->editColumn('employee_category_id', function ($model) {
                return $model->category?$model->category->name:'';
            })
            ->editColumn('top_designation_id', function ($model) {
                return $model->designation?$model->designation->name:'';
            })
            ->editColumn('description', function($model) {
                return str_limit($model->description, 60);
            })
            ->addColumn('action', function ($model) {
                return view('admin.employee.designation.action', compact('model'));
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


        $categories = EmployeeCategory::all();

        $designations = Designation::all();

        return view('admin.employee.designation.create',compact('categories','designations'));
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
            'name' => 'required|min:3|max:70|unique:designations,name,NULL,id,deleted_at,NULL',
            'employee_category_id' => 'required',
        ]);

        $model = new Designation;

        $model->employee_category_id = $request->employee_category_id;

        $model->name = $request->name;

        $model->top_designation_id = $request->top_designation_id;

        $model->description = $request->description;

        $model->save();

        // Activity Log
        activity()->log('Created a Employee Designation - ' . $request->name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\employee\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function show(Designation $designation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\employee\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }

        // find the data
        $model = Designation::where('id', $id)->firstOrFail();
        $categories = EmployeeCategory::all();
        $designations = Designation::whereNotIn('id', [$id])->get();
        // return
        return view('admin.employee.designation.edit', compact('model','categories','designations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\employee\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }

        $model =  Designation::findOrFail($id);


        $request->validate([
            'name' => ['required', 'string', 'max:70',
            Rule::unique('designations', 'name')->ignore($model->id)],           
            'employee_category_id' => 'required',
        ]);

        $model->employee_category_id = $request->employee_category_id;

        $model->name = $request->name;

        $model->top_designation_id = $request->top_designation_id;

        $model->description = $request->description;

        $model->save();

        // Activity Log
        activity()->log('Update a Employee Designation - ' . $request->name);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\employee\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }

        // Check This Gesignation Contains Any Employee
        $check = EmployeeDesignation::where('designation_id', $id)->first();
        if($check) {
            return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('You can not delete This Designation. Employee Contains This Designation')]);
        }

        $type = Designation::findOrFail($id);

        $name = $type->name;
        
        $type->delete();

        // Activity Log
        activity()->log('Delete a Employee Designation - ' . $name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted Successfully')]);
    }

    // term_info
    public function term_info(Request $request) {

        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }
        
        $id = $request->model_id;
        $models = EmployeeTerm::where('employee_id', $id)->get();
		return view('admin.employee.list.ajax.term_info', compact('models'));
    }
}
