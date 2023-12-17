<?php

namespace App\Http\Controllers\Admin\Production;

use App\Http\Controllers\Controller;
use App\Utilities\TransactionUtil;
use App\models\Production\Brand;
use App\models\Production\Product;
use App\models\Production\ProductMaterial;
use App\models\Production\RawMaterial;
use App\models\Production\Transaction;
use App\models\Production\TransactionPayment;
use App\models\Production\Variation;
use App\models\Production\WorkOrder;
use App\models\Production\WorkOrderProduct;
use App\models\account\Account;
use App\models\account\AccountTransaction;
use App\models\depertment\ProductFlow;
use App\models\depertment\StoreRequest;
use App\models\inventory\TransactionSellLine;
use App\models\Production\VariationBrandDetails;
use App\models\Production\VariationTemplateDetails;
use App\models\Production\WorkOrderDelivery;
use App\models\Production\WorkOrderDeliveryItem;
use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Yajra\Datatables\Datatables;

class WorkOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
   protected $transactionUtil;
   public function __construct(TransactionUtil $transactionUtil)
    {
        $this->transactionUtil = $transactionUtil;
    }

    public function index()
    {
        if (!auth()->user()->can('workorder.view')) {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.production.work_order.index');
    }


    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $document = WorkOrder::query();
            if (!empty($request->status)) {
                $document =$document->where('status', $request->status);
            }
            $document->orderBy('id','DESC')->get();
            return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('code', function ($document) {
                    return $document->prefix . numer_padding($document->code, get_option('digits_work_order_code'));
                })
                ->editColumn('payment_status', function ($document) {
                    if ($document->type == 'sample') {
                        return '<span class="badge badge-warning">Sample Work Order</span>';
                    } else {
                        return $document->payment_status == 1 ? '<span class="badge badge-success">Paid</span>' : '<span class="badge badge-danger">Due</span>';
                    }
                })

                ->editColumn('status', function ($document) {
                   if ($document->status=='requisition') {
                       return '<span class="badge badge-info">Requisition</span>';
                   }
                   else{
                      return '<span class="badge badge-danger">Not Requisition</span>';
                   }
                })
                ->addColumn('action', function ($model) {
                    return view('admin.production.work_order.action', compact('model'));
                })->rawColumns(['action', 'payment_status','status'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        if (!auth()->user()->can('workorder.create')) {
            abort(403, 'Unauthorized action.');
        }
        $brand = Brand::all();
        $models = Product::all();
        $code_prefix = get_option('work_order_code_prefix');
        $code_digits = get_option('digits_work_order_code');
        $uniqu_id = generate_id('workorder', false);
        $uniqu_id = numer_padding($uniqu_id, $code_digits);
        $accounts=Account::where('is_closed', 0)->get();

        return view('admin.production.work_order.create', compact('brand', 'models', 'code_prefix', 'code_digits', 'uniqu_id','accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('workorder.create')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'prefix' => '',
            'code' => '',
            'brand_id' => '',
            'type' => 'required|max:255',
            'date' => 'required|max:255',
            'delivery_date' => 'max:255',
        ]);
     if (isset($request->product_id)) {
        $model = new WorkOrder;
        $model->prefix = $request->prefix;
        $model->code = $request->code;
        $model->brand_id = $request->brand_id;
        $model->type = $request->type;
        $model->date = $request->date;
        $model->delivery_date = $request->delivery_date;
        $model->status = "Not";
        $model->hidden = 0;
        $model->tek_marks = 0;
        $model->created_by = Auth::user()->id;

        if($request->type != 'sample') {
            // if paid amount is greater then the payable amount
            if($request->paid > $request->total_payable_amount) {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Paid Amount is Greater then the Payable Amount')]);
            }

            $model->total_item = count($request->price);
            $model->sub_total = $request->net_total;
            $model->discount_type = $request->discount_type;
            $model->discount_amount = (($request->discount == null) ? 0 : $request->discount);
            $model->tax = (($request->tax == null) ? 0 : $request->tax);
            $model->shiping_charge = (($request->shiping_charge == null) ? 0 : $request->shiping_charge);
            $model->total_payable = $request->total_payable_amount;
            $model->paid = $request->paid;
            $model->due = $request->due;
            $model->method = $request->method;
            $model->check_no = $request->check_no;
            $model->sell_note = $request->sale_note;
            $model->stuff_note = $request->stuff_note;
            if($request->paid == $request->total_payable_amount) {
                $model->payment_status = 1;
            } else {
                $model->payment_status = 0;
            }

        }

        $success = $model->save();

        if( $request->type != 'sample') {
            $tx = new Transaction;
            $tx->sell_note = $request->sell_note;
            $tx->stuff_note = $request->stuff_note;

            $ym = Carbon::now()->format('Y/m');

            $row = Transaction::where('transaction_type', 'work_order')->withTrashed()->get()->count() > 0 ? Transaction::where('transaction_type', 'work_order')->withTrashed()->get()->count() + 1 : 1;

            $ref_no = $ym.'/Wo-'.ref($row);

            $tx->due = $request->due;
            $tx->paid = $request->paid;
            $tx->net_total = $request->total_payable_amount;
            $tx->shipping_charges = $request->shipping_charges;
            $tx->tax = $request->tax;
            $tx->discount_amount = $request->discount_amount;
            $tx->discount_type = $request->discount_type;
            $tx->discount = $request->discount;
            $tx->sub_total = $request->net_total;
            $tx->work_order_id = $model->id;
            $tx->transaction_type = 'work_order';
            $tx->type = 'Credit';
            $tx->date = date('y-m-d');
            $tx->invoice_no = '';
            $tx->reference_no = $ref_no;
            $tx->save();

            $tp = new TransactionPayment;
            $tp->transaction_id = $tx->id;
            $tp->method = $request->method;
            $tp->payment_date = date('y-m-d');
            $tp->amount = $request->paid;
            $tp->account_id =$request->account_id;
            $tp->type = 'Credit';
            $tp->created_by =auth()->user()->id;
            $tp->save();

           if ($request->account_id) {
              $this->account_transaction($tp->id,$request->account_id);
            }
              $this->transactionUtil->updatePaymentStatus($tx->id, $tx->net_total);
        }

        if ($success) {
            $work_order_delivery = new WorkOrderDelivery;
            $work_order_delivery->work_order_id = $model->id;
            $work_order_delivery->status = 'due';
            $work_order_delivery->save();

            $count = count($request->product_id);
            for ($i = 0; $i < $count; $i++) {
                $line_purchase = new WorkOrderProduct;
                $line_purchase->workorder_id = $model->id;
                $line_purchase->product_id = $request->product_id[$i];
                $line_purchase->variation_id = $request->variation_id[$i];
                $line_purchase->qty = $request->quantity[$i];
                $line_purchase->price = $request->price[$i];
                $line_purchase->sub_total = $request->sub_total[$i];
                $line_purchase->net_total = $request->sub_total[$i];
                $line_purchase->status = 0;
                $line_purchase->hidden = 0;
                $line_purchase->tek_marks = 0;
                $line_purchase->created_by = Auth::user()->id;
                $line_purchase->save();
            }
        }

        generate_id("workorder", true);
        // Activity Log
        activity()->log('Created a Work order By - ' . Auth::user()->id);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data created Successfuly'), 'goto' => url('/admin/production-work-order')]);

         }
    else
    {
      throw ValidationException::withMessages(['message' => _lang('Please Select atlest one item to WorkOrder')]);
    }
    }

    // pay_form
    public function pay_form($id) {
        $model = WorkOrder::findOrFail($id);
        $accounts=Account::where('is_closed', 0)->get();
        return view('admin.production.work_order.pay', compact('model','accounts'));
    }

    // pay_bill
    public function pay_bill (Request $request) {
        // find the work order id
        $work_order_id = $request->work_order_id;

        // find the work order
        $work_order = WorkOrder::findOrFail($work_order_id);

        // check the paid amount is greater then the total amount
        if($request->paid > $work_order->total_payable) {
            return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Paid Amount is Greater then the Payable Amount')]);
        }

        // check the paid Amount and older paid amount is greater then the total amount
        $new_paid = $request->paid;
        $old_paid = $work_order->paid;
        $total_paid = $new_paid + $old_paid;
        if($total_paid > $work_order->total_payable) {
            return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('You can not paid more then the total amount')]);
        }

        // update the work order table
        $work_order->paid = $total_paid;
        $work_order->due = $request->due;
        if( $total_paid == $work_order->total_payable) {
            $work_order->payment_status = 1;
        }
        $work_order->save();

        // update the transaction table
        $tx = Transaction::where('work_order_id', $request->work_order_id)->firstOrFail();
        $tx->paid = $total_paid;
        $tx->due = $request->due;
        if( $total_paid == $work_order->net_total) {
            $tx->payment_status = 1;
        }
        $tx->save();

        // create new Transaction Payment
        $tp = new TransactionPayment;
        $tp->transaction_id = $tx->id;
        $tp->method = $request->method;
        $tp->payment_date = date('y-m-d');
        $tp->amount = $request->paid;
        $tp->account_id =$request->account_id;
        $tp->type = 'Credit';
        $tp->created_by =auth()->user()->id;
        $tp->save();

         if ($request->account_id) {
            $this->account_transaction($tp->id,$request->account_id);
         }
          $this->transactionUtil->updatePaymentStatus($tx->id, $tx->net_total);

         // Activity Log
         activity()->log('Pay a Work order By - ' . Auth::user()->id);
         return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Payment successful'), 'goto' => url('/admin/production-work-order')]);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('workorder.view')) {
            abort(403, 'Unauthorized action.');
        }
        $model = WorkOrder::findOrFail($id);
        return view('admin.production.work_order.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }
        $brand = Brand::all();
        $model = WorkOrder::findOrFail($id);
        $accounts=Account::where('is_closed', 0)->get();
        $models = Product::all();

        $product_array = [];
        $products = WorkOrderProduct::where('workorder_id', $model->id)->get();
        if($products) {
            foreach($products as $product) {
                $product_array[] = $product->product_id;
            }
        }
        return view('admin.production.work_order.edit', compact('model', 'brand', 'accounts', 'models', 'product_array'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user()->can('workorder.update')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'prefix' => '',
            'code' => '',
            'brand_id' => 'required',
            'type' => 'required|max:255',
            'date' => 'required|max:255',
            'delivery_date' => 'max:255',
        ]);
      if (isset($request->product_id)) {
        $model = WorkOrder::findOrFail($id);
        $model->prefix = $request->prefix;
        $model->code = $request->code;
        $model->brand_id = $request->brand_id;
        $model->type = $request->type;
        $model->date = $request->date;
        $model->delivery_date = $request->delivery_date;
        // $model->status = 0;
        $model->hidden = 0;
        $model->tek_marks = 0;
        $model->updated_by = Auth::user()->id;


        if($request->type != 'sample') {

        // if paid amount is greater then the payable amount
            if($request->paid > $request->total_payable_amount) {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Paid Amount is Greater then the Payable Amount')]);
            }

            $model->total_item = count($request->price);
            $model->sub_total = $request->net_total;
            $model->discount_type = $request->discount_type;
            $model->discount_amount = (($request->discount == null) ? 0 : $request->discount);
            $model->tax = (($request->tax == null) ? 0 : $request->tax);
            $model->shiping_charge = (($request->shiping_charge == null) ? 0 : $request->shiping_charge);
            $model->total_payable = $request->total_payable_amount;
            $model->paid = $request->paid;
            $model->due = $request->due;
            $model->method = $request->method;
            $model->check_no = $request->check_no;
            $model->sell_note = $request->sale_note;
            $model->stuff_note = $request->stuff_note;
            if($request->paid == $request->total_payable_amount) {
                $model->payment_status = 1;
            } else {
                $model->payment_status = 0;
            }

        }

        $success = $model->save();

        $line_purchase = WorkOrderProduct::where('workorder_id', $id)->delete();


        if( $request->type != 'sample' && $model->type != 'production' ) {
            $tx = new Transaction;
            $tx->sell_note = $request->sell_note;
            $tx->stuff_note = $request->stuff_note;

            $ym = Carbon::now()->format('Y/m');

            $row = Transaction::where('transaction_type', 'work_order')->withTrashed()->get()->count() > 0 ? Transaction::where('transaction_type', 'work_order')->withTrashed()->get()->count() + 1 : 1;

            $ref_no = $ym.'/Wo-'.ref($row);

            $tx->due = $request->due;
            $tx->paid = $request->paid;
            $tx->net_total = $request->total_payable_amount;
            $tx->shipping_charges = $request->shipping_charges;
            $tx->tax = $request->tax;
            $tx->discount_amount = $request->discount_amount;
            $tx->discount_type = $request->discount_type;
            $tx->discount = $request->discount;
            $tx->sub_total = $request->net_total;
            $tx->work_order_id = $model->id;
            $tx->transaction_type = 'work_order';
            $tx->type = 'Credit';
            $tx->date = date('y-m-d');
            $tx->invoice_no = '';
            $tx->reference_no = $ref_no;
            $tx->save();

            $tp = new TransactionPayment;
            $tp->transaction_id = $tx->id;
            $tp->method = $request->method;
            $tp->payment_date = date('y-m-d');
            $tp->amount = $request->paid;
            $tp->account_id =$request->account_id;
            $tp->type = 'Credit';
            $tp->created_by =auth()->user()->id;
            $tp->save();

            if ($request->account_id) {
                $this->account_transaction($tp->id,$request->account_id);
            }

            $this->transactionUtil->updatePaymentStatus($tx->id, $tx->net_total);
        }

        if ($success) {

            $work_order_delivery = new WorkOrderDelivery;
            $work_order_delivery->work_order_id = $model->id;
            $work_order_delivery->status = 'due';
            $work_order_delivery->save();


            $count = count($request->product_id);
            for ($i = 0; $i < $count; $i++) {
                $line_purchase = new WorkOrderProduct;
                $line_purchase->workorder_id = $id;
                $line_purchase->product_id = $request->product_id[$i];
                $line_purchase->variation_id = $request->variation_id[$i];
                $line_purchase->qty = $request->quantity[$i];
                $line_purchase->price = $request->price[$i];
                $line_purchase->sub_total = $request->sub_total[$i];
                $line_purchase->net_total = $request->net_total[$i];
                $line_purchase->status = 0;
                $line_purchase->hidden = 0;
                $line_purchase->tek_marks = 0;
                $line_purchase->updated_by = Auth::user()->id;
                $line_purchase->save();
            }
        }
        // Activity Log
        activity()->log('updated a Work order By - ' . Auth::user()->id);
        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data created Successfuly'), 'goto' => url('/admin/production-work-order')]);
    }
    else
    {
      throw ValidationException::withMessages(['message' => _lang('Please Select atlest one item to WorkOrder')]);
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('workorder.delete')) {
            abort(403, 'Unauthorized action.');
        }
        $count1 = StoreRequest::where('work_order_id', $id)->count();
        $count2 = ProductFlow::where('work_order_id', $id)->count();
        if ($count1 == 0 && $count2==0) {
            $model = WorkOrder::findOrFail($id);

            //workorder product
            if ($model->workOrderProduct) {
                foreach ($model->workOrderProduct as $value) {
                    $value->delete();
                }
                // $model->workOrderProduct->delete();
                // workorder product
                if ($model->workOrderProduct) {
                    $model->workOrderProduct->delete();
                }
                if (isset($model->transaction)) {
                    if ($model->transaction->payment) {
                        $model->transaction->payment->delete();
                    }
                    $account_transaction = AccountTransaction::where('transaction_id', $model->transaction->id)->get();
                    if ($account_transaction) {
                        foreach ($account_transaction as $item) {
                            $item->delete();
                        }
                    }

                    $model->transaction->delete();
                }
                $model->delete();
                return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Data deleted')]);
            } else {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('This workorder is already use in store/final Product')]);
                // throw ValidationException::withMessages(['message' =>'This workorder is already use in store/final Product']);
            }
        }
    }

    public function item(Request $request)
    {
        $model = Product::find($request->product_id);
        return response()->json($model);
    }


    public function append(Request $request){
        $product_id = $request->product_id;
        $row = $request->row_count;

        if (!empty($product_id)) {
            $product = Product::where('id', $product_id)
                ->first();

            $variations = Variation::where('product_id', $product_id)
                ->with(['value1', 'value2'])->get();

            // $variations = $query->get();
            $html = view('admin.production.work_order.include.itemlist')
                ->with(compact(
                    'product',
                    'variations',
                    'row'
                ))->render();
        }
        return response()->json(['product_id' => $product_id, 'variations' => $variations, 'html' => $html]);
    }

    // getCatagory
    public function getProduct()
    {

        $term = request()->term;
        $products = Product::leftJoin(
            'variations',
            'products.id',
            '=',
            'variations.product_id'
        )->where(function ($query) use ($term) {
            $query->where('products.name', 'like', '%' . $term . '%');
            $query->orWhere('articel', 'like', '%' . $term . '%');
            $query->orWhere('prefix', 'like', '%' . $term . '%');
            $query->orWhere('sub_sku', 'like', '%' . $term . '%');

        })
            ->orderBy('products.id', 'DESC')
            ->select(
                'products.id as product_id',
                'products.name',
                // 'products.sku as sku',
                'variations.id as variation_id',
                'variations.name as variation',
                'variations.sub_sku as sub_sku'
            )
            ->get();
        $products_array = [];
        foreach ($products as $product) {
            $products_array[$product->product_id]['name'] = $product->name;
            $products_array[$product->product_id]['articel'] = $product->sub_sku;
            $products_array[$product->product_id]['variations'][]
                = [
                'variation_id' => $product->variation_id,
                'variation_name' => $product->variation,
                'sub_sku' => $product->sub_sku,
            ];
        }

        $result = [];
        $i = 1;
        if (!empty($products_array)) {
            foreach ($products_array as $key => $value) {

                $name = $value['name'];
                foreach ($value['variations'] as $variation) {
                    $text = $name;
                        $text = $text . ' (' . $variation['variation_name'] . ')';
                    $i++;
                    $result[] = ['id' => $i,
                        'text' => $text . ' - ' . $variation['sub_sku'],
                        'product_id' => $key,
                        'variation_id' => $variation['variation_id'],
                    ];
                }
                $i++;
            }
        }

        return json_encode($result);
    }

    public function getCatagoryParent($id, $name = Null)
    {
        $category = Product::find($id);
        if ($category) {
            $name = $category->name;
        }
        return $name;
    }

    // pay_bill
    public function transaction_list() {
        return view('admin.production.work_order.list');
    }

    // transaction_datatable
    public function transaction_datatable(Request $request) {
        if ($request->ajax()) {
            $documents = Transaction::where('transaction_type', 'work_order')->orderBy('id', 'desc')->get();
            return DataTables::of($documents)
            ->addIndexColumn()
              ->editColumn('work_order', function ($document) {
                // return $document->work_order->prefix.'-'.$document->work_order->code;
                return '';
            })
            ->editColumn('payment_status', function ($document) {
                if ($document->payment_status == 'due') {
                    return '<span class="badge badge-warning">Due</span>';
                } elseif($document->payment_status == 'paid') {
                    return'<span class="badge badge-success">Paid</span>';
                }else{
                    return  '<span class="badge badge-danger">Due</span>';
                }
            })
            ->editColumn('action', function ($document) {
                return '<a href="'. route('admin.print.work-order-transaction', base64_encode($document->reference_no)) .'" target="blank"><button type="button" class="btn btn-sm btn-success"><i class="fa fa-print" aria-hidden="true"></i> </button></a>';
            })
            // ->addColumn('action', function ($model) {
            //     return view('admin.production.work_order.action', compact('model'));
            ->rawColumns(['action', 'payment_status','work_order'])->make(true);
        }
    }

    // print
    public function print($id) {
        $id = base64_decode($id);

        // find the transaction list
        $model = Transaction::where('reference_no', $id)->firstOrFail();

        // find the work order
        $work_order = WorkOrder::findOrFail($model->work_order_id);

        // find the brand
        $brand = Brand::findOrFail($work_order->brand_id);

        // find the sell ling
        $lines = WorkOrderProduct::where('workorder_id', $work_order->id)->get();

        // find the transaction payment
        $items = TransactionPayment::where('transaction_id', $model->id)->get();

        return view('admin.production.work_order.print', compact('model', 'work_order', 'items', 'brand', 'lines'));

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

    // delivery
    public function delivery($id) {
        // find the work order
        $work_order = WorkOrder::findOrFail($id);

        // find the workd order product
        $work_order_products = WorkOrderProduct::where('workorder_id', $work_order->id)->get();

        // find the ready product
        $ready_products = [];
        if(count($work_order_products)) {
            foreach($work_order_products as $work_order_product) {
                $product_id = $work_order_product->product_id;
                $variation_id = $work_order_product->variation_id;
                $details = VariationBrandDetails::where('product_id', $product_id)->where('variation_id', $variation_id)->first();
                if($details) {
                    $product = Product::where('id', $product_id)->first();
                    $variation = Variation::where('id', $variation_id)->first();
                    $ready_products[] = [
                        'Product ID' => $product->id,
                        'Product Name' => $product->name,
                        'Variation ID' => $variation->id,
                        'Variation Name' => $variation->name,
                        'Quantity' => $details->qty_available
                    ];
                }
            }
        }

        // find the ready product
        // $ready_products = ProductFlow::where('work_order_id', $work_order->id)->where('send_depertment_id', null)->get();

        // find the delivery
        $delivery = WorkOrderDelivery::where('work_order_id',$work_order->id)->firstOrFail();
        $delivery_array = [];
        // find the delivery Products
        $delivery_products = WorkOrderDeliveryItem::where('work_order_deliveries_id', $delivery->id)->get();
        $delivery_variation = WorkOrderDeliveryItem::where('work_order_deliveries_id', $delivery->id)->groupBy('variation_id')->get();
        foreach($delivery_variation as $delivery_product) {
            $work_order_deliveries_id = $delivery_product->work_order_deliveries_id;
            $product_id = $delivery_product->product_id;
            $variation_id = $delivery_product->variation_id;
            $delivery_array[] =[
                'Product' => $delivery_product->product->name . ' ('. $delivery_product->variation->name .')',
                'Quantity'=> WorkOrderDeliveryItem::where('work_order_deliveries_id', $work_order_deliveries_id)->where('product_id', $product_id)->where('variation_id', $variation_id)->sum('quantity')
            ];
        }

        // return
        return view('admin.production.work_order.delivery.index', compact('work_order', 'ready_products', 'delivery_products', 'work_order_products', 'delivery', 'delivery_array'));
    }

    // send_delivery
    public function send_delivery(Request $request, $id) {
        // validate
        $request->validate([
            'date' => 'required',
        ]);

        if(!isset($request->product_id)) {
            return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Select At Least 1 Item for Delivery')]);
        }

        // find the work order
        $work_order = WorkOrder::findOrFail($id);

        $work_order_date = $work_order->date;
        if($work_order_date > $request->date) {
            return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Delivery Date must be after the work order start date')]);
        }

        // find the total requested product quantity
        $total_requested_qty = WorkOrderProduct::where('workorder_id', $id)->sum('qty');

        // find the work order delivery id
        $work_order_delivery = WorkOrderDelivery::where('work_order_id', $id)->firstOrFail();
        $work_order_deliveries_id = $work_order_delivery->id;

        for($i = 0; $i < count($request->product_id); $i++) {
            $product_id = $request->product_id[$i];
            $variation_id = $request->variation_id[$i];
            $qty = $request->quantity[$i];

            if($qty == 0) {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('You Can Not Deliver 0 Pair Product')]);
            }

            $stock = VariationBrandDetails::where('product_id', $product_id)->where('variation_id', $variation_id)->first();
            if($stock) {
                $qty_available = $stock->qty_available;
                $new_qty = $qty_available - $qty;
                $stock->qty_available = $new_qty;
                $success = $stock->save();

                if($success) {
                    $work_order_delivery_item = new WorkOrderDeliveryItem;
                    $work_order_delivery_item->work_order_deliveries_id = $work_order_deliveries_id;
                    $work_order_delivery_item->product_id = $product_id;
                    $work_order_delivery_item->variation_id = $variation_id;
                    $work_order_delivery_item->quantity = $qty;
                    $work_order_delivery_item->date = $request->date;
                    $work_order_delivery_item->save();
                }
            }
        }

        // find the total delivered product quantity
        $total_delivered_qty = WorkOrderDeliveryItem::where('work_order_deliveries_id', $work_order_deliveries_id)->sum('quantity');


        $work_order_delivery->requested_product_qty =$total_requested_qty;
        $work_order_delivery->delivered_product_qty =$total_delivered_qty;
        if($total_delivered_qty == 0) {
            $status = 'due';
        } elseif($total_delivered_qty == $total_requested_qty) {
            $status = 'paid';
        } elseif($total_requested_qty > $total_delivered_qty) {
            $status = 'partial';
        }
        $work_order_delivery->status =$status;
        $work_order_delivery->save();

        $date = $request->date;

        $html = view('admin.production.work_order.delivery.print_today', compact('work_order_delivery', 'work_order', 'date'))->render();

        return response()->json(['success' => true, 'html' => $html, 'message' => _lang('Delivery Completed Successfully!.')]);
    }
}
