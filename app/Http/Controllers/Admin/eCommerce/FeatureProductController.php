<?php

namespace App\Http\Controllers\admin\eCommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\eCommerce\EcommerceProduct;
use App\models\Production\Product;
use App\models\Production\Variation;
use Yajra\DataTables\DataTables;

class FeatureProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('ecommerce_featured_product.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.eCommerce.feature.index');
    }

    //datatable
    public function datatable(Request $request){
        if ($request->ajax()) {
            $document = Product::where('feature_product_status',1)->get();
            return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('photo', function ($model) {
                    if($model->photo != NULL) {
                        $url= asset('storage/product/'.$model->photo);
                    } else {
                        $url = asset('img/product.jpg');
                    }
                    return '<img width="100px;" src="'.($model->photo != NULL ? $url : $url).'" alt="Image of Product">';
                })
                ->editColumn('category', function ($model) {
                    return $model->category->name;
                })
                ->editColumn('code', function ($model) {
                    return $model->prefix . ''. $model->code;
                })
                ->editColumn('price', function ($model) {
                    $find_price =  Variation::where('product_id', $model->id)->get();
                    if(count($find_price) > 0) {
                        $total_product_variation = count($find_price);
                        $price = 0;
                        foreach($find_price as $row) {
                            $default_price = $row['default_sell_price'];
                            $price = $price + $default_price;
                        }
                
                        $per_product_price = round($price / $total_product_variation) ; 
                    } else {
                        $per_product_price = '';
                    }

                    return '৳'. $per_product_price;
                })
                ->rawColumns(['category', 'price', 'name', 'photo'])->make(true);
        }
    }
  

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('ecommerce_featured_product.create')) {
            abort(403, 'Unauthorized action.');
        }
        $product_id = [];
        $product = EcommerceProduct::all();
        
        foreach ($product as $value) {
            $product_id[] = $value->product_id;
        }

        $products = Product::whereIn('id', $product_id)->orderBy('avarage_retting', 'DESC')->get();
        return view('admin.eCommerce.feature.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        if (!auth()->user()->can('ecommerce_featured_product.create')) {
            abort(403, 'Unauthorized action.');
        }
        $id = $request->id;

        $check = Product::findOrFail($id);
        
        if($check->feature_product_status == 1) {
            $status = null;
        } else {
            $status = 1;
        }

        $check->feature_product_status = $status;
        $check->save();

        return response()->json(['success' => true, 'load' => true, 'status' => 'success', 'message' => _lang('Feature Product Status is Successfully Changed')]);
    }
}
