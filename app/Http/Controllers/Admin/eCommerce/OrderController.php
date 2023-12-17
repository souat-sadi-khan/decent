<?php

namespace App\Http\Controllers\Admin\eCommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\Client;
use App\Utilities\TransactionUtil;
use App\models\eCommerce\ClientShippingAddress;
use App\models\eCommerce\Coupon;
use App\models\eCommerce\EcommerceProduct;
use App\models\eCommerce\OrderStatus;
use App\models\inventory\TransactionSellLine;
use App\models\Production\Product;
use App\models\Production\Transaction;
use App\models\Production\TransactionPayment;
use App\models\Production\VariationBrandDetails;
use App\Qurier;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    
    protected $transactionUtil;
    public function __construct(TransactionUtil $transactionUtil)
    {
        $this->transactionUtil = $transactionUtil;
    }

    // eCommerce Order List index page
    public function index() {
        if (!auth()->user()->can('ecommerce_order.view')) {
            abort(403, 'Unauthorized action.');
        }
        $models = Transaction::where('ecommerce_status', 'pending')->orderBy('id', 'desc')->get();
        return view('admin.eCommerce.order.index', compact('models'));
    }

    // show 
    public function show ($id) {
        if (!auth()->user()->can('ecommerce_order.view')) {
            abort(403, 'Unauthorized action.');
        }
        $model = Transaction::findOrFail($id);

        $products = TransactionSellLine::where('transaction_id', $model->id)->get();
        return view('admin.eCommerce.order.show', compact('model', 'products'));
    }

    // change_status
    public function change_status(Request $request) {
        if (!auth()->user()->can('ecommerce_order.update')) {
            abort(403, 'Unauthorized action.');
        }
        $id = $request->id;
        $val = $request->val;
        $model = Transaction::where('id', $id)->first();
        if($val == 'return') {
            $model->ecommerce_status = 'return';
        } else {
            $model->ecommerce_status = 'payment_done';
        }

        $model->save();

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Status is Successfully Changed!'), 'load' => true]);

    }

    // sort_order
    public function sort_order(Request $request) {
        $val = $request->val;
        if($val == 'all') {
            $models = Transaction::where('ecommerce_status', '!=', null)->orderBy('id', 'desc')->get();
        } else {
            $models = Transaction::where('ecommerce_status', $val)->orderBy('id', 'desc')->get();
        }
        return view('admin.eCommerce.order.data', compact('models'));
    }

    // sort_order_date_wise
    public function sort_order_date_wise(Request $request) {
        $val = $request->val;
        $date = $request->start;
        $ex = explode('to', $date);
        $start = $ex[0];
        $end = trim($ex[1]);
        
        $models = Transaction::where('ecommerce_status', $val)->whereBetween('created_at', [$start, $end])->orderBy('id', 'desc')->get();
        return view('admin.eCommerce.order.data', compact('models'));
    }

    // pdf
    public function pdf($id) {
        $model = Transaction::where('reference_no', $id)->firstOrFail();
        return view('admin.eCommerce.order.pdf', compact('model'));
    }

    // show_update_page
    public function show_update_page($id) {
        if (!auth()->user()->can('ecommerce_order.update')) {
            abort(403, 'Unauthorized action.');
        }
        $model = Transaction::findOrFail($id);

        $quriers = Qurier::where('status', 1)->get();

        $sell_products = TransactionSellLine::where('transaction_id', $model->id)->get();

        $product_id = [];
        $brand_id = get_option('default_brand');
        // dd($brand_id);
        $product = VariationBrandDetails::where('brand_id', $brand_id)->get();

        foreach ($product as $value) {
            $product_id[] = $value->product_id;
        }

        $products = Product::whereIn('id', $product_id)->orderBy('avarage_retting', 'DESC')->take(3)->get();

        // find the coupon
        $coupon_id = $model->tek_marks;
        if($coupon_id != '') {

            $coupon = Coupon::where('id', $coupon_id)->first();
            if($coupon) {
                $coupon_amount = $coupon->discount_amount;
                $coupon_type = $coupon->discount_type;
            } else {
                $coupon_amount = 0;
                $coupon_type = 'None';
            }

        } else {
            $coupon_amount = 0;
            $coupon_type = 'None';
        }

        return view('admin.eCommerce.order.update', compact('model', 'sell_products', 'products', 'coupon_amount', 'quriers', 'coupon_type'));
    }

    // edit_the_transaction
    public function edit_the_transaction(Request $request, $id) {
        if (!auth()->user()->can('ecommerce_order.update')) {
            abort(403, 'Unauthorized action.');
        }
        // dd($request->all());
        if($request->product_id == null) {
            return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Sorry. Please Select Product First')]);
        }

        // find the Transaction Row
        $model = Transaction::findOrFail($id);
        $model->qurier_id = $request->qurier_id;

        // if status is payment done then no option for change status
        if($model->ecommerce_status == 'payment_done'  && $request->status != 'return') {
            return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Sorry. You Can only change status to RETURN on Payment Done Status')]);
        }

        // if status is confirm then no option for status pending
        if($model->ecommerce_status != 'pending'  && $request->status == 'pending') {
            return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Sorry. You can not go back to Pending Status')]);
        }

        // dd($model->ecommerce_status);

        // is the status is calcel 
        if($request->status == 'cancel') {
            if($model->ecommerce_status == 'progressing' || $model->ecommerce_status == 'shipment' || $model->ecommerce_status == 'success' || $model->ecommerce_status == 'payment_done') {
                return response()->json(['success' => true, 'html' => 'cancel', 'status' => 'danger', 'message' => _lang('First Make the Order Pending Or Confirm')]);
            }
        }

        // change the shiping address
        if($request->shipping_status == 'On') {
            $model->full_name = $request->ship_another_full_name;
            $model->email = $request->ship_another_email;
            $model->phone = $request->ship_another_phone;
            $model->address = $request->ship_another_address;
            $model->city = $request->ship_another_city;
        }

        // find the client
        $client = Client::findOrFail($model->client_id);

        // find the transaction sell line 
        $transaction_sell_lines = TransactionSellLine::where('transaction_id', $id)->get();

        

        // add new transaction sell line for this transaction 
        if ($request->status != 'pending') {
            
            // delete all transaction sell line for this transaction row
            if($transaction_sell_lines) {
                foreach($transaction_sell_lines as $sell_line) {
                    $sell_line->delete();
                }
            }
        
            for ($i = 0; $i < count($request->product_id); $i++) {

                $transaction = new TransactionSellLine();
                $transaction->transaction_id = $id;
                $transaction->client_id = $client->id;
                $transaction->product_id = $request->product_id[$i];
                $transaction->variation_id = $request->variation_id[$i];
                $transaction->quantity = $request->quantity[$i];
                $transaction->unit_price  = $request->price[$i];
                $total = ($request->quantity[$i]) * ($request->price[$i]);
                $transaction->total = $total;
                $transaction->save();
    
                $ecommerce_product = EcommerceProduct::where('product_id', $request->product_id[$i])->where('variation_id', $request->variation_id[$i])->first();
                if($ecommerce_product) {
                    $avaiable_stock = $ecommerce_product->quantity;
                    $new_stock = $avaiable_stock - $request->quantity[$i];
                    $ecommerce_product->quantity = $new_stock;
                    $ecommerce_product->save();
                }
            }
        }

        // update transaction table
        if($request->status == 'success') {
            $model->payment_status = 'Paid';
            $model->paid = $request->net_total;
            $model->due = 0;
        }
        $model->sub_total = $request->subtotal;
        $model->discount_amount = $request->subtotal - $request->net_total;
        $model->net_total = $request->net_total;


        // update ecommerce status
        $model->ecommerce_status = $request->status;
        $model->save();

        if($request->status == 'success') {
            $transaction_payment = new TransactionPayment();
            $transaction_payment->transaction_id = $id;
            $transaction_payment->method = 'Cash On Delivery';
            $transaction_payment->payment_date = date('Y-m-d');
            $transaction_payment->amount = $request->net_total;
            $transaction_payment->type = 'credit';
            $transaction_payment->save();
        }

        $status = new OrderStatus;
        $status->transaction_id = $id;
        $status->user_id = Auth::user()->id;
        $status->status = $request->status;
        $status->note = $request->order_note;
        $status->save();


        // return
        return response()->json(['success' => true,  'status' => 'success', 'message' => _lang('Order Status Change Successfully'), 'load' => true]);

    }

    // get_curier_print
    public function get_curier_print(Request $request) {
        $data = [];
        if (!auth()->user()->can('ecommerce_order.view')) {
            abort(403, 'Unauthorized action.');
        }
        
        for($i = 0; $i < count($request->check); $i++) {
            $id = $request->check[$i];
            $trans = Transaction::where('id', $id)->first();
            if($trans) {
                $items = TransactionSellLine::where('transaction_id', $id)->get();
                if($items) {
                    foreach ($items as $item) {
                        $data[] = [
                            'Artical' => $item->product->articel,
                            'Name' => $item->product->name,
                            'Quantity' => $item->quantity,
                            'Size' => $item->variation->name,
                            'Invoice' => $trans->reference_no,
                        ];
                    }
                }
            }
        }

        return view('admin.eCommerce.order.print', compact('data'));
    }
}
