<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transaction;
use App\APIService;

class InvestmentController extends Controller
{
    public function transaction(Request $request){
        if($request['transaction']){
            $u = $request['transaction']['user'];
            $uid = $u['id'];
            $token = $u['token'];
            $amount = $request['transaction']['amount'];
            $oid = $request['transaction']['option_id'];
            $type = $request['transaction']['type'];

            $user = User::getUserByToken($uid,$token);

            if($user->user_type != "C"){
                return APIService::sendJson(["status" => "NOK","message" => "você não tem acesso a essa operação"]);
            }

            $transaction = new Transaction();
            
            $transaction->bank_id = $user->customer->bank_id;
            $transaction->customer_id = $user->customer->id;
            $transaction->option_id = $oid;
            $transaction->amount = $amount;
            $transaction->transaction_type = $type;
            $transaction->transaction_status = $type == "S" ? "C" : "O";
            $done = $user->customer->makeTransaction($transaction->amount,$transaction->transaction_type,$transaction->option_id);

            if($done){
                $transaction->save();
                return APIService::sendJson(["status" => "OK","message" => "sucesso"]);
            }
            return APIService::sendJson(["status" => "NOK","message" => "transação inválida"]);
        }

        return APIService::sendJson(["status" => "NOK","message" => "parametros inválidos"]);
    }
}
