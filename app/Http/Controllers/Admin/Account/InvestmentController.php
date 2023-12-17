<?php

namespace App\Http\Controllers\admin\Account;

use App\Http\Controllers\Controller;
use App\models\account\AccountTransaction;
use App\models\account\InvestmentAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class InvestmentController extends Controller
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
          $accounts = InvestmentAccount::leftjoin('account_transactions as AT', function ($join) {
                $join->on('AT.investment_account_id', '=', 'investment_accounts.id');
                $join->whereNull('AT.deleted_at');
             })
                ->select(['name', 'account_number', 'investment_accounts.note', 'investment_accounts.id', DB::raw("SUM( IF(AT.type='Credit', amount, -1*amount) ) as balance")])
                ->groupBy('investment_accounts.id');

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
                 ->editColumn('balance', function ($model) {
                                return '<span class="display_currency" data-currency_symbol="true">' . number_format($model->balance,2) . '</span>';
                    })
                ->addColumn('action', function ($model) {
                    return view('admin.accounting.invest.action', compact('model'));
                })->rawColumns(['action','balance'])->make(true);
        }

        return view('admin.accounting.invest.index');
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
        return view('admin.accounting.invest.form');
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
                $input = $request->only(['name', 'account_number', 'note']);
                $user_id = auth()->user()->id;
                $input['created_by'] = $user_id;
                $input['account_type'] = 'saving_current';
               
                $investment = InvestmentAccount::create($input);

                //Opening Balance
                $opening_bal = $request->input('opening_balance');

                if (!empty($opening_bal)) {
                    $ob_transaction_data = [
                        'amount' =>$opening_bal,
                        'investment_account_id' => $investment->id,
                        'type' => 'Credit',
                        'sub_type' => 'opening_balance',
                        'operation_date' => Carbon::now(),
                        'created_by' => $user_id
                    ];

                    AccountTransaction::createAccountTransaction($ob_transaction_data);
                }

                 return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Created')]);
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
         if ($request->ajax()) {
             $q =AccountTransaction::query();

           if (!empty(request()->input('type'))) {
                $q=$q->where('type', request()->input('type'));
            }
            $start_date = request()->input('start_date');
            $end_date = request()->input('end_date');
            
            if (!empty($start_date) && !empty($end_date)) {
                $q=$q->whereBetween(DB::raw('date(operation_date)'), [$start_date, $end_date]);
            }

            $q =$q->where('investment_account_id',$id);
            $document =$q->get();

            return DataTables::of($document)
                ->addIndexColumn()
                 ->editColumn('date', function ($model) {
                  return formatDate($model->date);
                 })

                  ->addColumn('sub_type', function ($row) {
                                if ($row->sub_type == 'deposit') {
                                    return '<span class="badge badge-info">Deposit</span">';
                                }
                                elseif($row->sub_type == 'expense')
                                {
                                    return '<span class="badge badge-danger">Expense</span">';
                                }
                                else
                                {
                                    return '<span class="badge badge-success">Intial Investment</span">';
                                }
                            })
                  ->addColumn('debit', function ($row) {
                                if ($row->type == 'Debit') {
                                    return '<span class="display_currency debit" data-currency_symbol="true" data-orig-value="'.$row->amount.'">' . number_format($row->amount,2) . '</span>';
                                }
                                return '0.00';
                            })
                  ->addColumn('credit', function ($row) {
                                if ($row->type == 'Credit') {
                                    return '<span class="display_currency credit" data-currency_symbol="true" data-orig-value="'.$row->amount.'">' . number_format($row->amount,2) . '</span>';
                                }
                                return '<span class="credit" data-orig-value="'.number_format(0,2).'"></span>';
                            })
                  ->rawColumns(['date','debit','credit','sub_type'])->make(true);
         }

       $investment = InvestmentAccount::find($id);
       $credit =AccountTransaction::where('investment_account_id',$id)->where('type','Credit')->sum('amount');
       $debit =AccountTransaction::where('investment_account_id',$id)->where('type','Debit')->sum('amount');
       $balance =$credit-$debit;
                            
        return view('admin.accounting.invest.show')
                ->with(compact('investment','balance'));
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
        $model =InvestmentAccount::find($id);

        return view('admin.accounting.invest.form',compact('model'));
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
            $input = $request->only(['name', 'account_number', 'note']);

                $account = InvestmentAccount::findOrFail($id);
                $account->name = $input['name'];
                $account->account_number = $input['account_number'];
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
        $model=InvestmentAccount::findOrFail($id);
        //Expense Delete
        $model->expense->delete();
        $model->delete();
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Delete')]);
    }


    /**
     * Investment amount.
     * @param  Request $request
     * @return json
     */
    public function getInvest(Request $request,$id)
    {
        if (!auth()->user()->can('accounting.create')) {
            abort(403, 'Unauthorized action.');
        }
        if ($request->ajax()) {
            $investment=InvestmentAccount::findOrFail($id);
          return view('admin.accounting.invest.investment',compact('investment'));
        }
    }

    /**
     * Investment amount.
     * @param  Request $request
     * @return json
     */
    public function postInvest(Request $request)
    {
       if (!auth()->user()->can('accounting.create')) {
            abort(403, 'Unauthorized action.');
        }
        try {

            $amount = $request->input('amount');
            $investment_account_id = $request->input('investment_account_id');
            $note = $request->input('note');

            if (!empty($amount)) {
                $credit_data = [
                    'amount' => $amount,
                    'investment_account_id' => $investment_account_id,
                    'type' => 'Credit',
                    'acc_type' => 'investment',
                    'sub_type' => 'deposit',
                    'operation_date' => $request->input('operation_date'),
                    'created_by' => auth()->user()->id,
                    'note' => $note
                ];
                $credit = AccountTransaction::createAccountTransaction($credit_data);

                return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Update')]);
            }
            
 
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

        }

    }

}
