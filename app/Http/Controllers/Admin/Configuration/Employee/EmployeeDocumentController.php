<?php

namespace App\Http\Controllers\Admin\Configuration\Employee;

use App\models\employee\EmployeeDocument;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class EmployeeDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.employee.document.index');
    }

    // Datatable Data
    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $document = EmployeeDocument::where('name', '!=', config('system.default_role.admin'))->get();
            return Datatables::of($document)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    return view('admin.employee.document.action', compact('model'));
                })->rawColumns(['action'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\employee\EmployeeDocument  $employeeDocument
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeDocument $employeeDocument)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\employee\EmployeeDocument  $employeeDocument
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeDocument $employeeDocument)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\employee\EmployeeDocument  $employeeDocument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeDocument $employeeDocument)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\employee\EmployeeDocument  $employeeDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeDocument $employeeDocument)
    {
        //
    }
}
