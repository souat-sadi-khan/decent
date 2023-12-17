<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\User;
use App\models\Client;
use App\models\Expense\Expense;
use App\models\Expense\ExpenseCategory;
use App\models\Production\Brand;
use App\models\Production\Category;
use App\models\Production\Product;
use App\models\Production\Transaction;
use App\models\account\Account;
use App\models\account\AccountTransaction;
use App\models\account\InvestmentAccount;
use App\models\employee\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SuperAdminController extends Controller
{
   public function product(Request $request)
   {
      if (!auth()->user()->hasRole('Super Admin')) {
        abort(403, 'Unauthorized action.');
      }
        if ($request->ajax()) {
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
        if (!empty($brand_id)) {
            $products->where('VBD.brand_id', $brand_id);
        }
          $category_id = request()->get('category_id', null);
            if (!empty($category_id)) {
                $products->where('products.category_id', $category_id);
            }

           $products = $products->select(
                'products.id as product_id',
                'products.name as pro_name',
                'variations.id as variation_id',
                'variations.name as variation',
                'VBD.qty_available as qty',
                'variations.default_sell_price as selling_price',
                'variations.sub_sku as sku',
                'VBD.brand_id as brand_id',
                'products.photo as image',
                'variations.hidden as hidden',
                'variations.id as id'
            );
            $document = $products->orderBy('VBD.qty_available', 'desc')
                        ->get();
                 return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('product_name', function ($document) {
                    return $document->pro_name;
                })
                ->editColumn('variation', function ($document) {
                    return $document->variation? $document->variation : null;
                })
                ->editColumn('f_sku', function ($document) {
                    return $document->sku;
                  

                })

                ->editColumn('hidden', function ($model) {
                  $table ='variations';
                    return view('superadmin.status',compact('model','table'));
                
                })
                 ->editColumn('f_qty', function ($document) {
                  if (auth()->user()->can("view_product.qty")) {
                     return $document->qty;
                  }else
                  {
                    return 'N/A';
                  }

                })
                 ->editColumn('selling_price', function ($document) {
                   if (auth()->user()->can("view_product.sale_price")) {
                    return $document->selling_price;
                  }else{
                    return 'N/A';
                  }

                })
              
               ->rawColumns(['product_name', 'variation','f_sku','f_qty','selling_price','hidden'])->make(true);            
         }
         $brands=Brand::pluck('name', 'id');
         $categories=Category::pluck('name', 'id');
         return view('superadmin.product.index',compact('brands','categories')); 
   }

   public function client(Request $request)
   {
    if (!auth()->user()->hasRole('Super Admin')) {
        abort(403, 'Unauthorized action.');
      }
        if ($request->ajax()) {
            $document = Client::leftjoin('transactions AS t', 'clients.id', '=', 't.client_id')
                    ->select('clients.name','clients.email','clients.hidden', 'state', 'country', 'landmark', 'mobile', 'clients.id',
                        DB::raw("SUM(IF(t.transaction_type = 'Sale', net_total, 0)) as total_invoice"),
                        DB::raw("SUM(IF(t.transaction_type = 'Sale', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as invoice_received"),
                        DB::raw("SUM(IF(t.transaction_type = 'sale_return', net_total, 0)) as total_sell_return"),
                        DB::raw("SUM(IF(t.transaction_type = 'sale_return', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as sell_return_paid"),
                        DB::raw("SUM(IF(t.transaction_type = 'opening_balance', net_total, 0)) as opening_balance"),
                        DB::raw("SUM(IF(t.transaction_type = 'opening_balance', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as opening_balance_paid")

                        )
                    ->groupBy('clients.id');
            return DataTables::of($document)
                ->addIndexColumn()
                 ->editColumn(
                'landmark',
                '{{implode(array_filter([$landmark, $state, $country]), ", ")}}'
                  )
                    ->addColumn(
                'due',
                '<span class="display_currency contact_due" data-orig-value="{{$total_invoice - $invoice_received}}" data-currency_symbol=true data-highlight=true>{{($total_invoice - $invoice_received)}}</span>'
                )
               ->addColumn(
                'return_due',
                '<span class="display_currency return_due" data-orig-value="{{$total_sell_return - $sell_return_paid}}" data-currency_symbol=true data-highlight=false>{{$total_sell_return - $sell_return_paid }}</span>'
                )
                ->addColumn('action', function ($model) {
                  $table ='clients';
                    return view('superadmin.status', compact('model','table'));
                })->rawColumns(['action','landmark','due','return_due'])->make(true);
        }
        return view('superadmin.client');
   }

   public function sells(Request $request)
   {
    if (!auth()->user()->hasRole('Super Admin')) {
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
            $q =$q->where('transaction_type','Sale');
            $document =$q->get();

            return DataTables::of($document)
                ->addIndexColumn()
                 ->editColumn('date', function ($model) {
                  return formatDate($model->date);
                 })
                 ->editColumn('client', function ($model) {
                  return $model->client?$model->client->name:'';
                 })
                 ->editColumn('paid', function ($model) {
                    if (auth()->user()->can("view_sale.sale_paid")) {
                    return $model->payment()->where('type','Credit')->sum('amount');
                  }else{
                    return 'N/A';
                  }
                 })
                ->editColumn('due', function ($model) {
                    if (auth()->user()->can("view_sale.sale_due")) {
                    return $model->net_total-($model->payment()->where('type','Credit')->sum('amount'));
                    }else{
                        return 'N/A';
                    }
                 })
                 ->editColumn('payment_status', function ($model) {
                   if ($model->payment_status=='paid') {
                      return '<span class="badge badge-success">Paid</span>';
                   }
                   elseif($model->payment_status=='partial'){
                     return '<span class="badge badge-info">Partial</span>';
                   }
                   else{
                    return '<span class="badge badge-danger">Due</span>';
                   }
                 })
                ->addColumn('action', function ($model) {
                  $table ='transactions';
                    return view('superadmin.status', compact('model','table'));
                })->rawColumns(['action','client','date','paid','due','payment_status'])->make(true);
        }
        $customer =Client::orderBy('id','DESC')->pluck('name','id');
        $user =User::orderBy('id','DESC')->pluck('email','id');
       return view('superadmin.sells',compact('customer','user'));
   }

   public function sell_return(Request $request)
   {
    if (!auth()->user()->hasRole('Super Admin')) {
        abort(403, 'Unauthorized action.');
      }
          if ($request->ajax()) {
          $document = Transaction::orderBy('id','DESC')->where('transaction_type','Sale')->where('return',1)->get();
           return DataTables::of($document)
                ->addIndexColumn()
                 ->editColumn('reference_no', function ($model) {
                  return '<a href="'.route('admin.sale.pos.show',$model->id).'" target="_blank">'.$model->reference_no.'</a>';
                 })
                 ->editColumn('client', function ($model) {
                  return $model->client?$model->client->name:'';
                 })
                 ->editColumn('sale', function ($model) {
                    if (auth()->user()->can("view_sale.sale_price")) {
                    return $model->net_total;
                    }else{
                        return 'N/A';
                    }
                 })
                ->editColumn('return', function ($model) {
                    if (auth()->user()->can("view_sale.return_amt")) {
                    return $model->return_parent->sum('net_total');
                    }else{
                        return 'N/A';
                    }
                 })
                  ->editColumn('count', function ($model) {
                  return $model->return_parent->count();
                 })
                   ->editColumn('hide', function ($model) {
                  return $model->return_parent()->where('hidden',true)->count();
                 })
                ->addColumn('action', function ($model) {
                    return view('superadmin.sale_return.action', compact('model'));
                })->rawColumns(['action','client','reference_no','sale','return','count','hide'])->make(true);
      }  
      return view('superadmin.sale_return.sale_return');
   }

   public function sell_return_hide(Request $request,$id)
   {

    if (!auth()->user()->hasRole('Super Admin')) {
        abort(403, 'Unauthorized action.');
      }
     if ($request->ajax()) {
      $model =Transaction::where('transaction_type','sale_return')->where('return_parent_id',$id)->get();
         return DataTables::of($model)
                ->addIndexColumn()
                 ->editColumn('date', function ($model) {
                  return formatDate($model->date);
                 })
                 ->editColumn('client', function ($model) {
                  return $model->client?$model->client->name:'';
                 })
                 ->editColumn('total', function ($model) {
                   return $model->net_total;
                 })
                ->addColumn('action', function ($model) {
                  $table ='transactions';
                    return view('superadmin.status', compact('model','table'));
                })->rawColumns(['action','client','date','total'])->make(true);
     }
     return view('superadmin.sale_return.details',compact('id'));
   }


   public function purchase(Request $request)
   {
    if (!auth()->user()->hasRole('Super Admin')) {
        abort(403, 'Unauthorized action.');
      }
      if ($request->ajax()) {
            $document = Transaction::query();
              if (request()->has('employee_id')) {
                $employee_id = request()->get('employee_id');
                if (!empty($employee_id)) {
                    $document=$document->where('purchase_by', $employee_id);
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
            $document =$document->where('transaction_type','Purchase')->get();
            return DataTables::of($document)
                ->addIndexColumn()
                ->editColumn('purchase_by', function ($document) {
                    return $document->employee?$document->employee->name:'';
                })
                ->editColumn('brand_id', function ($document) {
                    return $document->brand? $document->brand->name:'';
                })
                ->editColumn('status', function ($document) {
                    if ($document->status == 'Received') {
                        return '<span class="badge badge-success">' . 'Received' . '</span>';
                    } else if($document->status == 'Pending') {
                        return '<span class="badge badge-warning">' . 'Pending' . '</span>';
                    } else if($document->status == 'Ordered') {
                        return '<span class="badge badge-info">' . 'Ordered' . '</span>';
                    }
                })
                ->editColumn('total', function ($document) {
                    if (auth()->user()->can("view_purchase.price")) {
                        return $document->net_total;
                    }else{
                        return 'N/A';
                    }
                })
                ->editColumn('payment_status', function ($document) {
                    if ($document->payment_status == 'Paid') {
                        return '<span class="badge badge-success">' . 'Paid' . '</span>';
                    } else if($document->payment_status == 'Partial') {
                        return '<span class="badge badge-info">' . 'Partial' . '</span>';
                    } else if($document->payment_status == 'Due') {
                        return '<span class="badge badge-info">' . 'Due' . '</span>';
                    }
                })
                ->addColumn('action', function ($model) {
                  $table ='transactions';
                    return view('superadmin.status', compact('model','table'));
                })->rawColumns(['action','status', 'payment_status','total'])->make(true);
        }

        $employeis =Employee::pluck('name','id');
        return view('superadmin.purchase',compact('employeis'));
   }

   public function expense(Request $request)
   {

    if (!auth()->user()->hasRole('Super Admin')) {
        abort(403, 'Unauthorized action.');
      }
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
                  $table ='expenses';
                    return view('superadmin.status', compact('model','table'));
                })->rawColumns(['action','category','date','account','e_amount','employee'])->make(true);
        }

        $categories =ExpenseCategory::pluck('name', 'id');
        $investment =InvestmentAccount::pluck('name', 'id');
        $employeis =Employee::pluck('name', 'id');
        return view('superadmin.expense',compact('categories','investment','employeis'));
   }


   public function account(Request $request)
   {

    if (!auth()->user()->hasRole('Super Admin')) {
        abort(403, 'Unauthorized action.');
      }
            if (request()->ajax()) {
            $accounts = AccountTransaction::join(
                'accounts as A',
                'account_transactions.account_id',
                '=',
                'A.id'
            )
            ->with(['transaction', 'transaction.client'])
            ->select(['type', 'amount', 'operation_date',
                'sub_type', 'transfer_transaction_id',
                DB::raw('(SELECT SUM(IF(AT.type="credit", AT.amount, -1 * AT.amount)) from account_transactions as AT WHERE AT.operation_date <= account_transactions.operation_date AND AT.deleted_at IS NULL) as balance'),
                'transaction_id',
                'account_transactions.id',
                'A.name as account_name',
                'account_transactions.hidden as hidden'
                ])
             ->groupBy('account_transactions.id')
             ->orderBy('account_transactions.operation_date', 'desc');
            if (!empty(request()->input('type'))) {
                $accounts->where('type', request()->input('type'));
            }

            if (!empty(request()->input('account_id'))) {
                $accounts->where('A.id', request()->input('account_id'));
            }

            $start_date = request()->input('start_date');
            $end_date = request()->input('end_date');
            
            if (!empty($start_date) && !empty($end_date)) {
                $accounts->whereBetween(DB::raw('date(operation_date)'), [$start_date, $end_date]);
            }

            return DataTables::of($accounts)
                    ->addColumn('debit', function ($row) {
                        if ($row->type == 'debit') {
                            return '<span class="display_currency" data-currency_symbol="true">' . number_format($row->amount,2) . '</span>';

                        }
                       
                    })
                    ->addColumn('credit', function ($row) {
                        if ($row->type == 'credit') {
                            return '<span class="display_currency" data-currency_symbol="true">' . number_format($row->amount,2) . '</span>';
                        }
                       
                    })
                    ->editColumn('balance', function ($row) {
                        return '<span class="display_currency" data-currency_symbol="true">' . number_format($row->balance,2) . '</span>';
                    })
                    ->editColumn('operation_date', function ($row) {
                        return $row->operation_date;
                    })

                    ->editColumn('hidden', function ($model) {
                      $table ='account_transactions';
                     return view('superadmin.status', compact('model','table'));
                    })
                    ->editColumn('sub_type', function ($row) {
                        $details = '';
                        if (!empty($row->sub_type)) {
                            $details = _lang( $row->sub_type);
                            if (in_array($row->sub_type, ['fund_transfer', 'deposit']) && !empty($row->transfer_transaction)) {
                                if ($row->type == 'credit') {
                                    $details .= ' ( ' . _lang('Form') .': ' . $row->transfer_transaction->account->name . ')';
                                } else {
                                    $details .= ' ( ' . _lang('To') .': ' . $row->transfer_transaction->account->name . ')';
                                }
                            }
                        } else {
                            if (!empty($row->transaction->transaction_type)) {
                                if ($row->transaction->transaction_type == 'Purchase') {
                                    $details = '<b>' . _lang('Supplier') . ':</b> ' . $row->transaction->client->name . '<br><b>'.
                                    _lang('Reference') . ':</b> ' . $row->transaction->reference_no;
                                } elseif ($row->transaction->transaction_type == 'Sale') {
                                    $details = '<b>' . _lang('Customer') . ':</b> ' . $row->transaction->client->name . '<br><b>'.
                                    _lang('Reference') . ':</b> ' . $row->transaction->reference_no;
                                }
                            }
                        }

                        return $details;
                    })
                    ->removeColumn('id')
                    ->rawColumns(['credit', 'debit', 'balance', 'sub_type','hidden'])
                    ->make(true);
        }
        $accounts = Account::forDropdown(false, false);

        $accounts->prepend(_lang('All'), '');
                            
        return view('superadmin.account')
                 ->with(compact('accounts'));
   }

   public function hidden(Request $request,$value,$id)
   {
    
    if (request()->ajax()) {
        DB::table($request->model)
            ->where('id', $id)
            ->update(['hidden' => $value,]);
      return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Status Updated')]);
    }
  
   }
}
