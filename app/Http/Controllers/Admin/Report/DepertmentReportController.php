<?php

namespace App\Http\Controllers\admin\Report;

use App\Http\Controllers\Controller;
use App\User;
use App\models\Production\WorkOrder;
use App\models\depertment\ApproveStoreItem;
use App\models\depertment\Depertment;
use App\models\depertment\DepertmentStore;
use App\models\depertment\MaterialReport;
use App\models\depertment\ProductFlow;
use App\models\depertment\StoreRequest;
use App\models\Production\Product;
use Illuminate\Http\Request;

class DepertmentReportController extends Controller
{
      public function product_report(){
        if (!auth()->user()->can('report.store_department')) {
            abort(403, 'Unauthorized action.');
        }
       $orders =WorkOrder::all();
       $depertments =Depertment::all();
       $users =User::all();
      	return view('admin.report.depertment.product_report',compact('depertments','orders','users'));
      }

      public function get_product_report(Request $request)
      {
         if (!auth()->user()->can('report.store_department')) {
            abort(403, 'Unauthorized action.');
        }
      	$depertment_id =$request->depertment_id;
      	$work_order_id =$request->work_order_id;
      	$user_id =$request->user_id;
      	$sDate =$request->sDate;
      	$eDate =$request->eDate;

      	$q =ProductFlow::query();
      	if ($depertment_id) {
      		$order =Depertment::find($depertment_id);
      		if ($order->flow=='First') {
      		    $q= $q->where('depertment_id',$depertment_id);
      		}
      		else{
      			$q= $q->where('send_depertment_id',$depertment_id);
      		}
      	}
      	if ($work_order_id=='All') {
      		$q=$q;
      	}
      	else
      	{
      		$q= $q->where('work_order_id',$work_order_id);	
      	}
      	if ($user_id=='All') {
      		$q=$q;
      	}
      	else{
      		$q= $q->where('created_by',$user_id);	
      	}
      	if ($sDate && $eDate) {
      		$q=$q->whereBetween('date',[$sDate,$eDate]);
      	}
      	$result =$q->get();
      	return view('admin.report.depertment.product_report_print',compact('result','sDate','eDate','depertment_id','order'));
      }

      public function get_dept_store_request(Request $request)
      {
        if (!auth()->user()->can('report.store_department')) {
            abort(403, 'Unauthorized action.');
        }
        $model =DepertmentStore::where('depertment_id',$request->depertment_id)->get();
        return response()->json($model);
      }

      public function raw_material_report(){
         if (!auth()->user()->can('report.store_department')) {
            abort(403, 'Unauthorized action.');
          }
             $depertments =Depertment::all();
             $users =User::all();
              return view('admin.report.depertment.material_report',compact('depertments','users'));
      }

      public function get_rawmaterial_report(Request $request)
      {
         if (!auth()->user()->can('report.store_department')) {
            abort(403, 'Unauthorized action.');
          }
            $depertment_id =$request->depertment_id;
            $depertment_store_id =$request->depertment_store_id;
            $user_id =$request->user_id;
            $sDate =$request->sDate;
            $eDate =$request->eDate;

            $q =StoreRequest::query();
            if ($depertment_id) {
               $q =$q->where('depertment_id',$depertment_id);
            }
            if ($depertment_store_id=='All') {
               $q=$q;
            }
            else
            {
                $q =$q->where('depertment_store_id',$depertment_store_id);    
            }
            if ($user_id=='All') {
                $q=$q;
            }
            else{
                $q= $q->where('created_by',$user_id);     
            }
            if ($sDate && $eDate) {
                $q=$q->whereBetween('request_date',[$sDate,$eDate]);
            }
            $result=$q->get();
            return view('admin.report.depertment.rawmaterial_report_print',compact('result','sDate','eDate','depertment_id'));
      }

      public function store_material_report(){
         if (!auth()->user()->can('report.store_department')) {
            abort(403, 'Unauthorized action.');
           }
             $depertments =Depertment::all();
             $users =User::all();
              return view('admin.report.depertment.store_material_report',compact('depertments','users'));
      }

      public function get_storematerial_report(Request $request)
      {
        if (!auth()->user()->can('report.store_department')) {
            abort(403, 'Unauthorized action.');
        }
        $depertment_id =$request->depertment_id;
        $user_id =$request->user_id;
        $sDate =$request->sDate;
        $eDate =$request->eDate;
        
        $q =ApproveStoreItem::query();
        if ($depertment_id=='All') {
            $q=$q;
        }
        else{
            $q =$q->where('depertment_id',$depertment_id); 
        }
        if ($user_id=='All') {
            $q=$q;
        }
        else{
            $q =$q->where('updated_by',$user_id);  
        }
        if ($sDate && $eDate) {
                $q=$q->whereBetween('approve_date',[$sDate,$eDate]);
        }
        $result =$q->get();
        return view('admin.report.depertment.storematerial_report_print',compact('result','sDate','eDate','depertment_id'));
      }

      public function product_report_details()
      {
         if (!auth()->user()->can('report.store_department')) {
            abort(403, 'Unauthorized action.');
          }
            $orders =WorkOrder::all();
            $depertments =Depertment::all();
            $users =User::all();
            return view('admin.report.depertment.product_report_details',compact('depertments','orders','users'));
      }

      public function get_product_report_details(Request $request)
      {
         if (!auth()->user()->can('report.store_department')) {
            abort(403, 'Unauthorized action.');
          }
            $depertment_id =$request->depertment_id;
            $work_order_id =$request->work_order_id;
            $user_id =$request->user_id;
            $sDate =$request->sDate;
            $eDate =$request->eDate;

            $q =ProductFlow::query();
            if ($depertment_id) {
                  $order =Depertment::find($depertment_id);
                  $q= $q->where('depertment_id',$depertment_id);
  
              
            }
            if ($work_order_id=='All') {
                  $q=$q;
            }
            else
            {
                  $q= $q->where('work_order_id',$work_order_id);  
            }
            if ($user_id=='All') {
                  $q=$q;
            }
            else{
                  $q= $q->where('created_by',$user_id);     
            }
            if ($sDate && $eDate) {
                  $q=$q->whereBetween('date',[$sDate,$eDate]);
            }
            $result =$q->get();
            return view('admin.report.depertment.product_report_details_print',compact('result','sDate','eDate','depertment_id','order'));  
      }


      public function raw_material_report_details(){
         if (!auth()->user()->can('report.store_department')) {
            abort(403, 'Unauthorized action.');
           }
             $depertments =Depertment::all();
             $users =User::all();
              return view('admin.report.depertment.material_report_details',compact('depertments','users'));
      }

      public function get_rawmaterial_report_details(Request $request)
      {
         if (!auth()->user()->can('report.store_department')) {
            abort(403, 'Unauthorized action.');
          }
            $depertment_id =$request->depertment_id;
            $depertment_store_id =$request->depertment_store_id;
            $user_id =$request->user_id;
            $sDate =$request->sDate;
            $eDate =$request->eDate;

            $q =MaterialReport::query();
            if ($depertment_id) {
               $q =$q->where('depertment_id',$depertment_id);
            }
            if ($user_id=='All') {
                $q=$q;
            }
            else{
                $q= $q->where('created_by',$user_id);     
            }
            if ($sDate && $eDate) {
                $q=$q->whereBetween('date',[$sDate,$eDate]);
            }
            $result=$q->get();
            return view('admin.report.depertment.rawmaterial_report_details_print',compact('result','sDate','eDate','depertment_id'));
      }


    //   ecommerce_report
    public function ecommerce_report () {
    
    }
}
