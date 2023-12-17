<?php

namespace App\Http\Controllers\Admin\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\models\Production\IngredientsCategory;
use Yajra\Datatables\Datatables;
use Illuminate\Validation\Rule;
use Auth;

class IngredientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
      if (!auth()->user()->can('production_ingredients.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.production.ingredients.index');
    }



    public function datatable(Request $request){
       if ($request->ajax()) {
            $document = IngredientsCategory::where('name', '!=', config('system.default_role.admin'))->get();
            return DataTables::of($document)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    return view('admin.production.ingredients.action', compact('model'));
                })->rawColumns(['action'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
      if (!auth()->user()->can('production_ingredients.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.production.ingredients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        if (!auth()->user()->can('production_ingredients.create')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            // 'name' => 'required|unique:ingredients_categories|max:255',
            'name'=>'required',
            'description' => '',
            'status' => '',
        ]);

        if ($request->status) {
            $status = 1;
        }else{
            $status = 0;
        }

        $model = new IngredientsCategory;
        $model->name = $request->name;
        $model->description = $request->description;
        $model->status = $status;
        $model->hidden = 0;
        $model->tek_marks = 0;
        $model->created_by = Auth::user()->id;
        $model->save();

        // Activity Log
        activity()->log('Created a Production Ingredients Category - ' . Auth::user()->id);
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
        if (!auth()->user()->can('production_ingredients.update')) {
            abort(403, 'Unauthorized action.');
        }
        $model = IngredientsCategory::findOrFail($id);
        return view('admin.production.ingredients.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        if (!auth()->user()->can('production_ingredients.update')) {
            abort(403, 'Unauthorized action.');
        }
        $model =  IngredientsCategory::findOrFail($id);
         $request->validate([
            // 'name' => ['required',Rule::unique('ingredients_categories')->ignore($model->id)],
            'name'=>'required',
            'description' => '',
            'status' => '',
        ]);
        if ($request->status) {
            $status = 1;
        }else{
            $status = 0;
        }
        $model->name = $request->name;
        $model->description = $request->description;
        $model->status = $request->status;
        $model->hidden = 0;
        $model->tek_marks = 0;
        $model->updated_by = Auth::user()->id;
        $model->save();

        // Activity Log
        activity()->log('Update a Production Ingredients Category - ' . Auth::user()->id);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Update Successfuly')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        if (!auth()->user()->can('production_ingredients.delete')) {
            abort(403, 'Unauthorized action.');
        }
        $count =JobCostMaterial::where('ingredients_category_id',$id)->count();
        if ($count==0) {
            $type = IngredientsCategory::findOrFail($id);
            $name = $type->name;
            $type->delete();
            activity()->log('Delete a Ingredients Category - ' . $name);
            return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted Successfully')]);
        } else{
              throw ValidationException::withMessages(['message' => _lang('You Cannot Delete this Contact')]);
      }
    }
}
