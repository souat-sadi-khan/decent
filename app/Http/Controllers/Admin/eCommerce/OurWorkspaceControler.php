<?php

namespace App\Http\Controllers\admin\eCommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use App\models\eCommerce\OurWorkspace;
use Illuminate\Support\Facades\Storage;

class OurWorkspaceControler extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        if (!auth()->user()->can('ecommerce_our_workspace.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.eCommerce.our_workspace.index');
    }


     public function datatable(Request $request){
       if ($request->ajax()) {
            $document = OurWorkspace::where('image_one', '!=', config('system.default_role.admin'))->get();
            return DataTables::of($document)
                ->addIndexColumn()
                
                 ->editColumn('image_one',function($model){
                $url= asset('storage/eCommerce/about/'.$model->image_one);
                return '<img src="'.$url.'" border="0" width="120" height="50" class="img-rounded" align="center" />';
                   })
                ->editColumn('image_two',function($model){
                $url= asset('storage/eCommerce/about/'.$model->image_two);
                return '<img src="'.$url.'" border="0" width="120" height="50" class="img-rounded" align="center" />';
                   })
                ->editColumn('image_three',function($model){
                $url= asset('storage/eCommerce/about/'.$model->image_three);
                return '<img src="'.$url.'" border="0" width="120" height="50" class="img-rounded" align="center" />';
                   })
                ->editColumn('image_four',function($model){
                $url= asset('storage/eCommerce/about/'.$model->image_four);
                return '<img src="'.$url.'" border="0" width="120" height="50" class="img-rounded" align="center" />';
                   })
                ->addColumn('action', function ($model) {
                    return view('admin.eCommerce.our_workspace.action', compact('model'));
                })->rawColumns(['action','image_one','image_two','image_three','image_four'])->make(true);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        if (!auth()->user()->can('ecommerce_our_workspace.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.eCommerce.our_workspace.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        if (!auth()->user()->can('ecommerce_our_workspace.create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'image_one' => 'required|max:2048',
            'image_one_alt' => '',
            'image_two' => 'required|max:2048',
            'image_two_alt' => '',
            'image_three' => 'required|max:2048',
            'image_three_alt' => '',
            'image_four' => 'required|max:2048',
            'image_four_alt' => '',
        ]);

         if ($request->hasFile('image_one')) {
            $storagepath = $request->file('image_one')->store('public/eCommerce/about');
            $fileName = basename($storagepath);
            $data['image_one'] = $fileName;
        }else{
            $data['image_one'] = '';
        }

         if ($request->hasFile('image_two')) {
            $storagepath = $request->file('image_two')->store('public/eCommerce/about');
            $fileName = basename($storagepath);
            $data['image_two'] = $fileName;
        }else{
            $data['image_two'] = '';
        }

        if ($request->hasFile('image_three')) {
            $storagepath = $request->file('image_three')->store('public/eCommerce/about');
            $fileName = basename($storagepath);
            $data['image_three'] = $fileName;
        }else{
            $data['image_three'] = '';
        }

        if ($request->hasFile('image_four')) {
            $storagepath = $request->file('image_four')->store('public/eCommerce/about');
            $fileName = basename($storagepath);
            $data['image_four'] = $fileName;
        }else{
            $data['image_four'] = '';
        }

        $model = new OurWorkspace;
        $model->create($data);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'goto' => route('admin.eCommerce.our-workspace.index')]);
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
        if (!auth()->user()->can('ecommerce_our_workspace.update')) {
            abort(403, 'Unauthorized action.');
        }

        $model = OurWorkspace::findOrFail($id);
        return view('admin.eCommerce.our_workspace.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        if (!auth()->user()->can('ecommerce_our_workspace.update')) {
            abort(403, 'Unauthorized action.');
        }

        $model = OurWorkspace::findOrFail($id);
        //dd($request->all());
        $data = $request->validate([
            'image_one' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'image_one_alt' => '',
            'image_two' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'image_two_alt' => '',
            'image_three' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'image_three_alt' => '',
            'image_four' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
            'image_four_alt' => '',
        ]);

         if ($request->hasFile('image_one')) {
             if ($model->image_one) {
                Storage::delete('public/eCommerce/about/'.$model->image_one);
            }
            $storagepath = $request->file('image_one')->store('public/eCommerce/about');
            $fileName = basename($storagepath);
            $data['image_one'] = $fileName;
        }else{
            $data['image_one'] = $model->image_one;
        }

         if ($request->hasFile('image_two')) {
             if ($model->image_two) {
                Storage::delete('public/eCommerce/about/'.$model->image_two);
            }
            $storagepath = $request->file('image_two')->store('public/eCommerce/about');
            $fileName = basename($storagepath);
            $data['image_two'] = $fileName;
        }else{
            $data['image_two'] = $model->image_two;
        }

        if ($request->hasFile('image_three')) {
            if ($model->image_three) {
                Storage::delete('public/eCommerce/about/'.$model->image_three);
            }
            $storagepath = $request->file('image_three')->store('public/eCommerce/about');
            $fileName = basename($storagepath);
            $data['image_three'] = $fileName;
        }else{
            $data['image_three'] = $model->image_three;
        }

        if ($request->hasFile('image_four')) {
            if ($model->image_four) {
                Storage::delete('public/eCommerce/about/'.$model->image_four);
            }
            $storagepath = $request->file('image_four')->store('public/eCommerce/about');
            $fileName = basename($storagepath);
            $data['image_four'] = $fileName;
        }else{
            $data['image_four'] = $model->image_four;
        }

        $model->update($data);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'goto' => route('admin.eCommerce.our-workspace.index')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        if (!auth()->user()->can('ecommerce_our_workspace.delete')) {
            abort(403, 'Unauthorized action.');
        }
        
        $model = OurWorkspace::findOrFail($id);
        Storage::delete(['public/eCommerce/about/'.$model->image_one, 'public/eCommerce/about/'.$model->image_two, 'public/eCommerce/about/'.$model->image_three, 'public/eCommerce/about/'.$model->image_four]);
        $model->delete();
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted'), 'goto' => route('admin.eCommerce.our-workspace.index')]);
    }
}
