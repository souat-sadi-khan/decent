<?php

namespace App\Http\Controllers\Frontend;

use App\EcommerceInvoiceNumber;
use App\Http\Controllers\Controller;
use App\Utilities\TransactionUtil;
use App\models\Client;
use App\models\Production\Product;
use App\models\Production\Transaction;
use App\models\Production\VariationBrandDetails;
use App\models\eCommerce\Coupon;
use App\models\eCommerce\PageBanner;
use App\models\eCommerce\EcommerceProduct;
use App\models\inventory\TransactionSellLine;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session as FacadesSession;
use Session;
use View;

class CartController extends Controller
{

    protected $transactionUtil;
    public function __construct(TransactionUtil $transactionUtil)
    {
        $this->transactionUtil = $transactionUtil;
    }

    public function add_cart(Request $request)
    {
        $request->validate([
            'variation' => 'required',
            'qty' => 'required'
        ]);
        

        $qty_available = 0;
        $qty = EcommerceProduct::where('variation_id', $request->variation)->first();
        if ($qty) {
            $qty_available = $qty->quantity;
        }
        if ($request->qty > $qty_available) {
            return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Quantity Not Available')]);
        }

        $a= Cart::add(array(
            'id' => $request->variation,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->qty,
            'attributes' => array(
                'product_id' => $request->id
            ),
        ));
        $cart_total =  Cart::getTotal();
        $bdt = get_option('currency');

        return response()->json(['success' => true, 'cart_total' => $cart_total , 'bdt'=>$bdt, 'status' => 'success', 'message' => _lang('Product Added To Cart Successfuly'), 'goto' => route('shopping-cart-show')]);

    }

    public function show_cart()
    {
        $banner = PageBanner::where('page_name', 'Cart')->first();
        $cart_total =  Cart::getContent();

        if (count($cart_total) > 0) {
            Session::put('coupon', null);
            $models = Cart::getContent();
            return view('eCommerce.shopping-cart', compact('models', 'banner'));
        }else{
            return redirect()->back()->with('error', 'The Cart is Empty.');
        }


    }

    public function qty_cart(Request $request)
    {
        Cart::update($request->id, array(
            'quantity' => array(
                'relative' => false,
                'value' => $request->qty
            ),
        ));

        $total = Cart::getTotal();
        $sub_total = Cart::getSubTotal();

        $bdt = get_option('currency');
        $models = Cart::getContent();

        return response()->json(['view'=>View::make('eCommerce.update-qty', compact('models'))->render(),'total'=> $total, 'bdt' => $bdt, 'sub_total'=> $sub_total]);

    }
    public function remove_cart(Request $request)
    {
        Cart::remove($request->id);
        $models = Cart::getContent();
        $total = Cart::getTotal();
        $sub_total = Cart::getSubTotal();
        $bdt = get_option('currency') != '' ? get_option('currency') : 'BDT';

        return response()->json(['view' => View::make('eCommerce.update-qty', compact('models'))->render(), 'total' => $total, 'bdt' => $bdt, 'sub_total' => $sub_total]);

    }

    public function coupon_check(Request $request)
    {

        if ($request->coupon == null) {
            return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('The coupon field is required.')]);
        }

        $model = Coupon::where('coupons_code', $request->coupon)->first();
        if($model){

            if (Session::get('coupon')) {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Coupon Already Used.')]);
            }

            Session::put('coupon_text', $request->coupon);

            Session::put('coupon', $model);
            Session::put('discount', $model->discount_amount);
            Session::put('discount_type', $model->discount_type);
            return response()->json(['success' => true, 'coupon' => $model, 'status' => 'success', 'message' => _lang('Coupon Code Match Successfuly')]);

        } else {
            return response()->json(['success' => true, 'status' => 'error', 'message' => _lang('Coupon Code Doesnot Match')]);
        }

    }


    public function store_cart(Request $request){


    
            if(Cart::getTotal() == 0) {
                return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Sorry. Your Cart is Empty'), 'goto' => url('/')]);
            }
            
        if (auth('client')->check() == true) {
            $models = Cart::getContent();
            Session::put('total', $request->total_hidden);
            Session::put('coupon', $request->coupon_amt);
            
        //     if(Cart::getTotal() == 0) {
        //     return redirect('/')->with('msg' , 'Sorry. Your Cart is Empty.');
        // }
    

            return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Welcome To Checkout Page'), 'goto' => route('shopping-checkout')]);
        } else {
            Session::put('goto', url()->previous());
            return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Please Login First'), 'goto' => route('account','goto=cart')]);
        }
    }

    public function checkout(Request $request)
    {
        $banner = PageBanner::where('page_name', 'Checkout')->first();
        
        

        if (auth('client')->check() == true) {
            $user = auth('client')->user('clients_id');
            $client = Client::findOrFail($user->clients_id);
            $models = Cart::getContent();

            return view('eCommerce.checkout', compact('models', 'client','banner'));
        } else {
            return response()->json(['success' => true, 'status' => 'danger', 'message' => _lang('Please Login First'), 'goto' => route('account')]);
        }
    }

    public function store_checkout(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'email' => 'required',
            'mobile' => 'required'
        ]);

        $client = Client::findOrFail($request->client_id);
        $client->name = $request->name;
        $client->last_name = $request->last_name;
        $client->company_name = $request->company_name;
        $client->address = $request->address;
        $client->city = $request->city;
        $client->state = $request->state;
        $client->post_code = $request->post_code;
        $client->email = $request->email;
        $client->mobile = $request->mobile;
        $client->save();


        $code_prefix = get_option('invoice_code_prefix', 'INV-');
        $code_digits = get_option('digits_invoice_code', 4);
        $uniqu_id = generate_id('purchase', false);
        $uniqu_id = numer_padding($uniqu_id, $code_digits);

        // find the invoice number
        $invoice = EcommerceInvoiceNumber::first();
        if($invoice) {
            $invoice_no = $invoice->number;
            $new = $invoice + 1;
            $invoice->number = $new;
            $invoice->save();
        } else {
            $invoice = new EcommerceInvoiceNumber;
            $invoice->number = 000001;
            $invoice->save();
        }
        // $invoice_no = rand(1, 100000);

        $payment = new Transaction();
        $payment->client_id = $client->id;
        $payment->date = date('Y-m-d');
        $payment->invoice_no = $invoice_no;
        $payment->transaction_type = 'eCommerce';
        $payment->sub_total = $request->sub_total;
        $payment->net_total = $request->total;
        $payment->sell_note = $request->order_note;

        if(FacadesSession::get('coupon')) {
            $payment->discount = Session::get('discount');
            $payment->discount_type = Session::get('discount_type');
            $payment->discount_amount = $request->coupon;
        }

        $payment->shipping_charges = 0;
        $payment->paid = 0;
        $payment->sale_type = 'eCommerce';
        $payment->type = 'Credit';
        $payment->brand_id= get_option('default_brand');
        $payment->payment_status = 'due';

        $payment->reference_no = $invoice_no;

        if($request->checkbox == 'on'){
            $payment->shipping_status = 'On';
            $payment->full_name = $request->forname;
            $payment->email = $request->foremail;
            $payment->phone = $request->forphone;
            $payment->address = $request->foraddress;
            $payment->city = $request->forcity;
        }
        $payment->ecommerce_status = 'pending';
        $payment->due = $request->total;
        $payment->save();
        $transaction_id = $payment->id;


        for ($i = 0; $i < count($request->product_id); $i++) {

            $transaction = new TransactionSellLine();
            $transaction->transaction_id = $transaction_id;
            $transaction->client_id = $request->client_id;
            $transaction->product_id = $request->product_id[$i];
            $transaction->variation_id = $request->variation_id[$i];
            $transaction->quantity = $request->quantity[$i];
            $transaction->unit_price  = $request->price[$i];
            $total = ($request->quantity[$i]) * ($request->price[$i]);
            $transaction->total = $total;
            $transaction->save();

            // $this->transactionUtil->decreaseProductQuantity(
            //     $request->product_id[$i],
            //     $request->variation_id[$i],
            //     get_option('default_brand'),
            //     $request->quantity[$i]
            // );
        }

        generate_id('purchase', true);

        Session::put('coupon', null);
        Session::put('total', null);
        Session::put('discount', null);
        Session::put('discount_type', null);
        Session::put('coupon_text', null);

        Cart::clear();
        // Cart::session($userId)->clear();

        return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Order Complete Successfuly'), 'goto' => route('welcome')]);

    }

    // welcome
    public function welcome() {
        $banner = PageBanner::where('page_name', 'Welcome')->first();
        $transaction = Transaction::orderBy('id', 'desc')->first();
        $client = Client::findOrFail($transaction->client_id);
        $transaction_sale  = TransactionSellLine::where('transaction_id', $transaction->reference_no)->get();
        return view('eCommerce.thank', compact('transaction', 'client', 'transaction_sale','banner'));
    }

    // invoice
    public function invoice($id) {
        $transaction = Transaction::where('reference_no', $id)->firstOrFail();
        $client = Client::findOrFail($transaction->client_id);
        $transaction_sale  = TransactionSellLine::where('transaction_id', $transaction->id)->get();
        return view('eCommerce.invoice', compact('transaction', 'client', 'transaction_sale'));
    }
}
