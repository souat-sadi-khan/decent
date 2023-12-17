<?php

namespace App\Http\Controllers\Admin\eCommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\eCommerce\SpecialOffer;
use App\models\eCommerce\SpecialOfferItem;
use App\models\Production\Product;
use App\models\Production\ProductPhoto;
use App\models\Production\Variation;
use App\models\Production\VariationBrandDetails;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class SpecialOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('ecommerce_special_offer.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.eCommerce.special-offer.index');
    }

        //datatable
        public function datatable(Request $request){
            if ($request->ajax()) {
                $document = SpecialOffer::all();
                return DataTables::of($document)
                    ->addIndexColumn()
                    ->editColumn('photo', function ($model) {
                        if($model->cover_image != NULL) {
                            $url= asset('storage/eCommerce/special_offer/'.$model->cover_image);
                        } else {
                            $url = asset('img/product.jpg');
                        }
                        return '<img width="100px;" src="'.($model->photo != NULL ? $url : $url).'" alt="Image of Product">';
                    })
                    ->editColumn('product', function ($model) {
                        return SpecialOfferItem::where('special_offer_id', $model->id)->count();
                        // return $model->category->name;
                    })
                    ->editColumn('action', function ($model) {
                        return view('admin.eCommerce.special-offer.action', compact('model'));
                    })
                    ->rawColumns(['photo', 'product', 'action'])->make(true);
            }
        }
      

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        if (!auth()->user()->can('ecommerce_special_offer.create')) {
            abort(403, 'Unauthorized action.');
        }
    $brand_id = get_option('default_brand');       
    $brand_id = $request->get('brand_id')?:get_option('default_brand');
    $term = $request->get('term');
    $check_qty = false;
    $products = Product::leftJoin(
        'variations',
        'products.id',
        '=',
        'variations.product_id'
    )
    ->join('product_photos','product_photos.product_id', '=', 'products.id')
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

       $products = $products->select(
            'products.id as product_id',
            'products.name as pro_name',
            'variations.id as variation_id',
            'variations.name as variation',
            'VBD.qty_available as qty',
            'variations.default_sell_price as selling_price',
            'variations.sub_sku as sku',
            'VBD.brand_id as brand_id',
            'products.photo as image',
            'product_photos.photo as photo'
        );
        $document = $products->orderBy('VBD.qty_available', 'desc')->groupBy('variations.id')
        ->get();
    //    dd($document);
        // $products = Product::whereIn('id', $product_id)->orderBy('avarage_retting', 'DESC')->take(3)->get();

        return view('admin.eCommerce.special-offer.create', compact('document'));
    }

    // add_to_special_offer_row
    public function add_to_special_offer_row(Request $request) {

        $row = $request->row;
        $product_info = $request->product_id;
        
        $exp = explode(' ', $product_info);

        $product_id = $exp[0];
        $variation_id = $exp[1];

        $product = Product::where('id', $product_id)->first();

        $variation = Variation::where('id', $variation_id)->first();

        $photo = ProductPhoto::select('photo')->where('product_id', $product_id)->first();
        if($photo) {
            $photo = $photo->photo;
        } else {
            $photo = '';
        }
        return view('admin.eCommerce.special-offer.add_product', compact('row', 'variation', 'product', 'photo'));
    }

    public function slug($old_slug, $row = Null)
    {
        if(!$row){
            $slug = $old_slug;
            $row = 0;
        }else{
            $slug = $old_slug . '-'.$row;
        }

        $check_res = SpecialOffer::where('offer_slug', $slug)->first();
        if($check_res) {
            $slug = $this->slug($old_slug, $row+1);
        }

        return $slug;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        if (!auth()->user()->can('ecommerce_special_offer.create')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'name' => 'required|string',
            'sub_heading' => 'required|string',
            'status' => 'required',
            'cover_iamge' => 'required',
        ]);

        if($request->status == 1) {
            $check = SpecialOffer::where('status', 1)->count();
            if($check >= 2) {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => 'Maximum 2 Active Status is Required']);
            }
        } 

        $slug = $this->slug(make_slug($request->name));


        $model = new SpecialOffer;
        $model->name = $request->name;
        $model->offer_slug = $slug;
        $model->sub_heading = $request->sub_heading;
        $model->status = $request->status;

        if($request->hasFile('cover_iamge')) {
            $data = getimagesize($request->file('cover_iamge'));
            $width = $data[0];
            $height = $data[0];

            if($width > 415 && $height > 225) {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => 'Offer Image Width and height is wrong']);
            }


            $storagepath = $request->file('cover_iamge')->store('public/eCommerce/special_offer/');
            $fileName = basename($storagepath);

            $model->cover_image = $fileName;

            //if file chnage then delete old one
            // $oldFile = $request->oldFile;
            // if( $oldFile != ''){

            //     $file_path = "public/user/photo/".$oldFile;
            //     Storage::delete($file_path);
            // }
        }

        $model->save();

        for($i = 0; $i < count($request->product_id); $i++) {
            $product_id = $request->product_id[$i];
            $variation_id = $request->variation_id[$i];
            $discount_type = $request->discount_type[$i];
            $discount = $request->discount[$i];
            $price_with_dis = $request->price_with_dis[$i];
            $price_without_dis = $request->price_without_dis[$i];

            $item = new SpecialOfferItem;
            $item->special_offer_id = $model->id;
            $item->variation_id = $variation_id;
            $item->product_id = $product_id;
            $item->discount_type = $discount_type;
            $item->discount_amount = $discount;
            $item->price_without_dis = $price_without_dis;
            $item->price_with_dis = $price_with_dis;
            $item->save();
        }
        return response()->json(['success' => true, 'status' => 'success', 'message' => 'Special Offer is Successfully Created']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('ecommerce_special_offer.view')) {
            abort(403, 'Unauthorized action.');
        }
        $model = SpecialOffer::findOrFail($id);

        $items = SpecialOfferItem::where('special_offer_id', $id)->get();

        return view('admin.eCommerce.special-offer.view', compact('model', 'items'));
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
        if (!auth()->user()->can('ecommerce_special_offer.delete')) {
            abort(403, 'Unauthorized action.');
        }
        $model = SpecialOffer::findOrFail($id);
        $model->delete();

        $items = SpecialOfferItem::where('special_offer_id', $id)->get();
        if(count($items)) {
            foreach($items as $item) {
                $item->delete();
            }
        }
        return response()->json(['success' => true, 'status' => 'success', 'message' => 'Special Offer is Successfully Deleted']);
    }
}
