<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\APIService;
use App\User;


class UserController extends Controller
{
    public function loginCustomer(Request $request){
        $credentials = null;
        if(isset($request['user'])){
            $u = $request['user'];
            $credentials = ["email" => $u['email'], "password" => $u['password']];
        } else {
            return APIService::sendJson(["status" => "NOK","message" => "parametros inválidos"]);
        }

        if(Auth::attempt($credentials)){
            if(Auth::user()->user_type != "C"){
                return APIService::sendJson(["status" => "NOK","message" => "Email e/ou senha inválidos"]);
            }

            if(!Auth::user()->token){
                Auth::user()->token = md5(Auth::user()->id . time());
                Auth::user()->save();
            }

            return APIService::sendJson(["status" => "OK","response" => Auth::user(), "message" => "success"]);
        }

        return APIService::sendJson(["status" => "NOK","message" => "Email e/ou senha inválidos"]);
    }

    public function loginBank(Request $request){
        $credentials = null;
        if(isset($request['user'])){
            $u = $request['user'];
            $credentials = ["email" => $u['email'], "password" => $u['password']];
        } else {
            return APIService::sendJson(["status" => "NOK","message" => "parametros inválidos"]);
        }

        if(Auth::attempt($credentials)){
            if(Auth::user()->user_type != "B"){
                return APIService::sendJson(["status" => "NOK","message" => "Email e/ou senha inválidos"]);
            }

            if(!Auth::user()->token){
                Auth::user()->token = md5(Auth::user()->id . time());
                Auth::user()->save();
            }

            return APIService::sendJson(["status" => "OK","response" => Auth::user(), "message" => "success"]);
        }

        return APIService::sendJson(["status" => "NOK","message" => "Email e/ou senha inválidos"]);   
    }

    public function tokenCustomer(Request $request){
        
        if(isset($request['user'])){
            $u = $request['user'];
            $uid = $u['user_id'];
            $token = $u['token'];
        } else {
            return APIService::sendJson(["status" => "NOK","message" => "parametros inválidos"]);
        }

        $user = User::getUserByToken($uid,$token);
        if($user){
            if(Auth::user()->user_type != "C"){
                return APIService::sendJson(["status" => "NOK","message" => "Nenhum usuário logado"]);
            }

            return APIService::sendJson(["status" => "OK","response" => Auth::user(), "message" => "success"]);
        }

        return APIService::sendJson(["status" => "NOK","message" => "Nenhum usuário logado"]);   
    }

    public function tokenBank(Request $request){
        
        if(isset($request['user'])){
            $u = $request['user'];
            $uid = $u['user_id'];
            $token = $u['token'];
        } else {
            return APIService::sendJson(["status" => "NOK","message" => "parametros inválidos"]);
        }

        $user = User::getUserByToken($uid,$token);
        if($user){
            if(Auth::user()->user_type != "B"){
                return APIService::sendJson(["status" => "NOK","message" => "Nenhum usuário logado"]);
            }

            return APIService::sendJson(["status" => "OK","response" => Auth::user(), "message" => "success"]);
        }

        return APIService::sendJson(["status" => "NOK","message" => "Nenhum usuário logado"]);   
    }
}
