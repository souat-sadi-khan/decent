<?php

namespace App\Http\Controllers\admin\Expense;

use App\Http\Controllers\Controller;
use App\models\Expense\Expense;
use App\models\Expense\ExpenseCategory;
use App\models\account\AccountTransaction;
use App\models\account\InvestmentAccount;
use App\models\employee\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('expense.view')) {
            abort(403, 'Unauthorized action.');
        }
        $categories =ExpenseCategory::pluck('name', 'id');
        $investment =InvestmentAccount::pluck('name', 'id');
        $employeis =Employee::pluck('name', 'id');
        return view('admin.expense.index',compact('categories','investment','employeis'));
    }


    public function datatable(Request $request){
        if ($request->ajax()) {
            $document = Expense::query();
            if (request()->has('investment_account_id')) {
                $investment_account_id = request()->get('investment_account_id');
                if (!empty($investment_account_id)) {
                    $document=$document->where('investment_account_id', $investment_account_id);
                }
            }
            if (request()->has('employee_id')) {
                $employee_id = request()->get('employee_id');
                if (!empty($employee_id)) {
                    $document=$document->where('employee_id', $employee_id);
                }
            }
            if (request()->has('expense_category_id')) {
                $expense_category_id = request()->get('expense_category_id');
                if (!empty($expense_category_id)) {
                    $document=$document->where('expense_category_id', $expense_category_id);
                }
            }
            if (!auth()->user()->hasRole('Super Admin')) {
                $document=$document->where('hidden',false);
            }
            $document=$document->get();
            return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('date', function ($model) {
                    return formatDate($model->date);
                })
                ->editColumn('category', function ($model) {
                    return $model->category?$model->category->name:'';
                })
                ->editColumn('employee', function ($model) {
                    return $model->employee?$model->employee->name:'None';
                })
                ->editColumn('e_amount', function ($model) {
                    if (auth()->user()->can('view_expense.amount')) {
                        return $model->amount;
                    }else{
                        return 'N/A';
                    }
                })
                ->editColumn('account', function ($model) {
                    return $model->investment?$model->investment->name:'';
                })
                ->addColumn('action', function ($model) {
                    return view('admin.expense.action', compact('model'));
                })->rawColumns(['action','category','date','account','e_amount','employee'])->make(true);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('expense.create')) {
            abort(403, 'Unauthorized action.');
        }
        $categories =ExpenseCategory::all();
        $investment =InvestmentAccount::pluck('name', 'id');
        $employeis =Employee::select('name', 'id')->get();
        return view('admin.expense.form',compact('categories','investment','employeis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('expense.create')) {
            abort(403, 'Unauthorized action.');
        }
        $validator = $request->validate([
            'expense_category_id'=>'required|integer',
            'investment_account_id'=>'required|integer',
            'amount'=>'required|numeric',
        ]);

        $model =new Expense;
        $model->employee_id =$request->employee_id;
        $model->investment_account_id =$request->investment_account_id;
        $model->expense_category_id =$request->expense_category_id;
        $model->reson =$request->reson;
        $model->amount =$request->amount;
        $model->note =$request->note;
        $model->date =Carbon::parse(date('Y-m-d'))->format('Y-m-d H:i:s');
        $model->created_by = auth()->user()->id;
        $model->save();

        $account_transaction =new AccountTransaction;
        $account_transaction->amount =$request->amount;
        $account_transaction->investment_account_id=$request->investment_account_id;
        $account_transaction->expense_id=$model->id;
        $account_transaction->type='Debit';
        $account_transaction->acc_type='investment';
        $account_transaction->sub_type='expense';
        $account_transaction->operation_date=Carbon::parse(date('Y-m-d'))->format('Y-m-d H:i:s');
        $account_transaction->created_by = auth()->user()->id;
        $account_transaction->note =$request->note;
        $account_transaction->save();
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Created')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('expense.view')) {
            abort(403, 'Unauthorized action.');
        }
        $model =Expense::find($id);
        return view('admin.expense.show',compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('expense.update')) {
            abort(403, 'Unauthorized action.');
        }
        $categories =ExpenseCategory::all();
        $investment =InvestmentAccount::pluck('name', 'id');
        $employeis =Employee::select('name', 'id')->get();
        $model =Expense::find($id);
        return view('admin.expense.form',compact('categories','model','investment','employeis'));
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
        if (!auth()->user()->can('expense.update')) {
            abort(403, 'Unauthorized action.');
        }
        $validator = $request->validate([
            'expense_category_id'=>'required|integer',
            'investment_account_id'=>'required|integer',
            'amount'=>'required|numeric',
        ]);

        $model =Expense::find($id);
        $model->employee_id =$request->employee_id;
        $model->expense_category_id =$request->expense_category_id;
        $model->investment_account_id =$request->investment_account_id;
        $model->reson =$request->reson;
        $model->amount =$request->amount;
        $model->note =$request->note;
        $model->date =Carbon::parse(date('Y-m-d'))->format('Y-m-d H:i:s');
        $model->updated_by = auth()->user()->id;
        $model->save();

        $account_transaction =AccountTransaction::where('expense_id',$id)->first();
        $account_transaction->investment_account_id=$request->investment_account_id;
        $account_transaction->operation_date=Carbon::parse(date('Y-m-d'))->format('Y-m-d H:i:s');
        $account_transaction->amount =$request->amount;
        $account_transaction->created_by = auth()->user()->id;
        $account_transaction->note =$request->note;
        $account_transaction->save();
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Created')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('expense.delete')) {
            abort(403, 'Unauthorized action.');
        }
        $count =AccountTransaction::where('expense_id',$id)->delete();
        $model =Expense::find($id)->delete();
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Delete')]);
    }
}
