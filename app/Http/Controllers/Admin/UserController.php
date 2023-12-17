<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\employee\Employee;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Hash;

class UserController extends Controller
{
	// Return to the index page
    public function index(Request $request) {
		// Check Unauthrized Action
		if (!auth()->user()->can('user.view')) {
			abort(403, 'Unauthorized action.');
		}
		return view('admin.user.index');
	}

	// Datatable Data
	public function datatable(Request $request)
	{
		if (request()->ajax()) {
			$users = User::where('user_type','!=','Client')->get()->except(1);
			return Datatables::of($users)
				->addIndexColumn()
				->addColumn('action', function ($model) {
					return view('admin.user.action', compact('model'));
				})
				->addColumn('username', function ($model) {
					return $model->username;
				})
				->addColumn('role', function ($model) {
					return $role_name = getUserRoleName($model->id);
				})
				->editColumn('status', function ($model) {

					return view('admin.status', compact('model'));
				})
				->rawColumns(['action','role','username', 'status'])->make(true);

		}
	}

	// Create & Store User Inforamtion 
	public function create(Request $request) {
		// Check Unauthorized Action
		if (!auth()->user()->can('user.create')) {
			abort(403, 'Unauthorized action.');
		}
		
		if ($request->isMethod('get')) {
			// return to the create page
			$roles = Role::where('name', '!=', config('system.default_role.admin'))->get()->pluck('name', 'id')->prepend('Select Role...', '');
			$all_user =User::where('employee_id','!=',null)->get();
			$employee_id=[];
			foreach ($all_user as  $user) {
			  $employee_id[]=$user->employee_id;
			}
			$employies=Employee::whereNotIn('id',$employee_id)->pluck('name','id');
			return view('admin.user.create', compact('roles','employies'));
		} else {
			// validating the data
			$validator = $request->validate([
				'surname' => 'required', 'max:255',
				'first_name' => 'required', 'max:255',
				'last_name' => 'required', 'max:255',
				'username' => ['required', 'string', 'max:255', 'unique:users'],
				'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
				'password' => ['required', 'string', 'min:8', 'confirmed'],
			]);

			// Create new User
			$user = new User;
			$user->employee_id=$request->employee_id;
			$user->surname = $request->surname;
			$user->first_name = $request->first_name;
			$user->last_name = $request->last_name;
			$user->username = $request->username;
			$user->email = $request->email;
			$user->username = $request->username;
			$user->password = Hash::make($request->password);
			$user->status = 'activated';
			$user->uuid = Str::uuid();
			$user->user_type = 'Employee';
			$user->save();

			// Assign the role for this user
			$role_id = $request->input('role');
			$role = Role::findOrFail($role_id);
			$user->assignRole($role->name);

			// Activity Log
			activity()->log('Created a User - '. $request->username);

			return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('User Created'), 'goto' => route('admin.user.index')]);
		}
	}

	// User Status Change
	public function status(Request $request, $value, $id) {
		// Check Unauthorized Action
		if (!auth()->user()->can('user.update')) {
			abort(403, 'Unauthorized action.');
		}

		if (request()->ajax()) {
			$user = User::find($id);
			$user->status = $value;
			$user->save();

			return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Status Updated')]);
		}
	}

	// return to the edit page
 	public function edit($id) {
		// Check Unauthorized Action
		if (!auth()->user()->can('user.update')) {
			abort(403, 'Unauthorized action.');
		}
		$user = User::find($id);
		$roles = Role::where('name', '!=', config('system.default_role.admin'))->get()->pluck('name', 'id')->prepend('Select Role...', '');
		return view('admin.user.edit', compact('user', 'roles'));
	}

	// Update User Informatiion
	public function update(Request $request) {
		// Check Unauthorized Action
		if (!auth()->user()->can('user.update')) {
			abort(403, 'Unauthorized action.');
		}

		if (request()->ajax()) {
			$id = $request->id;
			$user = User::findOrFail($id);
			$validator = $request->validate([

				'surname' => ['required', 'max:255'],
				'first_name' => ['required', 'max:255'],
				'last_name' => ['required', 'max:255'],
				'username' => ['required', 'string', 'max:255',
					Rule::unique('users', 'username')->ignore($user->id)],
				'email' => ['required', 'string', 'email', 'max:255',
					Rule::unique('users', 'email')->ignore($user->id)],

			]);

			$user->surname = $request->surname;
			$user->first_name = $request->first_name;
			$user->last_name = $request->last_name;
			$user->username = $request->username;
			$user->email = $request->email;
			$user->username = $request->username;
			$user->password = Hash::make($request->password);
			$user->status = 'activated';
			$user->save();

			$role_id = $request->input('role');
			$user_role = $user->roles->first();

			if ($user_role->id != $role_id) {
				$user->removeRole($user_role->name);

				$role = Role::findOrFail($role_id);
				$user->assignRole($role->name);
			}

			// Activity Log
			activity()->log('Updated User Information - '.$request->username);

			return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('User Updated'), 'goto' => route('admin.user.index')]);

		}
	}

	// Delete the user
	public function destroy(Request $request, $id) {
		// Check Unauthorized Action
		if (!auth()->user()->can('user.delete')) {
			abort(403, 'Unauthorized action.');
		}

		if (request()->ajax()) {
			$user = User::find($id);
			$user->delete();

			// Activity Log
			activity()->log('Deleted a user - '. $user->username);

			return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('User Deleted')]);
		}
	}

	// login_info
	public function login_info(Request $request) {
		$id = $request->model_id;
		$roles = Role::where('name', '!=', config('system.default_role.admin'))->get();
		return view('admin.employee.list.ajax.login_info', compact('id','roles'));
	}

	// set_login_info
	public function set_login_info(Request $request, $id) {
		$request->validate([
			'username' => 'required', 'max:255',
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => ['required', 'string' , 'confirmed', 'min:8'],
		]);

		if($request->check == 'on') {
			$model = Employee::where('id', $id)->first();
			$user_id = $model->user_id;
			if($user_id != '') {
				$user_id = $model->user_id;
				$user = User::findOrFail($user_id);
				$user->username = $request->username;
				$user->email = $request->email;
				$user->password = Hash::make($request->password);
				$user->status = 'activated';
				$user->save();

				$role_id = $request->input('role');
				$user_role = $user->roles->first();

				if ($user_role->id != $role_id) {
					$user->removeRole($user_role->name);

					$role = Role::findOrFail($role_id);
					$user->assignRole($role->name);
				}
			} else {
				$user = new User;
				$user->employee_id=$id;
				$user->user_type='Employee';
				$user->username = $request->username;
				$user->email = $request->email;
				$user->password = Hash::make($request->password);
				$user->status = 'activated';
				$user->uuid = Str::uuid();
				$user->save();
				// Assign the role for this user
				$role_id = $request->input('role');
				$role = Role::findOrFail($role_id);
				$user->assignRole($role->name);
				$user_id = $user->id;
				$model = Employee::findOrFail($id);
				$model->user_id = $user_id;
				$model->save();
			}
		}

		// Activity Log
		activity()->log('Make an user login system');

		return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Login Information Updated'), 'load' => true]);

	}
}
