<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\APIService;


class UserController extends Controller
{
    public function loginCustomer(Request $request){
        $credentials = $request->only(['email','password']);

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
        $credentials = $request->only(['email','password']);

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
}
