<?php

namespace App\Http\Controllers\Admin\eCommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\eCommerce\AboutUs;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller{
    
    public function index(){
        if (!auth()->user()->can('ecommerce_about_us.view')) {
            abort(403, 'Unauthorized action.');
        }
        $model = AboutUs::first();
        return view('admin.eCommerce.about.index',compact('model'));
    }

    public function store(Request $request){
        if (!auth()->user()->can('ecommerce_about_us.view')) {
            abort(403, 'Unauthorized action.');
        }
        $data = $request->validate([
            'name' => 'required',
            'header_image' => 'mimes:jpeg,png,jpg,gif|max:2048',
            'header_image_alt' => '',
            'seo_title' => '',
            'meta_keyword' => '',
            'meta_description' => '',
            'description' => 'required',
        ]);

         if($request->row_id){
            $nodels = AboutUs::findOrFail($request->row_id);
             if ($request->hasFile('header_image')) {
                 if ($nodels->header_image) {
                  Storage::delete('public/eCommerce/about/'.$nodels->header_image);
                }
                $storagepath = $request->file('header_image')->store('public/eCommerce/about');
                $fileName = basename($storagepath);
                $data['header_image'] = $fileName;
            }else{
                $data['header_image'] = $nodels->header_image;
            }
            $nodels->update($data);
            return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated'), 'goto' => route('admin.eCommerce.about-us.index')]);
         }else{
             if ($request->hasFile('header_image')) {
                $storagepath = $request->file('header_image')->store('public/eCommerce/about');
                $fileName = basename($storagepath);
                $data['header_image'] = $fileName;
            }else{
                $data['header_image'] = '';
            }
            $model = new AboutUs;
            $model->create($data);
             return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'goto' => route('admin.eCommerce.about-us.index')]);
         }
    }
}
