<?php

namespace App\Http\Controllers\Admin\Production;

use App\Http\Controllers\Controller;
use App\models\Client;
use App\models\Production\ProductMaterial;
use App\models\Production\RawMaterial;
use App\models\Production\Unit;
use App\models\depertment\StoreRequest;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class RawMaterialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        if (!auth()->user()->can('raw_material.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.production.raw_materials.index');
    }


    public function datatable(Request $request){
        if ($request->ajax()) {
             $document = RawMaterial::where('name', '!=', config('system.default_role.admin'))->get();
             return DataTables::of($document)
                 ->addIndexColumn()
                 ->addColumn('action', function ($model) {
                     return view('admin.production.raw_materials.action', compact('model'));
                 })->editColumn('unit', function ($model) {
                     return $model->unit->unit;
                 })->editColumn('stock', function ($model) {
                    if ($model->stock==null) {
                       return '0 '.$model->unit->unit;
                    }else{
                     return $model->stock . ' '. $model->unit->unit;
                    }
                 })->rawColumns(['action','unit', 'stock'])->make(true);
         }
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        if (!auth()->user()->can('raw_material.create')) {
            abort(403, 'Unauthorized action.');
        }
        $models = Unit::all();
        $supplier =Client::where('type','supplier')->get();
        return view('admin.production.raw_materials.create',compact('models','supplier'));
    }

    public function remort_material()
    {
        if (!auth()->user()->can('raw_material.create')) {
            abort(403, 'Unauthorized action.');
        }
        $models = Unit::all();
        return view('admin.production.raw_materials.quickmodal',compact('models'));
    }

    public function addremort_material(Request $request)
    {
        if (!auth()->user()->can('raw_material.create')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'unit_id' => 'required',
            'name' => 'required',
            'description' => '',
            'price' => '',
            'status' => '',
        ]);

        if ($request->status) {
            $status = 1;
        }else{
            $status = 0;
        }

        $model = new RawMaterial;
        $model->unit_id = $request->unit_id;
        $model->name = $request->name;
        $model->description = $request->description;
        $model->price = $request->price;
        $model->status = $status;
        $model->hidden = 0;
        $model->tek_marks = 0;
        $model->created_by = Auth::user()->id;
        $model->save();

         return response()->json(['id'=>$model->id,'name'=>$model->name,'addto'=>'raw_material','modal'=>'material_modal']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        if (!auth()->user()->can('raw_material.create')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'unit_id' => 'required',
            'name' => 'required',
            'description' => '',
            'price' => '',
            'status' => '',
        ]);

        if ($request->status) {
            $status = 1;
        }else{
            $status = 0;
        }

        $model = new RawMaterial;
        $model->unit_id = $request->unit_id;
        $model->name = $request->name;
        $model->description = $request->description;
        $model->price = $request->price;
        $model->status = $status;
        $model->hidden = 0;
        $model->tek_marks = 0;
        $model->created_by = Auth::user()->id;
        $model->save();
        $model->clients()->attach($request->client_id);

        // Activity Log
        activity()->log('Created a Production Raw Materials - ' . Auth::user()->id);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data created Successfuly')]);
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
        if (!auth()->user()->can('raw_material.update')) {
            abort(403, 'Unauthorized action.');
        }
         $model = RawMaterial::findOrFail($id);
         $models = Unit::all();
         $supplier =Client::where('type','supplier')->get();

        return view('admin.production.raw_materials.edit',compact('model','models','supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        if (!auth()->user()->can('raw_material.update')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'unit_id' => 'required',
            'name' => 'required',
            'description' => '',
            'price' => '',
            'status' => '',
        ]);

         if ($request->status) {
            $status = 1;
        }else{
            $status = 0;
        }

        $model = RawMaterial::findOrFail($id);
        $model->unit_id = $request->unit_id;
        $model->name = $request->name;
        $model->description = $request->description;
        $model->price = $request->price;
        $model->status = $status;
        $model->hidden = 0;
        $model->tek_marks = 0;
        $model->updated_by = Auth::user()->id;
        $model->save();
        $model->clients()->sync($request->client_id);

        // Activity Log
        activity()->log('Update a Production Raw Materials - ' . Auth::user()->id);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data created Successfuly')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        if (!auth()->user()->can('raw_material.delete')) {
            abort(403, 'Unauthorized action.');
        }
        $count1 =ProductMaterial::where('material_id',$id)->count();
        $count2 =StoreRequest::where('raw_material_id',$id)->count();
        if ($count1==0 && $count2==0) {
            $type = RawMaterial::findOrFail($id);
            $name = $type->name;
            $type->delete();
            activity()->log('Delete a Raw Materials - ' . $name);
            return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted Successfully')]);
        }else{
             throw ValidationException::withMessages(['message' => _lang('Do not delete Because this Material is already use in other section')]);
        }
    }
}
