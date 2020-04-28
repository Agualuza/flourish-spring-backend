<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\APIService;
use App\Score;

class ScoreController extends Controller
{
    public function create(Request $request){
        if(isset($request['transaction'])){
            $token = $request['transaction']['token'];
            $user_id = $request['transaction']['user_id'];
            $s = $request['transaction']['score'];

            $user = User::getUserByToken($user_id,$token);

            if(!$user || !$user->customer){
                return APIService::sendJson(["status" => "NOK","message" => "token inválido"]);
            }

            $score = new Score();
            $score->customer_id = $user->customer->id;
            $score->score = $s;
            $score->save();

            $updateLevel = $user->customer->updateLevel();
            return APIService::sendJson(["status" => "OK","response" => ["update_level" => $updateLevel], "message" => "success"]);
        }
        return APIService::sendJson(["status" => "NOK","message" => "parametros inválidos"]);
    }
}
