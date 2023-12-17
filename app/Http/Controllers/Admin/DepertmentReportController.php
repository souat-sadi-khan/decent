<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\models\Production\Variation;
use App\models\Production\VariationBrandDetails;
use App\models\Production\VariationTemplate;
use App\models\Production\WorkOrder;
use App\models\Production\WorkOrderProduct;
use App\models\depertment\Depertment;
use App\models\depertment\DepertmentStore;
use App\models\depertment\MaterialReport;
use App\models\depertment\ProductFlow;
use App\models\Production\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DepertmentReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('submit_product_to_department.create')) {
            abort(403, 'Unauthorized action.');
        }
        $orders =WorkOrder::all();
         if (auth()->user()->hasRole('Super Admin')) {
         $depertments =Depertment::select('id','name')->get();
        }else{
        $depertments =Depertment::leftjoin('depertment_employees AS de', 'depertments.id', '=', 'de.depertment_id')->select('depertments.id','depertments.name')->where('de.employee_id',auth()->user()->employee_id)->get();
        }
        return view('admin.depertment.report.product_report',compact('orders','depertments'));
    }


    public function get_variation_product(Request $request)
    {
        if (!auth()->user()->can('submit_product_to_department.create')) {
            abort(403, 'Unauthorized action.');
        }

        $depertments =Depertment::select('id','name')->get()->except($request->depertment);
        $variations =VariationTemplate::all();
        $depert_name =Depertment::find($request->depertment);
        if ($depert_name->flow=='First') {
            $products = WorkOrderProduct::
                join('variations', 'work_order_products.variation_id', '=', 'variations.id')
                ->where('work_order_products.workorder_id',$request->id)
                ->select('variations.*')
                ->distinct('product_id')
                ->get();
             return view('admin.depertment.report.include.get_product',compact('depertments','variations','products','depert_name'));   
        }
        elseif ($depert_name->flow=='last') {
              $products =ProductFlow::where('send_depertment_id',$request->depertment)->where('work_order_id',$request->id)->distinct('variation_id')->get();
              return view('admin.depertment.report.include.get_final_product',compact('depertments','variations','products','depert_name')); 
        }
        else{
          $products =ProductFlow::where('send_depertment_id',$request->depertment)->where('work_order_id',$request->id)->distinct('variation_id')->get();
        
           return view('admin.depertment.report.include.get_middle_product',compact('depertments','variations','products','depert_name')); 
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
       if (!auth()->user()->can('submit_product_to_department.create')) {
            abort(403, 'Unauthorized action.');
        }

        $validator = $request->validate([
            'qty.*'=>'nullable|integer',
  
        ]);
        $total_qty=0;
        $flow_type =$request->flow_type;
        if ($flow_type=='First') {
        for ($i=0; $i <count($request->qty) ; $i++) { 
            if ($request->qty[$i] ==0) {
            throw ValidationException::withMessages(['message' => _lang('You can not Create zero qty')]);
            }
            if ($request->department_id==$request->send_depertment_id) {
               throw ValidationException::withMessages(['message' => _lang('Requested Dept and Sending Dept Not Same')]);
            }
            $model =new ProductFlow;
            $model->depertment_id=$request->department_id;
            $model->product_id=$request->product_id[$i];
            $model->send_depertment_id=$request->send_depertment_id;
            $model->variation_id=$request->variation_id[$i];
            $model->work_order_id=$request->work_order_id;
            $model->qty=$request->qty[$i];
            $model->date=date('Y-m-d');
            $model->created_by=auth()->user()->id;
            $model->save();
         }
        }
        elseif($flow_type=='middle')
        {
         for ($i=0; $i <count($request->qty) ; $i++) { 
          if ($request->qty[$i]>0) {
            $total_qty+=$request->qty[$i];
            $rq_qty =$request->req_qty[$i];
            $done_qty =$request->done_qty[$i];
            if (($done_qty+$request->qty[$i])>$rq_qty) {
               throw ValidationException::withMessages(['message' => _lang('Requested Qty Greater than Total Qty').' '.$request->name_product[$i]]);
            }
            if ($request->department_id==$request->send_depertment_id) {
               throw ValidationException::withMessages(['message' => _lang('Requested Dept and Sending Dept Not Same')]);
            }
            $model =new ProductFlow;
            $model->depertment_id=$request->department_id;
            $model->product_id=$request->product_id[$i];
            $model->done_depertment_id=$request->done_depertment_id[$i];
            $model->send_depertment_id=$request->send_depertment_id;
            $model->variation_id=$request->variation_id[$i];
            $model->work_order_id=$request->work_order_id;
            $model->qty=$request->qty[$i];
            $model->date=date('Y-m-d');
            $model->created_by=auth()->user()->id;
            $model->save();
         }
        }
       if($total_qty <= 0){
         throw ValidationException::withMessages(['message' => _lang('You Cant Send Zero Quantity')]);
        }
        }
        else{
            
         for ($i=0; $i <count($request->qty) ; $i++) { 
          if ($request->qty[$i]>0) {
            $total_qty+=$request->qty[$i];
            $rq_qty =$request->req_qty[$i];
            $done_qty =$request->done_qty[$i];
            if (($done_qty+$request->qty[$i])>$rq_qty) {
               throw ValidationException::withMessages(['message' => _lang('Requested Qty Greater than Total Qty').' '.$request->name_product[$i]]);
            }
            $model =new ProductFlow;
            $model->depertment_id=$request->department_id;
            $model->product_id=$request->product_id[$i];
            $model->send_depertment_id=$request->send_depertment_id;
            $model->variation_id=$request->variation_id[$i];
            $model->work_order_id=$request->work_order_id;
            $model->qty=$request->qty[$i];
            $model->date=date('Y-m-d');
            $model->created_by=auth()->user()->id;
            $model->done_depertment_id=$request->done_depertment_id[$i];
            $model->save();
           
            $brand_id =WorkOrder::find($request->work_order_id)->brand_id;
            $product_variation_id =Variation::find($request->variation_id[$i])->product_variation_id;
             //branddetails product_id[$i] age 1 cilo....
            $variation_exit =VariationBrandDetails::where('product_id',$request->product_id[$i])
                                        ->where('variation_id',$request->variation_id[$i])
                                        ->where('brand_id',$brand_id)
                                        ->first();
                   
            if ($variation_exit) {
                 $variation_exit->qty_available =$variation_exit->qty_available+$request->qty[$i];
                 $variation_exit->save();
                 
              }
              else{
                  $add_new_brand_qty =new VariationBrandDetails;
                $add_new_brand_qty->product_id=$request->product_id[$i];
                $add_new_brand_qty->product_variation_id=$product_variation_id;
                $add_new_brand_qty->variation_id=$request->variation_id[$i];
                $add_new_brand_qty->brand_id=$brand_id;
                $add_new_brand_qty->qty_available =$request->qty[$i];
                $add_new_brand_qty->save();
              }
                   
         } 
        }
        if($total_qty <= 0){
         throw ValidationException::withMessages(['message' => _lang('You Cant Send Zero Quantity')]);
        }
        }


    return response()->json(['success' => true, 'status' => 'success', 'message' => ' Successfully.','window'=>route('admin.submit_product_report_print',[$request->department_id,$request->work_order_id]), 'load' => true]);
    }
    


    public function submit_product_report_print($dept,$wo,$sdate=null,$edate=null)
    {
        if ($sdate==null) {
            $model =ProductFlow::where('depertment_id',$dept)->where('work_order_id',$wo)->where('date',date('Y-m-d'))->get();
        }

        return view('admin.depertment.report.submit_product_report_print',compact('model'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function material()
    {
         if (!auth()->user()->can('submit_material_to_department.create')) {
            abort(403, 'Unauthorized action.');
        }

       if (auth()->user()->hasRole('Super Admin')) {
         $depertments =Depertment::select('id','name')->get();
        }else{
        $depertments =Depertment::leftjoin('depertment_employees AS de', 'depertments.id', '=', 'de.depertment_id')->select('depertments.id','depertments.name')->where('de.employee_id',auth()->user()->employee_id)->get();
        }
        return view('admin.depertment.report.material',compact('depertments'));
    }


    public function get_dstore_id(Request $request)
    {
        $model=DepertmentStore::orderBy('id','DESC')->where('depertment_id',$request->department_id)->select('id','dstore_id','request_date')->get();
        return response()->json($model);
    }

    public function get_depertment_material(Request $request)
    {
        $materials =DepertmentStore::query();
          if (!empty($request->dstore_id)) {
             $materials=$materials->where('id',$request->dstore_id);
          }
          $materials=$materials->orderBy('id','desc')->where('depertment_id',$request->depertment)->get();

       return view('admin.depertment.report.include.get_material',compact('materials'));
    }

   public function approve_request($id)
    {
        $model =DepertmentStore::findOrFail($id);
        return view('admin.depertment.report.approve_request',compact('model'));
    }

    public function material_store(Request $request)
    {
        if (!auth()->user()->can('submit_material_to_department.create')) {
            abort(403, 'Unauthorized action.');
        }
        $total_rqt_quantity = 0;
        for ($i=0; $i <count($request->qty) ; $i++) { 
           if ($request->qty[$i]>0) {
               $total_rqt_quantity += $request->qty[$i];
               if ($request->approve_qty[$i]<($request->total_use_qty[$i]+$request->total_waste[$i]+$request->qty[$i]+$request->waste[$i])) {
                   throw ValidationException::withMessages(['message' => _lang('Too Large Qty Instead of Approve Qty ')]);
               }
               $model =new MaterialReport;
               $model->depertment_store_id=$request->depertment_store_id;
               $model->store_request_id =$request->store_request_id[$i];
               $model->depertment_id=$request->depertment_id[$i];
               $model->raw_material_id =$request->raw_material_id[$i];
               $model->qty =$request->qty[$i];
               $model->waste =$request->waste[$i];
               $model->date=date('Y-m-d');
               $model->done_material_report_id =$request->store_request_id[$i];
               $model->created_by =auth()->user()->id;
               $model->save();
           }
        }
      if($total_rqt_quantity <= 0){
         throw ValidationException::withMessages(['message' => _lang('You Cant Send Zero Quantity')]);
        }

    return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Reported Generated'),'window'=>route('admin.every_matrial_report_print',$request->depertment_store_id),'load'=>true]);
    }


    public function every_matrial_report_print($id,$date=null)
    {
        $toDay =$date?$date:date('Y-m-d');
        $model =MaterialReport::where('depertment_store_id',$id)->where('date',$toDay)->get();
        return view('admin.depertment.report.every_matrial_report_print',compact('model'));
    }


    public function total_matrial_report_print($id)
    {
        $model =MaterialReport::where('depertment_store_id',$id)->get();
        return view('admin.depertment.report.total_matrial_report_print',compact('model'));
    }

    //   ecommerce_report
    public function ecommerce_report () {
        $models = Transaction::where('created_at', Carbon::today())->where('ecommerce_status', '!=', NULL)->where('ecommerce_status', '!=', 'pending')->where('ecommerce_status', '!=', 'cancel')->get();
        return view('admin.report.ecommerce.report',compact('models'));
    }

    // ecommerce_report_date_wise
    public function ecommerce_report_date_wise(Request $request) {
        $status = $request->status;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if($status == 'all') {
            $models = Transaction::where('ecommerce_status', '!=', NULL)->where('date', '>=', $start_date)->where('date', '<=', $end_date)->get();

        } else {
            $models = Transaction::where('ecommerce_status', $status)->where('date', '>=', $start_date)->where('date', '<=', $end_date)->get();
        }
        
        return view('admin.report.ecommerce.data', compact('models', 'start_date', 'end_date', 'status'));
    }

    // ecommerce_report_pdf
    public function ecommerce_report_pdf($date) {
        $date = base64_decode($date);
        
        $ex = explode('to', $date);
        $start = $ex[0];
        $end = trim($ex[1]);

        $start_date = formatDate($start);
        $end_date = formatDate($end);
        
        $models = Transaction::where('ecommerce_status', '!=', NULL)->where('ecommerce_status', '!=', 'pending')->where('ecommerce_status', '!=', 'cancel')->whereBetween('created_at', [$start, $end])->orderBy('id', 'desc')->get();

        return view('admin.report.eCommerce.pdf', compact('models', 'start_date', 'end_date'));

    }
}
