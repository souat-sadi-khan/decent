<?php

namespace App\Http\Controllers\admin\marketing;

use App\Http\Controllers\Controller;
use App\models\email\EmailTemolate;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Image;

class EmailTemplateController extends Controller
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
      return view('admin.marketing.email.template.index');
    }


     public function datatable(Request $request){
       if ($request->ajax()) {
            $document = EmailTemolate::orderBy('id','DESC')->get();
            return DataTables::of($document)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    return view('admin.marketing.email.template.action', compact('model'));
                })->rawColumns(['action'])->make(true);
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
       return view('admin.marketing.email.template.form');
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
            'template'=>'required',
        ]);
        $message=$request->input('template');
        $model=new EmailTemolate;
        $model->name =$request->name;
        $dom = new DomDocument();
        @$dom->loadHTML($message);   
        $images = $dom->getElementsByTagName('img');
       // foreach <img> in the submited message
        foreach($images as $img){
            $src = $img->getAttribute('src');
            
            // if the img source is 'data-url'
            if(preg_match('/data:image/', $src)){                
                // get the mimetype
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];                
                // Generating a random filename
                $filename = uniqid();
                $filepath = "summernoteimages/$filename.$mimetype";  
                $image = Image::make($src)
                  // resize if required
                  /* ->resize(300, 200) */
                  ->encode($mimetype, 100)  // encode file to the specified mimetype
                  ->save(public_path($filepath));              
                $new_src = asset($filepath);
                $img->removeAttribute('src');
                $img->setAttribute('src', $new_src);
            } // <!--endif
        } // <!-
        $model->template = $dom->saveHTML();
        $model->save();
         return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Created'),'goto'=>route('admin.emailmarketing.template.index')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('email_marketing.view')) {
            abort(403, 'Unauthorized action.');
        }
        $model =EmailTemolate::find($id);
        return view('admin.marketing.email.template.show',compact('model'));
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
        $model =EmailTemolate::find($id);
        return view('admin.marketing.email.template.form',compact('model'));
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
            'template'=>'required',
        ]);
        $message=$request->input('template');
        $model=EmailTemolate::find($id);
        $model->name =$request->name;
        $dom = new DomDocument();
        @$dom->loadHTML($message);   
        $images = $dom->getElementsByTagName('img');
       // foreach <img> in the submited message
        foreach($images as $img){
            $src = $img->getAttribute('src');
            
            // if the img source is 'data-url'
            if(preg_match('/data:image/', $src)){                
                // get the mimetype
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimetype = $groups['mime'];                
                // Generating a random filename
                $filename = uniqid();
                $filepath = "summernoteimages/$filename.$mimetype";  
                $image = Image::make($src)
                  // resize if required
                  /* ->resize(300, 200) */
                  ->encode($mimetype, 100)  // encode file to the specified mimetype
                  ->save(public_path($filepath));              
                $new_src = asset($filepath);
                $img->removeAttribute('src');
                $img->setAttribute('src', $new_src);
            } // <!--endif
        } // <!-
        $model->template = $dom->saveHTML();
        $model->save();
         return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Update'),'goto'=>route('admin.emailmarketing.template.index')]);
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
      $model =EmailTemolate::find($id)->delete();
      return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Delete')]);
    }
}
