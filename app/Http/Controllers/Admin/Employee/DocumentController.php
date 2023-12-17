<?php

namespace App\Http\Controllers\Admin\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\employee\EmployeeDocument;
use App\models\employee\EmployeeDocumentType;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{

    // document_info
    public function document_info(Request $request) {
        $id = $request->model_id;

        $models = EmployeeDocument::where('employee_id', $id)->with('document_type')->get();
        return view('admin.employee.list.ajax.document_info', compact('models', 'id'));

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // find the employee ID
        $employee_id = request()->id;

        $employee_document_types = EmployeeDocumentType::all();
        $model = new EmployeeDocument;

        return view('admin.employee.list.document-history.create', compact('employee_id', 'employee_document_types', 'model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // fetching all data from form and validate

        request()->validate([
            'employee_document_type_id'         =>      'required',
            'title'                             =>      'required|max:70',
            'employee_id'                       =>      'required',
            'file'                              =>      'required',
        ]);

        $employee_id = $request->employee_id;

        $model = new EmployeeDocument;
        $model->employee_id = $employee_id;
        $model->title = $request->title;
        $model->description = $request->description;
        $model->employee_document_type_id = $request->employee_document_type_id;

        // Upload the file
        $fileName="";
        if($request->hasFile('file')) {
            $storagepath = $request->file('file')->store('public/document');
            $fileName = basename($storagepath);
        }

        $model->upload_token = $fileName;
        $model->save();

        // make activity log & return
         activity()->log('Created a Employee Document ' );
         return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'load' => true]);
 

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // find the model & return to the show page
        $model = EmployeeDocument::findOrFail($id);
        return view('admin.employee.list.document-history.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // find the model & return to the edit page
        $model = EmployeeDocument::findOrFail($id);
        $employee_id = $model->employee_id;
        $employee_document_types = EmployeeDocumentType::all();
        return view('admin.employee.list.document-history.edit', compact('model', 'employee_document_types', 'employee_id'));
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
        request()->validate([
            'employee_document_type_id'         =>      'required',
            'title'                             =>      'required|max:70',
            'employee_id'                       =>      'required',
        ]);

        $employee_id = $request->employee_id;

        $model = EmployeeDocument::findOrFail($id);
        $model->employee_id = $employee_id;
        $model->title = $request->title;
        $model->description = $request->description;
        $model->employee_document_type_id = $request->employee_document_type_id;

        // Upload the file if have & delete the old file
        $fileName="";
        if($request->hasFile('upload_token')) {
            $storagepath = $request->file('upload_token')->store('public/document');
            $fileName = basename($storagepath);
        }

        if( $model->upload_token != ''){
            $file_path = "public/document/".$model->upload_token ;
            Storage::delete($file_path);
        }

        $model->upload_token = $fileName;
        $model->save();

        // make activity log & return
         activity()->log('Updated a Employee Document ' );
         return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated'), 'load' => true]);
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // find the model & delete
        $model = EmployeeDocument::findOrFail($id);
        if( $model->upload_token != ''){
            $file_path = "public/document/".$model->upload_token ;
            Storage::delete($file_path);
        }

        $model->delete();

        // make activity log & return
        activity()->log('Deleted a Employee Document ' );
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted'), 'load' => true]);
    }
}