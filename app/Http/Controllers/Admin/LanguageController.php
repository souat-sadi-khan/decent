<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class LanguageController extends Controller
{
    public function index(Request $request)
   	{
   		if (!auth()->user()->can('language.view')) {
            abort(403, 'Unauthorized action.');
        }
		// return to the index file
   		if ($request->isMethod('get')) {
      		return view('admin.language.index');
  	 	}
  	}

  	public function create(Request $request)
  	{
  		if (!auth()->user()->can('language.create')) {
            abort(403, 'Unauthorized action.');
        }
  		if ($request->isMethod('get')) {
			// return to the create file
			return view('admin.language.create');
  	 	} else {

			// Set time limit
  	    	@ini_set('max_execution_time', 0);
			@set_time_limit(0);
		
			// validating the data coming from form
			$validator = Validator::make($request->all(), [
				'language_name' => 'required|alpha|string|max:30',
			]);

			// If Validation Fails
        	if ($validator->fails()) {
        		return response()->json(['success' => false, 'status' => 'danger', 'message' => $validator->errors()]);
         	}
		 
			// else
			$name = $request->language_name;
		
			// Check Language name is already Exist OR Not
			if(file_exists(resource_path() . "/language/$name.php")){
				throw ValidationException::withMessages([
					'messege' => [_lang('Language already exists')],
				]);
			}
		
			// Create Language File
			$language = file_get_contents(resource_path() . "/language/language.php");
			$new_file = fopen(resource_path() . "/language/$name.php",'w+');
			fwrite($new_file,$language);
			fclose($new_file);
		
			// Activity Log
			activity()->log('Created a language file');

			// If all ok. Then return with Success file
			return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Language Created Sucessfully'),'goto'=>route('admin.language')]);
  	 	}
  	}

	// Edit Language File
  	public function edit(Request $request,$id="")
  	{
  		if (!auth()->user()->can('language.update')) {
            abort(403, 'Unauthorized action.');
        }
  	 	if ($request->isMethod('get')) {
  	 		if(file_exists(resource_path() . "/language/$id.php")){
				require (resource_path() . "/language/$id.php");
		    	return view('admin.language.edit',compact('language','id'));
			}
  	 	}
  	}

	// Update The Languate File
  	public function update(Request $request,$id)
    {
    	if (!auth()->user()->can('language.update')) {
            abort(403, 'Unauthorized action.');
        }
		// Set the Time Limit
        @ini_set('max_execution_time', 0);
		@set_time_limit(0);
		
		// Set The Language Data
		$contents="<?php \n\n";
		$contents.='$language=array();'."\n\n";	  
		foreach($_POST['language'] as $key => $value){
		  	$contents.='$language["'.$key.'"]="'.$value.'";'."\n";
		}

		$file = fopen(resource_path() . "/language/$id.php","w");
		
		// If update is successfull
		if(fwrite($file, $contents)){
			// Activity Log
			activity()->log('Updated a language file');

		 	return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Updated Sucessfully'),'goto'=>route('admin.language')]); 
		} else{
			// If update is fail
			throw ValidationException::withMessages([
				'messege' => [_lang('Update failed')],
			]);
		}
    }

	// Delete The Language File
    public function delete($id)
    {
    	if (!auth()->user()->can('language.delete')) {
            abort(403, 'Unauthorized action.');
        }
        if(file_exists(resource_path() . "/language/$id.php")){
			unlink(resource_path() . "/language/$id.php");

			// Activity Log
			activity()->log('Deleted a language file');

			return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Deleted Sucessfully'),'goto'=>route('admin.language')]);
		}
    }
}
