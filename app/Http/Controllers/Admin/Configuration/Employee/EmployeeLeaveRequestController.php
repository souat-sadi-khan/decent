<?php

namespace App\Http\Controllers\Admin\Configuration\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\models\employee\EmployeeLeaveType;
use App\models\employee\EmployeeLeaveAllocation;
use App\models\employee\EmployeeLeaveAllocationDetail;
use App\models\employee\EmployeeLeaveRequest;
use App\models\employee\EmployeeLeaveRequestDetail;
use App\models\employee\Employee;
use Illuminate\Support\Str;
use DateTime;
use Auth;

class EmployeeLeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.employee.leave.request.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $documents = EmployeeLeaveRequest::query();
            return Datatables::of($documents)
                ->addIndexColumn()
                ->editColumn('name', function ($document) {
                    return $document->employee->name . ' (' . $document->employee->prefix . numer_padding($document->employee->code, get_option('digits_employee_code')) . ')';
                })
                ->editColumn('designation', function ($document) {
                    return current_designation($document->employee_id) ? current_designation($document->employee_id) : "";
                })
                ->editColumn('leave_type', function ($document) {
                    return $document->leave_type->name;
                })
                ->editColumn('period', function ($document) {
                    return $document->start_date . ' To ' . $document->end_date;
                })
                ->editColumn('count', function ($document) {
                    return to_date($document->start_date, $document->end_date);
                })
                ->editColumn('status', function ($document) {
                    if ($document->status == 'pending') {
                        return '<span class="badge badge-info">'.'Pending'.'</span>';
                    }elseif($document->status == 'approved'){
                        return '<span class="badge badge-success">' . 'Approved' . '</span>';
                    }elseif($document->status == 'rejected'){
                        return '<span class="badge badge-danger">' . 'Rejected' . '</span>';
                    }elseif($document->status == 'cancelled'){
                        return '<span class="badge badge-warning">' . 'Cancelled' . '</span>';
                    }
                })
                ->editColumn('request', function ($document) {
                    if($document->request->id == 1){
                        return $document->request->name . ' (Admin)';
                    }else{
                        $employee = Employee::where('id', $document->request->employee_id)->first();
                        return $employee->name . ' (' . $employee->prefix . numer_padding($employee->code, get_option('digits_employee_code')) . ')';
                    }
                    
                })
                ->addColumn('action', function ($model) {
                    return view('admin.employee.leave.request.action', compact('model'));
                })->rawColumns(['action', 'name','status'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $models = Employee::all();
        $leave_types = EmployeeLeaveType::where('is_active', '1')->get();
        return view('admin.employee.leave.request.create', compact('models', 'leave_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $uuid =  Str::uuid()->toString();
        $leave_type = $request->leave_type;
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'file' => 'max:2000',
        ]);

        $id = auth()->user()->id;
        $employee_id = $request->employee;

        // Admin can't request leave for himself
        if ($id == 1 AND $employee_id == '') {
            return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Admin can\'t request leave for himself')]);
        }

        // Find the Employee
        if($id != 1){
            $models =  Employee::where('user_id', $id)->firstOrFail();
            $user_id = $models->id;
        }

        if ($employee_id) {
            $model =  EmployeeLeaveAllocation::where('employee_id', $employee_id)->firstOrFail();
        }else{
            $model =  EmployeeLeaveAllocation::where('employee_id', $user_id)->firstOrFail();
        }


        $alocation_details =  EmployeeLeaveAllocationDetail::where('employee_leave_allocation_id', $model->id)->where('employee_leave_type_id', $leave_type)->firstOrFail();
        $total = $alocation_details->allotted - $alocation_details->used;

        $count = to_date($request->start_date, $request->end_date);

        if ($total < $count) {
            return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Leave Request is Bigger then Your vacancy')]);
        }else{

        $model = new EmployeeLeaveRequest;
        $model->uuid = $uuid;
        if ($employee_id) {
            $model->employee_id = $employee_id;
        }else{
            $model->employee_id = $user_id;
        }

        // Upload the Leave Request File
        if ($request->hasFile('file')) {
            $storagepath = $request->file('file')->store('public/file');
            $fileName = basename($storagepath);
        }else{
            $fileName = '';
        }

        $model->employee_leave_type_id = $leave_type;
        $model->start_date = $request->start_date;
        $model->end_date = $request->end_date;
        $model->reason = $request->reason;
        $model->status = 'pending';
        $model->upload_token = $fileName;
        $model->requester_user_id = $id;
        $model->save();
        $id = $model->id;

        // Activity Log
        activity()->log('Created a Employee Leave Request Employee - ' . $request->employee);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'goto' => route('admin.employee-leave-request.index')]);
    }
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model =  EmployeeLeaveRequest::where('uuid', $id)->firstOrFail();
        $request =  EmployeeLeaveRequestDetail::where('employee_leave_request_id', $model->id)->get();
        $allocation =  EmployeeLeaveAllocation::where('employee_id', $model->employee_id)->firstOrFail();
        $leave =  EmployeeLeaveAllocationDetail::where('employee_leave_allocation_id', $allocation->id)->get();
        return view('admin.employee.leave.request.show', compact('model', 'allocation', 'leave','request'));
    }

    public function details(Request $request)
    {
        $date = EmployeeLeaveRequest::findOrFail($request->id);
        $end_date = strtotime($date->end_date);
        $now = strtotime(date('Y-m-d'));

        if ($now > $end_date) {
            return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Leave Request Date Expired')]);
        }

        $user_id = Auth::user()->id;
        
        $leave_id = $request->id;

        $status = $request->status;
        if ($leave_id) {
            $data = EmployeeLeaveRequest::findOrFail($leave_id);
            $old_status = $data->status;
            $data->status = $status;

            if ($status == "approved") {
                $employee_id = $data->employee_id;
                $employee = EmployeeLeaveAllocation::where('employee_id', $employee_id)->firstOrFail();
                $data1 = EmployeeLeaveAllocationDetail::where('employee_leave_type_id', $data->employee_leave_type_id)->where('employee_leave_allocation_id', $employee->id)->firstOrFail();

                $still_leave = $data1->allotted - $data1->used;
                $count = to_date($data->start_date, $data->end_date);

                if ($still_leave < $count) {
                    return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Leave Request is Bigger then Your vacancy')]);
                }

                if ($old_status != "approved") {
                    if ($data1->used) {
                        $count = $count + $data1->used;
                    } else {
                        $count;
                    }
                    $data1->used = $count;
                    $data1->save();
                }
            }else{
                if ($old_status == "approved") {
                    $employee_id = $data->employee_id;
                    $employee = EmployeeLeaveAllocation::where('employee_id', $employee_id)->firstOrFail();
                    $data1 = EmployeeLeaveAllocationDetail::where('employee_leave_type_id', $data->employee_leave_type_id)->where('employee_leave_allocation_id', $employee->id)->firstOrFail();

                    $count = to_date($data->start_date, $data->end_date);
                        if ($data1->used) {
                            $count = $data1->used - $count;
                            $data1->used = $count;
                            $data1->save();
                        }
                }
            }

            $data->save();
        }
       
        $model = new EmployeeLeaveRequestDetail;
        $model->employee_leave_request_id = $request->id;
        $model->date_of_action = now();
        $model->status = $request->status;
        $model->comment = $request->comment;
        $model->approver_user_id = $user_id;
        $model->save();

        // Activity Log
        activity()->log('Created a Employee Leave Request Employee - ');
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Update'), 'goto' => route('admin.employee-leave-request.index')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model =  EmployeeLeaveRequest::where('uuid', $id)->firstOrFail();
        $leave_types = EmployeeLeaveType::where('is_active', '1')->get();
        return view('admin.employee.leave.request.edit', compact('model', 'leave_types'));
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
        $leave_type = $request->leave_type;
        $uid = Auth::user()->id;
        $models =  Employee::where('user_id', $uid)->firstOrFail();

        if ($request->hasFile('file')) {
            $file = EmployeeLeaveRequest::findOrFail($id);
            if ($file->upload_token) {
                $file_path = public_path() . '/storage/file/' . $file->upload_token;
                unlink($file_path);
            }
            $storagepath = $request->file('file')->store('public/file');
            $fileName = basename($storagepath);
        } else {
            $fileName = $request->old_file;
        }


        $user_id = $models->user_id;
        $employee_id = $request->employee;
        if ($employee_id) {
            $model =  EmployeeLeaveAllocation::where('employee_id', $employee_id)->firstOrFail();
        } else {
            $model =  EmployeeLeaveAllocation::where('employee_id', $user_id)->firstOrFail();
        }
        $alocation_details =  EmployeeLeaveAllocationDetail::where('employee_leave_allocation_id', $model->id)->where('employee_leave_type_id', $leave_type)->firstOrFail();
        $total = $alocation_details->allotted - $alocation_details->used;

        $count = to_date($request->start_date, $request->end_date);

        if ($total < $count) {
            return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Leave Request is Bigger then Your vacancy')]);
        } else {
            $model = EmployeeLeaveRequest::findOrFail($id);
            $model->employee_leave_type_id = $leave_type;
            $model->start_date = $request->start_date;
            $model->end_date = $request->end_date;
            $model->reason = $request->reason;
            $model->upload_token = $fileName;
            $model->requester_user_id = $user_id;
            $model->save();
            // Activity Log
            activity()->log('Updated a Employee Leave Request Employee - ' . $request->employee);
            return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated'), 'goto' => route('admin.employee-leave-request.index')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = EmployeeLeaveRequest::where('uuid', $id)->firstOrFail();
        $name = $type->employee_id;
        $type->delete();

        // Activity Log
        activity()->log('Created a Employee Leave Request Employee - ' . $name);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted Successfully'), 'goto' => route('admin.employee-leave-request.index')]);
    }
}
