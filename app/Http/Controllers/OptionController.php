<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Option;
use App\APIService;

class OptionController extends Controller
{
    public function options(Request $request){
        if(isset($request['credentials'])){
            $user = User::getUserByToken($request['credentials']['user_id'],$request['credentials']['token']);

            if($user != null){
                $options = Option::getAllOptions($user->customer);
                return APIService::sendJson(["status" => "OK","response" => $options, "message" => "success"]);
            }
            return APIService::sendJson(["status" => "NOK","message" => "token inválido"]);
        } 
        
        return APIService::sendJson(["status" => "NOK","message" => "parametros inválidos"]);
    }
}
