<?php

namespace App\Http\Controllers\admin\Sale;

use App\Http\Controllers\Controller;
use App\Utilities\TransactionUtil;
use App\models\Production\Transaction;
use App\models\Production\TransactionPayment;
use App\models\account\Account;
use App\models\account\AccountTransaction;
use App\models\inventory\ReturnTransaction;
use App\models\inventory\TransactionSellLine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class SaleReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $transactionUtil;
    public function __construct(TransactionUtil $transactionUtil)
    {
        $this->transactionUtil = $transactionUtil;
    }
    public function index(Request $request)
    {
        if (!auth()->user()->can('sale_pos.view')) {
            abort(403, 'Unauthorized action.');
        }
         if (request()->ajax()) {

            $sale_returns = Transaction::leftJoin('clients', 'transactions.client_id', '=', 'clients.id')
                    ->leftJoin(
                        'transactions AS T',
                        'transactions.return_parent_id',
                        '=',
                        'T.id'
                    )
                    ->leftJoin(
                        'transaction_payments AS TP',
                        'transactions.id',
                        '=',
                        'TP.transaction_id'
                    )
                    ->where('transactions.transaction_type', 'sale_return')
                    ->select(
                        'transactions.id',
                        'transactions.date',
                        'transactions.reference_no',
                        'clients.name as client_name',
                        'transactions.status',
                        'transactions.payment_status',
                        'transactions.net_total',
                        'transactions.return_parent_id',
                        'T.reference_no as parent_sale',
                        DB::raw('SUM(TP.amount) as amount_paid')
                    )
                    ->groupBy('transactions.id');
            
            if (!empty(request()->client_id)) {
                $client_id = request()->client_id;
                $sale_returns->where('clients.id', $client_id);
            }
            return Datatables::of($sale_returns)
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (!empty($row->return_parent_id)) {
                        $html .= '<a href="' . route('admin.sale.return_sale', $row->return_parent_id) . '" class="btn btn-info btn-sm text-light" ><i class="fa fa-pencil-square-o"></i>' .
                                __("Edit") .
                                '</a>';
                    } else {
                          $html .= '<a href="' . route('admin.admin.sale.return_sale', $row->return_parent_id) . '" class="btn btn-info btn-sm text-light" ><i class="fa fa-pencil-square-o"></i>' .
                                __("Edit") .
                                '</a>';
                    }

                    $html .= '<a data-url="' . route('admin.sale.return.destroy', $row->id) . '" class="btn btn-danger btn-sm text-light" id="delete_item" data-id="'.$row->id.'" ><i class="fa fa-trash"></i>' .
                                __("Delete") .
                                '</a>';
                    
                    
                    return $html;
                })
                ->removeColumn('id')
                ->removeColumn('return_parent_id')
                ->editColumn(
                    'net_total',
                    '<span class="display_currency net_total" data-currency_symbol="true" data-orig-value="{{$net_total}}">{{$net_total}}</span>'
                )
                ->editColumn('transaction_date', '{{$date}}')
               
                ->editColumn(
                    'payment_status',
                    '<span class="view_payment_modal payment-status payment-status-label" data-orig-value="{{$payment_status}}" data-status-name="@if($payment_status != "paid"){{__( $payment_status)}}@else{{__("received")}}@endif"><span class="label @payment_status($payment_status)">@if($payment_status != "paid"){{__( $payment_status)}} @else {{__("received")}} @endif
                        </span></span>'
                )
                ->editColumn('parent_sale', function ($row) {
                    $html = '';
                    if (!empty($row->parent_sale)) {
                        $html = '<a href="#" data-url="' . route('admin.sale.pos.view', $row->return_parent_id) . '" id="content_managment">' . $row->parent_sale . '</a>';
                    }
                    return $html;
                })

                ->editColumn('reference_no', function ($row) {
                    $html = '';
                    if (!empty($row->reference_no)) {
                        $return_id = !empty($row->return_parent_id) ? $row->return_parent_id : $row->id;
                        $html = '<a href="#" data-url="'.route('admin.sale.return.show', $return_id).'" id="content_managment">' . $row->reference_no . '</a>';
                    }
                    return $html;
                })
                ->addColumn('payment_due', function ($row) {
                    $due = $row->net_total - $row->amount_paid;
                    return '<span class="display_currency payment_due" data-currency_symbol="true" data-orig-value="' . $due . '">' . $due . '</sapn>';
                })

                 ->addColumn('client', function ($row) {
                    return $row->client_name;
                })
                ->rawColumns(['net_total', 'action', 'payment_status', 'parent_sale', 'payment_due','client','reference_no'])
                ->make(true);
        }
      return view('admin.sale_return.index');
    }



    public function return_sale(Request $request,$id)
    {
        if (!auth()->user()->can('sale_pos.view')) {
            abort(403, 'Unauthorized action.');
        }
        $sale = Transaction::where('transaction_type', 'Sale')
                        ->with(['sell_lines', 'client', 'return_parent',  'sell_lines.product'])
                        ->find($id);
        $account_id =null;
        $return_id=null;
        if (isset($sale->return_parent)) {
        $return_id =$sale->return_parent->id;
        }
        $account_exit=TransactionPayment::where('transaction_id',$return_id)->first();
        if (isset($account_exit)) {
           $account_id =$account_exit->account_id;
        }
        $accounts = Account::forDropdown(false, false);
        foreach ($sale->sell_lines as $key => $value) {
            $qty_available = $value->qty;

            $sale->sell_lines[$key]->formatted_qty_available = $qty_available;
        }
       return view('admin.sale_return.add',compact('sale','accounts','account_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $transaction=Transaction::where('transaction_type','Sale')->select('id','reference_no')->get();
        return view('admin.sale_return.create',compact('transaction'));
    }


    public function return_check(Request $request)
    {
     $transaction_id =$request->transaction_id;
     return response()->json(['success' => true, 'status' => 'success', 'message' =>'Checking Successfully','goto'=>route('admin.sale.return_sale',$transaction_id)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('sale_pos.view')) {
            abort(403, 'Unauthorized action.');
        }

         $validator = $request->validate([
            'total_return'=>'required',
        ]);
         // if ($request->total_return==0) {
         //     # code...
         // }
        $sale = Transaction::where('transaction_type', 'Sale')
                        ->with(['sell_lines'])
                        ->findOrFail($request->input('transaction_id'));

            $return_quantities = $request->input('returns');
            $sale_type = $request->input('sale_type');
            $return_total = 0;

            foreach ($sale->sell_lines as $sale_line) {
                $old_return_qty = $sale_line->quantity_returned;

                $return_quantity = !empty($return_quantities[$sale_line->id]) ? $return_quantities[$sale_line->id] : 0;

                $sale_line->quantity_returned = $return_quantity;
                $sale_line->save();
                $return_total += $sale_line->unit_price * $sale_line->quantity_returned;
                //Decrease quantity in variation location details
                if ($old_return_qty != $sale_line->quantity_returned) {
                    $this->transactionUtil->updateProductQuantity(
                        $sale_line->product_id,
                        $sale_line->variation_id,
                        $sale_line->brand_id,
                        $return_quantity,
                        $old_return_qty,
                        $sale_type
                    );
                }
             }

            // $return_total_inc_tax = $return_total;

            $return_transaction_data = [
                'discount'=>$request->discount,
                'discount_type'=>$request->discount_type,
                'discount_amount'=>$request->discount_amount,
                'tax'=>$request->tax_amount,
                'sub_total' => $return_total,
                'net_total' => $request->total_return,
                'paid' => $request->total_return
            ];

            if (empty($request->input('ref_no'))) {
                //Update reference count
                $return_transaction_data['reference_no'] = $this->transactionUtil->setReference('sale_return');
            }
            
            $return_transaction = Transaction::where('transaction_type', 'sale_return')->where('return_parent_id', $sale->id)->first();

            if (!empty($return_transaction)) {
                $return_transaction->update($return_transaction_data);
            } else {
                $return_transaction_data['transaction_type'] = 'sale_return';
                $return_transaction_data['status'] = 'final';
                $return_transaction_data['client_id'] = $sale->client_id;
                $return_transaction_data['date'] = Carbon::now();
                $return_transaction_data['created_by'] = auth()->user()->id;
                $return_transaction_data['type'] = 'Debit';
                $return_transaction_data['return_parent_id'] = $sale->id;

                $return_transaction = Transaction::create($return_transaction_data);
            }

            $return_payment =TransactionPayment::where('transaction_id',$return_transaction->id)->first();
            $payment_data['client_id']=$sale->client_id;
            $payment_data['method']='cash';
            $payment_data['type']='Debit';
            $payment_data['payment_date']=date('Y-m-d');
            $payment_data['amount']=$return_transaction->net_total;
            if (!empty($return_payment)) {
                $return_payment->update($payment_data);
            }else{
                $payment_data['transaction_id']=$return_transaction->id;
                $return_payment=TransactionPayment::create($payment_data);
            }

            if ($request->account_id) {
              $this->account_transaction($return_payment->id,$request->account_id);
            }

            //update payment status
            $this->transactionUtil->updatePaymentStatus($return_transaction->id, $return_transaction->net_total);

            $sale->return=true;
            $sale->save(); 

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Sales Return'),'window'=>route('admin.sale.return.printpage',$return_transaction->return_parent_id)]); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    if (!auth()->user()->can('sale_pos.view')) {
            abort(403, 'Unauthorized action.');
        }
     $model = Transaction::with(['return_parent', 'sell_lines', 'sell_lines.product'])->find($id);
      return view('admin.sale_return.show',compact('model'));
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
        $sale_return = Transaction::where('id', $id)
                                ->where('transaction_type', 'sale_return')
                                ->with(['sell_lines'])
                                ->first();
                
                DB::beginTransaction();

                    $parent_sale = Transaction::where('id', $sale_return->return_parent_id)
                                ->where('transaction_type', 'Sale')
                                ->with(['sell_lines'])
                                ->first();

                    $updated_sale_lines = $parent_sale->sell_lines;
                    foreach ($updated_sale_lines as $sale_line) {
                        $this->transactionUtil->updateProductQuantity($sale_line->variation_id,$sale_line->brand_id,$sale_line->product_id, $sale_line->quantity_returned, 0, null, false);
                        $sale_line->quantity_returned = 0;
                        $sale_line->save();
                    }
                

                //Delete Transaction
                $sale_return->delete();

                //Delete account transactions
                AccountTransaction::where('transaction_id', $id)->delete();

                DB::commit();

                return response()->json(['status' => 'success', 'message' => 'Data is deleted successfully']);
    }

    public function printpage($id)
    {
        $model =Transaction::with(['return_parent', 'sell_lines', 'sell_lines.product'])->find($id);;
        return view('admin.sale_return.printpage',compact('model'));
    }


    private function account_transaction($payment_id,$account_id)
    {
        $payment = TransactionPayment::findOrFail($payment_id);
        $payment->account_id = $account_id;
        $payment->save();
        $payment_type = !empty($payment->transaction->transaction_type) ? $payment->transaction->transaction_type : null;
        if (empty($payment_type)) {
            $child_payment = TransactionPayment::where('parent_id', $payment->id)->first();
            $payment_type = !empty($child_payment->transaction->transaction_type) ? $child_payment->transaction->transaction_type : null;
        }
        $acc_type ='account';

        AccountTransaction::updateAccountTransaction($payment, $payment_type,$acc_type);
    }

}
