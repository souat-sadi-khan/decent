<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;
use App\User;

class RoleController extends Controller
{
	// return to the index page
   	public function index() {
		return view('admin.acl.index');
	}

	// Datatable Data
	public function datatable(Request $request) {
		if ($request->ajax()) {
			$roles = Role::where('name', '!=', config('system.default_role.admin'))->get();
			return Datatables::of($roles)
				->addIndexColumn()
				->addColumn('action', function ($model) {
					return view('admin.acl.action', compact('model'));
				})->rawColumns(['action'])->make(true);
		}
	}

  	public function create(Request $request) {
		// return to the create page
		if ($request->isMethod('get')) {
			$permissions = Permission::all();
			return view('admin.acl.create', compact('permissions'));
		} else {
			// validate the data coming from form
			$validator = $this->validate($request, [
				'name' => 'required|unique:roles,name|max:255',
			]);

			// create role & assigned Permission
			$role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
			$role->givePermissionTo($request->permissions);

			// Activity Log
			activity()->log('Created a Roll - '. $request->name);

			return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Role And Permission Setup'), 'goto' => route('admin.user.role')]);
		}
	}

	// Edit the role
	public function edit($id) {
		// Check Anauthorized Action
		if (!auth()->user()->can('role.update')) {
			abort(403, 'Unauthorized action.');
		}

		// Abort the id number 1
		if ($id == 1) {
			return abort(404);
		}

		// find the role & edit
		$role = Role::with(['permissions'])
			->find($id);
		$role_permissions = [];
		foreach ($role->permissions as $role_perm) {
			$role_permissions[] = $role_perm->name;
		}

		// sent the role on edit page
		$role = Role::where('id', $id)->firstOrFail();

		$permissions = Permission::all();
		return view('admin.acl.edit', compact(['role', 'permissions', 'role_permissions']));
	}

	// Update the role data
	public function update(Request $request) {
		// Unauthorized Action Check
		if (!auth()->user()->can('role.update')) {
			abort(403, 'Unauthorized action.');
		}

		// find the role columd
		$role = Role::where('id', $request->id)->firstOrFail();

		// Check the validation
		$validator = $request->validate([
			'name' => ['required', 'max:255',
				Rule::unique('roles', 'name')->ignore($role->id)],
		]);
        // dd($request->permissions);
		// Update the roll & permission
		$role->name = $request->name;
		$role->save();

		$role->syncPermissions($request->permissions);

		// Activity Log
		activity()->log('Updated a Roll - '. $request->name);

		return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Role And Permission Updated'), 'goto' => route('admin.user.role')]);
	}

	// Delete the role
	public function distroy(Request $request, $id) {
		// Check Unauthorized Action
		if (!auth()->user()->can('role.delete')) {
			abort(403, 'Unauthorized action.');
		}

		if (request()->ajax()) {
			// Find the role & delete
			$role = Role::where('id', $id)->firstOrFail();
			$role->delete();

			// Activity Log
			activity()->log('Deleted a role - '. $role->name);

			return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Role And Permission Delete')]);
		}
	}


}
