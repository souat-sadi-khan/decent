<?php

namespace App\Http\Controllers;

use App\models\Expense\Expense;
use App\models\Production\Transaction;
use Carbon\Carbon;
// use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_sell =Transaction::whereIn('transaction_type',['Sale','eCommerce'])->sum('net_total');
        $total_purchase =Transaction::where('transaction_type','Purchase')->sum('net_total');

        $sells_chart = Transaction::where('transaction_type','Sale')->where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y'))
                    ->get();
        // $sells_graph = Charts::database($sells_chart, 'bar', 'highcharts')
        //           ->title("Monthly Sale")
        //           ->elementLabel("Total Sale")
        //           ->dimensions(1000, 500)
        //           ->responsive(true)
        //           ->groupByMonth(date('Y'), true);

        $purchase_chart = Transaction::where('transaction_type','Purchase')->where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y'))
                    ->get();
        // $purchase_graph = Charts::database($purchase_chart, 'bar', 'highcharts')
        //           ->title("Monthly Purchase")
        //           ->elementLabel("Total Purchase")
        //           ->dimensions(1000, 500)
        //           ->responsive(true)
        //           ->groupByMonth(date('Y'), true);

        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        $dates = [];
        $sells_line = [];
        $purchase_line=[];
            while ($start->lte($end)) {
                  $date = $start->copy();
                  $start->addDay();
                  $purchase_line[] =Transaction::where('transaction_type','Purchase')->whereDate('date',$date->format('Y-m-d'))->sum('net_total');
                  $sells_line[] =Transaction::where('transaction_type','Sale')->whereDate('date',$date->format('Y-m-d'))->sum('net_total');
                  $dates[]=$date->format('d');
            }         

            //  $line =Charts::multi('areaspline', 'highcharts')
            //         ->title('Sale vs Purchase')
            //         ->colors(['#ff0000', '#ffffff'])
            //         ->labels($dates)
            //         ->dataset('Sale', $sells_line)
            //         ->responsive(true)
            //         ->dataset('Purchase', $purchase_line);


            $expense =Expense::sum('amount');
            // $donut =Charts::create('donut', 'highcharts')
            //         ->title('Estimate Amount')
            //         ->labels(['Sale', 'Purchase', 'Expense'])
            //         ->values([$total_sell,$total_purchase,$expense])
            //         ->dimensions(1000,500)
            //         ->responsive(true);
        // return view('home',compact(
        //     'sells_graph',
        //     'line',
        //     'purchase_graph',
        //     'donut'
        // ));
        return view('home');
    }
}
