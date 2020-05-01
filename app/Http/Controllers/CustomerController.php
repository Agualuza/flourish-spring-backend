<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function wallet(Request $request){
        if($request['transaction']){
            $u = $request['transaction']['user'];
            $uid = $u['id'];
            $token = $u['token'];
            $amount = $request['transaction']['amount'];
            $type = $request['transaction']['type']; //D - deposit, W - withdraw

            $user = User::getUserByToken($uid,$token);

            if($user->user_type != "C"){
                return APIService::sendJson(["status" => "NOK","message" => "você não tem acesso a essa operação"]);
            }

            if($type == "D"){
                $user->customer->deposit($amount);
                return APIService::sendJson(["status" => "OK","message" => "sucesso"]);
            } 

            if($type == "W"){
                $user->customer->withdraw($amount);
                return APIService::sendJson(["status" => "OK","message" => "sucesso"]);
            } 

            return APIService::sendJson(["status" => "NOK","message" => "transação inválida"]);
        }

        return APIService::sendJson(["status" => "NOK","message" => "parametros inválidos"]);
    }
}
