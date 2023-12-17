<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\models\Production\Product;
use App\models\Production\ProductMaterial;
use App\models\Production\RawMaterial;
use App\models\Production\WorkOrder;
use App\models\depertment\ApproveStoreItem;
use App\models\depertment\Depertment;
use App\models\depertment\DepertmentStore;
use App\models\depertment\StoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class StoreRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (!auth()->user()->can('store_request.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.depertment.request.index');
    }


    public function datatable(Request $request){
       if ($request->ajax()) {
            $document = DepertmentStore::orderBy('id','DESC')->get();
            return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('depertment',function($model){
                   return $model->depertment->name;
                   })
                  ->editColumn('date',function($model){
                   return formatDate($model->request_date);
                   })
                   ->editColumn('send',function($model){
                   return $model->send_by->email;
                   })
                ->addColumn('action', function ($model) {
                    return view('admin.depertment.request.action', compact('model'));
                })->rawColumns(['depertment','date','send','action'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     if (!auth()->user()->can('store_request.create')) {
            abort(403, 'Unauthorized action.');
        }
        if (auth()->user()->hasRole('Super Admin')) {
         $depertments =Depertment::select('id','name')->get();
        }else{
        $depertments =Depertment::leftjoin('depertment_employees AS de', 'depertments.id', '=', 'de.depertment_id')->select('depertments.id','depertments.name')->where('de.employee_id',auth()->user()->employee_id)->get();
        }
      return view('admin.depertment.request.create',compact('depertments'));
    }

    public function get_prev_request(Request $request)
    {
        $id =$request->id;
        return view('admin.depertment.request.depert_request_prev',compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('store_request.create')) {
            abort(403, 'Unauthorized action.');
        }
        $validate=$request->validate([
                'request_date'=>'required',

        ]);

        if (isset($request->raw_material_id)) {
             $rstq =$request->qty?$request->qty:0;
              $total_qty =array_sum($rstq);
             
              if ($total_qty==0) {
                throw ValidationException::withMessages(['message' => _lang('No Zero Qty Send Or enter non numeric value encounter')]);
              }
            $store =new DepertmentStore;
            $store->dstore_id =rand();
            $store->depertment_id =$request->depertment_id;
            $store->status ='Pendding';
            $store->request_date=$request->request_date;
            $store->created_by=auth()->user()->id;
            $store->save();
        for ($i=0; $i <count($request->raw_material_id) ; $i++) { 
          if ($request->qty[$i]>0) {
            $model =new StoreRequest;
            $model->depertment_store_id =$store->id;
            $model->depertment_id =$request->depertment_id;
            $model->work_order_id =$request->wo_id;
            $model->raw_material_id =$request->raw_material_id[$i];
            $model->qty=$request->qty[$i];
            $model->request_date=$request->request_date;
            $model->created_by=auth()->user()->id;
            $model->status='Pendding';
            $model->save();
          }
        }

          return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Created'),'window'=>route('admin.store_request_print',$store->id)]);
      }
      else{
        throw ValidationException::withMessages(['message' => _lang('First Select Item Then Send Request')]);
      }
    }



    public function store_request_print($id)
    {
      $model =DepertmentStore::with(['store_request'])->findOrFail($id);
      return view('admin.depertment.request.store_request_print',compact('model'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         if (!auth()->user()->can('store_request.view')) {
            abort(403, 'Unauthorized action.');
        }
        $model =DepertmentStore::findOrFail($id);
        return view('admin.depertment.request.show',compact('model'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         if (!auth()->user()->can('store_request.update')) {
            abort(403, 'Unauthorized action.');
        }
        $model =StoreRequest::findOrFail($id);
        $approve_item =$model->approve_store_item->sum('qty');
        return view('admin.depertment.request.edit',compact('model','approve_item'));
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
         if (!auth()->user()->can('store_request.update')) {
            abort(403, 'Unauthorized action.');
        }
        $model =StoreRequest::findOrFail($id);
        $approve_item =$model->approve_store_item->sum('qty');
        if ($request->qty ==0) {
            throw ValidationException::withMessages(['message' => _lang('You can not approve zero qty')]);
        }
        if (($request->qty+$model->approve_qty)>$model->qty) {
           throw ValidationException::withMessages(['message' => _lang('Request Qty >Approve Qty')]);
        }
        $model->approve_qty =$model->approve_qty+$request->qty;
        $model->approve_date=date('Y-m-d');
        $model->status=$request->status;
        $model->note=$request->note;
        $model->updated_by=auth()->user()->id;
        $model->save();
        $approve =new ApproveStoreItem;
        $approve->depertment_id=$request->depertment_id;
        $approve->raw_material_id=$request->raw_material_id;
        $approve->work_order_id=$request->work_order_id;
        $approve->store_request_id=$model->id;
        $approve->qty=$request->qty;
        $approve->note=$request->note;
        $approve->updated_by=auth()->user()->id;
        $approve->approve_date=date('Y-m-d');
        $approve->save();
        //row material stock update
        $material=$approve->material;
        $material->stock =$material->stock-$request->qty;
        $material->save();
        $this->status_change($model->depertment_store_id);

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Deleted'),'goto'=>route('admin.request.index')]);
    }

    public function approve_all_request(Request $request,$id)
    {
        if (!auth()->user()->can('store_request.update')) {
            abort(403, 'Unauthorized action.');
        }
       if ($request->isMethod('get')) {

           $models =DepertmentStore::with(['store_request'])->findOrFail($id);

           return view('admin.depertment.request.approve_all_request',compact('models'));
       }
       else
       {
        if (isset($request->raw_material_id)) {
          $total_qty =0;
          for ($i=0; $i <count($request->raw_material_id) ; $i++) { 
            if ($request->qty[$i]>0) {
              $model =StoreRequest::findOrFail($request->store_request_id[$i]);
               if (($request->qty[$i]+$model->approve_qty)>$model->qty) {
                   throw ValidationException::withMessages(['message' => _lang('Request Qty >Approve Qty')]);
                 }

                  $total_qty+=$request->qty[$i];
                  $model->approve_qty =$model->approve_qty+$request->qty[$i];
                  $model->approve_date=date('Y-m-d');
                  $model->status=$request->status;
                  $model->note=$request->note;
                  $model->updated_by=auth()->user()->id;
                  $model->save();

                  $approve =new ApproveStoreItem;
                  $approve->depertment_id=$request->depertment_id[$i];
                  $approve->raw_material_id=$request->raw_material_id[$i];
                  $approve->work_order_id=$request->work_order_id[$i];
                  $approve->store_request_id=$model->id;
                  $approve->qty=$request->qty[$i];
                  $approve->note=$request->note;
                  $approve->updated_by=auth()->user()->id;
                  $approve->approve_date=date('Y-m-d');
                  $approve->save();

                  //row material stock update
                  $material=$approve->material;
                  $material->stock =$material->stock-$request->qty[$i];
                  $material->save();
                  $this->status_change($id);
            }
          }

           if($total_qty <= 0){
               throw ValidationException::withMessages(['message' => _lang('You Cant Approve Zero Quantity')]);
              }

          return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Deleted'),'goto'=>route('admin.request.index')]);
        }
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         if (!auth()->user()->can('store_request.delete')) {
            abort(403, 'Unauthorized action.');
        }
        $model =StoreRequest::find($id);
        if ($model->approve_qty==0) {
           $model->delete();
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Deleted'),'load'=>true]);
        }else{
           throw ValidationException::withMessages(['message' =>'Can not Delete Because Item already approve this Request']);
        }
    }


    public function request_destroy($id)
    {
       $approve =StoreRequest::where('depertment_store_id',$id)->sum('approve_qty');
       if ($approve==0) {
         $model =DepertmentStore::find($id);
         $model->store_request()->delete();
         $model->delete();
          return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Deleted')]); 
       }
       else{
          throw ValidationException::withMessages(['message' =>'Can not Delete Because Item already approve this Request']);
       }
    }

    private function status_change($id)
    {
        $dept_store =DepertmentStore::findOrFail($id);
        $request_count =$dept_store->store_request->count();
        $approve_count =$dept_store->store_request()->where('status','Approve')->count();
        if ($request_count==$approve_count) {
            $status ='Approve';
        }
        else{
            $status='Partial';
        }
        $dept_store->status=$status;
        $dept_store->save();
        return true;
    }


    public function request($id)
    {
     if (!auth()->user()->can('store_request.create')) {
            abort(403, 'Unauthorized action.');
        }
       return view('admin.depertment.request.request_prev',compact('id')); 
    }

    public function request_form($type,$id)
    {
      if (!auth()->user()->can('store_request.create')) {
            abort(403, 'Unauthorized action.');
        }
       $depert =Depertment::findOrFail($id);
       $work_orders =WorkOrder::all();

        return view('admin.depertment.request.request',compact('depert','type','work_orders'));  
    }


    public function WorkOrder_request()
    {
        $people = [];
        $data = [];

        $people = WorkOrder::select('id')
            // ->where('transaction_status','transaction')
            ->where('type', 'like', '%' . $_GET['term'] . '%')
            ->orWhere('code', 'like', '%' . $_GET['term'] . '%')
            ->orderBy('id', 'DESC')
            ->get();

        foreach ($people as $k => $v) {
            $data[$k]['id'] = $v->id;
            $data[$k]['code'] = $this->getWorkOrder($v->id);
        }
        return response()->json(['items' => $data]);
    }

    public function getWorkOrder($id, $code = Null)
    {
        $workorders = WorkOrder::find($id);
        if ($workorders) {
            $code =  $workorders->prefix .'-'. $workorders->code;
        }
        return $code;
    }


    //Get Product Material Serch
    public function get_requestProduct()
    {
        $people = [];
        $data = [];

        $people = Product::select('id')
            ->where('name', 'like', '%' . $_GET['term'] . '%')
            ->orWhere('articel', 'like', '%' . $_GET['term'] . '%')
            ->orWhere('code', 'like', '%' . $_GET['term'] . '%')
            ->orderBy('id', 'DESC')
            ->get();

        foreach ($people as $k => $v) {
            $data[$k]['id'] = $v->id;
            $data[$k]['name'] = $this->Product_material($v->id);
        }
        return response()->json(['items' => $data]);
    }

    public function Product_material($id, $name = Null)
    {
        $category = Product::find($id);
        if ($category) {
            $name =  $category->name .'('. $category->articel.')';
        }
        return $name;
    }


    //Get Row Material Serch
    public function get_row_material_request()
    {
        $people = [];
        $data = [];

        $people = RawMaterial::select('id')
            ->where('name', 'like', '%' . $_GET['term'] . '%')
            ->orderBy('id', 'DESC')
            ->get();

        foreach ($people as $k => $v) {
            $data[$k]['id'] = $v->id;
            $data[$k]['name'] = $this->row_material($v->id);
        }
        return response()->json(['items' => $data]);
    }

    public function row_material($id, $name = Null)
    {
        $row = RawMaterial::find($id);
        if ($row) {
            $name =  $row->name;
        }
        return $name;
    }


    public function product_append(Request $request)
    {
        $models = WorkOrder::with('wop_material')->where('id', $request->id)->first();
        return view('admin.depertment.request.append_wk_material', compact('models'));
    }

    public function material_append(Request $request)
    {
        $models = ProductMaterial::where('product_id', $request->id)->get();
        return view('admin.depertment.request.appendproduct_mat', compact('models'));
    }

    public function row_material_append(Request $request)
    {
        $models = RawMaterial::where('id', $request->id)->get();
        return view('admin.depertment.request.appendrow_mat', compact('models'));
    }

    public function depertmentflow($id)
    {
        $model =ApproveStoreItem::findOrFail($id);
        $depertment =Depertment::select('id','name')->get()->except($model->depertment_id);

        $products = ApproveStoreItem::
              join('work_order_products', 'approve_store_items.work_order_id', '=', 'work_order_products.workorder_id')
            ->join('products', 'work_order_products.product_id', '=', 'products.id')
            ->select('products.*')
            ->first();
            dd($products);
        return view('admin.depertment.request.flow.depertmentflow',compact('model','depertment'));
    }
}