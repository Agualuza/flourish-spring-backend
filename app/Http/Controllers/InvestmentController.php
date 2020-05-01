<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transaction;
use App\APIService;

class InvestmentController extends Controller
{
    public function savings(Request $request){
        if($request['transaction']){
            $u = $request['transaction']['user'];
            $uid = $u['id'];
            $token = $u['token'];
            $amount = $request['transaction']['amount'];

            $user = User::getUserByToken($uid,$token);

            if($user->user_type != "C"){
                return APIService::sendJson(["status" => "NOK","message" => "você não tem acesso a essa operação"]);
            }

            $transaction = new Transaction();
            
            $transaction->bank_id = $user->customer->bank_id;
            $transaction->customer_id = $user->customer->id;
            $transaction->option_id = 1;
            $transaction->amount = $amount;
            $transaction->transaction_type = "B";
            $transaction->transaction_status = "O";
            $transaction->save();
            $done = $user->customer->makeTransaction($transaction->amount,$transaction->transaction_type);

            if($done){
                return APIService::sendJson(["status" => "OK","message" => "sucesso"]);
            }
            return APIService::sendJson(["status" => "NOK","message" => "desculpe, saldo insuficiente para realizar essa transação"]);
        }

        return APIService::sendJson(["status" => "NOK","message" => "parametros inválidos"]);
    }
}
