<?php

namespace App\Http\Controllers\Admin\Calender;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
// use App\models\employee\Designation;
use App\models\holiday\Holiday;
use Illuminate\Validation\Rule;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = Holiday::all();
        return view('admin.calender.holiday.index',compact('model'));
    }

    // ajax data table
    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $model = Holiday::orderBy('date')->get();    
            return Datatables::of($model)
            ->addIndexColumn()
            
            ->addColumn('action', function ($model) {
                return view('admin.calender.holiday.action', compact('model'));
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'calender' => 'required',
            'description' => 'required',
        ]);

        
        $holiday = explode(',',$request->holiday);
        foreach ($holiday as $dates) {
            $model = new Holiday;
            $model->date = $dates;
            $model->description = $request->description;
            $model->save();
        }

        activity() -> log('Added Holiday ');
        return response() -> json(['success' => true, 'status' => 'success', 'message' => _lang('Data Created'), 'load' => true]);
        
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
        $model = Holiday::findOrFail($id);
       
        return view('admin.calender.holiday.edit', compact('model'));
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
         $request->validate([
            'calender' => 'required',
        ]);
        $model = Holiday::findOrFail($id);
        $model->date = $request->calender;
        $model->description = $request->description;
        $model->save();
        
        activity() -> log('Updated Holiday ');
        return response() -> json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated'), 'load' => true]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd('sohag'); 
        $model = Holiday::findOrFail($id);
        
        $model->delete();
        // Activity Log
        activity() -> log('Deleted a Holiday ');
        return response() -> json(['success' => true, 'status' => 'success', 'message' => _lang('Data Deleted')]);
    
    }
}
