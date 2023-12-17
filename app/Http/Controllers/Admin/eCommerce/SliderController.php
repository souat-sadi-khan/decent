<?php

namespace App\Http\Controllers\admin\eCommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\eCommerce\Slider;
use App\models\production\Product;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
use Auth;

class SliderController extends Controller{
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        if (!auth()->user()->can('ecommerce.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.eCommerce.slider.index');
    }


    public function datatable(Request $request){
       if ($request->ajax()) {
            $document = Slider::where('title', '!=', config('system.default_role.admin'))->with('product')->get();
            return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('slider',function($model){
                $url= asset('storage/eCommerce/slider/'.$model->slider_image);
                return '<img src="'.$url.'" border="0" width="120" height="50" class="img-rounded" align="center" />';
                })
                ->editColumn('product_id',function($model){
                    return $model->product->name;
                })
                ->addColumn('action', function ($model) {
                    return view('admin.eCommerce.slider.action', compact('model'));
                })
                ->rawColumns(['slider','product_id','action'])->make(true);
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
        return view('admin.eCommerce.slider.create',compact('product'));
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
            'product_id' => 'required',
            'title' => 'required',
            'title_heading' => 'required',
            'short_description' => 'required',
            'slider_image' => '',
        ]);
        $data['created_by']=Auth::user()->id;

        if ($request->hasFile('slider_image')) {
            $storagepath = $request->file('slider_image')->store('public/eCommerce/slider');
            $fileName = basename($storagepath);
            $data['slider_image'] = $fileName;
        }else{
            $data['slider_image'] = '';
        }
        $model = new Slider;
        $model->create($data);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Slider Create Successfuly'), 'goto' => route('admin.eCommerce.slider.index')]);
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
    public function edit($id)
    {
        if (!auth()->user()->can('ecommerce.view')) {
            abort(403, 'Unauthorized action.');
        }
        $model = Slider::findOrFail($id);
        $product = Product::all();
        return view('admin.eCommerce.slider.edit',compact('model','product'));
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
        $model = Slider::findOrFail($id);
        $data = $request->validate([
            'product_id' => 'required',
            'title' => 'required',
            'title_heading' => 'required',
            'short_description' => 'required',
            'slider_image' => '',
        ]);
        $data['update_by']=Auth::user()->id;

        if ($request->hasFile('slider_image')) {
             if ($model->slider_image) {
                Storage::delete('public/eCommerce/slider/'.$model->slider_image);
            }
            $storagepath = $request->file('slider_image')->store('public/eCommerce/slider');
            $fileName = basename($storagepath);
            $data['slider_image'] = $fileName;
        }else{
            $data['slider_image'] = $model->slider_image;
        }
        $model->update($data);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Slider Update Successfuly'), 'goto' => route('admin.eCommerce.slider.index')]);
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
        $model = Slider::findOrFail($id);
        $model->delete();
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Slider Delete Successfuly'), 'goto' => route('admin.eCommerce.slider.index')]);
    }
}