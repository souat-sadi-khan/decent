<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\User;
use Validator;
use Illuminate\Validation\Rule;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UiController extends Controller
{
	// return to the user profile page
	public function index()
	{
		$id =Auth::user()->id;
		$user =User::findOrFail($id);
		return view('admin.user.profile',compact('user'));
	}

	// Edit user data
    public function postprofile(Request $request)
   	{
   	  	if ($request->ajax()) {
			$validator = Validator::make($request->all(),[
				'first_name' => ['sometimes', 'nullable','string'],
				'last_name' => ['sometimes', 'nullable','string'],
			]);
			$id =Auth::user()->id;
        	$model =User::findOrFail($id);
			$model->surname =$request->surname;
			$model->first_name =$request->first_name;
			$model->last_name =$request->last_name;
			$model->name =$request->name;
			$model->phone =$request->phone;

			if($request->hasFile('image')) {
				$model = User::findOrFail(Auth::user()->id);
				$storagepath = $request->file('image')->store('public/user/photo/');
				$fileName = basename($storagepath);
	
				$model->image = $fileName;
	
				//if file chnage then delete old one
				$oldFile = $request->oldFile;
				if( $oldFile != ''){

					$file_path = "public/user/photo/".$oldFile;
					Storage::delete($file_path);
				}
	
			}

			// Banner
			if($request->hasFile('banner')) {

				$model = User::findOrFail(Auth::user()->id);
				$storagepath = $request->file('banner')->store('public/user/photo/');
				$fileName = basename($storagepath);
	
				$model->banner = $fileName;
	
				//if file chnage then delete old one
				$oldFile = $request->oldBanner;
				if( $oldFile != ''){

					$file_path = "public/user/photo/".$oldFile;
					Storage::delete($file_path);
				}
	
			}

			$model->save();

			// Activity Log
			activity()->log('Update User Information from Profile.');


			return response()->json([ 'success' => true, 'load' => true, 'message' => _lang('Profile Update.')]);
		}
   	}

	// Password Change Action
	public function password_change(Request $request)
	{
		if ($request->ajax()) {
			$validator = $request->validate([
			'password' => ['required', 'string', 'min:6', 'confirmed'],
			]);

			$id =Auth::user()->id;
			$model =User::findOrFail($id);
			$model->password=Hash::make($request->password);
			$model->save();

			// Activity Log
			activity()->log('Change the password from profile');

			return response()->json(['message' => _lang('Password Change.')]);
		}
	}
}
