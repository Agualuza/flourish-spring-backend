<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\APIService;

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

    public function loadTransactions(Request $request){
        if($request['credentials']){
            $uid = $request['credentials']['id'];
            $token = $request['credentials']['token'];

            $user = User::getUserByToken($uid,$token);

            if($user->user_type != "C"){
                return APIService::sendJson(["status" => "NOK","message" => "você não tem acesso a essa operação"]);
            }

            $transactions = $user->customer->loadAllNotRebalancedTransactions();

            if($transactions){
                return APIService::sendJson(["status" => "OK","response" => $transactions, "message" => "sucesso"]);
            }

            return APIService::sendJson(["status" => "OK","response" => [], "message" => "você não possui nenhuma transação"]);
        }

        return APIService::sendJson(["status" => "NOK","message" => "parametros inválidos"]);
    }

    public function loadScore(Request $request){
        if($request['credentials']){
            $uid = $request['credentials']['id'];
            $token = $request['credentials']['token'];

            $user = User::getUserByToken($uid,$token);

            if($user->user_type != "C"){
                return APIService::sendJson(["status" => "NOK","message" => "você não tem acesso a essa operação"]);
            }

            $response = $user->customer->loadCustomer();
            
            return APIService::sendJson(["status" => "OK","response" => $response , "message" => "sucesso"]);
        }

        return APIService::sendJson(["status" => "NOK","message" => "parametros inválidos"]);
    }
}
