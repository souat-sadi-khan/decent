<?php

namespace App\Http\Controllers\admin\eCommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\eCommerce\PrivacyPolicy;
use App\WholeSale;

class PrivacyPolicyController extends Controller{
    
    public function index(){
        if (!auth()->user()->can('ecommerce_privecy_policy.view')) {
            abort(403, 'Unauthorized action.');
        }

        $model =  PrivacyPolicy::first();
        return view('admin.eCommerce.privacy_policy.index',compact('model'));
    }

    public function store(Request $request){
        if (!auth()->user()->can('ecommerce_privecy_policy.view')) {
            abort(403, 'Unauthorized action.');
        }
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        
         if($request->row_id){
            $nodels = PrivacyPolicy::findOrFail($request->row_id);
            $nodels->update($data);
             return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated'), 'goto' => route('admin.eCommerce.privacy-policy.index')]);
         }else{
            $model = new PrivacyPolicy;
            $model->create($data);
             return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'goto' => route('admin.eCommerce.privacy-policy.index')]);
         }
    }

    // whole_sale_index
    public function whole_sale_index() {
        if (!auth()->user()->can('ecommerce_whole_sale.view')) {
            abort(403, 'Unauthorized action.');
        }
        $model = WholeSale::first();
        return view('admin.eCommerce.whole_sale.index', compact('model'));
    }

    // whole_sale_store
    public function whole_sale_store(Request $request) {
        if (!auth()->user()->can('ecommerce_whole_sale.view')) {
            abort(403, 'Unauthorized action.');
        }
        
        $data = $request->validate([
            'header' => 'required',
            'description' => 'required',
        ]);
        

         if($request->row_id){
            $nodels = WholeSale::findOrFail($request->row_id);
            if($request->hasFile('catelog')) {
                $data = getimagesize($request->file('catelog'));
                $width = $data[0];
                $height = $data[0];

                if($width > 415 && $height > 225) {
                    return response()->json(['success' => true, 'status' => 'danger', 'message' => 'Offer Image Width and height is wrong']);
                }

                $storagepath = $request->file('catelog')->store('public/catelog');
                $fileName = basename($storagepath);
                
                $nodels->catelog = $fileName;
    
            }
            $nodels->update($data);
             return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated'), 'goto' => route('admin.eCommerce.whole-sale')]);
         }else{
            $model = new WholeSale;
            $model->header = $request->header;
            $model->description = $request->description;
            if($request->hasFile('catelog')) {
                $width = $data[0];
                $height = $data[0];
                if($width > 595 && $height > 841) {
                    return response()->json(['success' => true, 'status' => 'danger', 'message' => 'Offer Image Width and height is wrong']);
                }
                $storagepath = $request->file('catelog')->store('public/catelog');
                $fileName = basename($storagepath);
                
                $model->catelog = $fileName;
            }
            $model->save();
             return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'goto' => route('admin.eCommerce.whole-sale')]);
         }
    }
}