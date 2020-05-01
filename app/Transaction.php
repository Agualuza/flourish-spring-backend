<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    protected $table = 'transaction';
    const MAX_VAR_RATE = 0.4;

    public function option()
    {
        return $this->hasOne('App\Option');
    }

    public static function hasOptionsTransactionsOpen($customer,$option_id,$amount){
        $transactions = DB::table('transaction')
        ->select(DB::raw('id,amount'))
        ->whereRaw('customer_id = ? and option_id = ? and transaction_type = ? and transaction_status = ?',[$customer->id,$option_id,"B","O"])
        ->get();

        if(count($transactions) == 0){
            return false;
        }

        $array = [];
        $total = 0;

        foreach ($transactions as $a) {
            $t = Transaction::find($a->id);
            $t->transaction_status = "C";
            $array[] = $t;
            $total += $a->amount;
        }

        if($total < $amount){
            return false;
        }

        foreach($array as $transaction){
            $transaction->save();
        }
        
        $diff = $total - $amount;

        if($diff){
            $rebalanceTransaction = new Transaction();
            $rebalanceTransaction->bank_id = $customer->bank_id;
            $rebalanceTransaction->customer_id = $customer->id;
            $rebalanceTransaction->option_id = $option_id;
            $rebalanceTransaction->amount = $diff;
            $rebalanceTransaction->transaction_type = "B";
            $rebalanceTransaction->transaction_status = "O";
            $rebalanceTransaction->rebalanced = 1;
            $rebalanceTransaction->save();
        }

        return true;
    }

    public static function lock($customer,$type,$amount){
        if($type == "F"){
            return true;
        }

        $transactions = DB::table('transaction')
        ->join('option', 'transaction.option_id', '=', 'option.id')
        ->select(DB::raw('transaction.id,transaction.amount,transaction.option_id,option.option_type'))
        ->whereRaw('customer_id = ? and transaction_type = ? and transaction_status = ?',[$customer->id,"B","O"])
        ->get();

        if(count($transactions) == 0){
            return false;
        }

        $totalVar = 0;

        foreach ($transactions as $t) {
            if($t->option_type == "V"){
                $totalVar += $t->amount;
            }
        }

        $total = $customer->balance + $customer->cash;
        $rate = ($totalVar + $amount)/$total;

        if($rate > Transaction::MAX_VAR_RATE){
            return false;
        }

        return true;
    }
}
