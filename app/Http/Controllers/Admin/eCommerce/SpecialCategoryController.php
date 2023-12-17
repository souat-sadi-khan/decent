<?php

namespace App\Http\Controllers\Admin\eCommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\eCommerce\SpecialCategory;
use App\models\eCommerce\SpecialOffer;
use App\models\Production\Category;
use App\models\Production\Product;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class SpecialCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('ecommerce_special_category.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.eCommerce.special-category.index');
    }

    //datatable
    public function datatable(Request $request){
        if ($request->ajax()) {
            $document = SpecialCategory::all();
            return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('photo', function ($model) {
                    if($model->cover_image != NULL) {
                        $url= asset('storage/eCommerce/special_category/'.$model->cover_image);
                    } else {
                        $url = asset('img/product.jpg');
                    }
                    return '<img width="100px;" src="'.($model->photo != NULL ? $url : $url).'" alt="Image of Product">';
                })
                ->editColumn('name', function ($model) {
                    $cat = Category::where('id', $model->category_id)->first();
                    if($cat) {
                        $name = $cat->name;
                    } else {
                        $name = '';
                    }
                    return $name;
                    // return $model->category->name;
                })
                ->editColumn('product', function ($model) {
                    return Product::where('category_id', $model->category_id)->count();
                    // return $model->category->name;
                })
                ->editColumn('status', function ($model) {
                    return $model->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-warning">Inactive</span>' ;
                })
                ->editColumn('action', function ($model) {
                    return view('admin.eCommerce.special-category.action', compact('model'));
                })
                ->rawColumns(['photo', 'product', 'action', 'status'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('ecommerce_special_category.create')) {
            abort(403, 'Unauthorized action.');
        }
        $categories = Category::where('status', 1)->get();
        return view('admin.eCommerce.special-category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('ecommerce_special_category.create')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'category_id' => 'required',
            'status' => 'required',
            'cover_image' => 'required|mimes:jpeg,png,jpg|max:1024',
        ]);

        $model = new SpecialCategory;
        $model->category_id = $request->category_id;
        $model->status = $request->status;


        // check special category total offer
        if($request->status == 1) {
            $check_total_offer = SpecialCategory::where('status', 1)->count();
            if($check_total_offer > 3) {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Sorry. You Can not add more then 3 Special offer at a time!')]);
            }
        }


        if($request->hasFile('cover_image')) {
            $data = getimagesize($request->file('cover_image'));
            $width = $data[0];
            $height = $data[0];

            if($width > 400 && $height > 210) {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => 'Category Image Width and height is wrong']);
            }


            $storagepath = $request->file('cover_image')->store('public/eCommerce/special_category/');
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

        // Activity Log
        activity()->log('Created a Special Category - ' . $request->category_id );
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Special Category Inserted Successfully!')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('ecommerce_special_category.update')) {
            abort(403, 'Unauthorized action.');
        }
        $model = SpecialCategory::findOrFail($id);
        $categories = Category::where('status', 1)->get();
        return view('admin.eCommerce.special-category.edit', compact('model', 'categories'));
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
        if (!auth()->user()->can('ecommerce_special_category.update')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'category_id' => 'required',
            'status' => 'required',
            'cover_image' => 'mimes:jpeg,png,jpg|max:1024',
        ]);

        $model = SpecialCategory::findOrFail($id);
        $model->category_id = $request->category_id;
        $model->status = $request->status;


        // check special category total offer
        if($request->status == 1) {
            $check_total_offer = SpecialCategory::where('status', 1)->count();
            if($check_total_offer > 3) {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Sorry. You Can not add more then 3 Special offer at a time!')]);
            }
        }

        if($request->hasFile('cover_image')) {
            $data = getimagesize($request->file('cover_image'));
            $width = $data[0];
            $height = $data[0];

            if($width > 400 && $height > 210) {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => 'Category Image Width and height is wrong']);
            }


            $storagepath = $request->file('cover_image')->store('public/eCommerce/special_category/');
            $fileName = basename($storagepath);

            $model->cover_image = $fileName;

            //if file chnage then delete old one
            $oldFile = $request->oldFile;
            if( $oldFile != ''){

                $file_path = "public/eCommerce/special_category/".$oldFile;
                Storage::delete($file_path);
            }
        }
        $model->save();

        // Activity Log
        activity()->log('Created a Special Category - ' . $request->category_id );
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Special Category Updated Successfully!')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('ecommerce_special_category.delete')) {
            abort(403, 'Unauthorized action.');
        }
        
        $model = SpecialCategory::findOrFail($id);
        $model->delete();

        if( $model->cover_image != ''){

            $file_path = "public/eCommerce/special_category/".$model->cover_image;
            Storage::delete($file_path);
        }

        // Activity Log
        activity()->log('Created a Special Category - ' . $model->category_id );
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Special Category Deleted Successfully!')]);
    }
}
