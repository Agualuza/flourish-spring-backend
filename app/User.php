<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';

    public function bank()
    {
        return $this->hasOne('App\Bank');
    }

    public function customer()
    {
        return $this->hasOne('App\Customer');
    }
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getUserByToken($user_id,$token){
        $user = User::find($user_id);
        $user_token = $user->token ? $user->token : null;
        return $user_token == $token ? $user : null;
    }

    public function makeTransaction($amount,$type){
        if($type == "B"){

            if($this->customer->balance >= $amount){
                $this->customer->balance -= $amount;
                $this->customer->cash += $amount;
            } else {
                return false;
            }

        } else {
            if($this->customer->cash >= $amount){
                $this->customer->balance += $amount;
                $this->customer->cash -= $amount;
            } else {
                return false;
            }
        }
        
        if($this->save()){
            return true;
        }

        return false;
    }
    
}
