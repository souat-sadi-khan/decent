<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\models\employee\IdCardTemplate;
use App\models\employee\Department;
use App\models\employee\Employee;
use App\models\employee\EmployeeDesignation;

class IdCardController extends Controller
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

        return view('admin.id-card.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $document = IdCardTemplate::where('name', '!=', config('system.default_role.admin'))->get();
            return Datatables::of($document)
                ->addIndexColumn()
                ->editColumn('width', function($model) {
                    return $model->width . 'mm';
                })
                ->editColumn('height', function($model) {
                    return $model->height . 'mm';
                })
                ->addColumn('action', function ($model) {
                    return view('admin.id-card.action', compact('model'));
            })->rawColumns(['action', 'width', 'height'])->make(true);
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

        return view('admin.id-card.create');
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
            'name' => 'required|string|min:3|max:50',
            'width' => 'required|numeric|digits_between:1,2',
            'height' => 'required|numeric|digits_between:1,2',
            'show_per_page' => 'required|numeric|digits_between:1,2',
        ]);

        $model = new IdCardTemplate;
        $model->name = $request->name;
        $model->type = 'Employee';
        $model->width = $request->width;
        $model->height = $request->height;
        $model->show_per_page = $request->show_per_page;
        $model->save();

        // Activity Log
        activity()->log('Created a Employee Id Card Template - ' . $request->name);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }

        $department = EmployeeDesignation::where('department_id', $request->department)->get();
        $employee_id = [];
        foreach ($department as  $value) {
           $employee_id[] = $value->employee_id;
        }
        $employee = Employee::whereIn('id', $employee_id)->get();
        if (count($employee)) {
            return view('admin.id-card.show', compact('employee'));
        }else{
            return back()->withErrors(['field_name' => ['Employee Not Found']]);
        }
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

        $model = IdCardTemplate::findOrFail($id);
        return view('admin.id-card.edit', compact('model'));
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
            'name' => 'required|string|min:3|max:50',
            'width' => 'required|numeric|digits_between:1,2',
            'height' => 'required|numeric|digits_between:1,2',
            'show_per_page' => 'required|numeric|digits_between:1,2',
        ]);

        $model = IdCardTemplate::findOrFail($id);
        $model->name = $request->name;
        $model->width = $request->width;
        $model->height = $request->height;
        $model->show_per_page = $request->show_per_page;
        $model->save();

        // Activity Log
        activity()->log('Created a Employee Id Card Template - ' . $request->name);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created')]);
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

        $type = IdCardTemplate::findOrFail($id);
        $name = $type->name;
        $type->delete();

        // Activity Log
        activity()->log('Created a Employee Id Card Template - ' . $name);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted Successfully')]);
    }

    public function id_card()
    {
        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }

        $department = Department::all();
        $card = IdCardTemplate::all();
        return view('admin.id-card.id-card', compact('department','card'));
    }
}
