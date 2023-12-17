<?php

namespace App\Http\Controllers\Admin\Configuration\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\employee\EmployeeDocument;
use Yajra\Datatables\Datatables;
use App\models\employee\EmployeeDocumentType;

class EmployeeDocumentTypeController extends Controller
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

        return view('admin.employee.document-type.index');
    }

    public function datatable(Request $request)
    {
        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->ajax()) {
            $document = EmployeeDocumentType::where('name', '!=', config('system.default_role.admin'))->get();
            return Datatables::of($document)
                ->addIndexColumn()
                ->editColumn('description', function($model) {
                    return str_limit($model->description, 60);
                })
                ->addColumn('action', function ($model) {
                    return view('admin.employee.document-type.action', compact('model'));
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

        return view('admin.employee.document-type.create');
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
            'name' => 'required|min:3|max:50|unique:employee_document_types,name,NULL,id,deleted_at,NULL',
            'description' => '',
        ]);

        $model = new EmployeeDocumentType;
        $model->name = $request->name;
        $model->description = $request->description;
        $model->save();

        // Activity Log
        activity()->log('Created a Employee Document Type - ' . $request->name);
        
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
        $model = EmployeeDocumentType::where('id', $id)->firstOrFail();
        // return
        return view('admin.employee.document-type.edit', compact('model'));
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
            'name' => 'required|min:3|max:50|unique:employee_document_types,name,NULL,id,deleted_at,NULL'.$id,
            'description' => '',
        ]);

        $model = EmployeeDocumentType::findOrFail($id);
        $model->name = $request->name;
        $model->description = $request->description;
        $model->save();

        // Activity Log
        activity()->log('Update a Employee Document Type - ' . $request->name);
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

        // Check This Gesignation Contains Any Employee
        $check = EmployeeDocument::where('employee_document_type_id', $id)->first();
        if($check) {
            return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('You can not delete This Document. Employee Contains This Document')]);
        }

        $type = EmployeeDocumentType::findOrFail($id);
        $name = $type->name;
        $type->delete();

        // Activity Log
        activity()->log('Delete a Employee Document Type - ' . $name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted Successfully')]);
    }
}
