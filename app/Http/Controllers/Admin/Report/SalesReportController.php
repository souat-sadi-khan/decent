<?php

namespace App\Http\Controllers\admin\Report;

use App\Http\Controllers\Controller;
use App\User;
use App\models\Client;
use App\models\Production\Transaction;
use App\models\Production\TransactionPayment;
use App\models\account\Account;
use App\models\account\InvestmentAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesReportController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('report.selling')) {
            abort(403, 'Unauthorized action.');
        }
    	$client =Client::all();
    	$users =User::all();

    	return view('admin.report.selling.index',compact('client','users'));
    }


    public function get_sales_report(Request $request)

    {
         if (!auth()->user()->can('report.selling')) {
            abort(403, 'Unauthorized action.');
        }
    	$client_id =$request->client_id;
        $sale_type =$request->sale_type;
        $user_id =$request->user_id;
        $sDate =$request->sDate;
        $eDate =$request->eDate;

    	$q =Transaction::query();

	    if ($client_id=='All') {
        	$q=$q;	
        }
        else{           	
           $q =$q->where('client_id',$client_id);
        }
        // if ($sale_type=='All') {
        //     $q=$q;
        // }
        // else{
        //     $q= $q->where('sale_type',$sale_type);     
        // }
        if ($user_id=='All') {
            $q=$q;
        }
        else{
            $q= $q->where('created_by',$user_id);     
        }
        if ($sDate && $eDate) {
            $q=$q->whereBetween('date',[$sDate,$eDate]);
        }
        $q =$q->where('transaction_type','Sale');
         if (!auth()->user()->hasRole('Super Admin')) {
                $q=$q->where('hidden',false);
            }
        $result=$q->get();
        return view('admin.report.selling.sales_report_print',compact('result','sDate','eDate'));
    }

    public function sales_payment()
    {
         if (!auth()->user()->can('report.selling')) {
            abort(403, 'Unauthorized action.');
        }
    	$client =Client::all();
    	$refs =Transaction::where('transaction_type','Sale')->select('reference_no','id')->get();
    	return view('admin.report.selling.sales_payment',compact('client','refs'));
    }


    public function sales_payment_report(Request $request)
    {
         if (!auth()->user()->can('report.selling')) {
            abort(403, 'Unauthorized action.');
        }
    	$client_id =$request->client_id;
        $transaction_id =$request->transaction_id;
        $sDate =$request->sDate;
        $eDate =$request->eDate;

        $q =TransactionPayment::query();
        if ($client_id=='All') {
        	$q=$q;	
        }
        else{           	
           $q =$q->where('client_id',$client_id);
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
        $q =$q->where('type','Credit');
        $result=$q->groupBy('transaction_id')->select('transaction_id','client_id')->get();
        return view('admin.report.selling.sales_payment_report_print',compact('result','sDate','eDate'));

    }

    public function sales_due()
    {
         if (!auth()->user()->can('report.selling')) {
            abort(403, 'Unauthorized action.');
        }
    	$client =Client::all();
    	$users =User::all();
    	return view('admin.report.selling.sales_due',compact('client','users'));
    }

    public function sales_due_report(Request $request)
    {
         if (!auth()->user()->can('report.selling')) {
            abort(403, 'Unauthorized action.');
        }
    	$client_id =$request->client_id;
        $user_id =$request->user_id;
        $sDate =$request->sDate;
        $eDate =$request->eDate;

    	$q =Transaction::query();

	    if ($client_id=='All') {
        	$q=$q;	
        }
        else{           	
           $q =$q->where('client_id',$client_id);
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
        $q =$q->where('transaction_type','Sale');
         if (!auth()->user()->hasRole('Super Admin')) {
                $q=$q->where('hidden',false);
            }
        $result=$q->get();
        return view('admin.report.selling.sales__due_report_print',compact('result','sDate','eDate'));
    }


    public function sale_return()
    {
         if (!auth()->user()->can('report.selling')) {
            abort(403, 'Unauthorized action.');
        }
    	$refs =Transaction::where('transaction_type','Sale')
    	                           ->where('return',true)
    	                           ->get();
    	$client =Client::all();
    	$users =User::all();
    	return view('admin.report.selling.sale_return',compact('refs','client','users'));                           
    }

    public function sale_return_report(Request $request)
    {
         if (!auth()->user()->can('report.selling')) {
            abort(403, 'Unauthorized action.');
        }
        $client_id =$request->client_id;
        $transaction_id =$request->transaction_id;
        $user_id =$request->user_id;
        $sDate =$request->sDate;
        $eDate =$request->eDate;

        $q =Transaction::query();

        if ($client_id=='All') {
            $q=$q;  
        }
        else{               
           $q =$q->where('client_id',$client_id);
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
        $q =$q->where('transaction_type','sale_return');
         if (!auth()->user()->hasRole('Super Admin')) {
                $q=$q->where('hidden',false);
            }
        $result=$q->where('transaction_type','sale_return')->get();
        return view('admin.report.selling.sales__return_report_print',compact('result','sDate','eDate')); 
    }

    public function purchase_sale(Request $request)
    {
         if (!auth()->user()->can('report.purchase_sale')) {
            abort(403, 'Unauthorized action.');
        }
        if ($request->ajax()) {
            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');

            $purchase_details = $this->getPurchaseTotals($start_date, $end_date);
            $sell_details = $this->getSellTotals(
                $start_date,
                $end_date
            );
            // dd($sell_details);

            $transaction_types = [
                'purchase_return', 'sale_return'
            ];

            $transaction_totals = $this->getTransactionTotals(
                $transaction_types,
                $start_date,
                $end_date
            );


            $total_purchase_return_inc_tax = $transaction_totals['total_purchase_return_inc_tax'];
            $total_sell_return_inc_tax = $transaction_totals['total_sell_return_inc_tax'];
            $difference = [
                'total' => $sell_details['total_sell_inc_tax'] + $total_sell_return_inc_tax - $purchase_details['total_purchase_inc_tax'] - $total_purchase_return_inc_tax,
                'due' => $sell_details['invoice_due'] - $purchase_details['purchase_due']
            ];

            return ['purchase' => $purchase_details,
                    'sell' => $sell_details,
                    'total_purchase_return' => $total_purchase_return_inc_tax,
                    'total_sell_return' => $total_sell_return_inc_tax,
                    'difference' => $difference
                ];   
        }
        return view('admin.report.purchase_sell');
    }


    public function trail_balance(Request $request)
    {
        if (!auth()->user()->can('report.trail_balance')) {
            abort(403, 'Unauthorized action.');
         }
            if (request()->ajax()) {

            $end_date = !empty(request()->input('end_date')) ?request()->input('end_date') : \Carbon::now()->format('Y-m-d');

            $purchase_details = $this->getPurchaseTotals(
                null,
                $end_date
            );
            $sell_details = $this->getSellTotals(
                null,
                $end_date
            );

            $account_details = $this->getAccountBalance($end_date);
            $investmet_details = $this->getInvestBalance($end_date);

            // $capital_account_details = $this->getAccountBalance($business_id, $end_date, 'capital');

            $output = [
                'supplier_due' => $purchase_details['purchase_due'],
                'customer_due' => $sell_details['invoice_due'],
                'account_balances' => $account_details,
                'capital_account_details' => null,
                'investmet_details' => $investmet_details,
            ];

            return $output;
        }

        return view('admin.report.trial_balance'); 
    }


       /**
     * Gives the total purchase amount for a business within the date range passed
     *
     * @param int $business_id
     * @param int $transaction_id
     *
     * @return array
     */
    public function getPurchaseTotals( $start_date = null, $end_date = null, $brand_id = null)
    {
        $query = Transaction::where('transaction_type', 'Purchase')
                        ->select(
                            'net_total',
                            DB::raw("(net_total - tax) as total_exc_tax"),
                            DB::raw("SUM((SELECT SUM(tp.amount) FROM transaction_payments as tp WHERE tp.transaction_id=transactions.id)) as total_paid"),
                            DB::raw('SUM(sub_total) as total_before_tax'),
                            'shipping_charges'
                        )
                        ->groupBy('transactions.id');
                       

        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween(DB::raw('date(date)'), [$start_date, $end_date]);
        }

        if (empty($start_date) && !empty($end_date)) {
            $query->whereDate('date', '<=', $end_date);
        }

        if (!auth()->user()->hasRole('Super Admin')) {
            $query->where('hidden',false);
        }

        $purchase_details = $query->get();

        $output['total_purchase_inc_tax'] = $purchase_details->sum('net_total');
        //$output['total_purchase_exc_tax'] = $purchase_details->sum('total_exc_tax');
        $output['total_purchase_exc_tax'] = $purchase_details->sum('total_before_tax');
        $output['purchase_due'] = $purchase_details->sum('net_total') -
                                    $purchase_details->sum('total_paid');
        $output['total_shipping_charges'] = $purchase_details->sum('shipping_charges');

        return $output;
    }

        /**
     * Gives the total sell amount for a business within the date range passed
     *
     * @param int $business_id
     * @param int $transaction_id
     *
     * @return array
     */
    public function getSellTotals( $start_date = null, $end_date = null, $brand_id = null, $created_by = null)
    {
        $query = Transaction::where('transactions.transaction_type', 'Sale')
                    ->select(
                        'transactions.id',
                        'net_total',
                        DB::raw("(net_total - tax) as total_exc_tax"),
                        DB::raw('(SELECT SUM(tp.amount) FROM transaction_payments as tp WHERE tp.transaction_id = transactions.id) as total_paid'),
                        DB::raw('SUM(sub_total) as total_before_tax'),
                        'shipping_charges'
                    )
                    ->groupBy('transactions.id');

        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween(DB::raw('date(date)'), [$start_date, $end_date]);
        }

        if (empty($start_date) && !empty($end_date)) {
            $query->whereDate('date', '<=', $end_date);
        }

        if (!empty($created_by)) {
            $query->where('transactions.created_by', $created_by);
        }

        if (!auth()->user()->hasRole('Super Admin')) {
            $query->where('hidden',false);
        }

        $sell_details = $query->get();

        $output['total_sell_inc_tax'] = $sell_details->sum('net_total');
        //$output['total_sell_exc_tax'] = $sell_details->sum('total_exc_tax');
        $output['total_sell_exc_tax'] = $sell_details->sum('total_before_tax');
        $output['invoice_due'] = $sell_details->sum('net_total') - $sell_details->sum('total_paid');
        $output['total_shipping_charges'] = $sell_details->sum('shipping_charges');

        return $output;
    }

        /**
     * Calculates transaction totals for the given transaction types
     *
     * @param  int $business_id
     * @param  array $transaction_types
     * available types = ['purchase_return', 'sell_return', 'expense',
     * 'stock_adjustment', 'sell_transfer', 'purchase', 'sell']
     * @param  string $start_date = null
     * @param  string $end_date = null
     * @param  int $location_id = null
     * @param  int $created_by = null
     *
     * @return array
     */
    public function getTransactionTotals(
        $transaction_types,
        $start_date = null,
        $end_date = null,
        $location_id = null,
        $created_by = null
        ) {
       $query = Transaction::query();
        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween(DB::raw('date(date)'), [$start_date, $end_date]);
        }

        if (empty($start_date) && !empty($end_date)) {
            $query->whereDate('date', '<=', $end_date);
        }

        //Filter by created_by
        if (!empty($created_by)) {
            $query->where('transactions.created_by', $created_by);
        }

        if (!auth()->user()->hasRole('Super Admin')) {
            $query->where('transactions.hidden',false);
        }

        if (in_array('purchase_return', $transaction_types)) {
            $query->addSelect(
                DB::raw("SUM(IF(transactions.transaction_type='purchase_return', net_total, 0)) as total_purchase_return_inc_tax"),
                DB::raw("SUM(IF(transactions.transaction_type='purchase_return', sub_total, 0)) as total_purchase_return_exc_tax")
            );
        }

        if (in_array('sale_return', $transaction_types)) {
            $query->addSelect(
                DB::raw("SUM(IF(transactions.transaction_type='sale_return', net_total, 0)) as total_sell_return_inc_tax"),
                DB::raw("SUM(IF(transactions.transaction_type='sale_return', sub_total, 0)) as total_sell_return_exc_tax")
            );
        }


        if (in_array('Purchase', $transaction_types)) {
            $query->addSelect(
                DB::raw("SUM(IF(transactions.transaction_type='Purchase', IF(discount_type = 'percentage', COALESCE(discount_amount, 0)*sub_total/100, COALESCE(discount_amount, 0)), 0)) as total_purchase_discount")
            );
        }

        if (in_array('Sale', $transaction_types)) {
            $query->addSelect(
                DB::raw("SUM(IF(transactions.transaction_type='Sale' AND transactions.status='final', IF(discount_type = 'percentage', COALESCE(discount_amount, 0)*sub_total/100, COALESCE(discount_amount, 0)), 0)) as total_sell_discount")
            );
        }

        $transaction_totals = $query->first();
        $output = [];

        if (in_array('purchase_return', $transaction_types)) {
            $output['total_purchase_return_inc_tax'] = !empty($transaction_totals->total_purchase_return_inc_tax) ?
                $transaction_totals->total_purchase_return_inc_tax : 0;

            $output['total_purchase_return_exc_tax'] =
                !empty($transaction_totals->total_purchase_return_exc_tax) ?
                $transaction_totals->total_purchase_return_exc_tax : 0;
        }

        if (in_array('sale_return', $transaction_types)) {
            $output['total_sell_return_inc_tax'] =
                !empty($transaction_totals->total_sell_return_inc_tax) ?
                $transaction_totals->total_sell_return_inc_tax : 0;

            $output['total_sell_return_exc_tax'] =
                !empty($transaction_totals->total_sell_return_exc_tax) ?
                $transaction_totals->total_sell_return_exc_tax : 0;
        }


        if (in_array('Purchase', $transaction_types)) {
            $output['total_purchase_discount'] =
                !empty($transaction_totals->total_purchase_discount) ?
                $transaction_totals->total_purchase_discount : 0;
        }

        if (in_array('Sale', $transaction_types)) {
            $output['total_sell_discount'] =
                !empty($transaction_totals->total_sell_discount) ?
                $transaction_totals->total_sell_discount : 0;
        }
        
        return $output;
    }


    /**
     * Retrives account balances.
     * @return Obj
     */
    private function getAccountBalance($end_date, $account_type = 'others')
    {
        $query = Account::leftjoin(
            'account_transactions as AT',
            'AT.account_id',
            '=',
            'accounts.id'
        )
                                // ->NotClosed()
                                ->whereNull('AT.deleted_at')
                                ->whereDate('AT.operation_date', '<=', $end_date);
                                // ->where('AT.hidden',false);
        if (!auth()->user()->hasRole('Super Admin')) {
            $query->where('AT.hidden',false);
        }
        // if ($account_type == 'others') {
        //    $query->NotCapital();
        // } elseif ($account_type == 'capital') {
        //     $query->where('account_type', 'capital');
        // }

        $account_details = $query->select(['name',
                                        DB::raw("SUM( IF(AT.type='Credit', amount, -1*amount) ) as balance")])
                                ->groupBy('accounts.id')
                                ->get()
                                
                                ->pluck('balance', 'name');


        return $account_details;
    }



    /**
     * Retrives account balances.
     * @return Obj
     */
    private function getInvestBalance($end_date, $account_type = 'others')
    {
        $query = InvestmentAccount::leftjoin(
            'account_transactions as AT',
            'AT.investment_account_id',
            '=',
            'investment_accounts.id'
        )
                                // ->NotClosed()
                                ->whereNull('AT.deleted_at')
                                ->whereDate('AT.operation_date', '<=', $end_date);
                                // ->where('AT.hidden',false);
        if (!auth()->user()->hasRole('Super Admin')) {
            $query->where('AT.hidden',false);
        }
        // if ($account_type == 'others') {
        //    $query->NotCapital();
        // } elseif ($account_type == 'capital') {
        //     $query->where('account_type', 'capital');
        // }

        $investmet_details = $query->select(['name',
                                        DB::raw("SUM( IF(AT.type='Credit', amount, -1*amount) ) as balance")])
                                ->groupBy('investment_accounts.id')
                                ->get()
                                
                                ->pluck('balance', 'name');


        return $investmet_details;
    }

}
