<?php

namespace App\Http\Controllers\Admin\Production;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\Production\Product;
use App\models\Production\ProductMaterial;
use App\models\Production\WopMaterial;
use App\models\Production\WorkOrder;
use App\models\Production\WorkOrderProduct;
use Yajra\DataTables\Facades\DataTables;

class WopMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('production_wop_materials.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.production.wop-materials.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $document = WorkOrder::where('status', '=', 'requisition')->get();
            return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('code', function ($document) {
                    return $document->prefix . numer_padding($document->code, get_option('digits_work_order_code'));
                })->addColumn('action', function ($model) {
                    return view('admin.production.wop-materials.action', compact('model'));
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
        if (!auth()->user()->can('production_wop_materials.create')) {
            abort(403, 'Unauthorized action.');
        }
        $models = WorkOrder::where('status', '!=', 'requisition')->orderBy('id', 'desc')->get();
        return view('admin.production.wop-materials.create', compact('models'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('production_wop_materials.create')) {
            abort(403, 'Unauthorized action.');
        }
        // $request->validate([
        //     'wo_id' => 'required',
        //     'raw_material' => 'required',
        // ]);

        $wo_id = $request->wo_id;
        $raw_material_id = $request->raw_material_id;

        for($i = 0; $i < count($raw_material_id); $i++) {
            $raw_id = $request->raw_material_id[$i];
            $qty = $request->quantity[$i];
            $unit_price = $request->price[$i];
            $sub_total = $request->total[$i];

            $purchase = new WopMaterial;
            $purchase->wo_id = $wo_id;
            $purchase->raw_material_id = $raw_id;
            $purchase->qty = $qty;
            $purchase->price = $unit_price;
            $purchase->unit_price = $sub_total;
            $purchase->created_by = auth()->user()->id;
            $purchase->save();
        }

        // foreach ($raw_material as $key => $value) {
        //     $wop_id = $key;
        //     foreach ($value as $v) {
        //         $purchase = new WopMaterial;
        //         $purchase->wo_id = $wo_id;
        //         $purchase->wop_id = $wop_id;
        //         $purchase->raw_material_id = $v['raw_material_id'];
        //         $purchase->qty = $v['qty'];
        //         $purchase->price = $v['price'];
        //         $purchase->unit_price = $v['unit_price'];
        //         $purchase->waste = $v['waste'];
        //         $purchase->uses = $v['uses'];
        //         $purchase->created_by = auth()->user()->id;
        //         $purchase->save();
        //     }
        // }

        $work_order = WorkOrder::findOrFail($wo_id);
        $work_order->status = 'requisition';
        $work_order->save();

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'goto' => route('admin.production-wop-materials.index')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('production_wop_materials.view')) {
            abort(403, 'Unauthorized action.');
        }
        $model = WorkOrder::with('work_order')->findOrFail($id);
        $models = WopMaterial::where('wo_id', $id)->get();
        return view('admin.production.wop-materials.show', compact('models', 'model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('production_wop_materials.update')) {
            abort(403, 'Unauthorized action.');
        }
        $models = WorkOrder::findOrFail($id);
        return view('admin.production.wop-materials.edit', compact('models','id'));
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
        if (!auth()->user()->can('production_wop_materials.update')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'wo_id' => 'required',
            'raw_material' => 'required',
        ]);

        if ($id) {
            $type = WopMaterial::where('wo_id', $id)->delete();
        }

        $raw_material = $request->raw_material;

        foreach ($raw_material as $key => $value) {
            $wop_id = $key;
            foreach ($value as $v) {
                $purchase = new WopMaterial;
                $purchase->wo_id = $id;
                $purchase->wop_id = $wop_id;
                $purchase->raw_material_id = $v['raw_material_id'];
                $purchase->qty = $v['qty'];
                $purchase->price = $v['price'];
                $purchase->unit_price = $v['unit_price'];
                $purchase->waste = $v['waste'];
                $purchase->uses = $v['uses'];
                $purchase->updated_by = auth()->user()->id;
                $purchase->save();
            }
        }

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated'), 'goto' => route('admin.production-wop-materials.index')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('production_wop_materials.delete')) {
            abort(403, 'Unauthorized action.');
        }
        if ($id) {
            $type = WopMaterial::where('wo_id', $id)->delete();
        }
        $work_order = WorkOrder::findOrFail($id);
        $work_order->status = '0';
        $work_order->save();

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data deleted'), 'load' => true]);
    }


    public function product(Request $request)
    {
        $models = WorkOrder::with('workOrderProduct')->where('id',$request->id)->first();
        $data = [];
        $product_id_array = [];
        // find the work Order product
        $workOrderproduct = WorkOrderProduct::where('workorder_id', $models->id)->groupBy('product_id')->get();
        if($workOrderproduct) {
            foreach($workOrderproduct as $item) {
                $product_id_array[] = $item->product_id;
            }
        }

        $product_materials = ProductMaterial::whereIn('product_id', $product_id_array)->groupBy('material_id')->get();
        if($product_materials) {
            foreach ($product_materials as $product_material) {
                $product_id = $product_material->product_id;
                $material_id = $product_material->material_id;
                $work_order_id = $request->id;
                $workorder_product_qty = WorkOrderProduct::where('workorder_id', $work_order_id)->where('product_id', $product_id)->sum('qty');


                $price = $product_material->material->price;
                $qty = ProductMaterial::where('material_id', $material_id)->sum('qty') * $workorder_product_qty;
                $total = $price * $qty;

                $data[] = [
                    'material_id' => $product_material->material_id,
                    'material_name' => $product_material->material->name,
                    'price' => $product_material->material->price,
                    'qty' => $qty,
                    'unit' => $product_material->material->unit->unit,
                    'total' => $total
                ];
            }
        }

        return view('admin.production.wop-materials.new_product', compact('models','data'));
        // return view('admin.production.wop-materials.product', compact('models'));
    }
}
