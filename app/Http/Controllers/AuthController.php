<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return [
                'message' => 'The provided credentials are incorrect',
            ];
        }
        $token = $user->createToken($user->email);
        return ['message'=>'login ok', 'datas' => ['user' =>$user, 'token'=>$token->plainTextToken]];
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return [
            'message' => 'You are logged out',
        ];
    }
}
