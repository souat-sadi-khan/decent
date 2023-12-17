<?php

namespace App\Http\Controllers\Admin\Configuration\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\employee\Department;
use App\models\employee\Designation;
use App\models\employee\Employee;
use App\models\employee\EmployeeAttendance;
use App\models\employee\EmployeeAttendanceType;
use App\models\employee\EmployeeCategory;
use App\models\employee\EmployeeDesignation;
use App\models\holiday\Holiday;
use Yajra\DataTables\Facades\DataTables;

class EmployeeAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = today();
        $year = $today->year;
        $month = $today->month;
        $categorys = EmployeeCategory::all();
        $departments = Department::all();
        $designations = Designation::all();
        $types = EmployeeAttendanceType::where('is_active','1')->get();
        return view('admin.employee.attendance.index', compact('categorys','types', 'departments', 'designations', 'today'));
    }

    // public function datatable(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $document = EmployeeAttendance::where('name', '!=', config('system.default_role.admin'))->get();
    //         return DataTables::of($document)
    //             ->addIndexColumn()
    //             ->editColumn('is_active', function ($model) {
    //                 return $model->is_active == 1 ? 'Active' : 'Inactive';
    //             })
    //             ->addColumn('action', function ($model) {
    //                 return view('admin.employee.attendance.action', compact('model'));
    //             })->rawColumns(['action'])->make(true);
    //     }
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::all();
        $departments = Department::all();
        $designations = Designation::all();
        $types = EmployeeAttendanceType::where('is_active', '1')->where('type', '!=', 'production_based_deduction')->where('type', '!=', 'production_based_earning')->get();
        return view('admin.employee.attendance.create', compact('employees','types', 'departments', 'designations'));
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
            'date' => 'required',
        ]);
        $date = \Carbon\Carbon::parse($request['date'])->format('yy-m-d');
        $attendance = EmployeeAttendance::where('date_of_attendance', $date)->get();
        if (count($attendance)) {
            $employee = count($request->employee);
            for ($i = 0; $i < $employee; $i++) {
                $model = EmployeeAttendance::where('date_of_attendance', $date)->where('employee_id', $request->employee[$i])->first();
                $model->employee_id = $request->employee[$i];
                $model->date_of_attendance = $date;
                $model->employee_attendance_type_id = $request->type[$i];
                $model->remarks = $request->remarks[$i];
                $model->save();
            }
        }else{
            $employee = count($request->employee);
            for ($i=0; $i < $employee ; $i++) {
                $model = new EmployeeAttendance;
                $model->employee_id = $request->employee[$i];
                $model->date_of_attendance = $date;
                $model->employee_attendance_type_id = $request->type[$i];
                $model->remarks = $request->remarks[$i];
                $model->save();
            }
        }

        activity()->log('Created an Employee Attendance- ');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function department(Request $request)
    {
        $designation = $request->designation;
        $department = $request->department;
        $employees = EmployeeDesignation::query();
        if ($department) {
            $employees->whereIn('department_id', $department);
        }
        if ($designation) {
            $employees->whereIn('designation_id', $designation);
        }
        $employees = $employees->get();
        $employees_id=[];
        foreach ($employees as  $value) {
            $employees_id[] = $value->employee_id;
        }

        $employee = Employee::whereIn('id', $employees_id)->get();
        $types = EmployeeAttendanceType::where('is_active', '1')->where('type', '!=', 'production_based_deduction')->where('type', '!=', 'production_based_earning')->get();
        return view('admin.employee.attendance.data', compact('employee', 'types'));
    }

    public function designation(Request $request)
    {
        $designation = $request->designation;
        $department = $request->department;
        $employees = EmployeeDesignation::query();
        if ($department) {
            $employees->whereIn('department_id', $department);
        }
        if ($designation) {
            $employees->whereIn('designation_id', $designation);
        }
        $employees = $employees->get();
        $employees_id = [];
        foreach ($employees as  $value) {
            $employees_id[] = $value->employee_id;
        }

        $employee = Employee::whereIn('id', $employees_id)->get();
        $types = EmployeeAttendanceType::where('is_active', '1')->where('type', '!=', 'production_based_deduction')->where('type', '!=', 'production_based_earning')->get();
        return view('admin.employee.attendance.data', compact('employee', 'types'));
    }

    public function date(Request $request)
    {
        $date1 = \Carbon\Carbon::parse($request['date'])->format('yy-m-d');


        // check Holiday
        $holiday = Holiday::where('date', $date1)->first();
        if($holiday) {

            $holiday = 'Holiday';

        } else {

            $default_holiday = get_option('holiday');

            $dt = strtotime($date1);
            $day = date("l", $dt);

            
            if($default_holiday == $day) {
    
                $holiday = 'Holiday';
            
            } else {

                $holiday = '';

            }


        }

        $designation = $request->designation;
        $department = $request->department;
        $employees = EmployeeDesignation::query();
        if ($department) {
            $employees->whereIn('department_id', $department);
        }
        if ($designation) {
            $employees->whereIn('designation_id', $designation);
        }
        $employees = $employees->get();
        $employees_id = [];
        foreach ($employees as  $value) {
            $employees_id[] = $value->employee_id;
        }

        $employee = Employee::whereIn('id', $employees_id)->get();
        $types = EmployeeAttendanceType::where('is_active', '1')->where('type', '!=', 'production_based_deduction')->where('type', '!=', 'production_based_earning')->get();
        return view('admin.employee.attendance.date', compact('employee', 'types', 'date1', 'holiday'));
    }


    // checkholiday
    public function checkholiday(Request $request) {
        $date = $request->date;

        $dt = strtotime($date);
        $day = date("l", $dt);

        $default_holiday = get_option('holiday');

        if($default_holiday == $day) {

            return '<div class="alert alert-success">'. $date . ' - <strong> '. $default_holiday .' </strong> is already set as a default holiday ...</div>';
        
        }
        
        // check Holiday
        $holiday = Holiday::where('date', $date)->first();
        if($holiday) {
            return '<div class="alert alert-success">'. $date . ' <strong> '. $holiday->description .' </strong> is already set as a holiday ...</div>';
        }
    }


    
    public function fetch(Request $request)
    {
        $months = $request->month;
        $a = explode("-", $months);
        $year = $a[0];
        $month = $a[1];
        
        $today = days_in_month($month, $year);
        $dates = [];
        
        for ($i = 1; $i < $today + 1; ++$i) {
            $dates[] = \Carbon\Carbon::createFromDate($year, $month, $i)->format('d');
        }

        $cat_id = $request->category;
        $d_id = [];

        if ($cat_id) {
            $result = Designation::whereIn('employee_category_id', $cat_id)->get();
            foreach ($result as  $value) {
                $d_id[] = $value->id;
            }
        }
        $designation = $request->designation;
        $department = $request->department;
        $employees = EmployeeDesignation::query();
        if ($department) {
            $employees->whereIn('department_id', $department);
        }
        if ($designation) {
            $employees->whereIn('designation_id', $designation);
        }
        if ($d_id) {
            $employees->whereIn('designation_id', $d_id);
        }
        $employees = $employees->get();
        $employees_id = [];
        foreach ($employees as  $value) {
            $employees_id[] = $value->employee_id;
        }
        $employees = Employee::whereIn('id', $employees_id)->get();
        $types = EmployeeAttendanceType::where('is_active', '1')->where('type', '!=', 'production_based_deduction')->where('type', '!=', 'production_based_earning')->get();
        return view('admin.employee.attendance.fetch', compact('employees', 'dates', 'types', 'months','today'));
    }
}
