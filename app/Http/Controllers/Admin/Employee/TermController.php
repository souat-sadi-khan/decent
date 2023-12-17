<?php

namespace App\Http\Controllers\Admin\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\employee\EmployeeTerm;
use App\models\employee\Employeelist;
use App\models\employee\Employee;

class TermController extends Controller
{
   public function term_info(Request $request) {
        $id = $request->model_id;
        // dd($id);
        $models = EmployeeTerm::where('employee_id', $id)->orderBy('id', 'DESC')->get();
        return view('admin.employee.list.ajax.term_info', compact('models'));
    }
   



    public function show($id){
      $model = EmployeeTerm::findOrFail($id);
      return view('admin.employee.list.term-history.show', compact('model'));
    }

    public function edit($id){
        $model = EmployeeTerm::findOrFail($id);
      
        return view('admin.employee.list.term-history.edit', compact('model'));
    }

    public function update(Request $request , $id){
     

        if ($request->check) {
            $request -> validate([
                'date_of_leaving' => 'required',
                'leaving_remarks' => 'required',
            ]);
        }

        // uploading file to folder
        $fileName="";
        if($request->hasFile('document')) {
            $storagepath = $request->file('document')->store('public/document');
            $fileName = basename($storagepath);
        }

        $term_model = EmployeeTerm::findOrFail($id);
       $term_model->date_of_leaving = $request->date_of_leaving;
       $term_model->leaving_remarks = $request->leaving_remarks;
       $term_model->document  = $fileName;
       $term_model -> save();
       

        // Activity Log
        activity() -> log('Term Updated');
        return response() -> json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'load' => true]);
        
    }


}
