<?php

namespace App\Http\Controllers\admin\eCommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\eCommerce\Seo;

class SeoController extends Controller
{
    public function index(){
        if (!auth()->user()->can('ecommerce_seo.view')) {
            abort(403, 'Unauthorized action.');
        }
        $model = Seo::first();
        return view('admin.eCommerce.seo.index',compact('model'));
    }

     public function store(Request $request){
        if (!auth()->user()->can('ecommerce_seo.view')) {
            abort(403, 'Unauthorized action.');
        }
       $data = $request->validate([
            'meta_title' => 'required',
            'meta_author' => 'required',
            'meta_keyword' => 'required',
            'meta_description' => '',
            'google_analytics' => '',
            'bing_analytics' => '',
    
        ]);

         if($request->row_id){
            $nodels = Seo::findOrFail($request->row_id);
            $nodels->update($data);
            return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated'), 'goto' => route('admin.eCommerce.seo.index')]);
         }else{
            $model = new Seo;
            $model->create($data);
             return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'goto' => route('admin.eCommerce.seo.index')]);
         }
    }
}
