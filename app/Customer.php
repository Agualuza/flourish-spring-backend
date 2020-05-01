<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = "customer";

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

    public function makeTransaction($amount,$type){
        if($type == "B"){

            if($this->balance >= $amount){
                $this->balance -= $amount;
                $this->cash += $amount;
            } else {
                return false;
            }

        } else {
            if($this->cash >= $amount){
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
}
