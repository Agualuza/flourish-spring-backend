<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Option;
use App\Transaction;
use stdClass;

class Customer extends Model
{
    protected $table = "customer";

    public function transaction()
    {
        return $this->hasMany('App\Transaction');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function level()
    {
        return $this->belongsTo('App\Level');
    }

    public function updateLevel() {
        $level_id = null;
        if($this->score >= 5000) {
            $level_id = 5;
        } else if($this->score >= 3500) {
            $level_id = 4;
        } else if($this->score >= 2000) {
            $level_id = 3;
        } else if($this->score >= 800) {
            $level_id = 2;
        } else {
            $level_id = 1;
        }

        if($level_id != $this->level_id){
            $this->level_id = $level_id;
            $this->save();
            return 1;
        }

        return 0;
    }

    public function makeTransaction($amount,$type,$option_id){
        $options = Option::getAllOptions($this);
        $array = array();
        $fixedOrVar = array();

        foreach ($options as $op) {
            $array[$op['option']['id']] = $op["allow"];
            $fixedOrVar[$op['option']['id']] = $op["option"]["option_type"];
        }

        if($type == "B"){
            if($this->balance >= $amount && $array[$option_id] && Transaction::lock($this,$fixedOrVar[$option_id],$amount)){
                $this->balance -= $amount;
                $this->cash += $amount;
            } else {
                return false;
            }

        } else {

            if($this->cash >= $amount && Transaction::hasOptionsTransactionsOpen($this,$option_id,$amount)){
                $this->balance += $amount;
                $this->cash -= $amount;
            } else {
                return false;
            }
        }
        
        if($this->save()){
            return true;
        }

        return false;
    }

    public function deposit($amount){
        $this->balance += $amount;
        $this->save();
    }

    public function withdraw($amount){
        $this->balance -= $amount;
        $this->save();
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

    public function loadCustomer(){
        $customer = $this;
        $arrayNextLevelPoints = [1 => 800, 2 => 2000, 3 => 3500, 4 => 5000, 5 => 0 ];
        $arrayNextLevel = [1 => "Child", 2 => "Teen", 3 => "Major", 4 => "Senior", 5 => "Max"];

        $response = new stdClass;
        $response->id = $customer->id;
        $response->nome = $customer->user->name;
        $response->email = $customer->user->email;
        $response->level_id = $customer->level_id;
        $response->level = $customer->level->name;
        $response->score = $customer->score;
        $response->next_level_score = $arrayNextLevelPoints[$customer->level_id];
        $response->next_level_name = $arrayNextLevel[$customer->level_id];
        $response->balance = $customer->balance;
        $response->cash = $customer->cash;
        $response->cpf = $customer->cpf;
        $response->created_at = $customer->created_at;
        $response->updated_at = $customer->updated_at;

        return $response;
    }

}
