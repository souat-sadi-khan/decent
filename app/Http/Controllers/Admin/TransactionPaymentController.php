<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Utilities\TransactionUtil;
use App\models\Client;
use App\models\Production\Transaction;
use App\models\Production\TransactionPayment;
use App\models\account\AccountTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransactionPaymentController extends Controller
{

  protected $transactionUtil;
   public function __construct(TransactionUtil $transactionUtil)
    {
        $this->transactionUtil = $transactionUtil;
    }
   public function sales_payment(Request $request)

   {
     if (!auth()->user()->can('transaction_payment.view')) {
            abort(403, 'Unauthorized action.');
        }
   	   $validator = $request->validate([
            'payment_date'=>'required',
            'amount'=>'required|numeric',
        ]);

         $transaction = Transaction::find($request->get('transaction_id'));

         if ($transaction->paid+$request->amount>$transaction->net_total) {
             throw ValidationException::withMessages(['message' => _lang('Payble Amount Not> Net Total')]);
          }

            $ref_no = $request->get('reference_no');
            $previously_paid = $transaction->paid;
            $previously_due = $transaction->due;
            $transaction->paid = round(($previously_paid + $request->get('amount')), 2);
            $transaction->due = $previously_due-$request->get('amount');
            $transaction->save();

               //saving paid amount into payment table
            $payment =new TransactionPayment;
            $payment->transaction_id=$transaction->id;
            $payment->client_id=$transaction->client_id;
            $payment->method =$request->method;
            $payment->payment_date =$request->payment_date;
            $payment->transaction_no =$request->check_no;
            $payment->amount =$request->amount;
            $payment->note =$request->note;
            $payment->type ='Credit';
            $payment->created_by =auth()->user()->id;
            $payment->account_id =$request->account_id;
            $payment->save();

            if ($request->account_id) {
               $acc_transaction =new AccountTransaction;
               $acc_transaction->account_id =$request->account_id;
               $acc_transaction->transaction_id =$transaction->id;
               $acc_transaction->transaction_payment_id =$payment->id;
               $acc_transaction->type ='Credit';
               $acc_transaction->acc_type ='account';
               $acc_transaction->amount =$request->amount;
               $acc_transaction->reff_no =$transaction->reference_no;
               $acc_transaction->account_id =$request->account_id;
               $acc_transaction->operation_date =$request->payment_date;
               $acc_transaction->note ='Sale Paid';
               $acc_transaction->created_by =auth()->user()->id;
               $acc_transaction->save();
             }

            $this->transactionUtil->updatePaymentStatus($transaction->id, $transaction->net_total);
            return response()->json(['success' => true, 'status' => 'success', 'message' => 'Payment Successfully.', 'window' => route('admin.sale.pos.printpayment',$payment->id)]);
   }


   public function jobwork_payment(Request $request)
   {
    if (!auth()->user()->can('job_work.update')) {
            abort(403, 'Unauthorized action.');
        }
         $validator = $request->validate([
            'payment_date'=>'required',
            'amount'=>'required|numeric',
        ]);

         $transaction = Transaction::find($request->get('transaction_id'));

        if ($transaction->paid+$request->amount>$transaction->net_total) {
             throw ValidationException::withMessages(['message' => _lang('Payble Amount Not> Net Total')]);
          }

            $ref_no = $request->get('reference_no');
            $previously_paid = $transaction->paid;
            $previously_due = $transaction->due;
            $transaction->paid = round(($previously_paid + $request->get('amount')), 2);
            $transaction->due = $previously_due-$request->get('amount');
            $transaction->save();

               //saving paid amount into payment table
            $payment =new TransactionPayment;
            $payment->transaction_id=$transaction->id;
            $payment->method =$request->method;
            $payment->payment_date =$request->payment_date;
            $payment->transaction_no =$request->check_no;
            $payment->amount =$request->amount;
            $payment->note =$request->note;
            $payment->type ='Debit';
            $payment->investment_account_id =$request->investment_account_id;
            $payment->payment_type='investment';
            $payment->created_by =auth()->user()->id;
            $payment->save();

        if ($request->investment_account_id) {
               $acc_transaction =new AccountTransaction;
               $acc_transaction->investment_account_id =$request->investment_account_id;
               $acc_transaction->transaction_id =$transaction->id;
               $acc_transaction->transaction_payment_id =$payment->id;
               $acc_transaction->type ='Debit';
               $acc_transaction->acc_type ='investment';
               $acc_transaction->amount =$request->amount;
               $acc_transaction->reff_no =$transaction->reference_no;
               $acc_transaction->operation_date =date('Y-m-d');
               $acc_transaction->note ='Job Work';
               $acc_transaction->created_by =auth()->user()->id;
               $acc_transaction->save();
        }

            $this->transactionUtil->updatePaymentStatus($transaction->id, $transaction->net_total);
            return response()->json(['success' => true, 'status' => 'success', 'message' => 'Payment Successfully.', 'window' => route('admin.job_work.printpayment',$payment->id)]);
   }

       /**
     * Shows contact's payment due modal
     *
     * @param  int  $client_id
     * @return \Illuminate\Http\Response
     */
    public function getPayClientDue($client_id)
    {
        if (!auth()->user()->can('transaction_payment.view')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {

            $due_payment_type = request()->input('type');
            $query = Client::where('clients.id', $client_id)
                            ->join('transactions AS t', 'clients.id', '=', 't.client_id');
            if ($due_payment_type == 'Purchase') {
                $query->select(
                        DB::raw("SUM(IF(t.transaction_type = 'Purchase', net_total, 0)) as total_purchase"),
                        DB::raw("SUM(IF(t.transaction_type = 'Purchase', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as total_paid"),
                        'clients.name',
                        'clients.email',
                        'clients.mobile',
                        'clients.id as client_id'
                    );
            } elseif ($due_payment_type == 'purchase_return') {
                $query->select(
                        DB::raw("SUM(IF(t.transaction_type = 'purchase_return', net_total, 0)) as total_purchase_return"),
                        DB::raw("SUM(IF(t.transaction_type = 'purchase_return', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as total_return_paid"),
                        'clients.name',
                        'clients.email',
                        'clients.mobile',
                        'clients.id as client_id'
                    );
            } elseif ($due_payment_type == 'Sale') {
                $query->select(
                    DB::raw("SUM(IF(t.transaction_type = 'Sale', net_total, 0)) as total_invoice"),
                    DB::raw("SUM(IF(t.transaction_type = 'Sale', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as total_paid"),
                    'clients.name',
                    'clients.email',
                    'clients.mobile',
                    'clients.id as client_id'
                );
            } elseif ($due_payment_type == 'sale_return') {
                $query->select(
                        DB::raw("SUM(IF(t.transaction_type = 'sale_return', net_total, 0)) as total_sell_return"),
                        DB::raw("SUM(IF(t.transaction_type = 'sale_return', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as total_return_paid"),
                        'clients.name',
                        'clients.email',
                        'clients.mobile',
                        'clients.id as client_id'
                    );
            }

            //Query for opening balance details
            $query->addSelect(
                DB::raw("SUM(IF(t.transaction_type = 'opening_balance', net_total, 0)) as opening_balance"),
                DB::raw("SUM(IF(t.transaction_type = 'opening_balance', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as opening_balance_paid")
            );
            $contact_details = $query->first();
            
            $payment_line = new TransactionPayment();
            if ($due_payment_type == 'Purchase') {
                $contact_details->total_purchase = empty($contact_details->total_purchase) ? 0 : $contact_details->total_purchase;
                $payment_line->amount = $contact_details->total_purchase -
                                    $contact_details->total_paid;
            } elseif ($due_payment_type == 'purchase_return') {
                $payment_line->amount = $contact_details->total_purchase_return -
                                    $contact_details->total_return_paid;
            } elseif ($due_payment_type == 'Sale') {
                $contact_details->total_invoice = empty($contact_details->total_invoice) ? 0 : $contact_details->total_invoice;

                $payment_line->amount = $contact_details->total_invoice -
                                    $contact_details->total_paid;
            } elseif ($due_payment_type == 'sale_return') {
                $payment_line->amount = $contact_details->total_sell_return -
                                    $contact_details->total_return_paid;
            }

            //If opening balance due exists add to payment amount
            $contact_details->opening_balance = !empty($contact_details->opening_balance) ? $contact_details->opening_balance : 0;
            $contact_details->opening_balance_paid = !empty($contact_details->opening_balance_paid) ? $contact_details->opening_balance_paid : 0;
            $ob_due = $contact_details->opening_balance - $contact_details->opening_balance_paid;
            if ($ob_due > 0) {
                $payment_line->amount += $ob_due;
            }

            $amount_formated = $payment_line->amount;

            $contact_details->total_paid = empty($contact_details->total_paid) ? 0 : $contact_details->total_paid;
            
            $payment_line->method = 'cash';
            $payment_line->payment_date = Carbon::now()->toDateString();
            if ($due_payment_type == 'Purchase') {
              $type ='Debit';
            }else{
                $type='Credit';
            }       

            if ($payment_line->amount > 0) {
                return view('admin.client.pay_due_modal')
                        ->with(compact('contact_details', 'payment_line', 'due_payment_type', 'ob_due', 'amount_formated','type'));
            }
        }
    }

        /**
     * Adds Payments for Contact due
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postPayClientDue(Request  $request)
    {
        if (!auth()->user()->can('transaction_payment.create')) {
            abort(403, 'Unauthorized action.');
          }
           $validator = $request->validate([
            'payment_date'=>'required',
            'amount'=>'required|numeric',
           ]);
            $client_id = $request->input('client_id');
            $inputs = $request->only(['amount', 'method', 'note','payment_date','transaction_no']);
            $inputs['created_by'] = auth()->user()->id;
            $inputs['client_id'] = $client_id;
            $inputs['type'] = $request->type;
            $due_payment_type = $request->input('due_payment_type');
            

            if (!empty($request->input('account_id'))) {
                $inputs['account_id'] = $request->input('account_id');
            }

             if ($request->amount>$request->hidden_amount) {
             throw ValidationException::withMessages(['message' => _lang('Pay Amount Not> Total Total')]);
             }


            DB::beginTransaction();

            $parent_payment = TransactionPayment::create($inputs);

            $inputs['transaction_type'] = $due_payment_type;
            

            //Distribute above payment among unpaid transactions

            $this->transactionUtil->payAtOnce($parent_payment, $due_payment_type);

            DB::commit();

        return response()->json(['success' => true, 'status' => 'success', 'message' => 'Payment Successfully.']);
    }
}
