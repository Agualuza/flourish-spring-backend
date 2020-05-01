<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    protected $table = 'transaction';

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

        return true;
    }

}
