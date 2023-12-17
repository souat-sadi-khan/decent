<?php

namespace App\Http\Controllers\Admin\eCommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\eCommerce\OurTeam;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class OurTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        if (!auth()->user()->can('ecommerce_our_team.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.eCommerce.our_team.index');
    }


    public function datatable(Request $request){
       if ($request->ajax()) {
            $document = OurTeam::where('team_name', '!=', config('system.default_role.admin'))->get();
            return DataTables::of($document)
                ->addIndexColumn()
                
                ->editColumn('image_one',function($model){
                $url= asset('storage/eCommerce/about/'.$model->image_one);
                return '<img src="'.$url.'" border="0" width="120" height="50" class="img-rounded" align="center" />';
                   })
                ->editColumn('image_two',function($model){
                $url= asset('storage/eCommerce/about/'.$model->image_two);
                return '<img src="'.$url.'" border="0" width="120" height="50" class="img-rounded" align="center" />';
                   })
                ->addColumn('action', function ($model) {
                    return view('admin.eCommerce.our_team.action', compact('model'));
                })->rawColumns(['action','image_one','image_two'])->make(true);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        if (!auth()->user()->can('ecommerce_our_team.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.eCommerce.our_team.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        if (!auth()->user()->can('ecommerce_our_team.create')) {
            abort(403, 'Unauthorized action.');
        }
        $data = $request->validate([
            'team_name' => 'required|unique:our_teams|max:255',
            'team_designation' => 'required|unique:our_teams|max:255',
            'image_one' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
            'image_one_alt' => '',
            'image_two' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
            'image_two_alt' => '',
            'description' => 'required',
        ]);

         if ($request->hasFile('image_one')) {
            $storagepath = $request->file('image_one')->store('public/eCommerce/about');
            $fileName = basename($storagepath);
            $data['image_one'] = $fileName;
        }else{
            $data['image_one'] ='';
        }

         if ($request->hasFile('image_two')) {
            $storagepath = $request->file('image_two')->store('public/eCommerce/about');
            $fileName = basename($storagepath);
            $data['image_two'] = $fileName;
        }else{
            $data['image_two'] = '';
        }
        $model = new OurTeam;
        $model->create($data);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'goto' => route('admin.eCommerce.our-team.index')]);
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
    public function edit($id){
        if (!auth()->user()->can('ecommerce_our_team.update')) {
            abort(403, 'Unauthorized action.');
        }
        $model = OurTeam::findOrFail($id);
        return view('admin.eCommerce.our_team.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        if (!auth()->user()->can('ecommerce_our_team.update')) {
            abort(403, 'Unauthorized action.');
        }
        $model = OurTeam::findOrFail($id);
        $data = $request->validate([
            'team_name' => ['required',Rule::unique('our_teams')->ignore($model->id)],
            'team_designation' => ['required',Rule::unique('our_teams')->ignore($model->id)],
            'image_one' => '',
            'image_one_alt' => '',
            'image_two' => '',
            'image_two_alt' => '',
            'description' => 'required',
        ]);

         if ($request->hasFile('image_one')) {
             if ($model->image_one) {
                Storage::delete('public/eCommerce/about/'.$model->image_one);
            }
            $storagepath = $request->file('image_one')->store('public/eCommerce/about');
            $fileName = basename($storagepath);
            $data['image_one'] = $fileName;
        }else{
            $data['image_one'] =$model->image_one;
        }

         if ($request->hasFile('image_two')) {
             if ($model->image_two) {
                Storage::delete('public/eCommerce/about/'.$model->image_two);
            }
            $storagepath = $request->file('image_two')->store('public/eCommerce/about');
            $fileName = basename($storagepath);
            $data['image_two'] = $fileName;
        }else{
            $data['image_one'] =$model->image_two;
        }
       
        $model->update($data);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated'), 'goto' => route('admin.eCommerce.our-team.index')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        if (!auth()->user()->can('ecommerce_our_team.delete')) {
            abort(403, 'Unauthorized action.');
        }
        $model = OurTeam::findOrFail($id);
        Storage::delete(['public/eCommerce/about/'.$model->image_one, 'public/eCommerce/about/'.$model->image_two]);
        $model->delete();
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted'),'goto' => route('admin.eCommerce.our-team.index')]);
    }
}
