<?php

namespace App\Http\Controllers;
use App\User;
use App\APIService;

use Illuminate\Http\Request;

class BankController extends Controller
{
    public function loadCustomers(Request $request){
        if($request['credentials']){
            $uid = $request['credentials']['id'];
            $token = $request['credentials']['token'];

            $user = User::getUserByToken($uid,$token);

            if($user->user_type != "B"){
                return APIService::sendJson(["status" => "NOK","message" => "você não tem acesso a essa operação"]);
            }

            if($request["customer_id"]){
                $response = $user->bank->loadCustomer($request["customer_id"],$user->bank->id);
            } else {
                $response = $user->bank->loadCustomerList();
            }

            if($response){
                return APIService::sendJson(["status" => "OK","response" => $response, "message" => "sucesso"]);
            }

            return APIService::sendJson(["status" => "OK","message" => "nenhum cliente encontrado"]);
        }

        return APIService::sendJson(["status" => "NOK","message" => "parametros inválidos"]);
    }
}
