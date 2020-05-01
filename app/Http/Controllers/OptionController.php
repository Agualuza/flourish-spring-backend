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

    public function stock(Request $request){
        if(isset($request['credentials'])){
            $user = User::getUserByToken($request['credentials']['user_id'],$request['credentials']['token']);

            if($user == null){
                return APIService::sendJson(["status" => "NOK","message" => "token inválido"]);
            }

            $service = new APIService;

            $url1 = "https://api.hgbrasil.com/finance/stock_price?key=bd7138b1&symbol=bbas3";
            $url2 = "https://api.hgbrasil.com/finance/stock_price?key=bd7138b1&symbol=petr4";
            $url3 = "https://api.hgbrasil.com/finance/stock_price?key=bd7138b1&symbol=itub4";
            $url4 = "https://api.hgbrasil.com/finance/stock_price?key=bd7138b1&symbol=mglu3";

            $bb = $service->getHttpRequest($url1);
            $petrobras = $service->getHttpRequest($url2);
            $itau = $service->getHttpRequest($url3);
            $magalu = $service->getHttpRequest($url4);

            $bbTicker = "BBAS3";
            $itauTicker = "ITUB4";
            $petrobrasTicker = "PETR4";
            $magaluTicker = "MGLU4";
            
            $stockArray = array();
            $stockArray[] = $bb;
            $stockArray[] = $petrobras;
            $stockArray[] = $itau;
            $stockArray[] = $magalu;
            $tickers = [$bbTicker,$petrobrasTicker,$itauTicker,$magaluTicker];

            return APIService::sendJson(["status" => "OK", "response" => ["tickers" => $tickers, "stocks" => $stockArray], "message" => "sucesso"]);
        } 
        
        return APIService::sendJson(["status" => "NOK","message" => "parametros inválidos"]);
    }

    public function cripto(Request $request){
        if(isset($request['credentials'])){
            $user = User::getUserByToken($request['credentials']['user_id'],$request['credentials']['token']);

            if($user == null){
                return APIService::sendJson(["status" => "NOK","message" => "token inválido"]);
            }

            $service = new APIService;

            $url = "https://api.hgbrasil.com/finance";
            
            $r = $service->getHttpRequest($url);
            $r["body"]->results->currencies->BTC->code = "BTC";
            $response = $r["body"]->results->currencies->BTC;

            return APIService::sendJson(["status" => "OK", "response" => $response , "message" => "sucesso"]);
        } 
        
        return APIService::sendJson(["status" => "NOK","message" => "parametros inválidos"]);
    }
}
