<?php

namespace App\Http\Controllers\Admin\Configuration\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\models\employee\PayHead;
use App\models\employee\PayrollTemplateDetail;

class EmployeePayHeadController extends Controller
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

        return view('admin.employee.pay-head.index');
    }

    public function datatable(Request $request)
    {
        // dd("l;kajsdfkl;sadjflk;jas");
        if ($request->ajax()) {
            $document = PayHead::where('name', '!=', config('system.default_role.admin'))->get();
            return Datatables::of($document)
                ->addIndexColumn()
                ->editColumn('is_active',function($model){
                    return $model->is_active == 1? '<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">Inactive</span>';
                })
                ->editColumn('description', function($model) {
                    return str_limit($model->description, 30);
                })
                ->editColumn('type',function($model){
                    return $model->type == 'Earning' ? '<span class="badge badge-success">Earning</span>' : '<span class="badge badge-danger">Deduction</span>';
                })
                ->addColumn('action', function ($model) {
                    return view('admin.employee.pay-head.action', compact('model'));
                })->rawColumns(['action', 'type', 'is_active', 'description'])->make(true);
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

        return view('admin.employee.pay-head.create');
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
            'name' => 'required|min:3|unique:pay_heads|max:50',
            'alias' => 'required|min:1|max:10',
            'type' => 'required',
            'is_active' => 'required',
        ]);

        $model = new PayHead;

        $model->name = $request->name;

        $model->alias = strtoupper($request->alias);

        $model->type = $request->type;

        $model->description = $request->description;

        $model->is_active = $request->is_active;

        $model->save();

        // Activity Log
        activity()->log('Created a Employee Pay Head - ' . $request->name);

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
        $model = PayHead::where('id', $id)->firstOrFail();

        // return
        return view('admin.employee.pay-head.edit', compact('model'));
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
            'name' => "required|min:1|max:50|unique:pay_heads,name,{$id},id,deleted_at,NULL",
            'alias' => 'required',
            'type' => 'required',
            'is_active' => 'required',
        ]);

        $model =  PayHead::findOrFail($id);

        $model->name = $request->name;

        $model->alias = strtoupper($request->alias);

        $model->type = $request->type;

        $model->description = $request->description;

        $model->is_active = $request->is_active;

        $model->save();

        // Activity Log
        activity()->log('Update a Employee Pay Head - ' . $request->name);

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

        // Check the Payroll Contains in the Payroll Template
        $check = PayrollTemplateDetail::where('pay_head_id', $id)->first();
        if($check) {
            return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Sorry! You Can\'t Delete The Payhead. Payroll Template Contains this Payhead.')]);
        }

        $type = PayHead::findOrFail($id);

        $name = $type->name;

        $type->delete();

        // Activity Log
        activity()->log('Delete a Employee Pay Head - ' . $name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted Successfully')]);
    }
}