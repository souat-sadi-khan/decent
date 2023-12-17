<?php

namespace App\models\account;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;
    
    protected $guarded = ['id'];


    public static function accountTypes()
    {
        return [
            // '' => _lang('Not Applicable'),
            'saving_current' => _lang('Saving Current'),
            'capital' => _lang('Capital'),
            'bank_account' => _lang('Bank Account'),
            'direct_income' => _lang('Direct Income'),
            'unsecured_loan' => _lang('Unsecured Loan'),
        ];
    }

        /**
     * Scope a query to only include not closed accounts.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotClosed($query)
    {
        return $query->where('is_closed', 0);
    }

        /**
     * Scope a query to only include non capital accounts.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotCapital($query)
    {
        return $query->where(function ($q) {
            $q->where('account_type', '!=', 'capital');
            $q->orWhereNull('account_type');
        });
    }


   public static function forDropdown($brand_id=false, $prepend_none, $closed = false)
    {
        $query = Account::NotCapital();

        if (!$closed) {
            $query->where('is_closed', 0);
        }

        $dropdown = $query->pluck('name', 'id');
        if ($prepend_none) {
            $dropdown->prepend(_lang('None'), '');
        }

        return $dropdown;
    }


}
