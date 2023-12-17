<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\models\Production\IngredientsCategory;
use App\models\depertment\Depertment;
use App\models\depertment\DepertmentEmployee;
use App\models\depertment\DepertmentIgCategory;
use App\models\depertment\DepertmentStore;
use App\models\depertment\ProductFlow;
use App\models\employee\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class DepertmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('production_department.view')) {
            abort(403, 'Unauthorized action.');
        }
      return view('admin.depertment.index');
    }


     public function datatable(Request $request){
       if ($request->ajax()) {
            $document = Depertment::orderBy('id','DESC')->get();
            return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('head',function($model){
                   return $model->employee->name;
                   })
                ->addColumn('action', function ($model) {
                    return view('admin.depertment.action', compact('model'));
                })->rawColumns(['head','action'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        if (!auth()->user()->can('production_department.create')) {
            abort(403, 'Unauthorized action.');
        }
        $employee = Employee::pluck('name','id');
        return view('admin.depertment.form',compact('employee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!auth()->user()->can('production_department.create')) {
            abort(403, 'Unauthorized action.');
        }
        $validator = $request->validate([
            'name'=>'required',
            'employee_id'=>'required|integer',
        ]);

        $model =new Depertment;
        $model->name =$request->name;
        $model->employee_id=$request->employee_id;
        $model->description=$request->description;
        $model->hidden = 0;
        $model->tek_marks = 0;
        $model->flow=$request->flow;
        $model->created_by = auth()->user()->id;
        $model->save();

            $first_order =Depertment::where('flow',$request->flow)->get()->except($model->id);
            foreach ($first_order as $key => $value) {
               $first_order_change =Depertment::find($value->id);
               $first_order_change->flow=null;
               $first_order_change->save();
            }
    
        //depertment employee
        $d_emp =new DepertmentEmployee;
        $d_emp->depertment_id=$model->id;
        $d_emp->employee_id=$request->employee_id;
        $d_emp->designation='Head';
        $d_emp->save();
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Created')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
     if (!auth()->user()->can('production_department.view')) {
            abort(403, 'Unauthorized action.');
        }

      if (!auth()->user()->hasRole('Super Admin') && empdeptExit($id,auth()->user()->employee_id)==false)
      {
        abort(403, 'Unauthorized action.');
      }
      $model =Depertment::findOrFail($id);
      return view('admin.depertment.show',compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('production_department.update')) {
            abort(403, 'Unauthorized action.');
        }
        $model =Depertment::findOrFail($id);
        return view('admin.depertment.form',compact('model'));
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
        if (!auth()->user()->can('production_department.update')) {
            abort(403, 'Unauthorized action.');
        }
       $validator = $request->validate([
            'name'=>'required',
        ]);

        $model =Depertment::findOrFail($id);
        $model->name =$request->name;
        $model->description=$request->description;
        $model->hidden = 0;
        $model->tek_marks = 0;
        $model->flow=$request->flow;
        $model->created_by = auth()->user()->id;
        $model->save();
            $first_order =Depertment::where('flow',$request->flow)->get()->except($model->id);
            foreach ($first_order as $key => $value) {
               $first_order_change =Depertment::find($value->id);
               $first_order_change->flow=null;
               $first_order_change->save();
            }
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Created')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      if (!auth()->user()->can('production_department.delete')) {
            abort(403, 'Unauthorized action.');
        }
        $count1 = DepertmentStore::where('depertment_id', $id)->count();
        $count2 = ProductFlow::where('depertment_id', $id)->count();
        if ($count1 == 0 && $count2==0) {
        $model =Depertment::find($id);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Deleted')]);
         }else
         {
          throw ValidationException::withMessages(['message' =>'Depertment Cannot Delete Because its use in Store or Product Report']);
         }
    }


    public function new_employee($id)
    {
      if (!auth()->user()->can('production_department.view')) {
            abort(403, 'Unauthorized action.');
        }
       $depert =Depertment::findOrFail($id);
       $employee_id=[];
       foreach ($depert->depertment_employee as  $value) {
           $employee_id[]=$value->employee_id;
       }
       $employee = Employee::whereNotIn('id',$employee_id)->pluck('name','id'); 
       return view('admin.depertment.new_employee',compact('employee','depert'));
    }

    public function new_employee_add(Request $request)
    {
      if (!auth()->user()->can('production_department.view')) {
            abort(403, 'Unauthorized action.');
        }
        $validator = $request->validate([
            'employee_id'=>'required|integer',
        ]);

        $d_emp =new DepertmentEmployee;
        $d_emp->depertment_id=$request->depertment_id;
        $d_emp->employee_id=$request->employee_id;
        $d_emp->designation='Member';
        $d_emp->save();

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('New Employee Add To the Depertment'),'load'=>true]);
    }

    public function employee_destroy($id)
    {
        if (!auth()->user()->can('production_department.view')) {
            abort(403, 'Unauthorized action.');
        }
        $d_emp =DepertmentEmployee::findOrFail($id);
        if ($d_emp->designation=='Head') {
           throw ValidationException::withMessages(['message' => _lang('You Can not Remove Department Head')]);
        }

        $d_emp->forceDelete();
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Deleted'),'load'=>true]);
    }

    public function new_category($id)
    {
      if (!auth()->user()->can('production_department.view')) {
            abort(403, 'Unauthorized action.');
        }
       $depert =Depertment::findOrFail($id);
       $category_id=[];
       foreach ($depert->igcategory as  $value) {
           $category_id[]=$value->ingredients_category_id;
       }
       $category = IngredientsCategory::whereNotIn('id',$category_id)->pluck('name','id'); 
       return view('admin.depertment.new_category',compact('category','depert'));
    }

    public function new_category_add(Request $request)
    {
         if (!auth()->user()->can('production_department.view')) {
            abort(403, 'Unauthorized action.');
        }
        $validator = $request->validate([
            'ingredients_category_id'=>'required|integer',
        ]);

        $ing_category =new DepertmentIgCategory;
        $ing_category->depertment_id=$request->depertment_id;
        $ing_category->ingredients_category_id=$request->ingredients_category_id;
        $ing_category->save();

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('New Category Add To the Depertment'),'load'=>true]);
    }

    public function category_destroy($id)
    {
        if (!auth()->user()->can('production_department.view')) {
            abort(403, 'Unauthorized action.');
        }
        $ing_category =DepertmentIgCategory::findOrFail($id);
        $ing_category->forceDelete();
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Deleted'),'load'=>true]);
    }
    public function approve_request($id)
    {
        $model =DepertmentStore::find($id);
        return view('admin.depertment.approve_request',compact('model'));
    }
}
