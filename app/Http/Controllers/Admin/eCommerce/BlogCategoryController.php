<?php

namespace App\Http\Controllers\Admin\eCommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\models\eCommerce\BlogCategory;
use Yajra\DataTables\Facades\DataTables;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('ecommerce.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.blog.category.index');
    }


    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $document = BlogCategory::orderBy('id', 'DESC')->get();
            return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('count', function ($model) {
                    return $model->post->count();
                })
                ->editColumn('status', function ($model) {
                    if ($model->status == 'Active') {
                        return '<span class="badge badge-primary">Active</span>';
                    } else {
                        return '<span class="badge badge-warning">Inactive</span>';
                    }
                })
                ->addColumn('action', function ($model) {
                    return view('admin.blog.category.action', compact('model'));
                })->rawColumns(['count', 'status', 'action'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('ecommerce.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.blog.category.create');
    }

    // make slug
    public function slug($old_slug, $row = Null)
    {
        if (!$row) {
            $slug = $old_slug;
            $row = 0;
        } else {
            $slug = $old_slug . '-' . $row;
        }

        $check_res = BlogCategory::where('category_slug', $slug)->first();
        if ($check_res) {
            $slug = $this->slug($old_slug, $row + 1);
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
        if (!auth()->user()->can('ecommerce.view')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'name' => 'required|unique:blog_categories',
            'status' => 'required',
        ]);

        $model = new BlogCategory;
        $slug = $this->slug(make_slug($request->name));
        $model->category_slug = $slug;
        $model->name = $request->name;
        $model->status = $request->status;
        $model->save();

        activity()->log('Created a Blog Category - ' . Auth::user()->id);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data created Successfuly')]);

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
        if (!auth()->user()->can('ecommerce.view')) {
            abort(403, 'Unauthorized action.');
        }
        $model = BlogCategory::findOrFail($id);
        return view('admin.blog.category.edit', compact('model'));
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
        if (!auth()->user()->can('ecommerce.view')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'name' => 'required',
            'status' => 'required',
        ]);

        $model = BlogCategory::findOrFail($id);
        $model->name = $request->name;
        $model->status = $request->status;
        $model->save();

        activity()->log('Update a Blog Category - ' . Auth::user()->id);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Update Successfuly')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('ecommerce.view')) {
            abort(403, 'Unauthorized action.');
        }
        
        $type = BlogCategory::findOrFail($id);
        $type->delete();

        activity()->log('Delete a Blog Category - ' . Auth::user()->id);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted Successfully')]);
    }
}
