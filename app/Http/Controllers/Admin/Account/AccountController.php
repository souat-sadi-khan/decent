<?php

namespace App\Http\Controllers\admin\Account;

use App\Http\Controllers\Controller;
use App\models\Production\TransactionPayment;
use App\models\account\Account;
use App\models\account\AccountTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     if (!auth()->user()->can('accounting.view')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
          $accounts = Account::leftjoin('account_transactions as AT', function ($join) {
                $join->on('AT.account_id', '=', 'accounts.id');
                $join->whereNull('AT.deleted_at');
             })
                ->select(['name', 'account_number', 'accounts.note','accounts.account_type', 'accounts.id',
                    'is_closed', DB::raw("SUM( IF(AT.type='Credit', amount, -1*amount) ) as balance")])
                ->groupBy('accounts.id');

            $account_type = request()->input('account_type');

            if ($account_type == 'capital') {
                $accounts->where('account_type', 'capital');
            } elseif ($account_type == 'other') {
                $accounts->where(function ($q) {
                    $q->where('account_type', '!=', 'capital');
                    $q->orWhereNull('account_type');
                });
            }

            return DataTables::of($accounts)
                ->addIndexColumn()
                 ->editColumn('account_type', function ($model) {
                        return toWord($model->account_type);
                    })
                 ->editColumn('balance', function ($model) {
                                return '<span class="display_currency" data-currency_symbol="true">' . number_format($model->balance,2) . '</span>';
                    })
                ->addColumn('action', function ($model) {
                    return view('admin.accounting.account.action', compact('model'));
                })->rawColumns(['action','balance'])->make(true);
        }

          $not_linked_payments = TransactionPayment::leftjoin(
            'transactions as T',
            'transaction_payments.transaction_id',
            '=',
            'T.id'
        )
            ->whereNull('account_id')
            ->count();

        return view('admin.accounting.account.index',compact('not_linked_payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('accounting.create')) {
            abort(403, 'Unauthorized action.');
        }
        $account_types = Account::accountTypes();

        return view('admin.accounting.account.form')
                ->with(compact('account_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('accounting.create')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
                $input = $request->only(['name', 'account_number', 'note','account_type']);
                $user_id = auth()->user()->id;
                $input['created_by'] = $user_id;
                $account = Account::create($input);

                //Opening Balance
                $opening_bal = $request->input('opening_balance');

                if (!empty($opening_bal)) {
                    $ob_transaction_data = [
                        'amount' =>$opening_bal,
                        'account_id' => $account->id,
                        'acc_type'=>'account',
                        'type' => 'Credit',
                        'sub_type' => 'opening_balance',
                        'operation_date' => date('Y-m-d'),
                        'created_by' => $user_id
                    ];

                    AccountTransaction::createAccountTransaction($ob_transaction_data);
                }

                 return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Account Created Successfully')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
     if (!auth()->user()->can('accounting.view')) {
            abort(403, 'Unauthorized action.');
        }


        if (request()->ajax()) {
            $accounts = AccountTransaction::join(
                'accounts as A',
                'account_transactions.account_id',
                '=',
                'A.id'
            )
                            ->where('A.id', $id)
                            ->with(['transaction', 'transaction.client','transaction.employee'])
                            ->select(['type', 'amount', 'operation_date',
                                'sub_type', 'transfer_transaction_id',
                                DB::raw('(SELECT SUM(IF(AT.type="Credit", AT.amount, -1 * AT.amount)) from account_transactions as AT WHERE AT.operation_date <= account_transactions.operation_date AND AT.account_id  =account_transactions.account_id AND AT.deleted_at IS NULL) as balance'),
                                'transaction_id',
                                'account_transactions.id'
                                ])
                             ->groupBy('account_transactions.id')
                             ->orderBy('account_transactions.operation_date', 'desc');
            if (!empty(request()->input('type'))) {
                $accounts->where('account_transactions.type',request()->input('type'));
            }

            $start_date = request()->input('start_date');
            $end_date = request()->input('end_date');
            
            if (!empty($start_date) && !empty($end_date)) {
                $accounts->whereBetween(DB::raw('date(operation_date)'), [$start_date, $end_date]);
            }

            return DataTables::of($accounts)
                            ->addColumn('debit', function ($row) {
                                if ($row->type == 'Debit') {
                                    return '<span class="display_currency" data-currency_symbol="true">' . number_format($row->amount,2) . '</span>';
                                }
                                return '0.00';
                            })
                            ->addColumn('credit', function ($row) {
                                if ($row->type == 'Credit') {
                                    return '<span class="display_currency" data-currency_symbol="true">' . number_format($row->amount,2) . '</span>';
                                }
                                return '0.00';
                            })
                            ->editColumn('balance', function ($row) {
                                return '<span class="display_currency" data-currency_symbol="true">' . number_format($row->balance,2) . '</span>';
                            })
                            ->editColumn('operation_date', function ($row) {
                                return $row->operation_date;
                            })
                            ->editColumn('sub_type', function ($row) {
                                $details = '';
                                if (!empty($row->sub_type)) {
                                    $details = toWord($row->sub_type);
                                    if (in_array($row->sub_type, ['fund_transfer', 'deposit']) && !empty($row->transfer_transaction)) {
                                        if ($row->type == 'Credit') {
                                            $details .= ' ( ' . _lang('Account from') .': ' . $row->transfer_transaction->account->name . ')';
                                        } else {
                                            $details .= ' ( ' . _lang('Account to') .': ' . $row->transfer_transaction->account->name . ')';
                                        }
                                    }
                                } else {
                                    if (!empty($row->transaction->type)) {
                                        if ($row->transaction->transaction_type == 'Purchase') {
                                            $details = '<b>' . _lang('Supplier') . ':</b> ' . $row->transaction->employee->name . '<br><b>'.
                                            _lang('Reference No') . ':</b> ' . $row->transaction->reference_no;
                                        } elseif ($row->transaction->transaction_type == 'Sale') {
                                            $details = '<b>' . _lang('Customer') . ':</b> ' . $row->transaction->client->name . '<br><b>'.
                                            _lang('Reference No') . ':</b> ' . $row->transaction->reference_no;
                                        }elseif ($row->transaction->transaction_type == 'sale_return') {
                                            $details = '<b>' . _lang('Customer') . ':</b> ' . $row->transaction->client->name . '<br><b>'.
                                            _lang('Reference No') . ':</b> ' . $row->transaction->reference_no;
                                        }elseif ($row->transaction->transaction_type == 'opening_balance') {
                                            $details = '<b>' . _lang('Customer') . ':</b> ' . $row->transaction->client->name . '<br><b>'.
                                            _lang('Reference No') . ':</b> ' . $row->transaction->reference_no;
                                        }elseif ($row->transaction->transaction_type == 'job_work') {
                                            $details = 'Job Work';
                                        }
                                    }
                                }

                                return $details;
                            })
                            ->editColumn('action', function ($row) {
                                $action = '';
                                if ($row->sub_type == 'fund_transfer' || $row->sub_type == 'deposit') {
                                     if (auth()->user()->can("accounting.delete")) {
                                    $action = '<button type="button" class="btn btn-danger btn-sm delete_account_transaction" id="delete_item" data-url="' . action('Admin\Account\AccountController@destroy', [$row->id]) . '"><i class="fa fa-trash"></i> ' . _lang('Delete') . '</button>';
                                 }
                                }
                                return $action;
                            })
                            ->removeColumn('id')
                            ->removeColumn('is_closed')
                            ->rawColumns(['credit', 'debit', 'balance', 'sub_type', 'action'])
                            ->make(true);
        }
        $account = Account::find($id);
                            
        return view('admin.accounting.account.show')
                ->with(compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('accounting.update')) {
            abort(403, 'Unauthorized action.');
        }
        $account_types = Account::accountTypes();
        $model =Account::find($id);

        return view('admin.accounting.account.form',compact('model','account_types'));
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
        if (!auth()->user()->can('accounting.update')) {
            abort(403, 'Unauthorized action.');
        }
        if ($request->ajax()) {
        try{
            $input = $request->only(['name', 'account_number', 'note','account_type']);

                $account = Account::findOrFail($id);
                $account->name = $input['name'];
                $account->account_number = $input['account_number'];
                $account->account_type = $input['account_type'];
                $account->note = $input['note'];
                $account->save();
                return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Update')]);
         }
         catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
          return response()->json(['success' => true, 'status' => 'error', 'message' => _lang('Something Wromg')]);
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
       if (!auth()->user()->can('accounting.delete')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {

                $account_transaction = AccountTransaction::findOrFail($id);
                
                if (in_array($account_transaction->sub_type, ['fund_transfer', 'deposit'])) {
                    //Delete transfer transaction for fund transfer
                    if (!empty($account_transaction->transfer_transaction_id)) {
                        $transfer_transaction = AccountTransaction::findOrFail($account_transaction->transfer_transaction_id);
                        $transfer_transaction->delete();
                    }
                    $account_transaction->delete();
                }

                return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Delete')]);

            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            }

        }
    }


        /**
     * Calculates account current balance.
     * @param  int $id
     * @return json
     */
    public function getAccountBalance($id)
    {
        if (!auth()->user()->can('account.access')) {
            abort(403, 'Unauthorized action.');
        }

        $account = Account::leftjoin(
            'account_transactions as AT',
            'AT.account_id',
            '=',
            'accounts.id'
        )
            ->whereNull('AT.deleted_at')
            ->where('accounts.id', $id)
            ->select('accounts.*', DB::raw("SUM( IF(AT.type='credit', amount, -1 * amount) ) as balance"))
            ->first();

        return $account;
    }



        /**
     * Closes the specified account.
     * @return Response
     */
    public function close($id)
    {
        if (!auth()->user()->can('accounting.create')) {
            abort(403, 'Unauthorized action.');
        }
        
        if (request()->ajax()) {
            try {
            
                $account = Account::findOrFail($id);
                $account->is_closed = 1;
                $account->save();
             
                return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Account Closed')]);

            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            }
            
        }
    }


       /**
     * Shows form to transfer fund.
     * @param  int $id
     * @return Response
     */
    public function getFundTransfer($id)
    {
        if (!auth()->user()->can('accounting.create')) {
            abort(403, 'Unauthorized action.');
        }
        
        if (request()->ajax()) {
            
            $from_account = Account::NotClosed()
                            ->find($id);

            $to_accounts = Account::where('id', '!=', $id)
                            ->NotClosed()
                            ->pluck('name', 'id');

            return view('admin.accounting.account.transfer')
                ->with(compact('from_account', 'to_accounts'));
        }
    }


        /**
     * Transfers fund from one account to another.
     * @return Response
     */
    public function postFundTransfer(Request $request)
    {
        if (!auth()->user()->can('account.update')) {
            abort(403, 'Unauthorized action.');
        }
        
        if (request()->ajax()) {
            try {

                $amount = $request->input('amount');
                $from = $request->input('from_account');
                $to = $request->input('to_account');
                $note = $request->input('note');
                if (!empty($amount)) {
                    $debit_data = [
                        'amount' => $amount,
                        'account_id' => $from,
                        'type' => 'Debit',
                        'acc_type'=>'account',
                        'sub_type' => 'fund_transfer',
                        'created_by' => auth()->user()->id,
                        'note' => $note,
                        'transfer_account_id' => $to,
                        'operation_date' =>$request->input('operation_date'),
                    ];

                    DB::beginTransaction();
                    $debit = AccountTransaction::createAccountTransaction($debit_data);

                    $credit_data = [
                            'amount' => $amount,
                            'account_id' => $to,
                            'type' => 'Credit',
                            'acc_type'=>'account',
                            'sub_type' => 'fund_transfer',
                            'created_by' => auth()->user()->id,
                            'note' => $note,
                            'transfer_account_id' => $from,
                            'transfer_transaction_id' => $debit->id,
                            'operation_date' => $request->input('operation_date'),
                        ];

                    $credit = AccountTransaction::createAccountTransaction($credit_data);

                    $debit->transfer_transaction_id = $credit->id;
                    $debit->save();
                    DB::commit();
                }
                
           return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Update')]);

            } catch (\Exception $e) {
                DB::rollBack();
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
 
            }

        }
    }


       /**
     * Shows deposit form.
     * @param  int $id
     * @return Response
     */
    public function getDeposit($id)
    {
        if (!auth()->user()->can('accounting.create')) {
            abort(403, 'Unauthorized action.');
        }
        
        if (request()->ajax()) {

            
            $account = Account::NotClosed()
                            ->find($id);

            $from_accounts = Account::where('id', '!=', $id)
                            // ->where('account_type', 'capital')
                            ->NotClosed()
                            ->pluck('name', 'id');
            return view('admin.accounting.account.deposit')
                ->with(compact('account', 'account', 'from_accounts'));
        }
    }

        /**
     * Deposits amount.
     * @param  Request $request
     * @return json
     */
    public function postDeposit(Request $request)
    {
        if (!auth()->user()->can('accounting.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {

            $amount = $request->input('amount');
            $account_id = $request->input('account_id');
            $note = $request->input('note');

            $from_account = $request->input('from_account');

            $account = Account::findOrFail($account_id);

            if (!empty($amount)) {
                $credit_data = [
                    'amount' => $amount,
                    'account_id' => $account_id,
                    'acc_type'=>'account',
                    'type' => 'Credit',
                    'sub_type' => 'deposit',
                    'operation_date' => $request->input('operation_date'),
                    'created_by' => auth()->user()->id,
                    'note' => $note
                ];
                $credit = AccountTransaction::createAccountTransaction($credit_data);

                $debit_data = $credit_data;
                $debit_data['type'] = 'Debit';
                $debit_data['account_id'] = $from_account;
                $debit_data['transfer_transaction_id'] = $credit->id;

                $debit = AccountTransaction::createAccountTransaction($debit_data);

                $credit->transfer_transaction_id = $debit->id;

                $credit->save();

                return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Update')]);
            }
            
 
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

        }

    }


        /**
     * Displays payment account report.
     * @return Response
     */
    public function payment_account()
    {
        if (!auth()->user()->can('accounting.create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $query = TransactionPayment::leftjoin(
                'transactions as T',
                'transaction_payments.transaction_id',
                '=',
                'T.id'
            )
                                    ->leftjoin('accounts as A', 'transaction_payments.account_id', '=', 'A.id')
                                    ->whereNull('transaction_payments.parent_id')
                                    ->select([
                                        'payment_date',
                                        'T.reference_no',
                                        'T.invoice_no',
                                        'T.transaction_type as transaction_type',
                                        'T.id as transaction_id',
                                        'T.return_parent_id',
                                        'A.name as account_name',
                                        'A.account_number',
                                        'transaction_payments.id as payment_id',
                                        'transaction_payments.account_id'
                                    ]);

            $start_date = !empty(request()->input('start_date')) ? request()->input('start_date') : '';
            $end_date = !empty(request()->input('end_date')) ? request()->input('end_date') : '';

            if (!empty($start_date) && !empty($end_date)) {
                $query->whereBetween(DB::raw('date(payment_date)'), [$start_date, $end_date]);
            }

            $account_id = !empty(request()->input('account_id')) ? request()->input('account_id') : '';
            if (!empty($account_id)) {
                $query->where('account_id', $account_id);
            }
            $query->where('payment_type','account');

            return DataTables::of($query)
                    ->editColumn('payment_date', function ($row) {
                        return $row->payment_date;
                    })
                    ->addColumn('action', function ($row) {
                         if (auth()->user()->can("accounting.update")) {
                        $action = '<button type="button" class="btn btn-info 
                        btn-sm" id="content_managment" data-url="' .route('admin.accounting.getLinkAccount',$row->payment_id) .'" data-container=".view_modal">' . _lang('Link Account') .'</button>';
                        }
                        return $action;
                    })
                    ->addColumn('account', function ($row) {
                        $account = '';
                        if (!empty($row->account_id)) {
                            $account = $row->account_name . ' - ' . $row->account_number;
                        }
                        return $account;
                    })
                    ->addColumn('transaction_number', function ($row) {
                        $html = '';
                        if ($row->transaction_type == 'Sale') {
                            $html = '<button type="button" class="btn btn-success btn-sm"
                                    id="content_managment" data-url="' .route('admin.sale.pos.view',$row->transaction_id) .'" data-container=".view_modal">' . $row->reference_no . '</button>';
                        } elseif ($row->transaction_type == 'Purchase') {
                            $html = '<button type="button" class="btn btn-info btn-sm"
                                    id="content_managment" data-url="' . route('admin.purchase_view',$row->transaction_id) .'" data-container=".view_modal">' . $row->reference_no . '</button>';
                        }
                        elseif ($row->transaction_type == 'sale_return') {
                            $html = '<button type="button" class="btn btn-info btn-sm"
                                    id="content_managment" data-url="' . route('admin.sale.return.show',$row->return_parent_id) .'" data-container=".view_modal">' . $row->reference_no . '</button>';
                        }else{
                            $html='<span class="badge badge-danger">'.$row->reference_no.'</span>';
                        }
                        return $html;
                    })
                    ->editColumn('type', function ($row) {
                       return $type ='<span class="badge badge-info">'.toWord($row->transaction_type).'</span>';
                    })
                    ->filterColumn('account', function ($query, $keyword) {
                        $query->where('A.name', 'like', ["%{$keyword}%"])
                            ->orWhere('account_number', 'like', ["%{$keyword}%"]);
                    })
                    ->filterColumn('transaction_number', function ($query, $keyword) {
                        $query->where('T.invoice_no', 'like', ["%{$keyword}%"])
                            ->orWhere('T.reference_no', 'like', ["%{$keyword}%"]);
                    })
                    ->rawColumns(['action', 'type','transaction_number'])
                    ->make(true);
        }

        $accounts = Account::forDropdown(false,false);
        $accounts->prepend(_lang('All'), '');

        return view('admin.accounting.account.payment_account',compact('accounts'))
               ;
    }


    /**
     * Shows form to link account with a payment.
     * @return Response
     */
    public function getLinkAccount($id)
    {
        if (!auth()->user()->can('accounting.create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $payment = TransactionPayment::findOrFail($id);
            $accounts = Account::forDropdown(false, false);

            return view('admin.accounting.account.link_account_modal')
                ->with(compact('accounts', 'payment'));
        }
    }

        /**
     * Links account with a payment.
     * @param  Request $request
     * @return Response
     */
    public function postLinkAccount(Request $request)
    {
        if (!auth()->user()->can('accounting.create')) {
            abort(403, 'Unauthorized action.');
        }
            if (request()->ajax()) {
                $payment_id = $request->input('transaction_payment_id');
                $account_id = $request->input('account_id');

                $payment = TransactionPayment::findOrFail($payment_id);
                $payment->account_id = $account_id;
                $payment->save();

                $payment_type = !empty($payment->transaction->transaction_type) ? $payment->transaction->transaction_type : null;
                if (empty($payment_type)) {
                    $child_payment = TransactionPayment::where('parent_id', $payment->id)->first();
                    $payment_type = !empty($child_payment->transaction->transaction_type) ? $child_payment->transaction->transaction_type : null;
                }
                $acc_type='account';

                AccountTransaction::updateAccountTransaction($payment, $payment_type,$acc_type);
          return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Link To Account')]);
            }


    }


        /**
     * Show the specified resource.
     * @return Response
     */
    public function cashflow()
    {
        if (!auth()->user()->can('accounting.view')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $accounts = AccountTransaction::join(
                'accounts as A',
                'account_transactions.account_id',
                '=',
                'A.id'
            )
                            ->with(['transaction', 'transaction.client','transaction.employee'])
                            ->select(['type', 'amount', 'operation_date',
                                'sub_type', 'transfer_transaction_id',
                                DB::raw('(SELECT SUM(IF(AT.type="credit", AT.amount, -1 * AT.amount)) from account_transactions as AT WHERE AT.operation_date <= account_transactions.operation_date AND AT.acc_type="account" AND AT.deleted_at IS NULL) as balance'),
                                'transaction_id',
                                'account_transactions.id',
                                'A.name as account_name'
                                ])
                             ->groupBy('account_transactions.id')
                             ->orderBy('account_transactions.operation_date', 'desc');
                             
            if (!empty(request()->input('type'))) {
                $accounts->where('type', request()->input('type'));
            }

            if (!empty(request()->input('account_id'))) {
                $accounts->where('account_transactions.account_id', request()->input('account_id'));
            }

            $start_date = request()->input('start_date');
            $end_date = request()->input('end_date');
            
            if (!empty($start_date) && !empty($end_date)) {
                $accounts->whereBetween(DB::raw('date(operation_date)'), [$start_date, $end_date]);
            }

            return DataTables::of($accounts)
                            ->addColumn('debit', function ($row) {
                                if ($row->type == 'Debit') {
                                    return '<span class="display_currency" data-currency_symbol="true">' . number_format($row->amount,2) . '</span>';

                                }
                                return '0.00';
                               
                            })
                            ->addColumn('credit', function ($row) {
                                if ($row->type == 'Credit') {
                                    return '<span class="display_currency" data-currency_symbol="true">' . number_format($row->amount,2) . '</span>';
                                }
                                return '0.00';
                               
                            })
                            ->editColumn('balance', function ($row) {
                                return '<span class="display_currency" data-currency_symbol="true">' . number_format($row->balance,2) . '</span>';
                            })
                            ->editColumn('operation_date', function ($row) {
                                return $row->operation_date;
                            })
                            ->editColumn('sub_type', function ($row) {
                                $details = '';
                                if (!empty($row->sub_type)) {
                                    $details = toWord( $row->sub_type);
                                    if (in_array($row->sub_type, ['fund_transfer', 'deposit']) && !empty($row->transfer_transaction)) {
                                        if ($row->type == 'Credit') {
                                            $details .= ' ( ' . _lang('Form') .': ' . $row->transfer_transaction->account->name . ')';
                                        } else {
                                            $details .= ' ( ' . _lang('To') .': ' . $row->transfer_transaction->account->name . ')';
                                        }
                                    }
                                } else {

                                    if (!empty($row->transaction->transaction_type)) {
                                        if ($row->transaction->transaction_type == 'Purchase') {
                                            $details = '<b>' . _lang('Supplier') . ':</b> ' . $row->transaction->employee->name . '<br><b>'.
                                            _lang('Reference No') . ':</b> ' . $row->transaction->reference_no;
                                        } elseif ($row->transaction->transaction_type == 'Sale') {
                                            $details = '<b>' . _lang('Customer') . ':</b> ' . $row->transaction->client->name . '<br><b>'.
                                            _lang('Reference No') . ':</b> ' . $row->transaction->reference_no;
                                        }elseif ($row->transaction->transaction_type == 'sale_return') {
                                            $details = '<b>' . _lang('Customer') . ':</b> ' . $row->transaction->client->name . '<br><b>'.
                                            _lang('Reference No') . ':</b> ' . $row->transaction->reference_no;
                                        }elseif ($row->transaction->transaction_type == 'opening_balance') {
                                            $details = '<b>' . _lang('Customer') . ':</b> ' . $row->transaction->client->name . '<br><b>'.
                                            _lang('Reference No') . ':</b> ' . $row->transaction->reference_no;
                                        }elseif ($row->transaction->transaction_type == 'job_work') {
                                            $details = 'Job Work';
                                        }
                                    }
                                }

                                return $details;
                            })
                            ->removeColumn('id')
                            ->rawColumns(['credit', 'debit', 'balance', 'sub_type'])
                            ->make(true);
        }
        $accounts = Account::forDropdown(false, false);

        $accounts->prepend(_lang('All'), '');
                            
        return view('admin.accounting.account.cash_flow')
                 ->with(compact('accounts'));
    }

}
