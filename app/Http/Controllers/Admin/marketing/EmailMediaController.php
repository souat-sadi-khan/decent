<?php

namespace App\Http\Controllers\admin\marketing;

use App\Http\Controllers\Controller;
use App\models\email\EmailMedia;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EmailMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('email_marketing.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.marketing.email.media.index');
    }

     public function datatable(Request $request){
       if ($request->ajax()) {
            $document = EmailMedia::all();
            return DataTables::of($document)
                ->addIndexColumn()
                  ->editColumn('image',function($model){
                $url= asset('storage/marketing/media/'.$model->path);
                return '<img src="'.$url.'" border="0" width="120" class="img-rounded" align="center" />';
                   })
                ->addColumn('action', function ($model) {
                    return view('admin.marketing.email.media.action', compact('model'));
                })->rawColumns(['action','image'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('email_marketing.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.marketing.email.media.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('email_marketing.create')) {
            abort(403, 'Unauthorized action.');
        }
        $validator = $request->validate([
            'title'=>'required|max:250',
            'path'=>'required|mimes:jpeg,bmp,png,jpg|max:2000',
        ]);
        $model =new EmailMedia;
        $model->title =$request->title;
         if($request->hasFile('path')) {
          $storagepath = $request->file('path')->store('public/marketing/media/');
          $fileName = basename($storagepath);
          $model->path = $fileName;
        }
        $model->save();
          return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Created')]);
    }


    public function import_media()
    {
        if (!auth()->user()->can('email_marketing.create')) {
            abort(403, 'Unauthorized action.');
        }
        $models =EmailMedia::all();
        return view('admin.marketing.email.media.import_media',compact('models'));
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
        if (!auth()->user()->can('email_marketing.update')) {
            abort(403, 'Unauthorized action.');
        }
        $model =EmailMedia::find($id);
        return view('admin.marketing.email.media.form',compact('model'));
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
         if (!auth()->user()->can('email_marketing.update')) {
            abort(403, 'Unauthorized action.');
        }
        $validator = $request->validate([
            'title'=>'required|max:250',
            'path'=>'nullable|mimes:jpeg,bmp,png,jpg|max:2000',
        ]);
        $model =EmailMedia::find($id);
        $model->title =$request->title;

       if ($request->hasFile('path')) {
           if ($model->path) {
              $file_path = "public/marketing/media/" . $model->path;
              Storage::delete($file_path);
            }
            $storagepath = $request->file('path')->store('public/marketing/media/');
            $fileName = basename($storagepath);
            $model->path = $fileName;
        
          } 
         else {
           $fileName= $model->path;
           $model->path = $fileName;
          }
          $model->save();
          return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('email_marketing.delete')) {
            abort(403, 'Unauthorized action.');
        }
      $model = EmailMedia::findOrFail($id);
        if ($model->path) {
            $image_path = public_path() . '/storage/marketing/media/' . $model->path;
            unlink($image_path);
        }

        $model->delete();

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Delete')]);
    }
}
