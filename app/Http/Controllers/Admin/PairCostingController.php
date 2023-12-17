<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\JobCostMaterial;
use App\JobCosting;
use App\models\Production\IngredientsCategory;
use App\models\Production\Product;
use App\models\Production\ProductMaterial;
use App\models\Production\RawMaterial;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PairCostingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $q=JobCosting::query();
            $document =$q->get();

            return DataTables::of($document)
                ->addIndexColumn()
                 ->editColumn('date', function ($model) {
                  return formatDate($model->date);
                 })
                 ->editColumn('product', function ($model) {
                    return $model->product->name;
                 })
                ->addColumn('action', function ($model) {
                    return view('admin.pair_costing.action', compact('model'));
                })->rawColumns(['action','date','product'])->make(true);
        }
      return view('admin.pair_costing.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!auth()->user()->can('paircosting.view')) {
            abort(403, 'Unauthorized action.');
        }
        if ($request->ajax()) {
           
           $product_id =$request->product_id;
           $model=Product::with(['material'])->find($product_id);
           // $data = array('Upper','Upper','Linning','Quater Linning','Vamp Linning','Heel Grip','Inter Linning','Insole','Sank Board','Steel Snak','Toe Puff','Counter','ShoeLace','Insole/Wiled','Socks EVA','Socks','Folding' );
           $ingredies =IngredientsCategory::all();
           $materials=RawMaterial::all();
           return view('admin.pair_costing.ajax_include',compact('model','ingredies','materials'));
        }
        $products =Product::select('id','name')->get();
        return view('admin.pair_costing.create',compact('products'));
    }

    public function material_unit(Request $request)
    {
        $raw =$request->raw;
        $material =RawMaterial::with('unit')->find($raw);
        return response()->json($material);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('paircosting.create')) {
            abort(403, 'Unauthorized action.');
        }
        $model =new JobCosting;
        $model->product_id =$request->product_id;
        $model->cost_id =mt_rand(0,999999);
        $model->total_material_cost =$request->total_material_cost;
        $model->rejection =$request->rejection;
        $model->rejection_amt =$request->rejection_amt;
        $model->profit_percent =$request->profit_percent;
        $model->profit_amt =$request->profit_amt;
        $model->commercial =$request->commercial;
        $model->grand_total =$request->grand_total;
        $model->date=date('Y-m-d');
        $model->created_by=auth()->user()->id;
        $model->save();
        for ($i=0; $i <count($request->ingredients_category_id) ; $i++) { 
           
           $material = new JobCostMaterial;
           $material->job_costing_id =$model->id;
           $material->ingredients_category_id =$request->ingredients_category_id[$i];
           $material->raw_material_id =$request->raw_material_id[$i];
           $material->unit_id =$request->unit_id[$i];
           $material->consumstion =$request->consumstion[$i];
           $material->unit_cost =$request->unit_cost[$i];
           $material->cost_pr =$request->cost_pr[$i];
           $material->created_by=auth()->user()->id;
           $material->save();
        }

            activity()->log('Paircosting created - ' . $model->id);

        return response()->json(['success' => true, 'status' => 'success', 'message' => ' Successfully.','window'=>route('admin.paircosting.show',$model->id)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
          $model=JobCosting::with(['cost_material'])->find($id);

          return view('admin.pair_costing.show',compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ingredies =IngredientsCategory::all();
        $materials=RawMaterial::all();
        $model=JobCosting::findOrFail($id);
        return view('admin.pair_costing.edit',compact('model','materials','ingredies'));
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
        if (!auth()->user()->can('paircosting.create')) {
            abort(403, 'Unauthorized action.');
        }
        $model =JobCosting::findOrFail($id);
        $model->total_material_cost =$request->total_material_cost;
        $model->rejection =$request->rejection;
        $model->rejection_amt =$request->rejection_amt;
        $model->profit_percent =$request->profit_percent;
        $model->profit_amt =$request->profit_amt;
        $model->commercial =$request->commercial;
        $model->grand_total =$request->grand_total;
        $model->save();
        foreach ($model->cost_material as $key=> $material) { 
           $material->ingredients_category_id =$request->ingredients_category_id[$key];
           $material->raw_material_id =$request->raw_material_id[$key];
           $material->unit_id =$request->unit_id[$key];
           $material->consumstion =$request->consumstion[$key];
           $material->unit_cost =$request->unit_cost[$key];
           $material->cost_pr =$request->cost_pr[$key];
           $material->save();
        }

            activity()->log('Paircosting Updated - ' . $model->id);

        return response()->json(['success' => true, 'status' => 'success', 'message' => ' Successfully Updated.','window'=>route('admin.paircosting.show',$model->id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model=JobCosting::find($id);
        $model->cost_material()->delete();
        $model->delete();

        activity()->log('Paircosting Delete - ' . $model->id);

        return response()->json(['success' => true, 'status' => 'success', 'message' => ' Successfully Delete.']);

    }
}
