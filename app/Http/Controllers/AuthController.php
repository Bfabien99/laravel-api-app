<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|max:200',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);
        $user = User::create($fields);
        return ['message'=>'register ok', 'datas' => $user];
    }

    public function login(Request $request){
        return 'login';
    }

    public function logout(Request $request){
        return 'logout';
    }
}
