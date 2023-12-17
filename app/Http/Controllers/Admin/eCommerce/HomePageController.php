<?php

namespace App\Http\Controllers\admin\eCommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use App\models\eCommerce\HomePage;
use Illuminate\Support\Facades\Storage;
use App\models\production\Product;

class HomePageController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        if (!auth()->user()->can('ecommerce.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.eCommerce.home_page.index');
    }

    public function datatable(Request $request){
       if ($request->ajax()) {
            $document = HomePage::where('banner_image_one', '!=', config('system.default_role.admin'))->get();
            return DataTables::of($document)
                ->addIndexColumn()
                 ->editColumn('product_id',function($model){
                        return $model->product->name;
                   })
                ->editColumn('banner_image_one',function($model){
                $url= asset('storage/eCommerce/home_page/'.$model->banner_image_one);
                return '<img src="'.$url.'" border="0" width="80" height="50" class="img-rounded" align="center" />';
                   })
                ->editColumn('banner_image_two',function($model){
                $url= asset('storage/eCommerce/home_page/'.$model->banner_image_two);
                return '<img src="'.$url.'" border="0" width="80" height="50" class="img-rounded" align="center" />';
                   })
                ->editColumn('banner_frame_one',function($model){
                $url= asset('storage/eCommerce/home_page/'.$model->banner_frame_one);
                return '<img src="'.$url.'" border="0" width="80" height="50" class="img-rounded" align="center" />';
                   })
                ->editColumn('banner_frame_two',function($model){
                $url= asset('storage/eCommerce/home_page/'.$model->banner_frame_two);
                return '<img src="'.$url.'" border="0" width="80" height="50" class="img-rounded" align="center" />';
                   })
                ->editColumn('tab_slider_image',function($model){
                $url= asset('storage/eCommerce/home_page/'.$model->tab_slider_image);
                return '<img src="'.$url.'" border="0" width="80" height="50" class="img-rounded" align="center" />';
                   })
                ->editColumn('sale_category_image',function($model){
                $url= asset('storage/eCommerce/home_page/'.$model->sale_category_image);
                return '<img src="'.$url.'" border="0" width="80" height="50" class="img-rounded" align="center" />';
                   })
                ->addColumn('action', function ($model) {
                    return view('admin.eCommerce.home_page.action', compact('model'));
                })->rawColumns(['action','product_id','banner_image_one','banner_image_two','banner_frame_one','banner_frame_two','tab_slider_image','sale_category_image'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        if (!auth()->user()->can('ecommerce.view')) {
            abort(403, 'Unauthorized action.');
        }
        $product = Product::all();
        return view('admin.eCommerce.home_page.create',compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        if (!auth()->user()->can('ecommerce.view')) {
            abort(403, 'Unauthorized action.');
        }
        $data = $request->validate([
            'product_id' => 'required|max:255',
            'banner_image_one_check' => '',
            'banner_image_one' => '',
            'banner_image_one_alt' => '',
            'banner_image_two_check' => '',
            'banner_image_two' => '',
            'banner_image_two_alt' => '',
            'banner_frame_one' => '',
            'banner_frame_one_alt' => '',
            'banner_frame_two' => '',
            'banner_frame_two_alt' => '',
            'tab_slider_image' => '',
            'tab_slider_image_alt' => '',
            'sale_category_image' => '',
            'sale_category_image_alt' => '',
        ]);

         if ($request->hasFile('banner_image_one')) {
            $storagepath = $request->file('banner_image_one')->store('public/eCommerce/home_page');
            $fileName = basename($storagepath);
            $data['banner_image_one'] = $fileName;
        }else{
            $data['banner_image_one'] ='';
        }

         if ($request->hasFile('banner_image_two')) {
            $storagepath = $request->file('banner_image_two')->store('public/eCommerce/home_page');
            $fileName = basename($storagepath);
            $data['banner_image_two'] = $fileName;
        }else{
            $data['banner_image_two'] = '';
        }

        if ($request->hasFile('banner_frame_one')) {
            $storagepath = $request->file('banner_frame_one')->store('public/eCommerce/home_page');
            $fileName = basename($storagepath);
            $data['banner_frame_one'] = $fileName;
        }else{
            $data['banner_frame_one'] = '';
        }
        if ($request->hasFile('banner_frame_two')) {
            $storagepath = $request->file('banner_frame_two')->store('public/eCommerce/home_page');
            $fileName = basename($storagepath);
            $data['banner_frame_two'] = $fileName;
        }else{
            $data['banner_frame_two'] = '';
        }

        if ($request->hasFile('tab_slider_image')) {
            $storagepath = $request->file('tab_slider_image')->store('public/eCommerce/home_page');
            $fileName = basename($storagepath);
            $data['tab_slider_image'] = $fileName;
        }else{
            $data['tab_slider_image'] = '';
        }

        if ($request->hasFile('sale_category_image')) {
            $storagepath = $request->file('sale_category_image')->store('public/eCommerce/home_page');
            $fileName = basename($storagepath);
            $data['sale_category_image'] = $fileName;
        }else{
            $data['sale_category_image'] = '';
        }

        $model = new HomePage;
        $success = $model->create($data);
        if ($success) {
            $product = Product::findOrFail($request->product_id);
            $product->hot_sale_status = $request->hot_sale_status;
            $product->feature_product_status = $request->feature_product_status;
            $product->save();
        }
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'goto' => route('admin.eCommerce.home-page.index')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        if (!auth()->user()->can('ecommerce.view')) {
            abort(403, 'Unauthorized action.');
        }
        $product = Product::all();
        $model = HomePage::findOrFail($id);
        return view('admin.eCommerce.home_page.edit',compact('product','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        if (!auth()->user()->can('ecommerce.view')) {
            abort(403, 'Unauthorized action.');
        }

         $model = HomePage::findOrFail($id);
         $data = $request->validate([
            'product_id' => 'required|max:255',
            'banner_image_one_check' => '',
            'banner_image_one' => '',
            'banner_image_one_alt' => '',
            'banner_image_two_check' => '',
            'banner_image_two' => '',
            'banner_image_two_alt' => '',
            'banner_frame_one' => '',
            'banner_frame_one_alt' => '',
            'banner_frame_two' => '',
            'banner_frame_two_alt' => '',
            'tab_slider_image' => '',
            'tab_slider_image_alt' => '',
            'sale_category_image' => '',
            'sale_category_image_alt' => '',
        ]);

         if ($request->hasFile('banner_image_one')) {
             if ($model->banner_image_one) {
                Storage::delete('public/eCommerce/home_page/'.$model->banner_image_one);
                Storage::delete('public/eCommerce/home_page/'.$model->banner_image_two);
            }
            $storagepath = $request->file('banner_image_one')->store('public/eCommerce/home_page');
            $fileName = basename($storagepath);
            $data['banner_image_one'] = $fileName;
        }else{
            $data['banner_image_one'] =$model->banner_image_one;
        }

         if ($request->hasFile('banner_image_two')) {
             if ($model->banner_image_two) {
                Storage::delete('public/eCommerce/home_page/'.$model->banner_image_two);
                Storage::delete('public/eCommerce/home_page/'.$model->banner_image_one);
            }
            $storagepath = $request->file('banner_image_two')->store('public/eCommerce/home_page');
            $fileName = basename($storagepath);
            $data['banner_image_two'] = $fileName;
        }else{
            $data['banner_image_two'] = $model->banner_image_two;
        }

        if ($request->hasFile('banner_frame_one')) {
            if ($model->banner_frame_one) {
                Storage::delete('public/eCommerce/home_page/'.$model->banner_frame_one);
            }
            $storagepath = $request->file('banner_frame_one')->store('public/eCommerce/home_page');
            $fileName = basename($storagepath);
            $data['banner_frame_one'] = $fileName;
        }else{
            $data['banner_frame_one'] = $model->banner_frame_one;
        }
        if ($request->hasFile('banner_frame_two')) {
            if ($model->banner_frame_two) {
                Storage::delete('public/eCommerce/home_page/'.$model->banner_frame_two);
            }
            $storagepath = $request->file('banner_frame_two')->store('public/eCommerce/home_page');
            $fileName = basename($storagepath);
            $data['banner_frame_two'] = $fileName;
        }else{
            $data['banner_frame_two'] = $model->banner_frame_two;
        }

        if ($request->hasFile('tab_slider_image')) {
            if ($model->tab_slider_image) {
                Storage::delete('public/eCommerce/home_page/'.$model->tab_slider_image);
            }
            $storagepath = $request->file('tab_slider_image')->store('public/eCommerce/home_page');
            $fileName = basename($storagepath);
            $data['tab_slider_image'] = $fileName;
        }else{
            $data['tab_slider_image'] = $model->tab_slider_image;
        }

        if ($request->hasFile('sale_category_image')) {
            if ($model->sale_category_image) {
                Storage::delete('public/eCommerce/home_page/'.$model->sale_category_image);
            }
            $storagepath = $request->file('sale_category_image')->store('public/eCommerce/home_page');
            $fileName = basename($storagepath);
            $data['sale_category_image'] = $fileName;
        }else{
            $data['sale_category_image'] = $model->sale_category_image;
        }

        $success = $model->update($data);
        if ($success) {
            $product = Product::findOrFail($request->product_id);
            $product->hot_sale_status = $request->hot_sale_status;
            $product->feature_product_status = $request->feature_product_status;
            $product->save();
        }
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated'), 'goto' => route('admin.eCommerce.home-page.index')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        if (!auth()->user()->can('ecommerce.view')) {
            abort(403, 'Unauthorized action.');
        }
        $model = HomePage::findOrFail($id);
        Storage::delete(['public/eCommerce/home_page/'.$model->banner_image_one, 'public/eCommerce/home_page/'.$model->banner_image_two, 'public/eCommerce/home_page/'.$model->banner_frame_one, 'public/eCommerce/home_page/'.$model->banner_frame_two,'public/eCommerce/home_page/'.$model->tab_slider_image,'public/eCommerce/home_page/'.$model->sale_category_image]);
        $model->delete();
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted'), 'goto' => route('admin.eCommerce.our-workspace.index')]);
    }
}
