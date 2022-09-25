<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use lluminate\Support\Facades\Auth;
Use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\Auth\Loginrequest;

class AuthController extends Controller
{
    public function register(Request $request){
        $this->validate($request,[
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::Create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password)
        ]);
    
        $token = JWTAuth::fromuser($user);

        return response ()->json([
            'user' =>$user,
            'token' =>$token,
        ],201);
    }   

    public function login(Request $request){
        $credenciales = $request->only('email','password');
        
        $this->validate($request,[
            'email' => 'required|email|max:255',
            'password' => 'required|min:6'
        ]);
        try {
            if(!$token = JWTAuth::attempt($credenciales)){
            return response ()->json([
                    'error' => 'Credenciales invalida'
                ],400);
            }
        } catch (JWTException $e) {
            return response ()->json([
                'error' => 'No se creo el token'
            ],500);
        }
        return response ()->json(compact('token'));
    } 
}
