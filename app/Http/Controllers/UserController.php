<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if(session()->has('userId')){
            return view('blog');
        }else{
            return view('welcome');
        }
    }

    public function store(Request $request)
    {
        $ip=$request->ip();
        $data=User::store($request,$ip);
        return response()->json($data);
    }

    public function login(Request $request)
    {
        $data=User::login($request);
        return response()->json($data);
    }
    public function logout(){
        if(session()->has('userId')){
            session()->flush();
            $data['status']=true;
            return response()->json($data);
        }
    }
    


}
