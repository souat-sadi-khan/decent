<?php

namespace App\Http\Controllers\Admin\Production;

use App\Http\Controllers\Controller;
use App\PurchaseReceived;
use App\SupplierMaterial;
use App\Utilities\TransactionUtil;
use App\models\Client;
use App\models\Production\Product;
use App\models\Production\ProductMaterial;
use App\models\Production\Purchase;
use App\models\Production\RawMaterial;
use App\models\Production\Transaction;
use App\models\Production\TransactionPayment;
use App\models\Production\WorkOrder;
use App\models\account\AccountTransaction;
use App\models\account\InvestmentAccount;
use App\models\employee\Employee;
use App\models\Production\WopMaterial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class PurchaseController extends Controller
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
        if (!auth()->user()->can('purchase.view')) {
            abort(403, 'Unauthorized action.');
        }
        $employeis =Employee::pluck('name','id');
        $clients =Client::where('type','supplier')->pluck('name','id');
        return view('admin.production.purchase.index',compact('employeis','clients'));
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $document = Transaction::query();
              if (request()->has('employee_id')) {
                $employee_id = request()->get('employee_id');
                if (!empty($employee_id)) {
                    $document=$document->where('purchase_by', $employee_id);
                }
            }

               if (request()->has('client_id')) {
                $client_id = request()->get('client_id');
                if (!empty($client_id)) {
                    $document=$document->where('client_id', $client_id);
                }
            }

              if (request()->has('status')) {
                $status = request()->get('status');
                if (!empty($status)) {
                    $document=$document->where('status', $status);
                }
            }
              if (request()->has('payment_status')) {
                $payment_status = request()->get('payment_status');
                if (!empty($payment_status)) {
                    $document=$document->where('payment_status', $payment_status);
                }
            }
             if (!auth()->user()->hasRole('Super Admin')) {
                $document=$document->where('hidden',false);
            }
            $document =$document->where('transaction_type','Purchase')->get();
            return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('purchase_by', function ($document) {
                    return $document->employee?$document->employee->name:'';
                })
                 ->editColumn('client', function ($document) {
                    return $document->client?$document->client->name:'';
                })
                ->editColumn('status', function ($document) {
                    if ($document->status == 'Received') {
                        return '<a href="'.route('admin.purchase.received',$document->id).'"><span class="badge badge-success">' . 'Received' . '</span></a>';
                    } else if($document->status == 'Pending') {
                        return '<a href="'.route('admin.purchase.received',$document->id).'"><span class="badge badge-warning">' . 'Pending' . '</span></a>';
                    } else if($document->status == 'Ordered') {
                        return '<a href="'.route('admin.purchase.received',$document->id).'"><span class="badge badge-info">' . 'Ordered' . '</span></a>';
                    }
                })
                ->editColumn('total', function ($document) {
                    if (auth()->user()->can("view_purchase.price")) {
                        return $document->net_total;
                    }else{
                        return 'N/A';
                    }
                })
                 ->editColumn('reference_no', function ($model) {
                  return '<a title="view Details" data-url="'.route('admin.purchase_view',$model->id).'" class="btn_modal" style="cursor:pointer;color:#12f">'.$model->reference_no.'</a>';
                 })
                ->editColumn('payment_status', function ($document) {
                    if ($document->payment_status == 'paid') {
                        return '<span class="badge badge-success">' . 'Paid' . '</span>';
                    } else if($document->payment_status == 'partial') {
                        return '<span class="badge badge-info">' . 'Partial' . '</span>';
                    } else if($document->payment_status == 'due') {
                        return '<span class="badge badge-info">' . 'Due' . '</span>';
                    }
                })
                ->addColumn('action', function ($model) {
                    return view('admin.production.purchase.action', compact('model'));
                })->rawColumns(['action','status', 'payment_status','total','reference_no','client'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function request()
    {

        return view('admin.production.purchase.request_prev');
    }

    public function create(Request $request)
    {
        if (!auth()->user()->can('purchase.create')) {
            abort(403, 'Unauthorized action.');
        }
        $type = $request->type;
        $models = Employee::all();
        $workorders = WorkOrder::where('status', '=', 'requisition')->get();
        $uniqu_id = generate_id('purchase', false);
        $ym = Carbon::now()->format('Y/m');

        $row = Transaction::where('transaction_type', 'Purchase')->withTrashed()->get()->count() > 0 ? Transaction::where('transaction_type', 'Purchase')->withTrashed()->get()->count() + 1 : 1;

        $ref_no = $ym.'/P-'.ref($row);
        $inves_account =InvestmentAccount::all();
        return view('admin.production.purchase.create', compact('models', 'workorders','type','ref_no','inves_account'));
    }


    public function new_purchase()
    {
        if (!auth()->user()->can('purchase.create')) {
            abort(403, 'Unauthorized action.');
        }
        $models = Employee::all();
        $workorders = WorkOrder::whereIn('status',['requisition','transaction'])->get();
        $uniqu_id = generate_id('purchase', false);
        $ym = Carbon::now()->format('Y/m');

        $row = Transaction::where('transaction_type', 'Purchase')->withTrashed()->get()->count() > 0 ? Transaction::where('transaction_type', 'Purchase')->withTrashed()->get()->count() + 1 : 1;

        $ref_no = $ym.'/P-'.ref($row);
        $inves_account =InvestmentAccount::all();
        $suppliers =Client::where('type','supplier')->get();
        return view('admin.production.purchase.new_purchase', compact('models', 'workorders','ref_no','inves_account','suppliers'));
    }


    public function supplier_material(Request $request)
    {

        if ($request->work_order_id) {
              $wop =WopMaterial::where('wo_id',$request->work_order_id)->pluck('raw_material_id');
              $wop_qty = WopMaterial::where('wo_id',$request->work_order_id)->get();
              $model =SupplierMaterial::with('raw')->where('client_id',$request->client_id)->whereIn('raw_material_id',$wop)->get();
              return view('admin.production.purchase.client_material',compact('model', 'wop_qty'));
          }else{
            $wop_qty = Null;
              $model =SupplierMaterial::with('raw')->where('client_id',$request->client_id)->get();
              return view('admin.production.purchase.client_material',compact('model', 'wop_qty'));
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
        if (!auth()->user()->can('purchase.create')) {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'purchase_by' => 'required',
            'purchase_date' => 'required',
            'status' => 'required',
            'client_id' => 'required',
            'invoice_no' => 'nullable|unique:transactions',
            'reference_no' => 'nullable|unique:transactions',
        ]);

        $code_prefix = get_option('invoice_code_prefix');
        $code_digits = get_option('digits_invoice_code');
        $uniqu_id = generate_id('Purchase', false);
        $uniqu_id = numer_padding($uniqu_id, $code_digits);


        $ym = Carbon::now()->format('Y/m');

        $row = Transaction::where('transaction_type', 'Purchase')->withTrashed()->get()->count() > 0 ? Transaction::where('transaction_type', 'Purchase')->withTrashed()->get()->count() + 1 : 1;

        $ref_no = $ym.'/P-'.ref($row);

        if($request->invoice_no){
            $invoice_no = $request->invoice_no;
        }else{
            $invoice_no = $code_prefix . $uniqu_id;
        }

        $wo_id = $request->wo_id;

        $brand_id = '';
        if ($wo_id) {
            $brand = WorkOrder::findOrFail($wo_id);
            $brand_id = $brand->brand_id;
        }

        if (isset($request->raw_material)) {

        $model = new Transaction;

        $model->purchase_by = $request->purchase_by;
        $model->client_id = $request->client_id;
        $model->reference_no = $request->reference_no;
        $model->invoice_no = $invoice_no;
        $model->date = $request->purchase_date;
        $model->type = 'Debit';
        $model->transaction_type = 'Purchase';
        $model->work_order_id = $wo_id;
        $model->brand_id = $brand_id;
        $model->status = $request->status;
        $model->sub_total = $request->total_before_tax;
        $model->discount = $request->discount_amount;
        $model->discount_type = $request->discount_type;
        $model->discount_amount = $request->total_discount_amount;
        $model->net_total = $request->final_total;
        $model->paid = $request->payment;
        $model->due = $request->payment_due_hidden;
        $model->stuff_note = $request->stuff_notes;
        $model->sell_note = $request->sell_notes;
        $model->transaction_note = $request->transaction_notes;
        $model->tek_marks = 0;
        $model->created_by = Auth::user()->id;
        $model->save();
        $id = $model->id;


        if ($wo_id) {
            $workorders = WorkOrder::findOrFail($wo_id);
            $workorders->transaction_status = 'transaction';
            $workorders->save();
        }

        for ($i = 0; $i < count($request->raw_material); $i++) {
          if ($request->qty[$i]>0) {
            if ($request->status=='Received') {
                $qty =$request->qty[$i];
                $order_qty=$request->qty[$i];
            }else{
               $qty =0;
               $order_qty=$request->qty[$i];
            }
            $purchase = new Purchase;
            $purchase->transaction_id = $id;
            $purchase->raw_material_id = $request->raw_material[$i];
//            $purchase->product_id = $request->product_id[$i];
            $purchase->qty = $qty;
            $purchase->order_qty = $order_qty;
            $purchase->return_qty = 0;
            $purchase->price = $request->unit_price[$i];
            $purchase->unit_id = $request->unit_id[$i];
            $purchase->line_total = $request->price[$i];
//            $purchase->waste = $request->waste[$i];
//            $purchase->uses = $request->uses[$i];
            $purchase->created_by = auth()->user()->id;
            $purchase->save();
            if ($request->status=='Received') {
            $raw = RawMaterial::findOrFail($request->raw_material[$i]);

            $stock = $raw->stock + $request->qty[$i];
            $raw->stock = $stock;
            $raw->save();
           }
          }
        }


        if ($request->payment>0) {
            $payment = new TransactionPayment;
            $payment->transaction_id = $id;
            $payment->client_id = $request->client_id;
            $payment->employee_id = $request->purchase_by;
            $payment->method = $request->method;
            $payment->payment_date = $request->purchase_date;
            $payment->transaction_no = $request->transaction_no;
            $payment->amount = $request->payment;
            $payment->note = $request->payment_note;
            $payment->type = 'Debit';
            $payment->investment_account_id =$request->investment_account_id;
            $payment->payment_type='investment';
            $payment->created_by = auth()->user()->id;
            $payment->save();
        }


        if ($request->investment_account_id) {
               $acc_transaction =new AccountTransaction;
               $acc_transaction->investment_account_id =$request->investment_account_id;
               $acc_transaction->transaction_id =$model->id;
               $acc_transaction->transaction_payment_id =$payment->id;
               $acc_transaction->type ='Debit';
               $acc_transaction->acc_type ='investment';
               $acc_transaction->amount =$request->payment;
               $acc_transaction->reff_no =$model->reference_no;
               $acc_transaction->operation_date =date('Y-m-d');
               $acc_transaction->note ='Purchase';
               $acc_transaction->created_by =auth()->user()->id;
               $acc_transaction->save();
        }

        $this->transactionUtil->updatePaymentStatus($model->id, $model->net_total);

        generate_id('Purchase', true);

        // Activity Log
        activity()->log('Created a Purchase - ' . Auth::user()->id);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data created Successfuly'), 'goto' => route('admin.production-purchase.details',$id)]);
      } else
        {
          throw ValidationException::withMessages(['message' => _lang('Please Select atlest one item to Purchase')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function received(Request $request,$id)
    {
        if ($request->isMethod('Get')) {
            $model=Transaction::findOrFail($id);
            return view('admin.production.purchase.received',compact('model'));
        }elseif ($request->isMethod('Put')) {
            $model=Transaction::findOrFail($id);
             for ($i=0; $i <count($request->qty) ; $i++) {
                if ($request->qty[$i]>0) {
                    $pur =Purchase::findOrFail($request->purchase_id[$i]);
                    $pur->qty=$request->qty[$i];
                    $pur->save();

                    $raw = RawMaterial::findOrFail($request->raw_material_id[$i]);

                    $stock = $raw->stock + $request->qty[$i];
                    $raw->stock = $stock;
                    $raw->save();

                    $received =new PurchaseReceived;
                    $received->transaction_id=$id;
                    $received->purchase_id=$pur->id;
                    $received->raw_material_id=$request->raw_material_id[$i];
                    $received->qty=$request->qty[$i];
                    $received->date=date('Y-m-d');
                    $received->save();
                }
            }
            $model->status=$request->status;
            $model->save();
            activity()->log(' Received Purchase - ' . Auth::user()->id);
           return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Received Successfuly')]);

        }
    }

    public function details($id)
    {
        $model = Transaction::findOrFail($id);
        return view('admin.production.purchase.details', compact('model'));
    }

    public function payment($id)
    {
        $model = Transaction::findOrFail($id);
        $inves_account =InvestmentAccount::all();
        return view('admin.production.purchase.payment', compact('model','inves_account'));
    }

    public function add_payment(Request $request, $id)
    {
        if (!auth()->user()->can('purchase.view')) {
            abort(403, 'Unauthorized action.');
        }
        $transaction = Transaction::find($id);

         if ($transaction->paid+$request->paid_amount>$transaction->net_total) {
             throw ValidationException::withMessages(['message' => _lang('Payble Amount Not> Net Total')]);
          }

        $previously_paid = $transaction->paid;
        $previously_due = $transaction->due;
        $transaction->paid = round(($previously_paid + $request->get('paid_amount')), 2);
        $transaction->due = $previously_due-$request->get('paid_amount');
        $transaction->save();

        $payment = new TransactionPayment;
        $payment->transaction_id = $id;
        $payment->client_id = $transaction->client_id;
        $payment->method = $request->method;
        $payment->payment_date = $request->payment_date;
        $payment->transaction_no = $request->transaction_no;
        $payment->amount = $request->paid_amount;
        $payment->note = $request->payment_note;
        $payment->type = 'Debit';
        $payment->payment_type ='investment';
        $payment->investment_account_id =$request->investment_account_id;
        $payment->created_by = auth()->user()->id;
        $payment->save();

    if ($request->investment_account_id) {
           $acc_transaction =new AccountTransaction;
           $acc_transaction->investment_account_id =$request->investment_account_id;
           $acc_transaction->transaction_id =$transaction->id;
           $acc_transaction->transaction_payment_id =$payment->id;
           $acc_transaction->type ='Debit';
           $acc_transaction->acc_type ='investment';
           $acc_transaction->amount =$request->paid_amount;
           $acc_transaction->reff_no =$transaction->reference_no;
           $acc_transaction->operation_date =date('Y-m-d');
           $acc_transaction->note ='Purchase';
           $acc_transaction->created_by =auth()->user()->id;
           $acc_transaction->save();
        }

         $this->transactionUtil->updatePaymentStatus($transaction->id, $transaction->net_total);

        // Activity Log
        activity()->log('Add Payment - ' . Auth::user()->id);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Update Successfuly')]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('purchase.update')) {
            abort(403, 'Unauthorized action.');
        }
        $received =PurchaseReceived::where('transaction_id',$id)->count();
        if ($received==0) {
          $model = Transaction::findOrFail($id);
          return view('admin.production.purchase.edit', compact('model'));
        }else{
             return redirect('/admin/production-purchase')->with('msg','Can Not Edited This Purchase has Already Received in Received Section');
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
      if (!auth()->user()->can('purchase.update')) {
            abort(403, 'Unauthorized action.');
        }
     if (isset($request->raw_material)) {
        $model = Transaction::findOrFail($id);
        $due =$request->final_total-$model->paid;
        $model->reference_no = $request->reference_no;
        $model->date = $request->purchase_date;
        $model->status = $request->status;
        $model->sub_total = $request->total_before_tax;
        $model->discount = $request->discount_amount;
        $model->discount_type = $request->discount_type;
        $model->discount_amount = $request->total_discount_amount;
        $model->net_total = $request->final_total;
        $model->due = $due;
        $model->stuff_note = $request->stuff_notes;
        $model->sell_note = $request->sell_notes;
        $model->transaction_note = $request->transaction_notes;
        $model->tek_marks = 0;
        $model->updated_by = Auth::user()->id;
        $model->save();

        $type = Purchase::where('transaction_id', $id)->delete();

        for ($i = 0; $i < count($request->raw_material); $i++) {
          if ($request->qty[$i]) {
           if ($request->status=='Received') {
                $qty =$request->qty[$i];
                $order_qty=$request->qty[$i];
            }else{
               $qty =0;
               $order_qty=$request->qty[$i];
            }
            $purchase = new Purchase;
            $purchase->transaction_id = $id;
            $purchase->raw_material_id = $request->raw_material[$i];
            $purchase->product_id = $request->product_id[$i];
            $purchase->qty = $qty;
            $purchase->order_qty = $order_qty;
            $purchase->return_qty = 0;
            $purchase->price = $request->unit_price[$i];
            $purchase->unit_id = $request->unit_id[$i];
            $purchase->line_total = $request->price[$i];
            $purchase->waste = $request->waste[$i];
            $purchase->uses = $request->uses[$i];
            $purchase->created_by = auth()->user()->id;
            $purchase->save();
           if ($request->status=='Received') {
            $raw = RawMaterial::findOrFail($request->raw_material[$i]);
            $stock = $raw->stock;
            $old_qty = ($raw->stock-$request->old_qty[$i]?$request->old_qty[$i]:0);
            $new_stock = $old_qty + $request->qty[$i];
            $raw->stock = $new_stock;
            $raw->save();
           }
          }
        }


        // Activity Log
        activity()->log('Updated a Purchase - ' . Auth::user()->id);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data Updated Successfuly'),'goto' => route('admin.production-purchase.details',$id)]);
      } else
        {
          throw ValidationException::withMessages(['message' => _lang('Please Select atlest one item to Purchase')]);
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
        if (!auth()->user()->can('purchase.delete')) {
            abort(403, 'Unauthorized action.');
        }

        $model = Transaction::with('purchase')->find($id);
        $payment = TransactionPayment::where('transaction_id', $id)->delete();
        foreach ($model->purchase as $key => $pur) {
            $material=RawMaterial::find($pur->raw_material_id);
            $material->stock=$material->stock-$pur->qty;
            $material->save();
        }
        $model->purchase()->delete();
        $received =PurchaseReceived::where('transaction_id',$id)->delete();
        $model->delete();

        return response()->json(['message' => 'Data Deleted Success full']);
    }


    public function getEmployee()
    {
        $people = [];
        $data = [];

        $people = Employee::select('id')
            ->where('name', 'like', '%' . $_GET['term'] . '%')
            ->orWhere('contact_number', 'like', '%' . $_GET['term'] . '%')
            ->orWhere('email', 'like', '%' . $_GET['term'] . '%')
            ->orWhere('code', 'like', '%' . $_GET['term'] . '%')
            ->orderBy('id', 'DESC')
            ->get();

        foreach ($people as $k => $v) {
            $data[$k]['id'] = $v->id;
            $data[$k]['name'] = $this->getCatagoryParent($v->id);
        }
        return response()->json(['items' => $data]);
    }

    public function getCatagoryParent($id, $name = Null)
    {
        $category = Employee::find($id);
        if ($category) {
            $name =  $category->name;
        }
        return $name;
    }



    public function WorkOrder()
    {
        $people = [];
        $data = [];

        $people = WorkOrder::select('id')
            ->where('type', 'like', '%' . $_GET['term'] . '%')
            ->orWhere('code', 'like', '%' . $_GET['term'] . '%')
            ->orderBy('id', 'DESC')
            ->get();

        foreach ($people as $k => $v) {
            $data[$k]['id'] = $v->id;
            $data[$k]['code'] = $this->getWorkOrder($v->id);
        }
        return response()->json(['items' => $data]);
    }

    public function getWorkOrder($id, $code = Null)
    {
        $category = WorkOrder::find($id);
        if ($category) {
            $code =  $category->prefix .'-'. $category->code;
        }
        return $code;
    }


    //Get Product Material Serch
    public function getProduct()
    {
        $people = [];
        $data = [];

        $people = Product::select('id')
            ->where('name', 'like', '%' . $_GET['term'] . '%')
            ->orWhere('articel', 'like', '%' . $_GET['term'] . '%')
            ->orWhere('code', 'like', '%' . $_GET['term'] . '%')
            ->orderBy('id', 'DESC')
            ->get();

        foreach ($people as $k => $v) {
            $data[$k]['id'] = $v->id;
            $data[$k]['name'] = $this->Product_material($v->id);
        }
        return response()->json(['items' => $data]);
    }

    public function Product_material($id, $name = Null)
    {
        $category = Product::find($id);
        if ($category) {
            $name =  $category->name .'('. $category->articel.')';
        }
        return $name;
    }


    //Get Product Material Serch
    public function get_raw_material()
    {
        $people = [];
        $data = [];

        $people = RawMaterial::select('id')
            ->where('name', 'like', '%' . $_GET['term'] . '%')
            ->orderBy('id', 'DESC')
            ->get();

        foreach ($people as $k => $v) {
            $data[$k]['id'] = $v->id;
            $data[$k]['name'] = $this->raw_material($v->id);
        }
        return response()->json(['items' => $data]);
    }

    public function raw_material($id, $name = Null)
    {
        $category = RawMaterial::find($id);
        if ($category) {
            $name =  $category->name;
        }
        return $name;
    }


    public function rawMaterial(Request $request)
    {
        $item = RawMaterial::where('id', $request->id)->first();
        return view('admin.production.purchase.raw-material', compact('item'));
    }

    public function product(Request $request)
    {
        $models = WorkOrder::with('wop_material')->where('id', $request->id)->first();
        return view('admin.production.purchase.work-order', compact('models'));
    }

    public function material(Request $request)
    {
        $models = ProductMaterial::where('product_id', $request->id)->get();
        return view('admin.production.purchase.product-material', compact('models'));
    }

    public function view($id)
    {
     if (!auth()->user()->can('purchase.view')) {
            abort(403, 'Unauthorized action.');
        }
        $model =Transaction::find($id);
        return view('admin.production.purchase.view',compact('model'));
    }
}
