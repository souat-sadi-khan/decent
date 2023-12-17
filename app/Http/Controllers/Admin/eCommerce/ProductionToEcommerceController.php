<?php

namespace App\Http\Controllers\Admin\eCommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\eCommerce\EcommerceProduct;
use App\models\Production\Product;
use App\models\Production\VariationBrandDetails;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class ProductionToEcommerceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('ecommerce_stock.view')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.eCommerce.production-to-ecommerce.index');
    }

    // datatable
    public function datatable(Request $request){
        if ($request->ajax()) {
             $document = EcommerceProduct::all();
             return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('product', function ($model) {
                    return $model->product ? $model->product->name : 'No Product Found';
                })
                ->editColumn('variation', function ($model) {
                    return $model->variation ? $model->variation->name : 'No Variation Found';
                })
                ->editColumn('price', function ($model) {
                    return $model->price;
                })
                ->editColumn('date', function ($model) {
                    return formatDate($model->created_at);
                })
                ->rawColumns(['product', 'variation', 'price', 'date'])->make(true);
         }
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('ecommerce_stock.view')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.eCommerce.production-to-ecommerce.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!auth()->user()->can('ecommerce_stock.view')) {
            abort(403, 'Unauthorized action.');
        }

        if(!is_array($request->product_id)) {
            return response()->json(['status'=>true, 'status' => 'danger', 'message' => "Please Select Product First" ]); 
        }

        $request->validate([
            'variation_id' => 'required',
            'product_id' => 'required',
            'variation' => 'required',
            'product' => 'required',
            'avaiable_qty' => 'required',
            'stock_qty' => 'required',
            'price' => 'required|numeric',
        ]);

        for ($i = 0; $i < count($request->product_id); $i++) {
            $variation_id = $request->variation_id[$i];
            $product_id = $request->product_id[$i];
            $variation = $request->variation[$i];
            $product = $request->product[$i];
            $avaiable_qty = $request->avaiable_qty[$i];
            $stock_qty = $request->stock_qty[$i];
            $price = $request->price[$i];

            // check the stock transfer qty is not greater then avaiable qty
            if($avaiable_qty < $stock_qty) {
                $data = $product . ' - '. $variation. ' Pass quantity is greater then available quantity!';
                return response()->json(['status'=>true, 'status' => 'danger', 'message' => $data ]); 
            }

            // update main variation quantity
            $query = VariationBrandDetails::where('product_id', $product_id)->where('variation_id', $variation_id)->first();
            if($query) {
                $query->qty_available = $avaiable_qty - $stock_qty;
                $product_variation_id = $query->product_variation_id;
                $query->save();
            } else {
                $data = $product . ' - '. $variation. ' is not a valid Product';
                return response()->json(['status'=>true, 'status' => 'danger', 'message' => $data ]); 
            }

            // store the ecommerce quantity\
            $model = new EcommerceProduct;
            $model->product_id = $product_id;
            $model->product_variation_id = $product_variation_id;
            $model->variation_id = $variation_id;
            $model->quantity = $stock_qty;
            $model->price = $price;
            $model->save();

        };

        return response()->json(['status'=>true, 'status' => 'success', 'message' => 'Stock is Successfully Uploaded!', 'goto' => route('admin.eCommerce.production-to-ecommerce.index') ]); 

    }

    // reverse_show
    public function reverse_show() {
        if (!auth()->user()->can('ecommerce_stock.view')) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.eCommerce.production-to-ecommerce.reverse');
    }

    public function product_list(Request $request)
    {
        if (!auth()->user()->can('ecommerce_stock.view')) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->ajax()) {
            $brand_id = $request->get('brand_id')?:get_option('default_brand');
            $check_qty = false;
 
            $products = Product::leftJoin(
                'variations',
                'products.id',
                '=',
                'variations.product_id'
            )
         
            ->leftjoin('ecommerce_products AS VBD',
                function ($join) use ($brand_id) {
                    $join->on('variations.id', '=', 'VBD.variation_id');
                      //Include Location
                    // if (!empty($brand_id)) {
                    //     $join->where(function ($query) use ($brand_id) {
                    //         $query->where('VBD.brand_id', '=', $brand_id);
                    //         //Check null to show products even if no quantity is available in a location.
                    //         //TODO: Maybe add a settings to show product not available at a location or not.
                    //         // $query->orWhereNull('VBD.brand_id');
                    //     });
                    //     ;
                    // }
            });

            $products = $products->select(
                 'products.id as product_id',
                 'products.name',
                 'variations.id as variation_id',
                 'variations.name as variation',
                 'VBD.quantity as qty',
                 'VBD.id as ecommerce_id',
                 'variations.default_sell_price as selling_price',
                 'variations.sub_sku as sku',
                 'products.photo as image'
             );
             
            $result = $products->orderBy('VBD.quantity', 'desc')->get();
             
            return json_encode($result);
        }
    }

    public function scannerappend1(Request $request)
    {

        if (!auth()->user()->can('ecommerce_stock.view')) {
            abort(403, 'Unauthorized action.');
        }
        // dd($request->all());
        $row =$request->row;
        $action = '';
        $quantity =$request->quantity;
        $data = EcommerceProduct::join('products AS p', 'product_id', '=', 'p.id')
            ->join('variations AS pv', 'pv.id', '=', 'variation_id')
            
            ->where('ecommerce_products.id', $request->ecommerce_id)
            ->select( 'p.id as product_id',
            'ecommerce_products.id as e_pid',
            'ecommerce_products.quantity as qty_available',
                    'p.name as product_name',
                    // 'p.quantity',
                    // 'variations.default_sell_price as selling_price',
                    'pv.id as variation_id',
                    // 'vbd.brand_id as brand_id',
                    'pv.sub_sku as sku',
                    'pv.name as vari_name'
                )
            ->first();

            return view('admin.eCommerce.production-to-ecommerce.itemlist',compact('data','quantity','row', 'action'));
    }

    // store_reverse
    public function store_reverse(Request $request) {
        if (!auth()->user()->can('ecommerce_stock.view')) {
            abort(403, 'Unauthorized action.');
        }
        if(!is_array($request->product_id)) {
            return response()->json(['status'=>true, 'status' => 'danger', 'message' => "Please Select Product First" ]); 
        }
        
        // dd($request->all());

        $request->validate([
            'variation_id' => 'required',
            'product_id' => 'required',
            'variation' => 'required',
            'product' => 'required',
            'avaiable_qty' => 'required',
            'stock_qty' => 'required',
        ]);

        for ($i = 0; $i < count($request->product_id); $i++) {
            $variation_id = $request->variation_id[$i];
            $product_id = $request->product_id[$i];
            $variation = $request->variation[$i];
            $product = $request->product[$i];
            $avaiable_qty = $request->avaiable_qty[$i];
            $stock_qty = $request->stock_qty[$i];

            // check the stock transfer qty is not greater then avaiable qty
            if($avaiable_qty < $stock_qty) {
                $data = $product . ' - '. $variation. ' Pass quantity is greater then available quantity!';
                return response()->json(['status'=>true, 'status' => 'danger', 'message' => $data ]); 
            }

            // update main variation quantity
            $query = VariationBrandDetails::where('product_id', $product_id)->where('variation_id', $variation_id)->first();
            if($query) {
                $query->qty_available = $query->qty_available + $stock_qty;
                $query->save();
            } else {
                $data = $product . ' - '. $variation. ' is not a valid Product';
                return response()->json(['status'=>true, 'status' => 'danger', 'message' => $data ]); 
            }

            // store the ecommerce quantity\
            $model = EcommerceProduct::where('id', $request->ecom_id[$i])->first();
            $model->quantity = $avaiable_qty - $stock_qty;
            $model->save();

        };

        return response()->json(['status'=>true, 'status' => 'success', 'message' => 'Stock is Successfully Uploaded!', 'goto' => route('admin.eCommerce.production-to-ecommerce.index') ]); 

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}