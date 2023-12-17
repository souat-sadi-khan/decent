<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Utilities\TransactionUtil;
use App\models\Client;
use App\models\Production\Transaction;
use App\models\Production\TransactionPayment;
use App\models\email\EmailTemolate;
use App\models\inventory\TransactionSellLine;
use App\models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class ClientController extends Controller
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

    public function index()
    {
      if (!auth()->user()->can('client.create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.client.index');
    }

    public function datatable(Request $request){
       if ($request->ajax()) {
            $document = Client::leftjoin('transactions AS t', 'clients.id', '=', 't.client_id')
                    ->select('clients.name','clients.email','clients.sub_type', 'state', 'country', 'landmark', 'mobile', 'clients.id','t.hidden as hidden',
                        DB::raw("SUM(IF(t.transaction_type = 'Sale', net_total, 0)) as total_invoice"),
                        DB::raw("SUM(IF(t.transaction_type = 'Sale', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as invoice_received"),
                        DB::raw("SUM(IF(t.transaction_type = 'sale_return', net_total, 0)) as total_sell_return"),
                        DB::raw("SUM(IF(t.transaction_type = 'sale_return', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as sell_return_paid"),
                        DB::raw("SUM(IF(t.transaction_type = 'opening_balance', net_total, 0)) as opening_balance"),
                        DB::raw("SUM(IF(t.transaction_type = 'opening_balance', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as opening_balance_paid")
                        )

                    ->groupBy('clients.id');
                    $document->where('clients.type','customer');
                    if (!empty($request->sub_type)) {
                      $document->where('clients.sub_type',$request->sub_type);
                    }
                    if (!auth()->user()->hasRole('Super Admin')) {
                        $document->where('clients.hidden',false);
                    }
            return DataTables::of($document)
                ->addIndexColumn()
                 ->editColumn(
                'landmark',
                     'landmark', function ($model) {
                     $html = '';
                     $html .= $model->landmark ? $model->landmark . ', ' : '';
                     $html .= $model->state ? $model->state . ', ' : '';
                     $html .= $model->country ? $model->country : '';
                     return $html;

                 })
                ->addColumn(
                'due',
                '<span class="display_currency contact_due" data-orig-value="{{$total_invoice - $invoice_received}}" data-currency_symbol=true data-highlight=true>{{($total_invoice - $invoice_received)}}</span>'

                )
               ->addColumn(
                'return_due',
                '<span class="display_currency return_due" data-orig-value="{{$total_sell_return - $sell_return_paid}}" data-currency_symbol=true data-highlight=false>{{$total_sell_return - $sell_return_paid }}</span>'
                )
                ->addColumn(
                'sub_type',
                '<span class="badge btn-danger">{{$sub_type}}</span>'

                )
                ->addColumn('action', function ($model) {
                    return view('admin.client.action', compact('model'));
                })->rawColumns(['action','landmark','due','return_due','sub_type'])->make(true);
        }
    }

    public function get_supplier_index(Request $request)
    {
           if ($request->ajax()) {
            $document = Client::leftjoin('transactions AS t', 'clients.id', '=', 't.client_id')
                    ->select('clients.name','clients.email','clients.sub_type', 'state', 'country', 'landmark', 'mobile', 'clients.id','t.hidden as hidden',
                        DB::raw("SUM(IF(t.transaction_type = 'Purchase', net_total, 0)) as total_invoice"),
                        DB::raw("SUM(IF(t.transaction_type = 'Purchase', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as invoice_received"),
                        DB::raw("SUM(IF(t.transaction_type = 'purchase_return', net_total, 0)) as total_purchase_return"),
                        DB::raw("SUM(IF(t.transaction_type = 'purchase_return', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as purchase_return_paid"),
                        DB::raw("SUM(IF(t.transaction_type = 'opening_balance', net_total, 0)) as opening_balance"),
                        DB::raw("SUM(IF(t.transaction_type = 'opening_balance', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as opening_balance_paid")
                        )

                    ->groupBy('clients.id');
                    $document->where('clients.type','supplier');
                    if (!empty($request->sub_type)) {
                      $document->where('clients.sub_type',$request->sub_type);
                    }
                    if (!auth()->user()->hasRole('Super Admin')) {
                        $document->where('clients.hidden',false);
                    }
            return DataTables::of($document)
                ->addIndexColumn()
                 ->editColumn(
                'landmark', function ($model){
                    $html = '';
                    $html .=  $model->landmark ? $model->landmark . ', ' : '';
                    $html .=  $model->state ? $model->state . ', ' : '';
                    $html .=  $model->country ? $model->country : '';
                    return $html;
                 })
                ->addColumn(
                'due',
                '<span class="display_currency contact_due" data-orig-value="{{$total_invoice - $invoice_received}}" data-currency_symbol=true data-highlight=true>{{($total_invoice - $invoice_received)}}</span>'

                )
               ->addColumn(
                'return_due',
                '<span class="display_currency return_due" data-orig-value="{{$total_purchase_return - $purchase_return_paid}}" data-currency_symbol=true data-highlight=false>{{$total_purchase_return - $purchase_return_paid }}</span>'
                )
                ->addColumn(
                'sub_type',
                '<span class="badge btn-danger">{{$sub_type}}</span>'

                )
                ->addColumn('action', function ($model) {
                    return view('admin.supplier.action', compact('model'));
                })->rawColumns(['action','landmark','due','return_due','sub_type'])->make(true);
        }

        return view('admin.supplier.index');
    }


    public function ecustomer(Request $request)
    {
           if ($request->ajax()) {
            $document = Client::leftjoin('transactions AS t', 'clients.id', '=', 't.client_id')
                    ->select('clients.name','clients.email','clients.address', 'state', 'country', 'landmark', 'mobile', 'clients.id','t.hidden as hidden',
                        DB::raw("SUM(IF(t.transaction_type = 'eCommerce', net_total, 0)) as total_invoice"),
                        DB::raw("SUM(IF(t.transaction_type = 'eCommerce', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as invoice_received")
                        )

                    ->groupBy('clients.id');
                    $document->where('clients.client_type','ecommerce');
                    if (!auth()->user()->hasRole('Super Admin')) {
                        $document->where('clients.hidden',false);
                    }
            return DataTables::of($document)
                ->addIndexColumn()
                 ->editColumn(
                'landmark',
                     'landmark', function ($model) {
                     $html = '';
                     $html .= $model->landmark ? $model->landmark . ', ' : '';
                     $html .= $model->state ? $model->state . ', ' : '';
                     $html .= $model->country ? $model->country : '';
                     return $html;
                 })
                    ->addColumn(
                'due',
                '<span class="display_currency contact_due" data-orig-value="{{$total_invoice - $invoice_received}}" data-currency_symbol=true data-highlight=true>{{($total_invoice - $invoice_received)}}</span>'

                )
                ->addColumn('action', function ($model) {
                    return view('admin.eCommerce.customer.action', compact('model'));
                })->rawColumns(['action','landmark','due'])->make(true);
        }
      return view('admin.eCommerce.customer.index');
    }

    public function ecustomer_view($id)
    {
      $model =Client::where('client_type','ecommerce')->findOrFail($id);
      return view('admin.eCommerce.customer.view',compact('model'));
    }

    // delete
    public function delete($id) {
        $model = Client::findOrFail($id);
        if($model) {
            $model->delete();
        }

        $user = User::where('clients_id', $id)->first();
        if($user) {
            $user->delete();
        }

        $trans = Transaction::where('client_id', $model->id)->get();
        if($trans) {
            foreach ($trans as $item) {
                $item->delete();

                // find the tran payment
                $tranpay = TransactionPayment::where('transaction_id', $item->id)->get();
                if($tranpay) {
                    foreach($tranpay as $tp) {
                        $tp->delete();
                    }
                }

                // find the tran sell line
                $transellline = TransactionSellLine::where('transaction_id', $item->id)->get();
                if($transellline) {
                    foreach($transellline as $tsp) {
                        $tsp->delete();
                    }
                }
                $item->delete();
            }
        }

    return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Customer Deleted Successfully')]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!auth()->user()->can('client.create')) {
            abort(403, 'Unauthorized action.');
        }
        if ($request->type=='supplier') {
          return view('admin.supplier.form');
        }else{
        return view('admin.client.form');
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
        if (!auth()->user()->can('client.create')) {
            abort(403, 'Unauthorized action.');
        }
         $validator = $request->validate([
            'name'=>'required',
            'mobile'=>'required',
            'email'=>'nullable|email',
            'net_total'=>'nullable|numeric',
        ]);

         $input = $request->only(['type',
                'name', 'mobile', 'landline', 'alternate_number', 'city', 'state', 'country', 'landmark', 'email','bank_name','bank_holder','account_name','sub_type']);
         $input['created_by'] = auth()->user()->id;
         $input['client_type']='client';
         $contact = Client::create($input);
         $client_id =$contact->id;
         $type =$request->trans_type;
         $trans_type ='opening_balance';
           //Add opening balance
          if (!empty($request->input('net_total'))) {
                      $this->transactionUtil->createOpeningBalanceTransaction($client_id, $request->input('net_total'),$type,$trans_type);
              }

     return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Created')]);
    }

    public function quick_add(Request $request)
    {
        if (!auth()->user()->can('client.create')) {
            abort(403, 'Unauthorized action.');
        }
        $validator = $request->validate([
            'name'=>'required',
            'mobile'=>'required',
            'email'=>'nullable|email',
            'net_total'=>'nullable|numeric',
        ]);

         $input = $request->only(['type',
                'name', 'mobile', 'landline', 'alternate_number', 'city', 'state', 'country', 'landmark', 'email','bank_name','bank_holder','account_name','sub_type']);
         $input['created_by'] = auth()->user()->id;
         $input['client_type']='client';
         $contact = Client::create($input);
         return response()->json(['id'=>$contact->id,'name'=>$contact->name,'addto'=>'customer_id','modal'=>'contact_modal']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('client.view')) {
            abort(403, 'Unauthorized action.');
        }
              $contact = Client::where('clients.id', $id)
                            ->join('transactions AS t', 'clients.id', '=', 't.client_id')
                            ->select(
                                DB::raw("SUM(IF(t.transaction_type = 'Purchase', net_total, 0)) as total_purchase"),
                                DB::raw("SUM(IF(t.transaction_type = 'Sale', net_total, 0)) as total_invoice"),
                                DB::raw("SUM(IF(t.transaction_type = 'Purchase', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as purchase_paid"),
                                DB::raw("SUM(IF(t.transaction_type = 'Sale', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as invoice_received"),
                                DB::raw("SUM(IF(t.transaction_type = 'sale_return', net_total, 0)) as sale_return"),
                                DB::raw("SUM(IF(t.transaction_type = 'sale_return', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as return_paid"),
                                DB::raw("SUM(IF(t.transaction_type = 'opening_balance', net_total, 0)) as opening_balance"),
                                DB::raw("SUM(IF(t.transaction_type = 'opening_balance', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as opening_balance_paid"),
                                'clients.*'
                            )->first();
        return view('admin.client.show')
             ->with(compact('contact'));
    }


        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function supplier_show($id)
    {
        if (!auth()->user()->can('client.view')) {
            abort(403, 'Unauthorized action.');
        }
          $contact = Client::where('clients.id', $id)
                        ->join('transactions AS t', 'clients.id', '=', 't.client_id')
                        ->select(
                            DB::raw("SUM(IF(t.transaction_type = 'Purchase', net_total, 0)) as total_purchase"),
                            DB::raw("SUM(IF(t.transaction_type = 'Purchase', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as purchase_paid"),
                            DB::raw("SUM(IF(t.transaction_type = 'purchase_return', net_total, 0)) as purchase_return"),
                            DB::raw("SUM(IF(t.transaction_type = 'purchase_return', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as return_paid"),
                            DB::raw("SUM(IF(t.transaction_type = 'opening_balance', net_total, 0)) as opening_balance"),
                            DB::raw("SUM(IF(t.transaction_type = 'opening_balance', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as opening_balance_paid"),
                            'clients.*'
                        )->first();
        return view('admin.supplier.show')
             ->with(compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        if (!auth()->user()->can('client.update')) {
            abort(403, 'Unauthorized action.');
        }
           $model =Client::find($id);
            $ob_transaction =  Transaction::where('client_id', $id)
                                            ->where('transaction_type', 'opening_balance')
                                            ->first();
            $opening_balance = !empty($ob_transaction->net_total) ? $ob_transaction->net_total : 0;

            //Deduct paid amount from opening balance.
            if (!empty($opening_balance)) {
                $opening_balance_paid = $this->getTotalAmountPaid($ob_transaction->id);
                if (!empty($opening_balance_paid)) {
                    $opening_balance = $opening_balance - $opening_balance_paid;
                }

            }
            if ($request->type=='supplier') {
              return view('admin.supplier.form',compact('model','opening_balance'));
            }else{
              return view('admin.client.form',compact('model','opening_balance'));
            }
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
        if (!auth()->user()->can('client.update')) {
            abort(403, 'Unauthorized action.');
        }
        $validator = $request->validate([
            'name'=>'required',
            'mobile'=>'required',
            'email'=>'nullable|email',
            'net_total'=>'nullable|numeric',
        ]);

         $input = $request->only(['type',
                'name', 'mobile', 'landline', 'alternate_number', 'city', 'state', 'country', 'landmark', 'email','bank_name','bank_holder','account_name','sub_type']);
         $input['updated_by'] = auth()->user()->id;
         $contact =Client::find($id);
         $contact->update($input);

        $ob_transaction =  Transaction::where('client_id', $id)
                                        ->where('transaction_type', 'opening_balance')
                                        ->first();

      if (!empty($ob_transaction)) {
                $amount =$request->input('net_total');
                $opening_balance_paid = $this->getTotalAmountPaid($ob_transaction->id);
                if (!empty($opening_balance_paid)) {
                    $amount += $opening_balance_paid;
                }

                $ob_transaction->net_total = $amount;
                $ob_transaction->due = $amount;
                $ob_transaction->save();
                 $this->transactionUtil->updatePaymentStatus($ob_transaction->id, $ob_transaction->net_total);
                //Update opening balance payment status
                // $this->transactionUtil->updatePaymentStatus($ob_transaction->id, $ob_transaction->net_total);
            } else {
                //Add opening balance
                if (!empty($request->input('net_total'))) {
                   $client_id =$id;
                   $type =$request->trans_type;
                   $trans_type ='opening_balance';
                    $this->transactionUtil->createOpeningBalanceTransaction($client_id, $request->input('net_total'),$type,$trans_type);

                }
            }


     return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     if (!auth()->user()->can('client.delete')) {
            abort(403, 'Unauthorized action.');
        }
     $count = Transaction::where('client_id', $id)
                         ->count();
    if ($count == 0) {
       $model= Client::find($id);
        $model->delete();
        if ($model) {
            return response()->json(['success' => true, 'status' => 'success', 'message' => 'Information Delete Successfully.']);
        }
    }
    else{
      throw ValidationException::withMessages(['message' => _lang('You Cannot Delete this Contact')]);
    }

    }

    public function email($id)
    {
        if (!auth()->user()->can('email_marketing.create')) {
            abort(403, 'Unauthorized action.');
        }
        $model =Client::find($id);
        $templates = EmailTemolate::pluck('name','id');
        return view('admin.client.mail',compact('model','templates'));
    }

    public function sms($id)
    {
        if (!auth()->user()->can('sms_marketing.create')) {
            abort(403, 'Unauthorized action.');
        }
        $model =Client::find($id);
        return view('admin.client.sms',compact('model'));
    }


    private function getTotalAmountPaid($transaction_id)
    {
        $paid = TransactionPayment::where(
            'transaction_id',
            $transaction_id
        )->sum('amount');
        return $paid;
    }

   public function customers()
    {
        if (request()->ajax()) {
            $term = request()->input('q', '');

            $contacts = Client::query();

            if (!empty($term)) {
                $contacts->where(function ($query) use ($term) {
                    $query->where('name', 'like', '%' . $term .'%')
                            ->orWhere('mobile', 'like', '%' . $term .'%');
                });
            }
            $contacts->where('client_type','client');

            $contacts = $contacts->select(
                'id',
                'name as text',
                'mobile',
                'landmark',
                'city',
                'state'
            )
             ->get();

            return json_encode($contacts);
        }
    }

 public function getCustomerPayment($id)
    {
        if (request()->ajax()) {
            $query = TransactionPayment::leftjoin('transactions as t', 'transaction_payments.transaction_id', '=', 't.id')
                // ->where('t.type', 'opening_balance')
                ->where('t.client_id', $id)
                ->select(
                    'transaction_payments.amount',
                    'method',
                    'payment_date',
                    'transaction_payments.id as id',
                    't.transaction_type'
                )
                ->groupBy('transaction_payments.id');
            return Datatables::of($query)
                ->editColumn('amount', function ($row) {
                    return '<span class="display_currency paid-amount" data-orig-value="' . $row->amount . '" data-currency_symbol = true>' . $row->amount . '</span>';
                })

                 ->editColumn('action', function ($model) {
                  return '<button class="btn btn-danger btn-sm" id="btn_modal" data-url="'.route('admin.sale.pos.printpayment',$model->id).'">Print</button>';
                 })
                ->rawColumns(['amount', 'method', 'action'])
                ->make(true);
        }
    }
}



