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
            $amount = $request['amount'];

            $user = User::getUserByToken($uid,$token);
            $transaction = new Transaction();

            $transaction->bank_id = $user->customer->bank_id;
            $transaction->customer_id = $user->customer->id;
            $transaction->option_id = 1;
            $transaction->amount = $amount;
            $transaction->transaction_type = "B";
            $transaction->transaction_status = "O";
            $done = $user->makeTransaction($transaction->amount,$transaction->transaction_type);

            if($done){
                return APIService::sendJson(["status" => "OK","message" => "success"]);
            }
            return APIService::sendJson(["status" => "NOK","message" => "Desculpe, saldo insuficiente para realizar essa transação"]);
        }

        return APIService::sendJson(["status" => "NOK","message" => "parametros inválidos"]);
    }
}
