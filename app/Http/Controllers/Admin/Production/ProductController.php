<?php

namespace App\Http\Controllers\Admin\Production;

use App\Http\Controllers\Controller;
use App\models\Production\Brand;
use App\models\Production\Category;
use App\models\Production\Product;
use App\models\Production\ProductMaterial;
use App\models\Production\ProductPhoto;
use App\models\Production\ProductVariation;
use App\models\Production\RawMaterial;
use App\models\Production\Unit;
use App\models\Production\Variation;
use App\models\Production\VariationTemplate;
use App\models\Production\VariationTemplateDetails;
use App\models\depertment\ProductFlow;
use App\models\inventory\TransactionSellLine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (!auth()->user()->can('production_product.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.production.product.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $document = Product::where('name', '!=', config('system.default_role.admin'))->get();
            return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('code', function ($document) {
                    return $document->prefix . numer_padding($document->code, get_option('digits_production_code'));
                })
                ->editColumn('category_id', function ($document) {
                    return $document->category? $document->category->name : null;
                })
                ->editColumn('sub_category_id', function ($document) {
                    return $document->sub_category ? $document->sub_category->name : '';

                })
                ->editColumn('status', function ($document) {
                    if ($document->status == 'Sample') {
                        return '<a data-url="'.route('admin.get_product.status',$document->id).'" class="btn_modal" style="cursor:pointer"><span class="badge badge-success">' . 'Sample' . '</span></a>';
                    } else if ($document->status == 'Production') {
                        return '<a data-url="'.route('admin.get_product.status',$document->id).'" class="btn_modal" style="cursor:pointer"><span class="badge badge-danger">' . 'Production' . '</span></a>';
                    }
                })
                ->addColumn('action', function ($model) {
                    return view('admin.production.product.action', compact('model'));
                })->rawColumns(['action', 'status'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (!auth()->user()->can('production_product.create')) {
            abort(403, 'Unauthorized action.');
        }
        $categorys = Category::where('parent_id', 0)->select('id', 'name')->get();
        $models = RawMaterial::all();
        $code_prefix = get_option('production_code_prefix');
        $code_digits = get_option('digits_production_code', 1);
        $uniqu_id = generate_id('product', false);
        $uniqu_id = numer_padding($uniqu_id, $code_digits);

        // retrurn the employee create page
        return view('admin.production.product.create', compact('models', "categorys", "code_prefix", "uniqu_id"));
    }

    public function slug($old_slug, $row = Null)
    {
        if(!$row){
            $slug = $old_slug;
            $row = 0;
        }else{
            $slug = $old_slug . '-'.$row;
        }

        $check_res = Product::where('product_slug', $slug)->first();
        if($check_res) {
            $slug = $this->slug($old_slug, $row+1);
        }

        return $slug;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('production_product.create')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'catagory_id' => 'required',
            'status' => 'required',
            'photo' => 'mimes:jpeg,jpg,png | max:2000',
        ]);


        $uuid = Str::uuid()->toString();
        if ($request->articel) {
            $articel = $request->articel;
        } else {
            $articel = 'articel';
        }

        $product = new Product;

        $slug = $this->slug(make_slug($request->name));
        $product->product_slug = $slug;

        if ($request->hasFile('photo')) {
            $storagepath = $request->file('photo')->store('public/product');
            $fileName = basename($storagepath);
            $product->photo = $fileName;
        } else {
            $product->photo = '';
        }

        $product->uuid = $uuid;
        $product->code = $request->code;
        $product->prefix = $request->prefix;
        $product->articel = $articel;
        $product->name = $request->name;
        $product->category_id = $request->catagory_id;
        $product->sub_category_id = $request->sub_category;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->created_by = auth()->user()->id;
        $product->save();
        $id = $product->id;


        if($request->raw_material != '') {
            for ($i = 0; $i < count($request->raw_material); $i++) {
                $purchase = new ProductMaterial;
                $purchase->product_id = $id;
                $purchase->material_id = $request->raw_material[$i];
                $purchase->qty = $request->qty[$i];
                $purchase->price = $request->price[$i];
                $purchase->unit_price = $request->unit_price[$i];
                $purchase->waste = $request->waste[$i];
                $purchase->uses = $request->uses[$i];
                $purchase->status = $request->raw_status[$i];
                $purchase->description = $request->raw_description[$i];
                $purchase->unit_id = $request->unit[$i];
                $purchase->created_by = auth()->user()->id;
                $purchase->save();
            }
        }
    
        generate_id("product", true);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'goto' => route('admin.production-product.variation', $id)]);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('production_product.view')) {
            abort(403, 'Unauthorized action.');
        }
        $product = Product::with('material')->findOrFail($id);
        return view('admin.production.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('production_product.update')) {
            abort(403, 'Unauthorized action.');
        }
        $product = Product::with('material')->findOrFail($id);
        // dd($product);
        $categorys = Category::where('parent_id', 0)->select('id', 'name')->get();
        $models = RawMaterial::all();
        $code_prefix = get_option('production_code_prefix');
        $code_digits = get_option('digits_production_code');
        $uniqu_id = generate_id('employee', false);
        $uniqu_id = numer_padding($uniqu_id, $code_digits);

        // retrurn the employee create page
        return view('admin.production.product.edit', compact('product', 'models', "categorys"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('production_product.update')) {
            abort(403, 'Unauthorized action.');
        }
        if ($request->articel) {
            $articel = $request->articel;
        } else {
            $articel = 'articel';
        }

        $old_photo = '';
        $old_photo = $request->old_photo;

        $product = Product::findOrFail($id);

        if ($request->hasFile('photo')) {
            if ($product->photo) {
                $image_path = public_path() . '/storage/product/' . $product->photo;
                unlink($image_path);
            }
            $storagepath = $request->file('photo')->store('public/product');
            $fileName = basename($storagepath);
            $product->photo = $fileName;
        } else {
            $product->photo = $old_photo;
        }

        $product->articel = $articel;
        $product->name = $request->name;
        $product->category_id = $request->catagory_id;
        $product->sub_category_id = $request->sub_category;
        $product->description = $request->description;
        $product->status = $request->status;
        $product->updated_by = auth()->user()->id;
        $product->save();
        $id = $product->id;

        if ($id) {
            $type = ProductMaterial::where('product_id', $id)->delete();
        }

        for ($i = 0; $i < count($request->raw_material); $i++) {
            $purchase = new ProductMaterial;
            $purchase->product_id = $id;
            $purchase->material_id = $request->raw_material[$i];
            $purchase->qty = $request->qty[$i];
            $purchase->price = $request->price[$i];
            $purchase->unit_price = $request->unit_price[$i];
            $purchase->waste = $request->waste[$i];
            $purchase->uses = $request->uses[$i];
            $purchase->status = $request->raw_status[$i];
            $purchase->description = $request->raw_description[$i];
            $purchase->unit_id = $request->unit[$i];
            $purchase->updated_by = auth()->user()->id;
            $purchase->save();
        }

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated'), 'goto' => route('admin.production-product.index')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('production_product.delete')) {
            abort(403, 'Unauthorized action.');
        }
        $count1 =ProductFlow::where('product_id',$id)->count();
        $count2 =TransactionSellLine::where('product_id',$id)->count();
        if ($count1 ==0 && $count2==0) {
            $type = Product::findOrFail($id);
            $name = $type->name;

            if ($type->photo) {
                $image_path = public_path() . '/storage/product/' . $type->photo;
                unlink($image_path);
            }

            $type->delete();

            // Activity Log
            activity()->log('Delete a Production Product - ' . $name);

            return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted Successfully'), 'goto' => route('admin.production-product.index')]);
        }else{
            throw ValidationException::withMessages(['message' => _lang('Do not delete Because this Product is already Order/in Process')]);
        }
    }

    public function category(Request $request)
    {
        $data = Category::where('parent_id', $request->id)->select('id', 'name')->get();

        // retrurn the employee create page
        return response()->json($data);
    }


    public function get_product(Request $request, $id)
    {
        $product = RawMaterial::with('unit')->find($id);
        return response()->json($product);
    }

    public function product_add(Request $request)
    {

        $product = $request->product;
        $unit = $request->unit;
        $unit_price = $request->unit_price;
        $quantity = $request->quantity;
        $Price = $request->grossPrice;
        $waste = $request->waste;
        $uses = $request->uses;
        $status = $request->raw_status;
        $description = $request->raw_description;

        $unit_query = Unit::where('id', $unit)->first();
        if($unit_query) {
            $unit_name = $unit_query->unit;
        } else {
            $unit_name = '';
        }

        $model = RawMaterial::find($product);
        return view('admin.production.product.include.itemlist', compact('unit', 'unit_price', 'model', 'quantity', 'Price', 'waste', 'uses', 'status', 'description', 'unit_name'));
    }

    public function show_variation_form($id)
    {
        return view('admin.production.product.variation', compact('id'));
    }

    public function variation_show($id)
    {
        $product = product::with('product_variation')->findOrFail($id);
        // dd($product);
        return view('admin.production.product.variation-show',compact('product'));
    }

    public function variation_add_more($id)
    {
        $product = product::with('product_variation')->findOrFail($id);
        return view('admin.production.product.add-variation',compact('product'));
    }

    public function variation_add($id)
    {
        if (!auth()->user()->can('production_product.create')) {
            abort(403, 'Unauthorized action.');
        }
        $row = request()->row;
        $model = Product::findOrFail($id);
        $variations = VariationTemplate::all();
        return view('admin.production.product.include.add_variation', compact('model', 'variations', 'row'));
    }

    public function variation_store(Request $request)
    {
        if (!auth()->user()->can('production_product.create')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            // 'variation_value_id' => 'required',
        ]);
        $product_id = $request->product_id;
        $variations = $request->variation;
        $pv = $variations['varitaion_template_id'];
        $sub_sku = $variations['sub_sku'];
        $purchase_price = $variations['default_purchase_price'];
        $sell_price = $variations['default_sell_price'];
        $variation_value = $variations['variation_value_id'];

        // ProductVariation Insert
        $product_variations = new ProductVariation;
        $product_variations->variation_template_id = $pv[0];
        $product_variations->variation_template_id_2 = $pv[1];
        $product_variations->product_id = $product_id;
        $product_variations->is_dummy = '0';
        $product_variations->save();
        $id = $product_variations->id;

        // dd($pv[0]);


        for ($i = 0; $i < count($sub_sku); $i++) {
            $variation = new Variation();
            $variation->product_variation_id = $id;
            $variation->product_id = $product_id;
            $variation->sub_sku = $sub_sku[$i];
            $variation->default_purchase_price = $purchase_price[$i];
            $variation->default_sell_price = $sell_price[$i];

            $variation->variation_value_id =  $variation_value[$i][0];
            $variation->variation_value_id_2 =  $variation_value[$i][1];

            $name1 = VariationTemplateDetails::where('id', $variation_value[$i][0])->where('variation_template_id', $pv[0])->first();
            $name2 = VariationTemplateDetails::where('id', $variation_value[$i][1])->where('variation_template_id', $pv[1])->first();

            $name = $name1->name.'-'. $name2->name;
            $variation->name = $name;

            $variation->save();
        }

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'),'load'=>true]);
    }


    public function variation_store_more(Request $request)
    {
        if (!auth()->user()->can('production_product.create')) {
            abort(403, 'Unauthorized action.');
        }
        $product_id = $request->product_id;
        $variations = $request->variation;
        $pv = $variations['varitaion_template_id'];
        $sub_sku = $variations['sub_sku'];
        $purchase_price = $variations['default_purchase_price'];
        $sell_price = $variations['default_sell_price'];
        $variation_value = $variations['variation_value_id'];
        $id = $request->product_variation_id;

        for ($i = 0; $i < count($sub_sku); $i++) {
            $variation = new Variation();
            $variation->product_variation_id = $id;
            $variation->product_id = $product_id;
            $variation->sub_sku = $sub_sku[$i];
            $variation->default_purchase_price = $purchase_price[$i];
            $variation->default_sell_price = $sell_price[$i];

            if ($variation_value[$i][0] == Null) {
                throw ValidationException::withMessages(['message' => 'Color Field Is Required']);
            }elseif($variation_value[$i][1] == Null){
                throw ValidationException::withMessages(['message' => 'Size Field Is Required']);
            }else{
                $variation->variation_value_id =  $variation_value[$i][0];
                $variation->variation_value_id_2 =  $variation_value[$i][1];
            }

            $name1 = VariationTemplateDetails::where('id', $variation_value[$i][0])->where('variation_template_id', $pv[0])->first();
            $name2 = VariationTemplateDetails::where('id', $variation_value[$i][1])->where('variation_template_id', $pv[1])->first();

            $name = $name1->name.'-'. $name2->name;
            $variation->name = $name;

            $valid =  Variation::where('name', $name)->where('product_id', $product_id)->where('product_variation_id', $id)->first();

            if($valid){
                throw ValidationException::withMessages(['message' => '('.$name.') '. ' Variation Already Exist']);
            }else{
                $variation->save();
            }
        }

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'),'load'=>true]);
    }



    public function details_add($id)
    {
        $model =Product::findOrFail($id);
        return view('admin.production.product.details-add',compact('id','model'));
    }

    public function details_store(Request $request, $id)
    {
        $request->validate([
            'short_description' => 'required',
            'product_description' => 'required',
            // 'photo' => 'mimes:jpeg,jpg,png | max:2000 | required',
        ]);

        $model = Product::findOrFail($id);

        $model->short_description = $request->short_description;
        $model->information = $request->information;
        $model->product_description = $request->product_description;
        $model->seo_title = $request->seo_title;
        $model->title = $request->title;
        $model->keyword = $request->keyword;
        $model->meta_description = $request->meta_description;
        $model->updated_by = auth()->user()->id;

        $delete =ProductPhoto::where('product_id',$id)->delete();
        for ($i = 0; $i < count($request->hidden_value); $i++) {

            $photo = new ProductPhoto();

           if ($request->hasFile('photo')) {
            if(isset($request->file('photo')[$i])){
                if (isset($request->old_photo[$i])) {
                   $image_path = public_path() . '/storage/product/' . $request->old_photo[$i];
                    unlink($image_path);
                }
                $storagepath = $request->file('photo')[$i]->store('public/product');
                $fileName = basename($storagepath);
                $photo->photo = $fileName;
                } else{
                    $photo->photo = $request->old_photo[$i];
                }
            
            } else {
                $photo->photo = $request->old_photo[$i];
            }
            $photo->product_id = $id;
            $photo->save();
        }
         $model->save();

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated'), 'goto' => route('admin.production-product.index')]);

    }
   

   public function product_list(Request $request)
   {
        if ($request->ajax()) {
            $brand_id = $request->get('brand_id')?:get_option('default_brand');
            $term = $request->get('term');
            $sale_type = $request->get('sale_type');

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
            $query->orWhere('variations.name', 'like', '%' . $term . '%');
            // $query->orWhere('variation_brand_details.name', 'like', '%' . $term . '%');
           
        });
        }
         if (!auth()->user()->hasRole('Super Admin')) {
                $products->where('variations.hidden',false);
            }

             $products->where(function ($query) use ($brand_id) {
                    $query->where('VBD.brand_id', $brand_id);
                    
                });
            if ($sale_type=='wholesale' || $sale_type==null) {
             $products = $products->select(
                'products.id as product_id',
                'products.name',
                'variations.id as variation_id',
                'variations.name as variation',
                'VBD.qty_available as qty',
                'variations.default_sell_price as selling_price',
                'variations.sub_sku as sku',
                'VBD.brand_id as brand_id',
                'products.photo as image'
              );
              $result = $products->orderBy('VBD.qty_available', 'desc')
                        ->get();
             }else{
                $products = $products->select(
                'products.id as product_id',
                'products.name',
                'variations.id as variation_id',
                'variations.name as variation',
                'vbd.retail_qty as qty',
                'variations.retail_sell_price as selling_price',
                'variations.sub_sku as sku',
                'VBD.brand_id as brand_id',
                'products.photo as image'
               );
               $result = $products->orderBy('VBD.qty_available', 'desc')
                        ->get();
             } 
       
            return json_encode($result);

   }
}

public function finalproduct_list(Request $request)
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
                'variations.default_sell_price as selling_price',
                'variations.sub_sku as sku',
                'VBD.brand_id as brand_id',
                'products.photo as image'
            );
            $document = $products->orderBy('VBD.qty_available', 'desc')
                        ->get();
                 return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('product_name', function ($document) {
                    return $document->pro_name;
                })
                ->editColumn('variation', function ($document) {
                    return $document->variation? $document->variation : null;
                })
                ->editColumn('f_sku', function ($document) {
                    return $document->sku;
                  

                })
                 ->editColumn('f_qty', function ($document) {
                  if (auth()->user()->can("view_product.qty")) {
                     return $document->qty;
                  }else
                  {
                    return 'N/A';
                  }

                })
                 ->editColumn('selling_price', function ($document) {
                   if (auth()->user()->can("view_product.sale_price")) {
                    return $document->selling_price;
                  }else{
                    return 'N/A';
                  }

                })
              
               ->rawColumns(['product_name', 'variation','f_sku','f_qty','selling_price'])->make(true);            
         }
         $brands=Brand::pluck('name', 'id');
         $categories=Category::pluck('name', 'id');
         return view('admin.production.product.product_list',compact('brands','categories'));               
    
}


public function product_report(Request $request)
{
     if (!auth()->user()->can('report.product')) {
            abort(403, 'Unauthorized action.');
         }
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
                                    
                                }
          });

          if (!auth()->user()->hasRole('Super Admin')) {
                $products->where('variations.hidden',false);
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
                'products.photo as image'
            );
            $products = $products->orderBy('VBD.qty_available', 'desc')
                        ->get();
    return view('admin.report.product.product_report',compact('products'));          
}

public function product_report_print(Request $request)
{
            $brand_id = $request->get('brand_id')?:get_option('default_brand');
            $term = $request->get('product');
            $explode =explode('/',$term);
            $product_id =$explode[0];
            $variation_id =isset($explode[1])?$explode[1]:'';
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
                                    
                                }
          });
         if ($term=='All') {
             $products=$products;
         }
         else{

           $products =$products->where('products.id',$product_id);
           $products =$products->where('VBD.variation_id',$variation_id);
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
                'variations.default_sell_price as selling_price',
                'variations.sub_sku as sku',
                'VBD.brand_id as brand_id',
                'products.photo as image',
                'variations.default_purchase_price as default_purchase_price'
            );
            $products = $products->orderBy('VBD.qty_available', 'desc')
                        ->get();  
            return view('admin.report.product.product_report_print',compact('products'));        
}

public function get_product_status($id)
{
    $model=Product::find($id);
    return view('admin.production.product.include.get_product_status',compact('model'));
}

public function post_product_status(Request $request)
{
    $model =Product::find($request->product_id);
    for ($i=0; $i <count($request->variation_id) ; $i++) { 
        $variation=Variation::find($request->variation_id[$i]);
        $variation->default_purchase_price =$request->default_purchase_price[$i];
        $variation->default_sell_price =$request->default_sell_price[$i];
        $variation->retail_sell_price =$request->retail_sell_price[$i];
        $variation->save();
    }
    $model->status=$request->status;
    $model->save();

    return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated')]);

}
}
