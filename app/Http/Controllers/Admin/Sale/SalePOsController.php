<?php

namespace App\Http\Controllers\admin\Sale;

use App\Http\Controllers\Controller;
use App\User;
use App\Utilities\TransactionUtil;
use App\models\Client;
use App\models\Production\Brand;
use App\models\Production\Category;
use App\models\Production\Product;
use App\models\Production\Transaction;
use App\models\Production\TransactionPayment;
use App\models\Production\Variation;
use App\models\account\Account;
use App\models\account\AccountTransaction;
use App\models\email\EmailTemolate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class SalePOsController extends Controller
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

    public function index(Request $request)
    {
      if (!auth()->user()->can('sale_pos.view')) {
            abort(403, 'Unauthorized action.');
        }
      if ($request->ajax()) {
            $q=Transaction::query();
            if (!empty(request()->input('sale_type'))) {
                $q=$q->where('sale_type',request()->input('sale_type'));
            }

            if (!empty(request()->input('customer_id'))) {
                $q=$q->where('client_id',request()->input('customer_id'));
            }

            if (!empty(request()->input('payment_status'))) {
                $q=$q->where('payment_status',request()->input('payment_status'));
            }

            if (!empty(request()->input('created_by'))) {
                $q=$q->where('created_by',request()->input('created_by'));
            }

             if (!auth()->user()->hasRole('Super Admin')) {
                $q=$q->where('hidden',false);
            }
            $q =$q->where('transaction_type','Sale');
            $document =$q->get();

            return DataTables::of($document)
                ->addIndexColumn()
                 ->editColumn('date', function ($model) {
                    $return ='';
                    if ($model->return_parent) {
                        $return='<span class="badge badge-info"><i class="fa fa-reply-all" aria-hidden="true"></i></span>';
                    }
                  return formatDate($model->date).$return;
                 })

                ->editColumn('reference_no', function ($model) {
                  return '<a title="view Details" data-url="'.route('admin.sale.pos.view',$model->id).'" class="btn_modal" style="cursor:pointer;color:#12f">'.$model->reference_no.'</a>';
                 })
                 ->editColumn('client', function ($model) {
                  return $model->client?$model->client->name:'';
                 })
                 ->editColumn('paid', function ($model) {
                    if (auth()->user()->can("view_sale.sale_paid")) {
                    return $model->payment()->sum('amount');
                  }else{
                    return 'N/A';
                  }
                 })
                ->editColumn('due', function ($model) {
                    if (auth()->user()->can("view_sale.sale_due")) {
                    return $model->net_total-($model->payment()->sum('amount'));
                    }else{
                        return 'N/A';
                    }
                 })
                 ->editColumn('payment_status', function ($model) {
                   if ($model->payment_status=='paid') {
                      return '<a title="view Payment" data-url="'.route('admin.sale.pos.payment',$model->id).'" class="btn_modal" style="cursor:pointer;color:#12f"><span class="badge badge-success">Paid</span></a>';
                   }
                   elseif($model->payment_status=='partial'){
                     return '<a title="view Payment" data-url="'.route('admin.sale.pos.payment',$model->id).'" class="btn_modal" style="cursor:pointer;color:#12f"><span class="badge badge-info">Partial</span></a>';
                   }
                   else{
                    return '<a title="view Payment" data-url="'.route('admin.sale.pos.payment',$model->id).'" class="btn_modal" style="cursor:pointer;color:#12f"><span class="badge badge-danger">Due</span></a>';
                   }
                 })
                 ->editColumn('return', function ($model) {
                    $return="";
                    if ($model->return_parent) {
                    $return = '<a style="cursor:pointer;color:#12f" data-url="' . route('admin.sale.return.show', $model->return_parent->return_parent_id) . '" class="btn_modal">' . ($model->net_total-($model->payment()->sum('amount')+$model->return_parent->net_total)). '</a>';
                    }
                    return $return;
                 })
                ->addColumn('action', function ($model) {
                    return view('admin.salePos.action', compact('model'));
                })->rawColumns(['action','client','date','paid','due','payment_status','return','reference_no'])->make(true);
        }
        $customer =Client::orderBy('id','DESC')->where('client_type','client')->pluck('name','id');
        $user =User::orderBy('id','DESC')->pluck('email','id');
       return view('admin.salePos.index',compact('customer','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('sale_pos.create')) {
            abort(403, 'Unauthorized action.');
        }
        $brands =Brand::select('id','name')->get();
        $categories=Category::all();
        $accounts = Account::forDropdown(false, false);
        return view('admin.salePos.create',compact('brands','categories','accounts'));
    }

    public function sale_add()
    {
     if (!auth()->user()->can('sale_pos.create')) {
            abort(403, 'Unauthorized action.');
        }
      $accounts = Account::forDropdown(false, false);
       return view('admin.salePos.sale_add',compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('sale_pos.create')) {
            abort(403, 'Unauthorized action.');
        }
        $input = $request->except('_token','variation');

         if (empty($request->input('date'))) {
                    $input['date'] =  Carbon::now()->format('Y-m-d H:i:s');
                } else {
                    $input['date'] =$request->input('date');
         }

        if (empty($request->input('client_id'))) {
                    $input['client_id'] = 1;
                } else {
                    $input['client_id'] =$request->input('client_id');
         }
        $user_id =auth()->user()->id;

        $ym = Carbon::now()->format('Y/m');

        $row = Transaction::where('transaction_type', 'Sale')->withTrashed()->get()->count() > 0 ? Transaction::where('transaction_type', 'Sale')->withTrashed()->get()->count() + 1 : 1;

        $ref_no = $ym.'/S-'.ref($row);

        $code_prefix = get_option('invoice_code_prefix');
        $code_digits = get_option('digits_invoice_code');
        $uniqu_id = generate_id('purchase', false);
        $uniqu_id = numer_padding($uniqu_id, $code_digits);

        if($request->invoice_no){
            $invoice_no = $request->invoice_no;
        }else{
            $invoice_no = $code_prefix . $uniqu_id;
        }

        $variations =$request->variation;
        if (isset($variations)) {
        $transaction = $this->transactionUtil->createSellTransaction($input,$user_id,$ref_no,$invoice_no);
        $sale_line =$this->transactionUtil->createSellLines($transaction,$variations);


        foreach ($variations as $value) {
            $decrease_qty = $value['quantity'];
             $this->transactionUtil->decreaseProductQuantity(
                                $value['product_id'],
                                $value['variation_id'],
                                get_option('default_brand'),
                                $decrease_qty,
                                $request->sale_type
                            );
        }

        if (!empty($input['paid'])) {
            $payment =new TransactionPayment;
            $payment->transaction_id=$transaction->id;
            $payment->client_id=$transaction->client_id;
            $payment->method =$request->method;
            $payment->payment_date =$input['date'];
            $payment->transaction_no =$input['check_no'];
            $payment->amount =$request->paid;
            $payment->note =$request->sale_note;
            $payment->type ='Credit';
            $payment->created_by =$user_id;
            $payment->save();
        }

        if ($request->account_id) {
               $acc_transaction =new AccountTransaction;
               $acc_transaction->account_id =$request->account_id;
               $acc_transaction->transaction_id =$transaction->id;
               $acc_transaction->transaction_payment_id =$payment->id;
               $acc_transaction->type ='Credit';
               $acc_transaction->acc_type ='account';
               $acc_transaction->amount =$request->paid;
               $acc_transaction->reff_no =$transaction->reference_no;
               $acc_transaction->operation_date =$input['date'];
               $acc_transaction->note ='Sale Paid';
               $acc_transaction->created_by =$user_id;
               $acc_transaction->save();
        }

        //Update payment status
         $this->transactionUtil->updatePaymentStatus($transaction->id, $transaction->net_total);

         return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Information Updated'),'window'=>route('admin.sale.pos.print',$transaction->id)]);

    }
    else
    {
      throw ValidationException::withMessages(['message' => _lang('Please Select atlest one item to sale')]);
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
     if (!auth()->user()->can('sale_pos.create')) {
            abort(403, 'Unauthorized action.');
        }
        $model =Transaction::findOrfail($id);
        return view('admin.salePos.show',compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    if (!auth()->user()->can('sale_pos.delete')) {
            abort(403, 'Unauthorized action.');
        }
            if (request()->ajax()) {
                //Check if return exist then not allowed
                if ($this->transactionUtil->isReturnExist($id)) {
                   throw ValidationException::withMessages(['message' => _lang('This Transaction has return Item')]);
                }

                $transaction = Transaction::where('id', $id)
                                ->with(['sell_lines'])
                                ->first();

                $delete_sale_lines = $transaction->sell_lines;
                DB::beginTransaction();

                $transaction_status = $transaction->status;

                    //Delete sell_lines lines first
                    $delete_sale_line_ids = [];
                    foreach ($delete_sale_lines as $purchase_line) {
                        $delete_sale_line_ids[] = $purchase_line->id;
                    }

                    TransactionSellLine::where('transaction_id', $transaction->id)
                                ->whereIn('id', $delete_sale_line_ids)
                                ->delete();

                //Delete Transaction
                $transaction->payment()->delete();
                $transaction->delete();

                //Delete account transactions
                AccountTransaction::where('transaction_id', $id)->delete();

                DB::commit();

             return response()->json(['status' => 'success', 'message' => 'Data is deleted successfully']);
            }

    }

    public function getProductSuggestion(Request $request)
    {
         if ($request->ajax()) {
            $category_id = $request->get('category_id');
            $sub_category_id = $request->get('sub_category_id');
            $brand_id = $request->get('brand_id')?:get_option('default_brand');
            $term = $request->get('term');

            $check_qty = false;

        $products = Product::leftJoin(
            'variations',
            'products.id',
            '=',
            'variations.product_id'
        )
        ->leftjoin('variation_brand_details AS VBD',
             function ($join) use ($brand_id) {
                $join->on('variations.id', '=', 'VBD.variation_id');
                     //Include Location
                                if (!empty($brand_id)) {
                                    $join->where(function ($query) use ($brand_id) {
                                        $query->where('VBD.brand_id', '=', $brand_id);
                                        //Check null to show products even if no quantity is available in a location.
                                        //TODO: Maybe add a settings to show product not available at a location or not.
                                        $query->orWhereNull('VBD.brand_id');
                                    });
                                    ;
                                }
          });
        if (!empty($term)) {
        $products->where(function ($query) use ($term) {
            $query->where('products.name', 'like', '%' . $term . '%');
            $query->orWhere('articel', 'like', '%' . $term . '%');
            $query->orWhere('prefix', 'like', '%' . $term . '%');
            $query->orWhere('sub_sku', 'like', '%' . $term . '%');

        });
        }
         // if ($category_id != 'all') {
         //        $products->where(function ($query) use ($category_id) {
         //            $query->where('products.category_id', $category_id);
         //            $query->orWhere('products.sub_category_id', $category_id);
         //        });
         //  }
        if (!empty($category_id)) {
            $products->where('products.category_id',$category_id);
        }

        if (!empty($sub_category_id)) {
            $products->where('products.sub_category_id',$sub_category_id);
        }
          if (!auth()->user()->hasRole('Super Admin')) {
                $products->where('variations.hidden',false);
            }
           $products->where(function ($query) use ($brand_id) {
                    $query->where('VBD.brand_id', $brand_id);

                });
           $products = $products->select(
                'products.id as product_id',
                'products.name',
                'variations.id as variation_id',
                'variations.name as variation',
                'VBD.qty_available as qty',
                'variations.default_sell_price as selling_price',
                'variations.sub_sku',
                'products.photo as image'
            );
            $products=$products->orderBy('products.id', 'DESC')
                     ->groupBy('variations.id')
            // ->select(
            // 'VBD.qty_available as qty',
            //        'variations.id as variation_id',
            //        'products.id as product_id'
            //    )
           ->paginate(20);
            return view('admin.salePos.partials.product_list')
                    ->with(compact('products'));
        }
    }

    public function get_variation_product(Request $request)
    {
        $data = Variation::join('products AS p', 'variations.product_id', '=', 'p.id')
                ->join('product_variations AS pv', 'variations.product_variation_id', '=', 'pv.id')
                ->leftjoin('variation_brand_details AS vbd', 'variations.id', '=', 'vbd.variation_id')
                ->where('variations.id', $request->variation_id)
                ->select( 'p.id as product_id',
                        'p.category_id',
                        'vbd.qty_available',
                        'variations.default_sell_price as selling_price',
                        'variations.id as variation_id',
                        'vbd.brand_id as brand_id',
                        'variations.sub_sku as sku'
                    )
                ->first();
      if ($data !=null && $data->qty_available>0) {
         return response()->json(['status'=>true,'product'=>$data]);
        }
        else
        {
           return response()->json(['status'=>false,'product'=>$data]);
        }
    }

    public function scannerappend1(Request $request)
    {
        $row =$request->row;
        $quantity =$request->quantity;
        $sale_type =$request->sale_type;
        $data = Variation::join('products AS p', 'variations.product_id', '=', 'p.id')
            ->join('product_variations AS pv', 'variations.product_variation_id', '=', 'pv.id')
            ->leftjoin('variation_brand_details AS vbd', 'variations.id', '=', 'vbd.variation_id')
            ->where('variations.id', $request->variation_id)
            ->select( 'p.id as product_id',
                    'p.name as product_name',
                    'p.category_id',
                    'vbd.qty_available',
                    'vbd.retail_qty',
                    'variations.default_sell_price as selling_price',
                    'variations.retail_sell_price as retail_price',
                    'variations.id as variation_id',
                    'vbd.brand_id as brand_id',
                    'variations.sub_sku as sku',
                    'variations.name as vari_name'
                )
            ->first();

        $page = $request->page;
        if($page != 'ecommerce') {
            $page == '';
        }

        $action = $request->action;
        if($action != 'create') {
            $action == '';
        }

        if($page == 'ecommerce') {
            return view('admin.eCommerce.production-to-ecommerce.itemlist',compact('data','quantity','row', 'action'));
        }
    

        return view('admin.salePos.partials.product_row',compact('data','quantity','row','sale_type'));
    }


    public function printpayment($id)
    {
        $model =TransactionPayment::find($id);
        $bill_for =_lang('Sales  for');
        return view('admin.salePos.partials.paymentPrint',compact('model','bill_for'));
    }

    public function pos_print($id)
    {
        $model =Transaction::find($id);
        return view('admin.salePos.partials.posPrint',compact('model'));
    }

    public function notification($id)
    {
        $model =Transaction::find($id);
        $templates = EmailTemolate::select('id','name')->get();
        return view('admin.salePos.partials.notification',compact('model','templates'));
    }

    public function view($id)
    {
     if (!auth()->user()->can('sale_pos.view')) {
            abort(403, 'Unauthorized action.');
        }
        $model =Transaction::find($id);
        return view('admin.salePos.partials.view',compact('model'));
    }

    public function payment($id)
    {
        $transaction = Transaction::where('id', $id)
                                    ->with(['client'])
                                    ->first();
        $payments_query = TransactionPayment::where('transaction_id', $id);

        $payments_query->with(['payment_account']);

        $payments = $payments_query->get();
        $accounts = Account::forDropdown(false, false);
        return view('admin.salePos.partials.makepayment_modal',compact('transaction','payments','accounts'));
    }

}
