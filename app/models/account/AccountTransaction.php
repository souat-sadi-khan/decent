<?php

namespace App\models\account;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountTransaction extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function transaction()
    {
        return $this->belongsTo('App\models\Production\Transaction','transaction_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function user(){
        return $this->belongsTo('App\User','created_by','id');
    }

       public function transfer_transaction()
    {
        return $this->belongsTo(AccountTransaction::class, 'transfer_transaction_id');
    }

    /**
     * Creates new account transaction
     * @return obj
     */
    public static function createAccountTransaction($data)
    {
        $transaction_data = [
            'amount' => $data['amount'],
            'account_id' => !empty($data['account_id'])?$data['account_id']:null,
            'investment_account_id' => !empty($data['investment_account_id'])?$data['investment_account_id']:null,
            'acc_type' => !empty($data['acc_type'])?$data['acc_type']:'investment',
            'type' => $data['type'],
            'sub_type' => !empty($data['sub_type']) ? $data['sub_type'] : null,
            'operation_date' => !empty($data['operation_date']) ? $data['operation_date'] : Carbon::now(),
            'created_by' => $data['created_by'],
            'transaction_id' => !empty($data['transaction_id']) ? $data['transaction_id'] : null,
            'transaction_payment_id' => !empty($data['transaction_payment_id']) ? $data['transaction_payment_id'] : null,
            'note' => !empty($data['note']) ? $data['note'] : null,
            'transfer_transaction_id' => !empty($data['transfer_transaction_id']) ? $data['transfer_transaction_id'] : null,
        ];

        $account_transaction = AccountTransaction::create($transaction_data);

        return $account_transaction;
    }

    /**
     * Updates transaction payment from transaction payment
     * @param  obj $transaction_payment
     * @param  array $inputs
     * @param  string $transaction_type
     * @return string
     */
    public static function updateAccountTransaction($transaction_payment, $transaction_type)
    {
        if (!empty($transaction_payment->account_id)) {
            $account_transaction = AccountTransaction::where(
                'transaction_payment_id',
                $transaction_payment->id
            )->first();
            if (!empty($account_transaction)) {
                $account_transaction->amount = $transaction_payment->amount;
                $account_transaction->account_id = $transaction_payment->account_id;
                $account_transaction->save();
                return $account_transaction;
            } else {
                $accnt_trans_data = [
                    'amount' => $transaction_payment->amount,
                    'account_id' => $transaction_payment->account_id,
                    'acc_type'=>'account',
                    'type' => self::getAccountTransactionType($transaction_type),
                    'operation_date' => $transaction_payment->operation_date,
                    'created_by' => $transaction_payment->created_by,
                    'transaction_id' => $transaction_payment->transaction_id,
                    'transaction_payment_id' => $transaction_payment->id
                ];

                self::createAccountTransaction($accnt_trans_data);
            }
        }
    }

    /**
     * Gives account transaction type from payment transaction type
     * @param  string $payment_transaction_type
     * @return string
     */
    public static function getAccountTransactionType($tansaction_type)
    {
        $account_transaction_types = [
            'Sale' => 'Credit',
            'Purchase' => 'Debit',
            'opening_balance' => 'Debit',
            'Expense' => 'Debit',
            'purchase_return' => 'Credit',
            'sale_return' => 'Debit',
            'work_order'=>'Credit',
            'eCommerce'=>'Credit',
        ];

        return $account_transaction_types[$tansaction_type];
    }
}
