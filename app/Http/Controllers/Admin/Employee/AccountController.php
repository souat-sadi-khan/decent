<?php

namespace App\Http\Controllers\Admin\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\employee\EmployeeAccount;
use App\models\employee\Employee;

class AccountController extends Controller
{
    // account_info
    public function account_info(Request $request) {
        $id = $request->model_id;
        $models = EmployeeAccount::where('employee_id', $id)->get();
        return view('admin.employee.list.ajax.account_info', compact('models' , 'id' ));
    }

    // account_info Create
    public function create($id) {
        $model = Employee::findOrFail($id);
        return view('admin.employee.list.account.create', compact('id','model'));
    }

    // account_info Create
    public function store(Request $request ,$id) {

        $request->validate([
            'name' => 'required|min:1|max:50',
            'account_number' => 'required|min:1|max:50',
            'bank_name' => 'required|min:1|max:50',
            'branch_name' => 'required|min:1|max:50',
            'bank_identification_code' => 'required|min:1|max:50',
        ]);

        $model = new EmployeeAccount;
        $model->employee_id = $id;
        $model->name = $request->name;
        $model->account_number = $request->account_number;
        $model->bank_name = $request->bank_name;
        $model->branch_name = $request->branch_name;
        $model->bank_identification_code = $request->bank_identification_code;
        $model->description = $request->description;
        $model->save();

        // Activity Log
        activity()->log('Created a Employee Account Info - ' . $id);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated'), 'goto' => route('admin.employee-list.edit',$request->uuid)]);
    }
    
    // account_info Edit
    public function edit($id) {
        $model = EmployeeAccount::findOrFail($id);
        return view('admin.employee.list.account.edit', compact('model'));
    }

    // account_info show
    public function show($id) {
        $model = EmployeeAccount::findOrFail($id);
        return view('admin.employee.list.account.show', compact('model'));
    }

    // account_info Update
    public function update(Request $request, $id) {

        $request->validate([
            'name' => 'required|min:1|max:50',
            'account_number' => 'required|min:1|max:50',
            'bank_name' => 'required|min:1|max:50',
            'branch_name' => 'required|min:1|max:50',
            'bank_identification_code' => 'required|min:1|max:50',
        ]);
        
        $model = EmployeeAccount::findOrFail($id);
        $model->name = $request->name;
        $model->account_number = $request->account_number;
        $model->bank_name = $request->bank_name;
        $model->branch_name = $request->branch_name;
        $model->bank_identification_code = $request->bank_identification_code;
        $model->description = $request->description;
        $model->save();

        // Activity Log
        activity()->log('Created a Employee Account Info - ' . $id);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Update'), 'goto' => route('admin.employee-list.edit',$request->uuid)]);
    }

    // account_info destroy
    public function destroy($id) {
        $type = EmployeeAccount::findOrFail($id);
        $name = $type->name;
        $type->delete();

        // Activity Log
        activity()->log('Created a Employee Account - ' . $name);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted Successfully'), 'load' => true]);
    }
}