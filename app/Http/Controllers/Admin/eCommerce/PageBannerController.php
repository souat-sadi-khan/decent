<?php

namespace App\Http\Controllers\Admin\eCommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\eCommerce\PageBanner;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PageBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('ecommerce_page_banner.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.eCommerce.page-banner.index');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $document = PageBanner::get();
            return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('image', function ($model) {
                    $url = asset('storage/page/' . $model->image);
                    return '<img src="' . $url . '" border="0" width="90" height="60" class="img-rounded" align="center" />';
                })
                ->addColumn('action', function ($model) {
                    return view('admin.eCommerce.page-banner.action', compact('model'));
                })->rawColumns(['action', 'image'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('ecommerce_page_banner.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.eCommerce.page-banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('ecommerce_page_banner.create')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'page_name' => 'required',
            'image' => 'max:2000',
        ]);

        $page = new PageBanner;

        if ($request->hasFile('image')) {
            $storagepath = $request->file('image')->store('public/page');
            $fileName = basename($storagepath);
            $page->image = $fileName;
        } else {
            $page->image = '';
        }

        $page->page_name = $request->page_name;
        $page->save();

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'goto' => route('admin.eCommerce.page-banner.index')]);

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
        if (!auth()->user()->can('ecommerce_page_banner.update')) {
            abort(403, 'Unauthorized action.');
        }
        $model = PageBanner::findOrFail($id);
        return view('admin.eCommerce.page-banner.edit', compact('model'));
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
        if (!auth()->user()->can('ecommerce_page_banner.update')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'page_name' => 'required',
            'image' => 'max:2000',
        ]);

        $page = PageBanner::findOrFail($id);

        if ($request->hasFile('image')) {
            $storagepath = $request->file('image')->store('public/page');
            $fileName = basename($storagepath);
            $page->image = $fileName;

            // $oldFile = $page->image;
            //     if( $oldFile != ''){
            //         $file_path = "public/page/".$oldFile;
            //         Storage::delete($file_path);
            //     }

        } else {
            $page->image = '';
        }

        $page->page_name = $request->page_name;
        $page->save();

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated'), 'goto' => route('admin.eCommerce.page-banner.index')]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('ecommerce_page_banner.delete')) {
            abort(403, 'Unauthorized action.');
        }
        $type = PageBanner::findOrFail($id);
        $type->delete();
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted Successfully'), 'load' => true]);
    }
}
