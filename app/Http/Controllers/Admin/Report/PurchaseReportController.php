<?php

namespace App\Http\Controllers\admin\Report;

use App\Http\Controllers\Controller;
use App\User;
use App\models\Production\Transaction;
use App\models\Production\TransactionPayment;
use App\models\employee\Employee;
use Illuminate\Http\Request;

class PurchaseReportController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('report.purchase')) {
            abort(403, 'Unauthorized action.');
        }
    	$employee =Employee::all();
    	$users =User::all();

    	return view('admin.report.purchase.index',compact('employee','users'));
    }

    public function get_purchase_report(Request $request)

    {
        if (!auth()->user()->can('report.purchase')) {
            abort(403, 'Unauthorized action.');
        }
    	$purchase_by =$request->purchase_by;
        $user_id =$request->user_id;
        $sDate =$request->sDate;
        $eDate =$request->eDate;

    	$q =Transaction::query();

	    if ($purchase_by=='All') {
        	$q=$q;	
        }
        else{           	
           $q =$q->where('purchase_by',$purchase_by);
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
        $q =$q->where('transaction_type','Purchase');
        if (!auth()->user()->hasRole('Super Admin')) {
                $q=$q->where('hidden',false);
        }
        $result=$q->get();
        return view('admin.report.purchase.purchase_report_print',compact('result','sDate','eDate'));
    }


    public function purchase_payment()
    {
        if (!auth()->user()->can('report.purchase')) {
            abort(403, 'Unauthorized action.');
        }
        $employee =Employee::all();
        if (!auth()->user()->hasRole('Super Admin')) {
         $refs =Transaction::where('transaction_type','Purchase')->select('reference_no','id')->where('hidden',false)->get();
        }else{

         $refs =Transaction::where('transaction_type','Purchase')->select('reference_no','id')->get();
        }
        return view('admin.report.purchase.purchase_payment',compact('employee','refs'));
    }


    public function purchase_payment_report(Request $request)
    {
        if (!auth()->user()->can('report.purchase')) {
            abort(403, 'Unauthorized action.');
        }
        $employee_id =$request->employee_id;
        $transaction_id =$request->transaction_id;
        $sDate =$request->sDate;
        $eDate =$request->eDate;

        $q =TransactionPayment::query();
        if ($employee_id=='All') {
            $q=$q;  
        }
        else{               
           $q =$q->where('employee_id',$employee_id);
        }
        if ($transaction_id=='All') {
            $q=$q;
        }
        else{
            $q= $q->where('transaction_id',$transaction_id);     
        }
        if ($sDate && $eDate) {
            $q=$q->whereBetween('payment_date',[$sDate,$eDate]);
        }
        $q =$q->where('type','Debit');
        $result=$q->groupBy('transaction_id')->select('transaction_id','client_id')->get();
        return view('admin.report.purchase.purchase_payment_report_print',compact('result','sDate','eDate'));

    }

    public function purchase_due()
    {
        if (!auth()->user()->can('report.purchase')) {
            abort(403, 'Unauthorized action.');
        }
        $employee =Employee::all();
        $users =User::all();
        return view('admin.report.purchase.purchase_due',compact('employee','users'));
    }

    public function purchase_due_report(Request $request)
    {
        if (!auth()->user()->can('report.purchase')) {
            abort(403, 'Unauthorized action.');
        }
        $purchase_by =$request->purchase_by;
        $user_id =$request->user_id;
        $sDate =$request->sDate;
        $eDate =$request->eDate;

        $q =Transaction::query();

        if ($purchase_by=='All') {
            $q=$q;  
        }
        else{               
           $q =$q->where('purchase_by',$purchase_by);
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
        $q =$q->where('transaction_type','Purchase');

        if (!auth()->user()->hasRole('Super Admin')) {
                $q=$q->where('hidden',false);
        }
        $result=$q->get();
        return view('admin.report.purchase.purchase_due_report_print',compact('result','sDate','eDate'));
    }
}
