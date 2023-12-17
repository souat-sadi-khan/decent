<?php

namespace App\Http\Controllers\admin\Production;

use App\Http\Controllers\Controller;
use App\models\Production\RawMaterial;
use App\models\Production\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('unit.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.production.unit.index');
    }

    public function datatable(Request $request){
       if ($request->ajax()) {
            $document = Unit::all();
            return DataTables::of($document)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    return view('admin.production.unit.action', compact('model'));
                })->rawColumns(['action'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('unit.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.production.unit.form');
    }

    public function remort_modal()
    {
        if (!auth()->user()->can('unit.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.production.unit.quickmodal');
    }

    public function addremort_modal(Request $request)
    {
        if (!auth()->user()->can('unit.create')) {
            abort(403, 'Unauthorized action.');
        }
       $validator = $request->validate([
            'unit'=>'required',
            'child_unit'=>'nullable',
            'convert_rate'=>'nullable|numeric',
        ]);

        $unit = new Unit;
        $unit->unit =$request->unit;
        if ($request->check==1) {
          $unit->child_unit =$request->child_unit;
          $unit->convert_rate =$request->convert_rate;
        }
        $unit->created_by = auth()->user()->id;
        $unit->save(); 
        return response()->json(['id'=>$unit->id,'name'=>$unit->unit,'addto'=>'unit_append','modal'=>'unit_modal']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('unit.create')) {
            abort(403, 'Unauthorized action.');
        }
        $validator = $request->validate([
            'unit'=>'required',
            'child_unit'=>'nullable',
            'convert_rate'=>'nullable|numeric',
        ]);

        $unit = new Unit;
        $unit->unit =$request->unit;
        if ($request->check==1) {
          $unit->child_unit =$request->child_unit;
          $unit->convert_rate =$request->convert_rate;
        }
        $unit->created_by = auth()->user()->id;
        $unit->save();

     return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Created')]);
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
        if (!auth()->user()->can('unit.update')) {
            abort(403, 'Unauthorized action.');
        }
        $model =Unit::find($id);
        return view('admin.production.unit.form',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('unit.update')) {
            abort(403, 'Unauthorized action.');
        }
      $validator = $request->validate([
            'unit'=>'required',
            'child_unit'=>'nullable',
            'convert_rate'=>'nullable|numeric',
        ]);

        $unit = Unit::find($id);
        $unit->unit =$request->unit;
        if ($request->check==1) {
          $unit->child_unit =$request->child_unit;
          $unit->convert_rate =$request->convert_rate;
        }
        $unit->updated_by = auth()->user()->id;
        $unit->save();

     return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        if (!auth()->user()->can('unit.delete')) {
            abort(403, 'Unauthorized action.');
        }
        $count =RawMaterial::where('unit_id',$id)->count();
        if ($count==0) {
            $unit= Unit::find($id);
            $unit->delete();
            if ($unit) {
                return response()->json(['success' => true, 'status' => 'success', 'message' => 'Information Delete Successfully.']);
            }
        }else{
            throw ValidationException::withMessages(['message' => _lang('Do not delete Because this Unit is already use in other section')]);
        }
    }
}
