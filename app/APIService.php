<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class APIService extends Model
{
    public static function sendJson($body){
        $response = response()->json($body);
        $response->header('Content-Type', 'application/json');
        $response->header('charset', 'utf-8');

        return $response;
    }
}
