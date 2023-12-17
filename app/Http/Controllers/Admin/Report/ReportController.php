<?php

namespace App\Http\Controllers\admin\Report;

use Illuminate\Http\Request;
use App\models\Client;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
       /**
     * Shows report for Supplier
     *
     * @return \Illuminate\Http\Response
     */
    public function getCustomerSuppliers(Request $request)
    {
         if (!auth()->user()->can('report.customer')) {
            abort(403, 'Unauthorized action.');
         }

        //Return the details in ajax call
        if ($request->ajax()) {
            $contacts = Client::join('transactions AS t', 'clients.id', '=', 't.client_id')
                ->groupBy('clients.id')
                ->select(
                    DB::raw("SUM(IF(t.transaction_type = 'Purchase', net_total, 0)) as total_purchase"),
                    DB::raw("SUM(IF(t.transaction_type = 'purchase_return', net_total, 0)) as total_purchase_return"),
                    DB::raw("SUM(IF(t.transaction_type = 'Sale', net_total, 0)) as total_invoice"),
                    DB::raw("SUM(IF(t.transaction_type = 'Purchase', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as purchase_paid"),
                    DB::raw("SUM(IF(t.transaction_type = 'Sale', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as invoice_received"),
                    DB::raw("SUM(IF(t.transaction_type = 'sale_return', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as sell_return_paid"),
                    DB::raw("SUM(IF(t.transaction_type = 'purchase_return', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as purchase_return_received"),
                    DB::raw("SUM(IF(t.transaction_type = 'sale_return', net_total, 0)) as total_sell_return"),
                    DB::raw("SUM(IF(t.transaction_type = 'opening_balance', net_total, 0)) as opening_balance"),
                    DB::raw("SUM(IF(t.transaction_type = 'opening_balance', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as opening_balance_paid"),
                    'clients.name',
                    'clients.id'
                );

        if (!auth()->user()->hasRole('Super Admin')) {
            $contacts->where('clients.hidden',false);
        }
            return Datatables::of($contacts)
                ->editColumn('name', function ($row) {
                    $name = $row->name;
                    return '<a href="' . route('admin.client.show', $row->id) . '" target="_blank" class="no-print">' .
                            $name .
                        '</a>';
                })
                ->editColumn('total_purchase', function ($row) {
                    return '<span class="total_purchase" data-orig-value="' . $row->total_purchase . '" data-currency_symbol = true>' . $row->total_purchase . '</span>';
                })
                ->editColumn('total_purchase_return', function ($row) {
                    return '<span class="total_purchase_return" data-orig-value="' . $row->total_purchase_return . '" data-currency_symbol = true>' . $row->total_purchase_return . '</span>';
                })
                ->editColumn('total_sell_return', function ($row) {
                    return '<span class="total_sell_return" data-orig-value="' . $row->total_sell_return . '" data-currency_symbol = true>' . $row->total_sell_return . '</span>';
                })
                ->editColumn('total_invoice', function ($row) {
                    return '<span class="total_invoice" data-orig-value="' . $row->total_invoice . '" data-currency_symbol = true>' . $row->total_invoice . '</span>';
                })
                ->addColumn('due', function ($row) {
                    $due = ($row->total_invoice - $row->invoice_received - $row->total_sell_return + $row->sell_return_paid) - ($row->total_purchase - $row->total_purchase_return + $row->purchase_return_received - $row->purchase_paid) + ($row->opening_balance - $row->opening_balance_paid);

                    return '<span class="total_due" data-orig-value="' . $due . '" data-currency_symbol=true data-highlight=true>' . $due .'</span>';
                })
                ->addColumn(
                    'opening_balance_due',
                    '<span class="opening_balance_due" data-currency_symbol=true data-orig-value="{{$opening_balance - $opening_balance_paid}}">{{$opening_balance - $opening_balance_paid}}</span>'
                )
                ->removeColumn('supplier_business_name')
                ->removeColumn('invoice_received')
                ->removeColumn('purchase_paid')
                ->removeColumn('id')
                ->rawColumns(['total_purchase', 'total_invoice', 'due', 'name', 'total_purchase_return', 'total_sell_return', 'opening_balance_due'])
                ->make(true);
        }

        return view('admin.report.customer');
    }


    public function monthly_report(Request $request)
    {
        if (!auth()->user()->can('report.monthly')) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->ajax()) {
	   	    $date =$request->month;
	   	    $ex =explode('-', $date);
	   	    $year=$ex[0];
	   	    $month=$ex[1];
            $days =days_in_month($month, $year);
            return view('admin.report.monthly_ajax',compact('days','month','year'));
        }


   	    $month =date('m');
        $year =date('Y');
        $days =days_in_month($month, $year);
        return view('admin.report.monthly',compact('days','month','year'));
 }


    public function yearly_report(Request $request)
    {
        if (!auth()->user()->can('report.yearly')) {
            abort(403, 'Unauthorized action.');
        }
        if ($request->ajax()) {
	   	    $year =$request->year;
            return view('admin.report.yearly_ajax',compact('year'));
        }
            $year =date('Y');
            return view('admin.report.yearly',compact('year'));
    }
}
