<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\models\Production\Brand;
use App\models\Production\Category;
use App\models\Production\Product;
use App\models\Production\Variation;
use App\models\Production\VariationBrandDetails;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->can('production_product.view')) {
            abort(403, 'Unauthorized action.');
        }
        if ($request->ajax()) {
            $brand_id = $request->get('brand_id')?:get_option('default_brand');
            $term = $request->get('term');

            $check_qty = false;

        $products = Product::leftJoin(
            'variations',
            'products.id',
            '=',
            'variations.product_id'
        )
        ->leftjoin('variation_brand_details AS VBD',
             function ($join) use ($brand_id) {
                $join->on('variations.id', '=', 'VBD.variation_id');
                     //Include Location
                                if (!empty($brand_id)) {
                                    $join->where(function ($query) use ($brand_id) {
                                        $query->where('VBD.brand_id', '=', $brand_id);
                                        //Check null to show products even if no quantity is available in a location.
                                        //TODO: Maybe add a settings to show product not available at a location or not.
                                        $query->orWhereNull('VBD.brand_id');
                                    });
                                    ;
                                }
          });
        if (!empty($term)) {
        $products->where(function ($query) use ($term) {
            $query->where('products.name', 'like', '%' . $term . '%');
            $query->orWhere('articel', 'like', '%' . $term . '%');
            $query->orWhere('prefix', 'like', '%' . $term . '%');
            $query->orWhere('sub_sku', 'like', '%' . $term . '%');

        });
        }
        if (!empty($brand_id)) {
            $products->where('VBD.brand_id', $brand_id);
        }
          $category_id = request()->get('category_id', null);
            if (!empty($category_id)) {
                $products->where('products.category_id', $category_id);
            }
            if (!auth()->user()->hasRole('Super Admin')) {
                $products->where('variations.hidden',false);
            }
           $products = $products->select(
                'products.id as product_id',
                'products.name as pro_name',
                'variations.id as variation_id',
                'variations.name as variation',
                'VBD.qty_available as qty',
                'VBD.retail_qty as retail_qty',
                'variations.default_sell_price as selling_price',
                'variations.retail_sell_price as retail_sell_price',
                'variations.sub_sku as sku',
                'VBD.brand_id as brand_id',
                'products.photo as image'
            );
            $document = $products
                        ->get();
                 return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('product_name', function ($document) {
                    return $document->pro_name.'_'.$document->variation;
                })
                ->editColumn('variation', function ($document) {
                    return $document->variation? $document->variation : null;
                })
                ->editColumn('f_sku', function ($document) {
                    return $document->sku;

                })
                 ->editColumn('f_qty', function ($document) {
                     return $document->qty;

                })
                 ->editColumn('selling_price', function ($document) {
                    return $document->selling_price;

                })

               ->rawColumns(['product_name','f_sku','f_qty','selling_price'])->make(true);
         }
         $brands=Brand::pluck('name', 'id');
         $categories=Category::pluck('name', 'id');
         return view('admin.stock.index',compact('brands','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.stock.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
            $query = VariationBrandDetails::find($request->variation_brand_id[$i]);
            if($query) {
                $query->qty_available = $avaiable_qty - $stock_qty;
                $query->retail_qty = $query->retail_qty+$stock_qty;
                $query->save();
            } else {
                $data = $product . ' - '. $variation. ' is not a valid Product';
                return response()->json(['status'=>true, 'status' => 'danger', 'message' => $data ]);
            }


        };

        return response()->json(['status'=>true, 'status' => 'success', 'message' => 'Stock is Successfully Uploaded!','goto' => route('admin.product_stock.index') ]);
    }


    public function whole_stock()
    {
        return view('admin.stock.whole_stock');
    }


    public function wholsale_stock_post(Request $request)
    {
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
            $query = VariationBrandDetails::find($request->variation_brand_id[$i]);
            if($query) {
                $query->retail_qty = $query->retail_qty - $stock_qty;
                $query->qty_available = $query->qty_available+$stock_qty;
                $query->save();
            } else {
                $data = $product . ' - '. $variation. ' is not a valid Product';
                return response()->json(['status'=>true, 'status' => 'danger', 'message' => $data ]);
            }


        };

        return response()->json(['status'=>true, 'status' => 'success', 'message' => 'Stock is Successfully Uploaded!','goto' => route('admin.product_stock.index') ]);
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


   public function retail_stock(Request $request)
    {
        $row =$request->row;
        $quantity =$request->quantity;
        $data = Variation::join('products AS p', 'variations.product_id', '=', 'p.id')
            ->join('product_variations AS pv', 'variations.product_variation_id', '=', 'pv.id')
            ->leftjoin('variation_brand_details AS vbd', 'variations.id', '=', 'vbd.variation_id')
            ->where('variations.id', $request->variation_id)
            ->select( 'p.id as product_id',
                    'p.name as product_name',
                    'p.category_id',
                    'vbd.qty_available',
                    'vbd.id as id',
                    'variations.default_sell_price as selling_price',
                    'variations.id as variation_id',
                    'vbd.brand_id as brand_id',
                    'variations.sub_sku as sku',
                    'variations.name as vari_name'
                )
            ->first();
        

        return view('admin.stock.retail_stock',compact('data','quantity','row'));
    }

    public function wholsale_stock(Request $request)
    {
        $row =$request->row;
        $quantity =$request->quantity;
        $data = Variation::join('products AS p', 'variations.product_id', '=', 'p.id')
            ->join('product_variations AS pv', 'variations.product_variation_id', '=', 'pv.id')
            ->leftjoin('variation_brand_details AS vbd', 'variations.id', '=', 'vbd.variation_id')
            ->where('variations.id', $request->variation_id)
            ->select( 'p.id as product_id',
                    'p.name as product_name',
                    'p.category_id',
                    'vbd.retail_qty as qty_available',
                    'vbd.id as id',
                    'variations.default_sell_price as selling_price',
                    'variations.id as variation_id',
                    'vbd.brand_id as brand_id',
                    'variations.sub_sku as sku',
                    'variations.name as vari_name'
                )
            ->first();

        return view('admin.stock.retail_stock',compact('data','quantity','row'));
    }
}
