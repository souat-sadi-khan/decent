<?php

namespace App\Http\Controllers\Admin\Configuration\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\Member\Nationality;
use Yajra\Datatables\Datatables;

class Member_Nationality_Setting_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return to the index page
        return view('admin.setting.member.nationality.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return to the create page
        return view('admin.setting.member.nationality.create');
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $document = Nationality::where('name', '!=', config('system.default_role.admin'))->get();
            return Datatables::of($document)
                ->addIndexColumn()
                ->addColumn('action', function ($model) {
                    return view('admin.setting.member.nationality.action', compact('model'));
                })->rawColumns(['action'])->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // fetch data from form and store
        $request->validate([
            'name' => 'required|unique:nationalities',
        ]);

        $model = new Nationality;
        $model->name = $request->name;
        $model->description = $request->description;
        $model->status = $request->status;
        $model->save();

        // Activity Log
        activity()->log('Created a Nationality - ' . $request->name);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'load' => true]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // find the model & return
        $model = Nationality::findOrFail($id);
        return view('admin.setting.member.nationality.edit', compact('model'));

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
        // fetch data from form and store
        $request->validate([
            'name' => 'required|unique:nationalities,name,'.$id,
        ]);

        $model = Nationality::findOrFail($id);
        $model->name = $request->name;
        $model->description = $request->description;
        $model->status = $request->status;
        $model->save();

        // Activity Log
        activity()->log('Update a Nationality - ' . $request->name);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated'), 'load' => true]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // find the model & delete
        $model = Nationality::findOrFail($id);
        $model->delete();

        // Activity Log
        activity()->log('Deleted a Nationality - ' . $model->name);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted'), 'load' => true]);

    }
}
