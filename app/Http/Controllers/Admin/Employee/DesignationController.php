<?php

namespace App\Http\Controllers\Admin\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\employee\EmployeeTerm;
use App\models\employee\Designation;
use App\models\employee\Department;
use App\models\employee\EmployeeDesignation;
use App\models\employee\Employee;
use Carbon\Carbon;
use Storage;
class DesignationController extends Controller
{
    
    // term_info
    public function term_info(Request $request) {
        $id = $request->model_id;
        $models = EmployeeTerm::where('employee_id', $id)->orderBy('id', 'DESC')->get();
        return view('admin.employee.list.ajax.term_info', compact('models'));
    }
       // desig_info
     public function desig_info(Request $request) {
        $id = $request->model_id;
        $models = EmployeeDesignation::where('employee_id', $id)->with('terms')->orderBy('id', 'DESC')->get();
        // dd($models);
        return view('admin.employee.list.ajax.desig_info', compact('models','id'));
    }

    // designation add form
    public function add_desig($id) {
        // dd("sohag");
        $designations = Designation::all();
        $departments = Department::all();
        $model = new EmployeeDesignation;

        return view('admin.employee.list.designation-history.create',compact('model','designations','departments','id'));
    }

    public function store(Request $request)
    {
         $request->validate([
            'designation' => 'required|max:255',
            'department' => 'required',
            'data_effective' => 'required',
            
        ]);
        // uploading file to folder
        $fileName="";
        if($request->hasFile('document')) {
                $storagepath = $request->file('document')->store('public/document');
                $fileName = basename($storagepath);
            }
        //    getting employee information for redirecting after submission. redirection will be made by uuid.
       $employee_id = $request->employee_id;
       $emp_info = Employee::where('id', $employee_id)->first();
  
        //    now updating last term putting here the leaving date
       $last_term = EmployeeTerm::where('employee_id',$employee_id)->latest()->first();
       $term_id = $last_term->id;

       $last_desi = EmployeeDesignation::where('employee_id',$employee_id)->latest()->first();
       $last_desi->date_end = Carbon::create($request->data_effective)->subDays(1)->format('Y-m-d');
       $last_desi->save();

        // this time we are inserting employee designation
       $emp_designation_model = new EmployeeDesignation;
       $emp_designation_model->employee_id = $employee_id;
       $emp_designation_model->designation_id = $request->designation;
       $emp_designation_model->department_id = $request->department;
       $emp_designation_model->employee_term_id  = $term_id;
       $emp_designation_model->date_effective  = $request->data_effective;
       $emp_designation_model->remarks  = $request->remarks;
       $emp_designation_model->document  = $fileName;
       $emp_designation_model -> save();

         // Activity Log
        activity()->log('Created a Employee Designation ' );
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'load' => true]);
    }

    public function show($id){
      $model = EmployeeDesignation::findOrFail($id);
      return view('admin.employee.list.designation-history.show', compact('model'));
    }

    public function edit($id){

        $model = EmployeeDesignation::findOrFail($id);
        $designations = Designation::all();
        $departments = Department::all();
        $id="";
        return view('admin.employee.list.designation-history.edit', compact('model','designations','departments','id'));
    }

    public function update(Request $request , $id){
          $request -> validate([
        'designation' => 'required|max:255',
        'department' => 'required',
        'data_effective' => 'required',

        ]);
        
        $emp_designation_model = EmployeeDesignation::findOrFail($id);
        $employee_id = $emp_designation_model -> employee_id;
        $emp_info = Employee::where('id', $employee_id) -> first();

        // if a file is selected then that file is going to uploaded and previous file will be deleted
        $fileName="";
        if($request->hasFile('document')) {
            $storagepath = $request->file('document')->store('public/document');
            $fileName = basename($storagepath);

              if ($emp_designation_model->document) {
                $file_path = "public/document/".$emp_designation_model->document;
                Storage::delete($file_path);
            }
        }

        $emp_designation_model = EmployeeDesignation::findOrFail($id);
        $employee_id = $emp_designation_model -> employee_id;
        $emp_info = Employee::where('id', $employee_id) -> first();

         $last_desi = EmployeeDesignation::where('employee_id',$employee_id)->where('date_end', '!=', Null)->latest()->first();
       $last_desi->date_end = Carbon::create($request->data_effective)->subDays(1)->format('Y-m-d');
       $last_desi->save();

        
        // now updating last term putting here the joining date
       
        $emp_designation_model -> designation_id = $request -> designation;
        $emp_designation_model -> department_id = $request -> department;
        $emp_designation_model -> date_effective = $request -> data_effective;
        $emp_designation_model -> remarks = $request -> remarks;
        $emp_designation_model->document  = $fileName;
        $emp_designation_model -> save();

        // Activity Log
        activity() -> log('Created a Employee Designation ');
        return response() -> json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'load' => true]);
        
    }

    // now its time to destroy data 
    public function destroy($id){
        $model = EmployeeDesignation::findOrFail($id);
        if ($model->document) {
            $file_path = "public/document/".$model->document;
            Storage::delete($file_path);
        }
        $model->delete();
        // Activity Log
        activity() -> log('Deleted a Employee Designation ');
        return response() -> json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'load' => true]);
    }

    
}
