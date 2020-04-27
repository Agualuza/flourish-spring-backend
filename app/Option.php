<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'option';
    public $allow;

    public static function getAllOptions($customer){
        $options = Option::all();
        $options_list = array();

        foreach ($options as $option) {
            if($customer->level_id >= $option->level_id){
                $option->allow = 1;
            } else {
                $option->allow = 0;
            }
            
            $options_list[] = ["option" => $option , "allow"  => $option->allow];
        }

        return $options_list;
    }
}
