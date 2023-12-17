<?php

namespace App\Http\Controllers\Admin\Configuration\Employee;

use App\models\employee\Employee;
use App\models\employee\IdGenerator;
use App\models\employee\Designation;
use App\models\employee\Department;
use App\models\employee\EmployeeTerm;
use App\models\employee\EmployeeDesignation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employee\EmployeeShift;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;

class EmployeeListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd("sohag");
        return view('admin.employee.list.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $documents = Employee::query();
            return Datatables::of($documents)
            ->addIndexColumn()
            ->editColumn('code', function ($document) {
                return $document->prefix.numer_padding($document->code, get_option('digits_employee_code'));
            })
            ->addColumn('status', function ($document) {
                $id = $document->id;
                $term = EmployeeTerm::where('employee_id',$id)->latest()->first();
                return ($term AND $term->date_of_leaving)?'<span class="badge badge-danger">Inactive</span>':'<span class="badge badge-primary">Active</span>';
            })
            ->editColumn('designation', function ($document) {
                return current_designation($document->id) ? current_designation($document->id) : "";
            })
            ->editColumn('shift', function ($document) {
                return current_shift($document->shift_id);
            })
            ->editColumn('department', function ($document) {
                // dd();                                                                        
                return current_dept($document->id)?current_dept($document->id):"";
            })
            ->addColumn('joining_date', function ($document) {
                $id = $document->id;
                $term = EmployeeTerm::where('employee_id',$id)->latest()->first();
                return ($term AND $term->date_of_joining)?$term->date_of_joining:"";
            })
            ->addColumn('action', function ($model) {
                return view('admin.employee.list.action', compact('model'));
            })->rawColumns(['action','status', 'shift'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // get designation or employees
        $designations = Designation::all();
        $departments = Department::all();
        $code_prefix = get_option('employee_code_prefix');
        $code_digits = get_option('digits_employee_code');
        $uniqu_id = generate_id('employee',false);
        $uniqu_id = numer_padding($uniqu_id,$code_digits);
        $shifts = EmployeeShift::where('status', 1)->get();

       // retrurn the employee create page
        return view('admin.employee.list.create',compact("designations","departments","code_prefix","uniqu_id", 'shifts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'prefix' => 'required|min:1|max:5',
            'code' => 'required|min:1|max:10',
            'name' => 'required|min:1|max:70',
            'designation' => 'required',
            'department' => 'required',
            'father_name' => 'max:70',
            'mother_name' => 'max:70',
            'contact_number' => 'required|numeric|digits_between:1,13',
        ]);

        $uuid =  Str::uuid()->toString();

        $emp_model = new Employee;
        $emp_model->uuid = $uuid;
        $emp_model->code = $request->code;
        $emp_model->prefix = $request->prefix;
        $emp_model->name = $request->name;
        $emp_model->date_of_birth = $request->date_of_birth;
        $emp_model->gender = $request->gender;
        $emp_model->contact_number = $request->contact_number;
        $emp_model->father_name = $request->father_name;
        $emp_model->mother_name = $request->mother_name;
        $emp_model->shift_id = $request->shift;

        $emp_model->save();

        $emp_tbl_id = $emp_model->id ;

        generate_id("employee", true);

        $term_model = new EmployeeTerm;
        $term_model->employee_id = $emp_tbl_id;
        $term_model->date_of_joining = $request->joining_date;
        $term_model->save();
        $term_id = $term_model->id;

        $emp_designation_model = new EmployeeDesignation;
        $emp_designation_model->employee_id = $emp_tbl_id;
        $emp_designation_model->designation_id = $request->designation;
        $emp_designation_model->department_id = $request->department;
        $emp_designation_model->employee_term_id  = $term_id;
        $emp_designation_model->date_effective  = $request->joining_date;
        $emp_designation_model -> save();

        activity()->log('Created an Employee - ' . $request->name);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\employee\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\models\employee\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // find the model 
        $model =  Employee::where('uuid', $id)->firstOrFail();

        $designations = Designation::all();
        $departments = Department::all();
        $code_prefix = get_option('employee_code_prefix');
        $code_digits = get_option('digits_employee_code');
        $uniqu_id = generate_id('employee',false);
        $uniqu_id = numer_padding($uniqu_id,$code_digits);

       // retrurn the employee create page
        return view('admin.employee.list.edit',compact("designations","departments","code_prefix","uniqu_id", 'model'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\employee\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\employee\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }

    // basic_info
    public function basic_info(Request $request) {
        $model_id = $request->model_id;
        $model = Employee::findOrFail($model_id);
        return view('admin.employee.list.ajax.basic_info', compact('model'));
    }

    // contact_info
    public function contact_info(Request $request) {
        $model_id = $request->model_id;
        $model = Employee::findOrFail($model_id);
        return view('admin.employee.list.ajax.contact_info', compact('model'));
    }

    // update_basic_info
    public function update_basic_info(Request $request) {

        // find the ID for updating the data
        $id = $request->id;


        // validate the data 
        $request->validate([
            'prefix' => 'required|min:1|max:5',
            'code' => 'required|min:1|max:10',
            'name' => 'required|min:1|max:70',
            'shift' => 'required',
            'father_name' => 'max:70',
            'mother_name' => 'max:70',
        ]);

        $prefix = $request->prefix;
        $code = $request->code;
        $name = $request->name;
        $date_of_birth = $request->date_of_birth;
        $date_of_anniversary = $request->date_of_anniversary;
        $gender = $request->gender;
        $marital_status = $request->marital_status;
        $nationality = $request->nationality;
        $mother_tongue = $request->mother_tongue;
        $father_name = $request->father_name;
        $mother_name = $request->mother_name;

        // find the model & update the data
        $model = Employee::findOrFail($id);
        $model->prefix = $prefix;
        $model->code = $code;
        $model->name = $name;
        $model->date_of_birth = $date_of_birth;
        $model->date_of_anniversary = $date_of_anniversary;
        $model->gender = $gender;
        $model->marital_status = $marital_status;
        $model->nationality = $nationality;
        $model->mother_tongue = $mother_tongue;
        $model->father_name = $father_name;
        $model->mother_name = $mother_name;
        $model->shift_id = $request->shift;
        $model->save();

        activity()->log('Updated an Employee Basic Information - ' . $request->name);
       return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated Successfully')]);
    }

    // update_contact_info
    public function update_contact_info(Request $request) {
        // find the ID for updating the data
        $id = $request->id;

        // validate the data 
        $request->validate([
            'email'                     =>      'required|email|max:50',
            'emergency_contact_name'    =>      'required|max:50',
            'present_address_line_1'    =>      'required|max:50',
            'contact_number' => 'required|numeric|digits_between:1,11',
        ]);

        // find the model & update the data
        $model = Employee::findOrFail($id);
        $model->contact_number              =   $request->contact_number;
        $model->alternate_contact_number    =   $request->alternate_contact_number;
        $model->email                       =   $request->email;
        $model->alternate_email             =   $request->alternate_email;
        $model->emergency_contact_name      =   $request->emergency_contact_name;
        $model->present_address_line_1      =   $request->present_address_line_1;
        $model->present_address_line_2      =   $request->present_address_line_2;
        $model->present_city                =   $request->present_city;
        $model->present_state               =   $request->present_state;
        $model->present_zipcode             =   $request->present_zipcode;
        $model->present_country             =   $request->present_country;
        $model->same_as_present_address     =   $request->same_as_present_address;
        if($request->same_as_present_address == 1) {
            $model->permanent_address_line_1    =   '';
            $model->permanent_address_line_2    =   '';
            $model->permanent_state             =   '';
            $model->permanent_city              =   '';
            $model->permanent_zipcode           =   '';
            $model->permanent_country           =   '';
        } else {
            $model->permanent_address_line_1    =   $request->permanent_address_line_1;
            $model->permanent_address_line_2    =   $request->permanent_address_line_2;
            $model->permanent_state             =   $request->permanent_state;
            $model->permanent_city              =   $request->permanent_state;
            $model->permanent_zipcode           =   $request->permanent_zipcode;
            $model->permanent_country           =   $request->permanent_country;
        }
        $model->save();

        activity()->log('Updated an Employee Contact Information - ' . $model->name);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated Successfully')]);

    }

    // Image_Upload
    public function Image_Upload(Request $request, $id) {
        
        // $request->validate([
        //     'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' ,
        // ]);
        // Upload the file if have & delete the old file
    
        $model = Employee::findOrFail($id);
        $old_photo = '';
        $old_photo = $request->old_photo;
        if ($request->hasFile('photo')) {
            if ($model->photo) {
                $image_path = public_path() . '/storage/employee/' . $model->photo;
                unlink($image_path);
            }
            $storagepath = $request->file('photo')->store('public/employee');
            $fileName = basename($storagepath);
            $model->photo = $fileName;
        } else {
            $model->photo = $old_photo;
        }

        $model->save();
        // make activity log & return
        activity()->log('Updated a Employee Photo ' );
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Image Updated'), 'load' => true]);

    }
}