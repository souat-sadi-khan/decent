<?php

namespace App\Http\Controllers\admin\Report;

use App\Http\Controllers\Controller;
use App\User;
use App\models\Expense\Expense;
use App\models\Expense\ExpenseCategory;
use App\models\account\AccountTransaction;
use App\models\account\InvestmentAccount;
use Illuminate\Http\Request;

class ExpenseReportController extends Controller
{
    public function index()
    {
      if (!auth()->user()->can('report.expense')) {
            abort(403, 'Unauthorized action.');
        }
       $categories =ExpenseCategory::all();
       $invest_accounts =InvestmentAccount::all();
       $users =User::all();
       return view('admin.report.expense.index',compact('invest_accounts','categories','users'));
    }



    public function get_expense_report(Request $request)
    {
        if (!auth()->user()->can('report.expense')) {
            abort(403, 'Unauthorized action.');
        }
    	$expense_category_id =$request->expense_category_id;
        $investment_account_id =$request->investment_account_id;
        $user_id =$request->user_id;
        $sDate =$request->sDate;
        $eDate =$request->eDate;
           $q =Expense::query();
            if ($expense_category_id=='All') {
            	$q=$q;	
            }
            else{           	
               $q =$q->where('expense_category_id',$expense_category_id);
            }
            if ($investment_account_id=='All') {
               $q=$q;
            }
            else
            {
                $q =$q->where('investment_account_id',$investment_account_id);    
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
            if (!auth()->user()->hasRole('Super Admin')) {
                $q=$q->where('hidden',false);
            }
            $result=$q->get();
            return view('admin.report.expense.expense_report_print',compact('result','sDate','eDate'));
    }


    public function account()
    {
        if (!auth()->user()->can('report.expense')) {
            abort(403, 'Unauthorized action.');
        }
        $invest_accounts=InvestmentAccount::all();
         $users =User::all();
        return view('admin.report.expense.account',compact('invest_accounts','users'));
    }

    public function get_expense_account_report(Request $request)
    {
        if (!auth()->user()->can('report.expense')) {
            abort(403, 'Unauthorized action.');
        }
        $investment_account_id =$request->investment_account_id;
        $transaction_type =$request->transaction_type;
        $user_id =$request->user_id;
        $sDate =$request->sDate;
        $eDate =$request->eDate;
            $q =AccountTransaction::query();
            $q =$q->where('investment_account_id',$investment_account_id);
            if ($transaction_type=='All') {
               $q=$q;
            }
            else
            {
                $q =$q->where('type',$transaction_type);    
            }

            if ($user_id=='All') {
                $q=$q;
            }
            else{
                $q= $q->where('created_by',$user_id);     
            }
            if ($sDate && $eDate) {
                $q=$q->whereBetween('operation_date',[$sDate,$eDate]);
            }
            if (!auth()->user()->hasRole('Super Admin')) {
                $q=$q->where('hidden',false);
            }
            $result=$q->get();
            $investment=InvestmentAccount::find($investment_account_id);
            return view('admin.report.expense.expense_account_print',compact('result','investment','sDate','eDate','transaction_type'));
    }
}
