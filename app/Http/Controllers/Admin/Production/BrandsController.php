<?php

namespace App\Http\Controllers\Admin\Production;

use App\Http\Controllers\Controller;
use App\models\Production\Brand;
use App\models\Production\Product;
use App\models\Production\VariationBrandDetails;
use App\models\email\EmailTemolate;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;


class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        if (!auth()->user()->can('production_brands.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.production.brand.index');
    }


    public function datatable(Request $request){
       if ($request->ajax()) {
            $document = Brand::where('name', '!=', config('system.default_role.admin'))->get();
            return DataTables::of($document)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    return view('admin.production.brand.action', compact('model'));
                })->rawColumns(['action'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        if (!auth()->user()->can('production_brands.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.production.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        if (!auth()->user()->can('production_brands.create')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'name' => 'required|unique:brands|max:255',
            'owner_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => '',
        ]);

        $model = new Brand;
        $model->name = $request->name;
        $model->owner_name = $request->owner_name;
        $model->email = $request->email;
        $model->phone = $request->phone;
        $model->address = $request->address;
        $model->hidden = 0;
        $model->tek_marks = 0;
        $model->created_by = Auth::user()->id;
        $model->save();

        // Activity Log
        activity()->log('Created a Production Brand - ' . Auth::user()->id);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data created Successfuly') ]);
    }

    public function remort_modal()
    {
      if (!auth()->user()->can('production_brands.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.production.brand.quickmodal');
    }

   public function addremort_modal(Request $request)
    {
     if (!auth()->user()->can('production_brands.create')) {
            abort(403, 'Unauthorized action.');
        }
     $request->validate([
            'name' => 'required|unique:brands|max:255',
            'owner_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => '',
        ]);

        $model = new Brand;
        $model->name = $request->name;
        $model->owner_name = $request->owner_name;
        $model->email = $request->email;
        $model->phone = $request->phone;
        $model->address = $request->address;
        $model->hidden = 0;
        $model->tek_marks = 0;
        $model->created_by = Auth::user()->id;
        $model->save();
        return response()->json(['id'=>$model->id,'name'=>$model->name,'addto'=>'brand_append','modal'=>'brand_modal']);
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
        if (!auth()->user()->can('production_brands.update')) {
            abort(403, 'Unauthorized action.');
        }
        $model = Brand::findOrFail($id);
        return view('admin.production.brand.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        if (!auth()->user()->can('production_brands.update')) {
            abort(403, 'Unauthorized action.');
        }
        $model =  Brand::findOrFail($id);
         $request->validate([
            'name' => ['required',Rule::unique('brands')->ignore($model->id)],
            'owner_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => '',
        ]);
        $model->name = $request->name;
        $model->owner_name = $request->owner_name;
        $model->email = $request->email;
        $model->phone = $request->phone;
        $model->address = $request->address;
        $model->hidden = 0;
        $model->tek_marks = 0;
        $model->updated_by = Auth::user()->id;
        $model->save();

        // Activity Log
        activity()->log('Update a Production Brand - ' . Auth::user()->id);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Update Successfuly')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        if (!auth()->user()->can('production_brands.delete')) {
            abort(403, 'Unauthorized action.');
        }
        $count1 =VariationBrandDetails::where('brand_id',$id)->count();
        if ($count1 ==0) {
        $type = Brand::findOrFail($id);
        $name = $type->name;
        $type->delete();

        activity()->log('Delete a Brand - ' . $name);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted Successfully'), 'load'=>true]);
      }else{
        throw ValidationException::withMessages(['message' => _lang('Do not delete Because this Brand is already use in other section')]);
      }
    }

  public function email($id)
    {
        if (!auth()->user()->can('email_marketing.view')) {
            abort(403, 'Unauthorized action.');
        }
        $model =Brand::find($id);
        $templates = EmailTemolate::pluck('name','id');
        return view('admin.production.brand.mail',compact('model','templates'));
    }

    public function sms($id)
    {
        if (!auth()->user()->can('sms_marketing.view')) {
            abort(403, 'Unauthorized action.');
        }
        $model =Brand::find($id);
        return view('admin.production.brand.sms',compact('model'));
    }
}
