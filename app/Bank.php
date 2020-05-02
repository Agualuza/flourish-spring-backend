<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Customer;
use App\Transaction;
use stdClass;

class Bank extends Model
{   
    protected $table = 'bank';

    public function transaction()
    {
        return $this->hasMany('App\Transaction');
    }

    public function loadCustomerList(){
        $customers = Customer::where('bank_id', $this->id)->get();
        $arrayResponse = [];

        foreach($customers as $customer){
            $response = new stdClass;
            $response->id = $customer->id;
            $response->nome = $customer->user->name;
            $response->email = $customer->user->email;
            $response->level_id = $customer->level_id;
            $response->level = $customer->level->name;
            $response->score = $customer->score;
            $response->balance = $customer->balance;
            $response->cash = $customer->cash;
            $response->cpf = $customer->cpf;
            $response->created_at = $customer->created_at;
            $response->updated_at = $customer->updated_at;
            $arrayResponse[] = $response;
        }
      
        return $arrayResponse;
    }

    public function loadCustomer($cid,$bid){
        $customer = Customer::find($cid);
        
        if(!$customer){
            return false;
        }

        if($customer->bank_id != $bid){
            return false;
        }

        $response = new stdClass;
        $response->id = $customer->id;
        $response->nome = $customer->user->name;
        $response->email = $customer->user->email;
        $response->level_id = $customer->level_id;
        $response->level = $customer->level->name;
        $response->score = $customer->score;
        $response->balance = $customer->balance;
        $response->cash = $customer->cash;
        $response->cpf = $customer->cpf;
        $response->created_at = $customer->created_at;
        $response->updated_at = $customer->updated_at;

        return $response;
    }

    public function loadDashData(){
        $customers = Customer::where('bank_id', $this->id)->count();
        $balance = DB::table('customer')
        ->select(DB::raw('sum(balance) as balance'))
        ->whereRaw('bank_id = ?',[$this->id])
        ->get();
        $cash = DB::table('customer')
        ->select(DB::raw('sum(cash) as cash'))
        ->whereRaw('bank_id = ?',[$this->id])
        ->get();
        $transactions = Transaction::whereRaw('bank_id = ? AND rebalanced = 0', [$this->id])->count();
        $response = new stdClass;
        $response->customers = $customers;
        $response->balance = $balance[0]->balance;
        $response->cash = $cash[0]->cash;
        $response->transactions = $transactions;

        return $response;
    }

    public function loadAllNotRebalancedTransactions(){
        $transactions = array();

        foreach ($this->transaction as $t) {
            if(!$t->rebalanced){
                $transactions[] = ["transaction" => $t, "option_transaction" => $t->option->name];
            }
        }

        return $transactions;
    }
}
