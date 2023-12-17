<?php 
namespace App\Utilities;

use App\models\Production\Product;
use App\models\Production\Transaction;
use App\models\Production\TransactionPayment;
use App\models\Production\Variation;
use App\models\Production\VariationBrandDetails;
use App\models\inventory\TransactionSellLine;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionUtil
{
  
  public function createSellTransaction($input,$user_id,$ref_no,$invoice_no=null){

  	$transaction = Transaction::create([
  		'client_id'=>$input['client_id']?:1,
  		'date'=>$input['date'],
  		'type'=>'Credit',
        'invoice_no'=>$invoice_no,
  		'reference_no'=>$ref_no,
  		'transaction_type'=>'Sale',
        'sale_type'=>$input['sale_type'],
  		'brand_id'=>get_option('default_brand'),
  		'sub_total'=>$input['sub_total'],
  		'discount'=>$input['discount'],
  		'discount_type'=>$input['discount_type'],
  		'discount_amount'=>$input['discount_amount'],
  		'tax'=>$input['tax'],
  		'shipping_charges'=>$input['shipping_charges'],
  		'net_total'=>$input['net_total'],
  		'paid'=>$input['paid'],
  		'due'=>$input['due'],
  		'stuff_note'=>$input['stuff_note'],
  		'sell_note'=>$input['sale_note'],
  		'created_by'=>$user_id,

  	]);

  	return $transaction;
  }

  public function createSellLines($transaction,$variations)
  {
  	foreach ($variations as $variation) {
  		$create_sale_line = TransactionSellLine::create([
  			'transaction_id'=>$transaction->id,
  			'client_id'=>$transaction->client_id,
  			'product_id'=>$variation['product_id'],
            'sale_type'=>$transaction->sale_type,
  			'variation_id'=>$variation['variation_id'],
            'brand_id'=>$variation['brand_id'],
  			'quantity'=>$variation['quantity'],
  			'unit_price'=>$variation['unit_price'],
  			'total'=>$variation['unit_price']*$variation['quantity'],
  			'created_by'=>$transaction->created_by,
  		]);
  	}
  	return true;
  }


     public function decreaseProductQuantity($product_id, $variation_id, $brand_id, $new_quantity,$sale_type=null, $old_quantity = 0)
    {
        $qty_difference = $new_quantity - $old_quantity;

        $product = Product::find($product_id);

        //Check if stock is enabled or not.
            //Decrement Quantity in variations location table
        if ($sale_type=='wholesale') {
            VariationBrandDetails::where('variation_id', $variation_id)
                ->where('product_id', $product_id)
                ->where('brand_id', $brand_id)
                ->decrement('qty_available', $qty_difference);
        }else{
            VariationBrandDetails::where('variation_id', $variation_id)
                ->where('product_id', $product_id)
                ->where('brand_id', $brand_id)
                ->decrement('retail_qty', $qty_difference);
        }

            
            // Variation::where('id', $variation_id)
            //     ->where('product_id', $product_id)
            //     ->decrement('qty_available', $qty_difference);

            //TODO: Decrement quantity in products table
            // Product::where('id', $product_id)
            //     ->decrement('total_qty_available', $qty_difference);

        return true;
    }


    public function IncreaseVariationQty($product_id, $variation_id, $brand_id, $new_quantity, $old_quantity = 0)

    {
        $product = Product::find($product_id);

        //Check if stock is enabled or not.
            //Decrement Quantity in variations location table
            VariationBrandDetails::where('variation_id', $variation_id)
                ->where('product_id', $product_id)
                ->where('brand_id', $brand_id)
                ->increment('qty_available', $new_quantity);

            
            // Variation::where('id', $variation_id)
            //     ->where('product_id', $product_id)
            //     ->decrement('qty_available', $qty_difference);

            //TODO: Decrement quantity in products table
            // Product::where('id', $product_id)
            //     ->decrement('total_qty_available', $qty_difference);

        return true;
    }



     /**
     * Creates a new opening balance transaction for a contact
     *
     * @param  int $business_id
     * @param  int $contact_id
     * @param  int $amount
     *
     * @return void
     */
    public function createOpeningBalanceTransaction($client_id, $amount,$type=null,$trans_type=null)
    {


        $ym = Carbon::now()->format('Y/m');

        $row = Transaction::where('transaction_type', $trans_type)->withTrashed()->get()->count() > 0 ? Transaction::where('transaction_type', $trans_type)->withTrashed()->get()->count() + 1 : 1;
        
        $ref_no = $ym.'/Opening_'.ref($row);

        $transaction = Transaction::create([
            'client_id'=>$client_id,
            'date'=>date('Y-m-d'),
            'type'=>$type,
            'payment_status' => 'due',
            'reference_no'=>$ref_no,
            'transaction_type'=>$trans_type,
            'net_total'=>$amount,
            'due'=>$amount,
            'created_by'=>auth()->user()->id,
        ]);

         return true;
    }



        /**
     * Checks if products has manage stock enabled then Updates quantity for product and its
     * variations
     *
     * @param $location_id
     * @param $product_id
     * @param $variation_id
     * @param $new_quantity
     * @param $old_quantity = 0
     * @param $number_format = null
     * @param $uf_data = true, if false it will accept numbers in database format
     *
     * @return boolean
     */
    public function updateProductQuantity($product_id, $variation_id,$brand_id, $new_quantity, $old_quantity = 0,$sale_type=null, $number_format = null, $uf_data = true)
    {

        $qty_difference = $new_quantity - $old_quantity;

        $product = Product::find($product_id);

        //Check if stock is enabled or not.
        if ($qty_difference != 0) {
            $variation = Variation::where('id', $variation_id)
                            ->where('product_id', $product_id)
                            ->first();
            
            //Add quantity in VariationBrandDetails
            $variation_brand_d = VariationBrandDetails::where('product_id', $product_id)
                                    ->where('variation_id', $variation_id)
                                     ->where('product_variation_id', $variation->product_variation_id)
                                     ->where('brand_id', $brand_id)
                                    ->first();
            if (empty($variation_brand_d)) {
                $variation_brand_d = new VariationBrandDetails();
                $variation_brand_d->variation_id = $variation->id;
                $variation_brand_d->product_id = $product_id;
                $variation_brand_d->brand_id = $brand_id;
                $variation_brand_d->product_variation_id = $variation->product_variation_id;
                if ($sale_type=='wholesale') {
                  $variation_brand_d->qty_available = 0;
                }else{
                  $variation_brand_d->retail_qty = 0;  
                }
            }
            if ($sale_type=='wholesale') {
                $variation_brand_d->qty_available +=$qty_difference;
            }else{
                $variation_brand_d->retail_qty +=$qty_difference;
            }
             $variation_brand_d->save();

            //TODO: Add quantity in products table
            // Product::where('id', $product_id)
            //     ->increment('total_qty_available', $qty_difference);
        }
        
        return true;
    }


        /**
     * Update the payment status for purchase or sell transactions. Returns
     * the status
     *
     * @param int $transaction_id
     *
     * @return string
     */
    public function updatePaymentStatus($transaction_id, $final_amount = null)
    {
        $status = $this->calculatePaymentStatus($transaction_id, $final_amount);
        Transaction::where('id', $transaction_id)
            ->update(['payment_status' => $status]);

        return $status;
    }


     public function setReference($transaction_type)
    {
        $ym = Carbon::now()->format('Y/m');

        $row = Transaction::where('transaction_type', $transaction_type)->withTrashed()->get()->count() > 0 ? Transaction::where('transaction_type', $transaction_type)->withTrashed()->get()->count() + 1 : 1;
        if ($transaction_type=='Sale') {
          $seq ='/S-';
        }
        elseif ($transaction_type=='sale_return') {
          $seq ='/SR-';
        }
        elseif ($transaction_type=='Purchase') {
          $seq ='/P-';
        }
         elseif ($transaction_type=='purchase_return') {
          $seq ='/PR-';
        }
        elseif ($transaction_type=='opening_balance') {
          $seq ='/Open-';
        }
         $ref_no = $ym.$seq.ref($row);
         return $ref_no;
    }

    /**
     * Calculates the payment status and returns back.
     *
     * @param int $transaction_id
     * @param float $final_amount = null
     *
     * @return string
     */
    public function calculatePaymentStatus($transaction_id, $final_amount = null)
    {
        $total_paid = $this->getTotalPaid($transaction_id);

        if (is_null($final_amount)) {
            $final_amount = Transaction::find($transaction_id)->net_total;
        }

        $status = 'due';
        if ($final_amount <= $total_paid) {
            $status = 'paid';
        } elseif ($total_paid > 0 && $final_amount > $total_paid) {
            $status = 'partial';
        }

        return $status;
    }

    /**
     * Get total paid amount for a transaction
     *
     * @param int $transaction_id
     *
     * @return int
     */
    public function getTotalPaid($transaction_id)
    {
        $total_paid = TransactionPayment::where('transaction_id', $transaction_id)
                ->select(DB::raw('SUM(IF( is_return = 0, amount, amount*-1))as total_paid'))
                ->first()
                ->total_paid;

        return $total_paid;
    }


       /**
     * Pay contact due at once
     *
     * @param obj $parent_payment, string $type
     *
     * @return void
     */
    public function payAtOnce($parent_payment, $type)
    {
        //Get all unpaid transaction for the contact
        $types = ['opening_balance', $type];
        
        if ($type == 'purchase_return') {
            $types = [$type];
        }

        $due_transactions = Transaction::where('client_id', $parent_payment->client_id)
                                ->whereIn('transaction_type', $types)
                                ->where('payment_status', '!=', 'paid')
                                ->orderBy('date', 'asc')
                                ->get();
        $total_amount = $parent_payment->amount;
        $tranaction_payments = [];
        if ($due_transactions->count()) {
            foreach ($due_transactions as $transaction) {
                if ($total_amount > 0) {
                    $total_paid = $this->getTotalPaid($transaction->id);
                    $due = $transaction->net_total - $total_paid;

                    $now = Carbon::now()->toDateTimeString();

                    $array = [
                            'transaction_id' => $transaction->id,
                            'method' => $parent_payment->method,
                            'type'=>$parent_payment->type,
                            'transaction_no' => $parent_payment->transaction_no,
                            'payment_date' => $parent_payment->payment_date,
                            'created_by' => $parent_payment->created_by,
                            'client_id' => $parent_payment->client_id,
                            'parent_id' => $parent_payment->id,
                            'created_at' => $now,
                            'updated_at' => $now
                        ];

                      // if ($transaction->transaction_type=='sale_return') {
                      //       $array['type'] = 'Debit';
                      //   }else{
                      //       $array['type'] = 'Credit'; 
                      //   }

                    if ($due <= $total_amount) {
                        $array['amount'] = $due;
                        $tranaction_payments[] = $array;

                        //Update transaction status to paid
                        $transaction->paid =$transaction->paid+$due;
                        $transaction->due =$transaction->due-$due;
                        $transaction->payment_status = 'paid';
                        $transaction->save();

                        $total_amount = $total_amount - $due;
                    } else {
                        $array['amount'] = $total_amount;
                        $tranaction_payments[] = $array;

                        //Update transaction status to partial
                        $transaction->paid =$transaction->paid+$due;
                        $transaction->due =$transaction->due-$due;
                        $transaction->payment_status = 'partial';
                        $transaction->save();
                        break;
                    }
                }
            }

            //Insert new transaction payments
            if (!empty($tranaction_payments)) {
                TransactionPayment::insert($tranaction_payments);
            }
        }
    }

       /**
     * Check if return exist for a particular purchase or sell
     * @param id $transacion_id
     *
     * @return boolean
     */
    public function isReturnExist($transacion_id)
    {
        return Transaction::where('return_parent_id', $transacion_id)->exists();
    }

}
