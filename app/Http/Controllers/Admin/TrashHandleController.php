<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\employee\Department;
use Yajra\Datatables\Datatables;
use App\models\employee\EmployeeCategory;
use App\models\employee\EmployeeDocumentType;
use App\models\employee\EmployeeLeaveType;

class TrashHandleController extends Controller
{
    // EmployeeCatagoryIndex
    public function EmployeeCatagoryIndex() {
        return view('admin.employee.category.delete');
    }

    // EmployeeCatagoryDatable
    public function EmployeeCatagoryDatable(Request $request)
    {
        if ($request->ajax()) {
            $document = EmployeeCategory::onlyTrashed()->get();
            return Datatables::of($document)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    return view('admin.employee.category.trash-action', compact('model'));
                })->rawColumns(['action'])->make(true);
        }
    }

    public function EmployeeCatagoryRestore(Request $request) {
        $id = $request->id;

        $model = EmployeeCategory::where('id', $id)->onlyTrashed()->first();
        $name = $model->name;
        $model->restore();

        // Create Log Report
        activity()->log('Restored a Employee Category - ' . $model->name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Employee Catagory Restored'), 'load' => true]);
    }

    // EmployeeCatagoryForceDelete
    public function EmployeeCatagoryForceDelete(Request $request) {
        $id = $request->id;
        $model = EmployeeCategory::where('id', $id)->onlyTrashed()->first();
        $name = $model->name;
        $model->forceDelete();

        // Create Log Report
        activity()->log('Deleted a Employee Category - ' . $model->name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Employee Catagory Permanently Deleted'), 'load' => true]);
    }

    // Employee_Department_Index
    public function Employee_Department_Index() {
        return view('admin.employee.department.delete');
    }

    // Employee_Department_Datable
    public function Employee_Department_Datable(Request $request) {
        if ($request->ajax()) {
            $document = Department::onlyTrashed()->get();
            return Datatables::of($document)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    return view('admin.employee.department.trash-action', compact('model'));
                })->rawColumns(['action'])->make(true);
        }
    }

    // Employee_Department_Restore
    public function Employee_Department_Restore(Request $request) {
        $id = $request->id;

        $model = Department::where('id', $id)->onlyTrashed()->first();
        $name = $model->name;
        $model->restore();

        // Create Log Report
        activity()->log('Restored a Employee Department - ' . $model->name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Employee Department Restored'), 'load' => true]);
    }

    // Employee_Department_ForceDelete
    public function Employee_Department_ForceDelete(Request $request) {
        $id = $request->id;
        $model = Department::where('id', $id)->onlyTrashed()->first();
        $name = $model->name;
        $model->forceDelete();

        // Create Log Report
        activity()->log('Deleted a Employee Department - ' . $model->name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Employee Department Permanently Deleted'), 'load' => true]);
    }

    // Employee_Document_Type_index
    public function Employee_Document_Type_index() {
        return view('admin.employee.document-type.delete');
    }

    // Employee_Document_Type_Datable
    public function Employee_Document_Type_Datable(Request $request) {
        if ($request->ajax()) {
            $document = EmployeeDocumentType::onlyTrashed()->get();
            return Datatables::of($document)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    return view('admin.employee.document-type.trash-action', compact('model'));
                })->rawColumns(['action'])->make(true);
        }
    }

    // Employee_Document_type_Restore
    public function Employee_Document_type_Restore(Request $request) {
        $id = $request->id;

        $model = EmployeeDocumentType::where('id', $id)->onlyTrashed()->first();
        $name = $model->name;
        $model->restore();

        // Create Log Report
        activity()->log('Restored a Employee Document Type - ' . $model->name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Employee Document Type Restored'), 'load' => true]);
    }

    // Employee_Document_Type_ForceDelete
    public function Employee_Document_Type_ForceDelete(Request $request) {
        $id = $request->id;
        $model = EmployeeDocumentType::where('id', $id)->onlyTrashed()->first();
        $name = $model->name;
        $model->forceDelete();

        // Create Log Report
        activity()->log('Deleted a Employee Document Type - ' . $model->name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Employee Document Type Permanently Deleted'), 'load' => true]);
    }

    // Employee_Leave_Type_index
    public function Employee_Leave_Type_index() {
        return view('admin.employee.leave-type.delete');
    }

    // Employee_Leave_Type_Datable
    public function Employee_Leave_Type_Datable(Request $request) {
        if ($request->ajax()) {
            $document = EmployeeLeaveType::onlyTrashed()->get();
            return Datatables::of($document)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    return view('admin.employee.leave-type.trash-action', compact('model'));
                })->rawColumns(['action'])->make(true);
        }
    }

    // Employee_Leave_type_Restore
    public function Employee_Leave_type_Restore(Request $request) {
        $id = $request->id;

        $model = EmployeeLeaveType::where('id', $id)->onlyTrashed()->first();
        $name = $model->name;
        $model->restore();

        // Create Log Report
        activity()->log('Restored a Employee Leave Type - ' . $model->name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Employee Leave Type Restored'), 'load' => true]);
    }

    // Employee_Leave_Type_ForceDelete
    public function Employee_Leave_Type_ForceDelete(Request $request) {
        $id = $request->id;
        $model = EmployeeLeaveType::where('id', $id)->onlyTrashed()->first();
        $name = $model->name;
        $model->forceDelete();

        // Create Log Report
        activity()->log('Deleted a Employee Leaave Type - ' . $model->name);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Employee Leave Type Permanently Deleted'), 'load' => true]);
    }

    // Employee_Pay_Head_index
    public function Employee_Pay_Head_index() {
        return view('admin.employee.document-type.delete');
    }
}
