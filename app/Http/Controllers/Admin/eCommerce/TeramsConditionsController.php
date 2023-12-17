<?php

namespace App\Http\Controllers\admin\eCommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\eCommerce\TeramsCondition;
use Illuminate\Support\Facades\Storage;

class TeramsConditionsController extends Controller{
    public function index(){
        if (!auth()->user()->can('ecommerce_terms_and_condition.view')) {
            abort(403, 'Unauthorized action.');
        }
        $model = TeramsCondition::first();
        return view('admin.eCommerce.terams_condition.index',compact('model'));
    }

     public function store(Request $request){
       
        if (!auth()->user()->can('ecommerce_terms_and_condition.view')) {
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
            $nodels = TeramsCondition::findOrFail($request->row_id);
             if ($request->hasFile('header_image')) {
                if ($nodels->header_image) {
                  Storage::delete('public/eCommerce/terms/'.$nodels->header_image);
                }
                $storagepath = $request->file('header_image')->store('public/eCommerce/terms');
                $fileName = basename($storagepath);
                $data['header_image'] = $fileName;
            }else{
                $data['header_image'] = $nodels->header_image;
            }
            $nodels->update($data);
            return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated'), 'goto' => route('admin.eCommerce.terams-conditions.index')]);
         }else{
             if ($request->hasFile('header_image')) {
                $storagepath = $request->file('header_image')->store('public/eCommerce/terms');
                $fileName = basename($storagepath);
                $data['header_image'] = $fileName;
            }else{
                $data['header_image'] = '';
            }
            $model = new TeramsCondition;
            $model->create($data);
             return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'goto' => route('admin.eCommerce.terams-conditions.index')]);
         }
    }
}
