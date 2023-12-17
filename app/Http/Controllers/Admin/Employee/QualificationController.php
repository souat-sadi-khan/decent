<?php

namespace App\Http\Controllers\Admin\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\employee\EmployeeQualification;

class QualificationController extends Controller
{
    // qua_info
    public function qua_info(Request $request) {
        $id = $request->model_id;
        $models = EmployeeQualification::where('employee_id', $id)->orderBy('id', 'desc')->get();
        return view('admin.employee.list.ajax.qualification_info', compact('models', 'id'));
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

        $model = new EmployeeQualification;

        return view('admin.employee.list.qualification-history.create', compact('employee_id', 'model'));
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
            'standard'                          =>      'required|min:1|max:50',
            'institute_name'                    =>      'required|min:1|max:50',
            'board_name'                        =>      'required|min:1|max:50',
            'start_period'                      =>      'required',
            'result'                            =>      'required|min:1|max:50',
        ]);

        $employee_id = $request->employee_id;

        $model = new EmployeeQualification;
        $model->employee_id = $employee_id;
        $model->standard = $request->standard;
        $model->institute_name = $request->institute_name;
        $model->board_name = $request->board_name;
        $model->start_period = $request->start_period;
        $model->end_period = $request->end_period;
        $model->result = $request->result;
        $model->description = $request->description;
        $model->save();

        // make activity log & return
        activity()->log('Created a Employee Qualification ' );
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
        $model = EmployeeQualification::findOrFail($id);
        return view('admin.employee.list.qualification-history.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // find the employee ID

        $model = EmployeeQualification::findOrFail($id);
        $employee_id = $model->employee_id;

        return view('admin.employee.list.qualification-history.edit', compact('employee_id', 'model'));
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
        // fetching all data from form and validate
        request()->validate([
            'standard'                          =>      'required|min:1|max:50',
            'institute_name'                    =>      'required|min:1|max:50',
            'board_name'                        =>      'required|min:1|max:50',
            'start_period'                      =>      'required',
            'result'                            =>      'required|min:1|max:50',
        ]);

        $employee_id = $request->employee_id;

        $model = EmployeeQualification::findOrFail($id);
        $model->employee_id = $employee_id;
        $model->standard = $request->standard;
        $model->institute_name = $request->institute_name;
        $model->board_name = $request->board_name;
        $model->start_period = $request->start_period;
        $model->end_period = $request->end_period;
        $model->result = $request->result;
        $model->description = $request->description;
        $model->save();

        // make activity log & return
        activity()->log('Updated a Employee Qualification ' );
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'load' => true]);
 
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
        $model = EmployeeQualification::findOrFail($id);
        $model->delete();

        // make activity log & return
        activity()->log('Deleted a Employee Qualification Information ' );
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted'), 'load' => true]);

    }
}
