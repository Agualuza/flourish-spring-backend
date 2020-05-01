<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Customer;

class Bank extends Model
{   
    protected $table = 'bank';

    public function loadCustomerList(){
        return Customer::where('bank_id', $this->id)->get();
    }

    public function loadCustomer($cid,$bid){
        $customer = Customer::find($cid);
        
        if($customer->bank_id != $bid){
            return false;
        }

        return $customer;
    }
}
