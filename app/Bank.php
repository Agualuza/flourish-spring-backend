<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Customer;
use stdClass;

class Bank extends Model
{   
    protected $table = 'bank';

    public function loadCustomerList(){
        $customers = Customer::where('bank_id', $this->id)->get();
        $arrayResponse = [];

        foreach($customers as $customer){
            $response = new stdClass;
            $response->id = $customer->id;
            $response->nome = $customer->user->name;
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
}
