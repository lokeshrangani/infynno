<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $fillable = [
        'username',
        'email',
        'password',
        'ipaddress',
        'lastlogin'
    ];

    public static function store($request,$ip){
        $check=self::where('email',$request->email)->first(['id']);
        if(!$check){
            self::create([
                'username'=>$request->username,
                'email'=>$request->email,
                'password'=>md5($request->password),
                'ipaddress'=>$ip
            ]);
            $data['status']=true;
            $data['msg']="Register Success";
        }else{
            $data['status']=false;
            $data['msg']="User Exist";
        }
        return $data;
    }
    public static function login($request){
        $check=self::where(['email'=>$request->username1,'password'=>md5($request->password1)])->orWhere(['username'=> $request->username1,'password'=>md5($request->password1)])->first(['id']);
        if($check){
            session()->put('userId',$check->id);
            self::where('id',$check->id)->update([
                'lastlogin' => date('Y-m-d H:i:s'),
            ]);
            $data['status']=true;
            $data['msg']="Login Success";
        }else{
            $data['status']=false;
            $data['msg']="Login Failed";
        }
        return $data;
    }
}
