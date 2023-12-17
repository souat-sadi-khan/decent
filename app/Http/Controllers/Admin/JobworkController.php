<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\JobWork;
use App\Utilities\TransactionUtil;
use App\models\Production\Transaction;
use App\models\Production\TransactionPayment;
use App\models\Production\VariationTemplate;
use App\models\Production\WorkOrder;
use App\models\Production\WorkOrderProduct;
use App\models\account\AccountTransaction;
use App\models\account\InvestmentAccount;
use App\models\depertment\Depertment;
use App\models\depertment\ProductFlow;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class JobworkController extends Controller
{

	protected $transactionUtil;
   public function __construct(TransactionUtil $transactionUtil)
    {
        $this->transactionUtil = $transactionUtil;
    }

    public function index(Request $request)
    {
      if (!auth()->user()->can('job_work.view')) {
            abort(403, 'Unauthorized action.');
        }
    	   if ($request->ajax()) {
            $q=Transaction::query();
            $q =$q->where('transaction_type','job_work');
            $document =$q->get();

            return DataTables::of($document)
                ->addIndexColumn()
                 ->editColumn('date', function ($model) {
                  return formatDate($model->date);
                 })
                 ->editColumn('paid', function ($model) {
                    return $model->payment()->sum('amount');
                 })
                ->editColumn('due', function ($model) {
                    return $model->net_total-($model->payment()->sum('amount'));
                 })

                 ->editColumn('payment_status', function ($model) {
                   if ($model->payment_status=='paid') {
                      return '<span class="badge badge-success">Paid</span>';
                   }

                   else{
                    return '<span class="badge badge-danger">Due</span>';
                   }
                 })
                 ->editColumn('job_work_status', function ($model) {
                   if ($model->job_work_status=='pendding') {
                      return '<span class="badge badge-success">Pendding</span>';
                   }
                   elseif($model->job_work_status=='Accept'){
                     return '<span class="badge badge-info">Accept</span>';
                   }
                   else{
                    return '<span class="badge badge-danger">Partial</span>';
                   }
                 })
                ->addColumn('action', function ($model) {
                    return view('admin.job_work.action', compact('model'));
                })->rawColumns(['action','date','paid','due','payment_status','job_work_status'])->make(true);
        }
      return view('admin.job_work.index');
    }

    public function create()
    {
      if (!auth()->user()->can('job_work.create')) {
            abort(403, 'Unauthorized action.');
        }
    	$workorder =WorkOrder::all();
    	$depertments =Depertment::select('id','name')->get();
    	return view('admin.job_work.create',compact('workorder','depertments'));
    }


    public function get_job_product(Request $request)
    {
    	
        $variations =VariationTemplate::all();
            $products = WorkOrderProduct::
                join('variations', 'work_order_products.variation_id', '=', 'variations.id')
                ->where('work_order_products.workorder_id',$request->id)
                ->select('variations.*')
                ->distinct('product_id')
                ->get();
        $inves_account =InvestmentAccount::all();        
                if (isset($products)) {
                	 return view('admin.job_work.get_product',compact('variations','products','inves_account')); 
                }
              
        
    }


    public function job_work_post(Request $request)
    {
      if (!auth()->user()->can('job_work.create')) {
            abort(403, 'Unauthorized action.');
        }

    	$ym = Carbon::now()->format('Y/m');

        $row = Transaction::where('transaction_type', 'job_work')->withTrashed()->get()->count() > 0 ? Transaction::where('transaction_type', 'job_work')->withTrashed()->get()->count() + 1 : 1;
        
        $ref_no = $ym.'/job-'.ref($row);
        $transaction_data['date']=date('Y-m-d');
        $transaction_data['type']='Debit';
        $transaction_data['reference_no']=$ref_no;
        $transaction_data['transaction_type']='job_work';
        $transaction_data['sub_total']=$request->sub_total;
        $transaction_data['shipping_charges']=$request->shipping_charges;
        $transaction_data['net_total']=$request->net_total;
        $transaction_data['paid']=$request->paid;
        $transaction_data['due']=$request->due;
        $transaction_data['job_work_status']='pendding';
        $transaction_data['job_work_reason']=$request->job_work_reason;
        $transaction_data['job_work_company']=$request->job_work_company;

        if ($request->hidden_qty>0) {
          $transaction =Transaction::create($transaction_data);
           for ($i=0; $i <count($request->qty) ; $i++) { 
            if ($request->qty[$i]>0) {
            $model =new JobWork;
            $model->transaction_id =$transaction->id;
            $model->depertment_id=$request->department_id;
            $model->product_id=$request->product_id[$i];
            $model->variation_id=$request->variation_id[$i];
            $model->work_order_id=$request->work_order_id;
            $model->qty=$request->qty[$i];
            $model->date=date('Y-m-d');
            $model->status='pendding';
            $model->created_by=auth()->user()->id;
            $model->save();
          }
         }

       if (!empty($transaction_data['paid'])) {
            $payment =new TransactionPayment;
            $payment->transaction_id=$transaction->id;
            $payment->method ='Cash';
            $payment->payment_date =$transaction_data['date'];
            $payment->amount =$request->paid;
            $payment->type ='Debit';
            $payment->investment_account_id =$request->investment_account_id;
            $payment->payment_type='investment';
            $payment->created_by =auth()->user()->id;
            $payment->save();
        }

        if ($request->investment_account_id) {
               $acc_transaction =new AccountTransaction;
               $acc_transaction->investment_account_id =$request->investment_account_id;
               $acc_transaction->transaction_id =$transaction->id;
               $acc_transaction->transaction_payment_id =$payment->id;
               $acc_transaction->type ='Debit';
               $acc_transaction->acc_type ='investment';
               $acc_transaction->amount =$request->paid;
               $acc_transaction->reff_no =$transaction->reference_no;
               $acc_transaction->operation_date =date('Y-m-d');
               $acc_transaction->note ='Job Work';
               $acc_transaction->created_by =auth()->user()->id;
               $acc_transaction->save();
        }

        //Update payment status
         $this->transactionUtil->updatePaymentStatus($transaction->id, $transaction->net_total);

          return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Updated'),'goto'=>route('admin.job_work.index')]);
        }
        else
        {
        	throw ValidationException::withMessages(['message' => _lang('You Have No Qty To Job Work')]);
        }

    }

    public function edit($id)
    {
      if (!auth()->user()->can('job_work.update')) {
            abort(403, 'Unauthorized action.');
        }
    	 $model = Transaction::where('transaction_type', 'job_work')
                        ->with(['job_works'])
                        ->find($id); 
        $send_dept =JobWork::where('transaction_id',$model->id)->first();                  
        $depertments =Depertment::select('id','name')->get()->except($send_dept->depertment_id);                                              
       return view('admin.job_work.accept',compact('model','depertments','send_dept'));
    }

    public function update(Request $request)
    {
      if (!auth()->user()->can('job_work.update')) {
            abort(403, 'Unauthorized action.');
        }
      $jobWork = Transaction::where('transaction_type', 'job_work')
                        ->with(['job_works'])
                        ->findOrFail($request->input('transaction_id'));
       for ($i=0; $i <count($request->qty) ; $i++) { 
           if ($request->qty[$i]>0) {
             $rq_qty =$request->total_qty[$i];
             $done_qty =$request->accept_qty[$i];
            if (($done_qty+$request->qty[$i])>$rq_qty) {
               throw ValidationException::withMessages(['message' => _lang('Qty Greater than Total Qty')]);
            }
              $job_work =JobWork::findOrFail($request->job_work_id[$i]);
              $job_work->accept_qty =$job_work->accept_qty+$request->qty[$i];
              $job_work->send_depertment_id =$request->send_depertment_id;
              $job_work->save();
              $this->job_work_status($request->job_work_id[$i]);

              $product_flow =new ProductFlow;
              $product_flow->depertment_id=$request->depertment_id[$i];
              $product_flow->send_depertment_id=$request->send_depertment_id;
              $product_flow->variation_id=$request->variation_id[$i];
              $product_flow->work_order_id=$request->work_order_id[$i];
              $product_flow->product_id=$request->product_id[$i];
              $product_flow->qty=$request->qty[$i];
              $product_flow->date=date('Y-m-d');
              $product_flow->created_by=auth()->user()->id;
              $product_flow->job_work_id=$request->job_work_id[$i];
              $product_flow->save();
           }
        } 
        $this->transaction_status($request->input('transaction_id'));  

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Updated'),'goto'=>route('admin.job_work.index')]);            
    }


    public function payment($id)
    {
      if (!auth()->user()->can('job_work.update')) {
            abort(403, 'Unauthorized action.');
        }
       $transaction = Transaction::where('id', $id)
                                        ->with(['job_works'])
                                        ->first();
      $payments_query = TransactionPayment::where('transaction_id', $id);


      $payments_query->with(['pay_investment']);

       $payments = $payments_query->get();
       $inves_account =InvestmentAccount::all(); 
        return view('admin.job_work.makepayment_modal',compact('transaction','payments','inves_account')); 
    }


public function printpayment($id)
{
  $model =TransactionPayment::find($id);
  $bill_for =_lang('JobWork  for');
  return view('admin.job_work.paymentPrint',compact('model','bill_for'));
}


public function destroy($id)
{
  if (!auth()->user()->can('job_work.delete')) {
            abort(403, 'Unauthorized action.');
        }
  $model=Transaction::findOrFail($id);
  // dd($model->job_works->product_flow);
  foreach ($model->job_works as $work) {
     if ($work->product_flow->count()>0) {
        throw ValidationException::withMessages(['message' => _lang('This Job Work is already accepted to use')]);
     }
  }

  $model->job_works()->delete();
  $model->payment()->delete();
//Delete account transactions
  AccountTransaction::where('transaction_id', $id)->delete();
  $model->delete();

  return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Deleted')]);
}


    private function job_work_status($id)
    {
      $job =JobWork::findOrFail($id);
      $total_qty =$job->qty;
      $accept_qty =$job->accept_qty;
      if ($total_qty==$accept_qty) {
        $status='Accept';
      }
      else{
        $status='Partial';
      }
      $job->status =$status;
      $job->save();
      return true;
    }

    private function transaction_status($id)
    {
      $transaction = Transaction::where('transaction_type', 'job_work')
                        ->with(['job_works'])
                        ->findOrFail($id);
      $totalqty=$transaction->job_works->sum('qty');                
      $total_accept_qty=$transaction->job_works->sum('accept_qty');  

      if ($totalqty==$total_accept_qty) {
        $job_work_status ='Accept';
       } 
       else{
        $job_work_status='Partial';
       }  
       $transaction->job_work_status =$job_work_status;
       $transaction->save();
       return true;           
    }
}
