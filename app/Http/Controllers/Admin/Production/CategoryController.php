<?php

namespace App\Http\Controllers\Admin\Production;

use App\Http\Controllers\Controller;
use App\models\Production\Category;
use App\models\Production\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       if (!auth()->user()->can('production_category.view')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $id = request()->id == '#' ? 0 : request()->id;
            $models = Category::where('parent_id', $id)->select('id', 'name')->get();
            return view('admin.production.category.tree', compact('models'));
        }
        return view('admin.production.category.index');
    }

    // public function datatable(Request $request){
    //     if ($request->ajax()) {
    //         $document = Category::where('name', '!=', config('system.default_role.admin'))->get();
    //         return DataTables::of($document)
    //             ->addIndexColumn()
    //             ->editColumn('status', function ($document) {
    //                 if ($document->status == '1') {
    //                     return '<span class="badge badge-success">' . 'Active' . '</span>';
    //                 } else if($document->status == '0') {
    //                     return '<span class="badge badge-danger">' . 'Inactive' . '</span>';
    //                 }
    //             })
    //             ->addColumn('action', function ($model) {
    //                 return view('admin.production.category.action', compact('model'));
    //             })->rawColumns(['action','status'])->make(true);
    //     }
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       if (!auth()->user()->can('production_category.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.production.category.create');
    }

    public function remort_add()
    {
       if (!auth()->user()->can('production_category.create')) {
            abort(403, 'Unauthorized action.');
        }
         return view('admin.production.category.quick_modal'); 
    }

    // make slug
    public function slug($old_slug, $row = Null)
    {
        if(!$row){
            $slug = $old_slug;
            $row = 0;
        }else{
            $slug = $old_slug . '-'.$row;
        }

        $check_res = Category::where('category_slug', $slug)->first();
        if($check_res) {
            $slug = $this->slug($old_slug, $row+1);
        }

        return $slug;
    }
    

    public function remort_addCategory(Request $request)
    {
       if (!auth()->user()->can('production_category.create')) {
            abort(403, 'Unauthorized action.');
        }
      if ($request->status) {
            $status = 1;
        }else{
            $status = 0;
        }
      $validator = $request->validate([
            'name' => 'required|unique:categories|max:255',
            'description' => '',
        ]);
        $model = new Category;
        $slug = $this->slug(make_slug($request->name));
        $model->category_slug = $slug;
        $model->name = $request->name;
        $model->parent_id =0;
        $model->description = $request->description;
        $model->status = $status;
        $model->created_by = auth()->user()->id;
        $model->save();
        return response()->json(['id'=>$model->id,'name'=>$model->name,'addto'=>'append_category','modal'=>'category_modal']);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       if (!auth()->user()->can('production_category.create')) {
            abort(403, 'Unauthorized action.');
        }
        if ($request->status) {
            $status = 1;
        }else{
            $status = 0;
        }
        $validator = $request->validate([
            'name' => 'required|unique:categories|max:255',
            'parent_id' => 'required',
            'description' => '',
        ]);

        $model = new Category;
        $slug = $this->slug(make_slug($request->name));
        $model->category_slug = $slug;
        $model->name = $request->name;
        $model->parent_id = $request->parent_id;
        $model->description = $request->description;
        $model->status = $status;
        $model->save();
        // Activity Log
        activity()->log('Created a Production Category - ' . $request->name);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'goto' => route('admin.production-category.index')]);
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
       if (!auth()->user()->can('production_category.update')) {
            abort(403, 'Unauthorized action.');
        }
        // find the data
        $model = Category::where('id', $id)->firstOrFail();
        // return
        return view('admin.production.category.edit', compact('model'));
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
       if (!auth()->user()->can('production_category.update')) {
            abort(403, 'Unauthorized action.');
        }
        if ($request->status) {
            $status = 1;
        } else {
            $status = 0;
        }

        $model = Category::findOrFail($id);
        $validator = $request->validate([
            // 'name' => 'required|max:255|unique:categories,name,' . $model->id,
            'name' => ['required', 'string', 'max:255',
                    Rule::unique('categories', 'name')->ignore($model->id)],
        ]);
        $model->name = $request->name;
        $model->parent_id = $request->parent_id;
        $model->description = $request->description;
        $model->status = $status;
        $model->save();

        // Activity Log
        activity()->log('Update a Production Category - ' . $request->name);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated'), 'goto' => route('admin.production-category.index')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){

       if (!auth()->user()->can('production_category.delete')) {
            abort(403, 'Unauthorized action.');
        }
        $count =Product::where('category_id',$id)->count();
        if ($count==0) {
            $type = Category::findOrFail($id);
            $name = $type->name;
            $type->delete();

            // Activity Log
            activity()->log('Delete a Production Category - ' . $name);

            return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted Successfully'), 'goto' => route('admin.production-category.index')]);
        }else{

        throw ValidationException::withMessages(['message' => _lang('Do not delete Because this Category is already use in other section')]);
      }

    }




    // getCatagory
    public function getCatagory(){
        $people = [];
        $data = [];

        $people = Category::select('id')
            ->where('name', 'like', '%' . $_GET['term'] . '%')
            ->where('parent_id',0)
            ->orderBy('id', 'DESC')
            ->get();

        foreach ($people as $k => $v) {
            $data[$k]['id'] = $v->id;
            $data[$k]['name'] = $this->getCatagoryParent($v->id);
        }
        return response()->json(['items' => $data]);
    }

    public function getCatagoryParent($id, $name = Null){
        $category = Category::find($id);
        if ($category) {
            $name =  $category->name;
            // if ($category->parent_id != 0) {
            //     $name = $this->getCatagoryParent($category->parent_id, $name);
            // }
        }
        return $name;
    }
}
